<?php
declare(strict_types=1);
session_start();

const ADMIN_PASSWORD_HASH = '$2y$12$Q3Y0SiShhBBmLz8EjXs87uEoScuKLB1toNfNT/QimVzV9l4u008cK';
const MAX_FILE_SIZE = 220 * 1024 * 1024;

$root = dirname(__DIR__);
$uploadDir = $root . '/assets/projects';
$manifestFile = $uploadDir . '/projects.json';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

function loadProjects(string $file): array {
    $data = is_file($file) ? json_decode((string) file_get_contents($file), true) : [];
    return is_array($data) ? $data : [];
}
function saveProjects(string $file, array $items): bool {
    $tmp = $file . '.tmp';
    $json = json_encode(array_values($items), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    if ($json === false || file_put_contents($tmp, $json, LOCK_EX) === false) return false;
    return rename($tmp, $file);
}
function redirectSelf(): never { header('Location: index.php'); exit; }
function wantsJson(): bool {
    return isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json');
}
function jsonResponse(bool $ok, string $message, array $extra = [], int $status = 200): never {
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array_merge(['ok' => $ok, 'message' => $message], $extra), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}
function uploadErrorMessage(int $code): string {
    return match ($code) {
        UPLOAD_ERR_INI_SIZE => 'Plik przekracza limit serwera upload_max_filesize.',
        UPLOAD_ERR_FORM_SIZE => 'Plik przekracza limit formularza.',
        UPLOAD_ERR_PARTIAL => 'Plik został przesłany tylko częściowo.',
        UPLOAD_ERR_NO_FILE => 'Nie wybrano pliku.',
        UPLOAD_ERR_NO_TMP_DIR => 'Na serwerze brakuje katalogu tymczasowego.',
        UPLOAD_ERR_CANT_WRITE => 'Serwer nie może zapisać pliku na dysku.',
        UPLOAD_ERR_EXTENSION => 'Rozszerzenie PHP zatrzymało wysyłanie pliku.',
        default => 'Nieznany błąd wysyłania pliku.'
    };
}

if (isset($_GET['logout'])) { session_destroy(); redirectSelf(); }
$error = '';
if (isset($_POST['login'])) {
    if (password_verify((string) ($_POST['password'] ?? ''), ADMIN_PASSWORD_HASH)) {
        $_SESSION['admin'] = true;
        $_SESSION['csrf'] = bin2hex(random_bytes(24));
        redirectSelf();
    }
    $error = 'Nieprawidłowe hasło.';
}
$logged = !empty($_SESSION['admin']);

if ($logged && $_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['login'])) {
    if (!hash_equals((string) ($_SESSION['csrf'] ?? ''), (string) ($_POST['csrf'] ?? ''))) {
        wantsJson() ? jsonResponse(false, 'Nieprawidłowy token sesji.', [], 403) : die('Nieprawidłowy token CSRF.');
    }

    $items = loadProjects($manifestFile);

    if (isset($_POST['upload'])) {
        if (!isset($_FILES['photos'])) jsonResponse(false, 'Nie otrzymano żadnych plików.', [], 400);

        $files = $_FILES['photos'];
        $names = (array) ($files['name'] ?? []);
        $tmpNames = (array) ($files['tmp_name'] ?? []);
        $errors = (array) ($files['error'] ?? []);
        $sizes = (array) ($files['size'] ?? []);
        $uploaded = [];
        $failed = [];
        $finfo = new finfo(FILEINFO_MIME_TYPE);

        foreach ($tmpNames as $i => $tmp) {
            $original = (string) ($names[$i] ?? 'plik');
            $errorCode = (int) ($errors[$i] ?? UPLOAD_ERR_NO_FILE);
            if ($errorCode !== UPLOAD_ERR_OK) {
                $failed[] = $original . ': ' . uploadErrorMessage($errorCode);
                continue;
            }
            $size = (int) ($sizes[$i] ?? 0);
            if ($size <= 0 || $size > MAX_FILE_SIZE) {
                $failed[] = $original . ': plik jest pusty albo większy niż 220 MB.';
                continue;
            }

            $extension = strtolower(pathinfo($original, PATHINFO_EXTENSION));
            $mime = (string) $finfo->file($tmp);
            $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'webp'], true)
                && in_array($mime, ['image/jpeg', 'image/png', 'image/webp'], true);
            $isMp4 = $extension === 'mp4'
                && in_array($mime, ['video/mp4', 'application/mp4', 'application/octet-stream'], true);

            if (!$isImage && !$isMp4) {
                $failed[] = $original . ': niedozwolony format (' . ($mime ?: 'nieznany MIME') . ').';
                continue;
            }

            $targetExtension = $isMp4 ? 'mp4' : ($extension === 'jpeg' ? 'jpg' : $extension);
            $newName = date('Ymd-His') . '-' . bin2hex(random_bytes(5)) . '.' . $targetExtension;
            $target = $uploadDir . '/' . $newName;
            if (!move_uploaded_file($tmp, $target)) {
                $failed[] = $original . ': nie udało się zapisać pliku.';
                continue;
            }
            @chmod($target, 0644);
            $items[] = ['file' => $newName];
            $uploaded[] = $newName;
        }

        if ($uploaded && !saveProjects($manifestFile, $items)) {
            jsonResponse(false, 'Pliki wgrano, ale nie udało się zapisać listy projektów.', ['failed' => $failed], 500);
        }

        if (!$uploaded) jsonResponse(false, $failed[0] ?? 'Nie udało się wgrać pliku.', ['failed' => $failed], 422);
        jsonResponse(true, count($uploaded) === 1 ? 'Materiał został wgrany.' : 'Materiały zostały wgrane.', ['uploaded' => $uploaded, 'failed' => $failed]);
    }

    if (isset($_POST['save_order'])) {
        $order = json_decode((string) ($_POST['order'] ?? '[]'), true);
        if (!is_array($order)) jsonResponse(false, 'Nieprawidłowa kolejność.', [], 422);
        $byName = [];
        foreach ($items as $item) if (isset($item['file'])) $byName[(string) $item['file']] = $item;
        $newItems = [];
        foreach ($order as $name) {
            $name = basename((string) $name);
            if (isset($byName[$name])) { $newItems[] = $byName[$name]; unset($byName[$name]); }
        }
        foreach ($byName as $item) $newItems[] = $item;
        if (!saveProjects($manifestFile, $newItems)) jsonResponse(false, 'Nie udało się zapisać kolejności.', [], 500);
        jsonResponse(true, 'Kolejność zapisana.');
    }

    if (isset($_POST['delete'])) {
        $name = basename((string) $_POST['delete']);
        $items = array_values(array_filter($items, fn($item) => ($item['file'] ?? '') !== $name));
        $path = $uploadDir . '/' . $name;
        if (is_file($path)) unlink($path);
        saveProjects($manifestFile, $items);
        redirectSelf();
    }
}
$items = loadProjects($manifestFile);
?>
<!doctype html>
<html lang="pl"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Projekty — Inflect Studio</title>
<style>
:root{--bg:#111;--fg:#fff;--muted:rgba(255,255,255,.55);--line:rgba(255,255,255,.24)}*{box-sizing:border-box}body{margin:0;background:var(--bg);color:var(--fg);font-family:Inter,"Helvetica Neue",Arial,sans-serif;-webkit-font-smoothing:antialiased}button,input{font:inherit}.shell{min-height:100svh;padding:28px clamp(18px,4vw,64px) 64px}.top{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:clamp(56px,8vw,110px)}.brand{font-size:18px;font-weight:600;letter-spacing:-.04em}.logout{font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:var(--fg);text-decoration:none}.title{margin:0 0 34px;font-size:14px;font-weight:500;line-height:1;letter-spacing:.14em;text-transform:uppercase}.card{border-top:1px solid var(--line);padding:22px 0 32px}.label{display:block;margin-bottom:15px;font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:var(--muted)}.upload{display:flex;gap:12px;align-items:center;flex-wrap:wrap}.file{flex:1;min-width:260px;padding:15px;border:1px solid var(--line);background:transparent;color:var(--fg)}.btn{min-height:48px;padding:0 22px;border:1px solid var(--fg);background:var(--fg);color:var(--bg);cursor:pointer;text-transform:uppercase;font-size:10px;letter-spacing:.1em}.progress-wrap{display:none;margin-top:18px}.progress-wrap.is-active{display:block}.progress{height:2px;background:rgba(255,255,255,.18);overflow:hidden}.progress__bar{width:0;height:100%;background:#fff;transition:width 120ms linear}.progress__meta{display:flex;justify-content:space-between;gap:12px;margin-top:9px;color:var(--muted);font-size:10px;letter-spacing:.08em;text-transform:uppercase}.upload-status{min-height:18px;margin-top:12px;color:var(--muted);font-size:11px}.grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:18px}.item{position:relative;border:1px solid var(--line);padding:9px;cursor:grab;background:#111;transition:opacity .18s ease,transform .18s ease}.item.dragging{opacity:.3;transform:scale(.98)}.item img,.item video{display:block;width:100%;aspect-ratio:1/1;object-fit:cover;background:#111}.item__meta{display:flex;justify-content:space-between;gap:8px;align-items:center;padding-top:9px}.name{min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:10px;color:var(--muted)}.delete{border:0;background:transparent;color:#fff;cursor:pointer;font-size:10px}.order-tools{display:flex;gap:10px;align-items:center;flex-wrap:wrap;margin:0 0 18px}.btn--ghost{background:transparent;color:var(--fg);border-color:var(--line)}.btn--ghost:hover{border-color:var(--fg)}.btn:disabled{opacity:.45;cursor:not-allowed}.save-state{min-height:16px;margin-top:14px;color:var(--muted);font-size:10px;letter-spacing:.08em;text-transform:uppercase}.login{display:grid;place-items:center;min-height:calc(100svh - 56px)}.login form{width:min(420px,100%)}.password{width:100%;padding:18px 0;border:0;border-bottom:1px solid var(--line);background:transparent;color:#fff;outline:none;text-align:center;font-size:16px}.password::placeholder{color:var(--muted)}.error{margin:0 0 18px;text-align:center;font-size:11px}.hidden-submit{position:absolute;width:1px;height:1px;opacity:0;pointer-events:none}.empty{color:var(--muted);padding:48px 0;font-size:12px}@media(max-width:900px){.grid{grid-template-columns:repeat(2,minmax(0,1fr))}}@media(max-width:520px){.grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:8px}.upload{display:block}.file,.btn{width:100%;margin-bottom:10px}.order-tools{display:grid;grid-template-columns:1fr 1fr;gap:8px}.order-tools .btn{margin:0;padding-inline:10px}.shell{padding-inline:14px}.item{padding:6px}.name{display:none}}
</style></head><body><main class="shell">
<?php if (!$logged): ?>
<section class="login"><form method="post"><?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif ?><input class="password" type="password" name="password" placeholder="Hasło" required autofocus autocomplete="current-password"><button class="hidden-submit" name="login" value="1" tabindex="-1" aria-hidden="true">Zaloguj</button><input type="hidden" name="login" value="1"></form></section>
<?php else: ?>
<header class="top"><div class="brand">INFLECT STUDIO</div><a class="logout" href="?logout=1">[ WYLOGUJ ]</a></header>
<h1 class="title">Projekty</h1>
<section class="card"><span class="label">Dodaj zdjęcia lub wideo MP4</span>
<form class="upload" id="upload-form" method="post" enctype="multipart/form-data"><input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf']) ?>"><input type="hidden" name="upload" value="1"><input class="file" type="file" name="photos[]" accept="image/jpeg,image/png,image/webp,video/mp4,.mp4" multiple required><button class="btn" type="submit">Wgraj</button></form>
<div class="progress-wrap" id="progress-wrap"><div class="progress"><div class="progress__bar" id="progress-bar"></div></div><div class="progress__meta"><span id="progress-label">Wgrywanie</span><span id="progress-percent">0%</span></div></div><div class="upload-status" id="upload-status"></div>
</section>
<section class="card"><span class="label">Kolejność — przeciągnij materiały</span><?php if (!$items): ?><div class="empty">Brak materiałów.</div><?php else: ?><div class="order-tools"><button class="btn btn--ghost" type="button" id="shuffle-order">Losowe ułożenie</button><button class="btn btn--ghost" type="button" id="ai-grid">AI Grid</button></div><div class="grid" id="sortable"><?php foreach ($items as $item): $name = basename((string) $item['file']); $isVideo = strtolower(pathinfo($name, PATHINFO_EXTENSION)) === 'mp4'; ?><article class="item" draggable="true" data-file="<?= htmlspecialchars($name) ?>"><?php if ($isVideo): ?><video src="../assets/projects/<?= rawurlencode($name) ?>" muted loop playsinline autoplay preload="metadata"></video><?php else: ?><img src="../assets/projects/<?= rawurlencode($name) ?>" alt=""><?php endif ?><div class="item__meta"><span class="name"><?= htmlspecialchars($name) ?></span><form method="post" onsubmit="return confirm('Usunąć materiał?')"><input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf']) ?>"><button class="delete" name="delete" value="<?= htmlspecialchars($name) ?>">USUŃ</button></form></div></article><?php endforeach ?></div><div class="save-state" id="save-state" aria-live="polite"></div><?php endif ?></section>
<script>
const csrf=<?= json_encode((string)$_SESSION['csrf']) ?>;
const uploadForm=document.querySelector('#upload-form');
const progressWrap=document.querySelector('#progress-wrap');
const progressBar=document.querySelector('#progress-bar');
const progressPercent=document.querySelector('#progress-percent');
const progressLabel=document.querySelector('#progress-label');
const uploadStatus=document.querySelector('#upload-status');
if(uploadForm){uploadForm.addEventListener('submit',event=>{event.preventDefault();const data=new FormData(uploadForm);const xhr=new XMLHttpRequest();xhr.open('POST','index.php');xhr.setRequestHeader('Accept','application/json');progressWrap.classList.add('is-active');progressBar.style.width='0%';progressPercent.textContent='0%';progressLabel.textContent='Wgrywanie';uploadStatus.textContent='';uploadForm.querySelector('button').disabled=true;xhr.upload.addEventListener('progress',e=>{if(!e.lengthComputable)return;const p=Math.min(100,Math.round(e.loaded/e.total*100));progressBar.style.width=p+'%';progressPercent.textContent=p+'%';if(p===100)progressLabel.textContent='Przetwarzanie';});xhr.addEventListener('load',()=>{uploadForm.querySelector('button').disabled=false;let response={ok:false,message:'Serwer zwrócił nieprawidłową odpowiedź.'};try{response=JSON.parse(xhr.responseText)}catch(_){}progressBar.style.width=response.ok?'100%':'0%';progressPercent.textContent=response.ok?'100%':'Błąd';progressLabel.textContent=response.ok?'Gotowe':'Nie udało się';uploadStatus.textContent=response.message+(response.failed?.length?' '+response.failed.join(' '):'');if(response.ok)setTimeout(()=>location.reload(),650);});xhr.addEventListener('error',()=>{uploadForm.querySelector('button').disabled=false;progressLabel.textContent='Błąd połączenia';progressPercent.textContent='';uploadStatus.textContent='Nie udało się połączyć z serwerem.';});xhr.send(data);});}
const grid=document.querySelector('#sortable');
const saveState=document.querySelector('#save-state');

if(grid){
    const shuffleBtn=document.querySelector('#shuffle-order');
    const aiGridBtn=document.querySelector('#ai-grid');
    let drag=null;
    let saveTimer=null;

    const setButtonsDisabled=(disabled)=>{
        [shuffleBtn,aiGridBtn].forEach(btn=>{if(btn)btn.disabled=disabled;});
    };

    const saveOrder=()=>{
        saveState.textContent='Zapisywanie…';
        setButtonsDisabled(true);

        const data=new FormData();
        data.append('csrf',csrf);
        data.append('save_order','1');
        data.append('order',JSON.stringify([...grid.children].map(item=>item.dataset.file)));

        fetch('index.php',{
            method:'POST',
            headers:{Accept:'application/json'},
            body:data
        })
        .then(r=>r.json())
        .then(result=>{
            saveState.textContent=result.ok?'Kolejność zapisana':'Nie udało się zapisać kolejności';
        })
        .catch(()=>{
            saveState.textContent='Nie udało się zapisać kolejności';
        })
        .finally(()=>setButtonsDisabled(false));
    };

    const scheduleSave=()=>{
        clearTimeout(saveTimer);
        saveTimer=setTimeout(saveOrder,350);
    };

    grid.addEventListener('dragstart',e=>{
        drag=e.target.closest('.item');
        drag?.classList.add('dragging');
    });

    grid.addEventListener('dragend',()=>{
        drag?.classList.remove('dragging');
        drag=null;
        scheduleSave();
    });

    grid.addEventListener('dragover',e=>{
        e.preventDefault();
        const target=e.target.closest('.item');
        if(!drag||!target||target===drag)return;

        const rect=target.getBoundingClientRect();
        const after=
            (e.clientY>rect.top+rect.height/2)||
            (
                Math.abs(e.clientY-(rect.top+rect.height/2))<rect.height*.35 &&
                e.clientX>rect.left+rect.width/2
            );

        grid.insertBefore(drag,after?target.nextSibling:target);
    });

    const fisherYates=(items)=>{
        const copy=[...items];
        for(let i=copy.length-1;i>0;i--){
            const j=Math.floor(Math.random()*(i+1));
            [copy[i],copy[j]]=[copy[j],copy[i]];
        }
        return copy;
    };

    if(shuffleBtn){
        shuffleBtn.addEventListener('click',()=>{
            const mixed=fisherYates([...grid.children]);
            mixed.forEach(el=>grid.appendChild(el));
            saveState.textContent='Losowe ułożenie…';
            saveOrder();
        });
    }

    const getMediaInfo=(item)=>new Promise(resolve=>{
        const media=item.querySelector('img,video');
        if(!media){
            resolve({item,type:'unknown',ratio:1,isVideo:false});
            return;
        }

        const isVideo=media.tagName==='VIDEO';

        const finish=()=>{
            const width=isVideo?media.videoWidth:media.naturalWidth;
            const height=isVideo?media.videoHeight:media.naturalHeight;
            const ratio=width&&height?width/height:1;
            let type='square';

            if(ratio>1.18)type='landscape';
            else if(ratio<0.84)type='portrait';

            resolve({item,type,ratio,isVideo});
        };

        if(isVideo){
            if(media.readyState>=1&&media.videoWidth)finish();
            else{
                media.addEventListener('loadedmetadata',finish,{once:true});
                media.addEventListener('error',finish,{once:true});
                media.load();
            }
        }else{
            if(media.complete&&media.naturalWidth)finish();
            else{
                media.addEventListener('load',finish,{once:true});
                media.addEventListener('error',finish,{once:true});
            }
        }
    });

    const smartArrange=(entries)=>{
        const buckets={
            landscape:[],
            portrait:[],
            square:[]
        };

        fisherYates(entries).forEach(entry=>{
            (buckets[entry.type]||buckets.square).push(entry);
        });

        const result=[];
        let previousType='';
        let previousWasVideo=false;

        while(buckets.landscape.length||buckets.portrait.length||buckets.square.length){
            const available=Object.entries(buckets)
                .filter(([,values])=>values.length)
                .sort((a,b)=>b[1].length-a[1].length);

            let candidates=available.filter(([type])=>type!==previousType);
            if(!candidates.length)candidates=available;

            let selectedBucket=null;
            let selectedIndex=0;

            outer:
            for(const [type,values] of candidates){
                for(let i=0;i<values.length;i++){
                    if(!(previousWasVideo&&values[i].isVideo)){
                        selectedBucket=type;
                        selectedIndex=i;
                        break outer;
                    }
                }
            }

            if(!selectedBucket){
                selectedBucket=candidates[0][0];
                selectedIndex=0;
            }

            const [chosen]=buckets[selectedBucket].splice(selectedIndex,1);
            result.push(chosen);
            previousType=chosen.type;
            previousWasVideo=chosen.isVideo;
        }

        return result;
    };

    if(aiGridBtn){
        aiGridBtn.addEventListener('click',async()=>{
            setButtonsDisabled(true);
            saveState.textContent='AI Grid analizuje proporcje…';

            try{
                const entries=await Promise.all([...grid.children].map(getMediaInfo));
                const arranged=smartArrange(entries);
                arranged.forEach(entry=>grid.appendChild(entry.item));
                saveState.textContent='AI Grid ułożony. Zapisywanie…';
                saveOrder();
            }catch(error){
                console.error(error);
                saveState.textContent='Nie udało się utworzyć AI Grid.';
                setButtonsDisabled(false);
            }
        });
    }
}
</script>
<?php endif ?></main></body></html>
