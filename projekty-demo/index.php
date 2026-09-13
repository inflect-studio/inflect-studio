<?php
$manifest = __DIR__ . '/../assets/projects/projects.json';
$projects = [];
if (is_file($manifest)) {
  $decoded = json_decode((string) file_get_contents($manifest), true);
  if (is_array($decoded)) $projects = $decoded;
}
$media = [];
foreach ($projects as $i => $p) {
  $file = isset($p['file']) ? basename((string)$p['file']) : '';
  if (!$file) continue;
  $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
  $media[] = [
    'file' => $file,
    'video' => $ext === 'mp4',
    'index' => $i + 1,
    'title' => 'Project ' . str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT)
  ];
}
?>
<!doctype html>
<html lang="pl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<meta name="theme-color" content="#0b0b0b">
<title>Projekty Demo - Inflect Studio</title>
<style>
:root{
  --bg:#0b0b0b;
  --fg:#f4f2ec;
  --muted:rgba(244,242,236,.48);
  --line:rgba(255,255,255,.14);
  --ease:cubic-bezier(.22,1,.36,1);
}
*{box-sizing:border-box}
html,body{margin:0;background:var(--bg);color:var(--fg);font-family:Inter,Arial,Helvetica,sans-serif;-webkit-font-smoothing:antialiased}
body{overflow-x:hidden}
button{font:inherit}
img,video{display:block;width:100%;height:100%;object-fit:cover}
.demo-nav{
  position:fixed;z-index:200;top:0;left:0;width:100%;
  display:flex;justify-content:space-between;align-items:flex-start;
  padding:max(16px,env(safe-area-inset-top)) 16px 0;
  mix-blend-mode:difference;color:white;pointer-events:none
}
.demo-brand{font-size:11px;font-weight:600;letter-spacing:.16em;text-transform:uppercase;text-decoration:none;color:inherit;pointer-events:auto}
.demo-switch{display:flex;flex-direction:column;align-items:flex-end;gap:5px;pointer-events:auto}
.demo-switch button{
  border:0;background:none;color:inherit;padding:0;
  font-size:10px;letter-spacing:.12em;text-transform:uppercase;opacity:.38;cursor:pointer
}
.demo-switch button.active{opacity:1}
.view{display:none}
.view.active{display:block}

/* 01 - FULLSCREEN STORIES */
.stories{
  background:#0b0b0b;
  scroll-snap-type:y mandatory;
}
.story{
  position:relative;height:100svh;overflow:hidden;scroll-snap-align:start;isolation:isolate
}
.story-media{position:absolute;inset:0;transform:scale(1.06);transition:transform 1.2s var(--ease)}
.story.is-current .story-media{transform:scale(1)}
.story:after{
  content:"";position:absolute;inset:0;z-index:1;
  background:linear-gradient(180deg,rgba(0,0,0,.08) 0%,rgba(0,0,0,.04) 45%,rgba(0,0,0,.86) 100%)
}
.story-meta{
  position:absolute;z-index:3;left:16px;right:16px;bottom:max(22px,env(safe-area-inset-bottom));
  display:flex;align-items:flex-end;justify-content:space-between;gap:20px
}
.story-index{font-size:11px;letter-spacing:.12em;text-transform:uppercase;color:rgba(255,255,255,.66)}
.story-title{margin:6px 0 0;font-size:clamp(44px,14vw,86px);line-height:.86;letter-spacing:-.07em;font-weight:600}
.story-arrow{font-size:32px;line-height:1}
.story-progress{
  position:absolute;z-index:4;top:50%;right:10px;transform:translateY(-50%);
  display:flex;flex-direction:column;gap:5px
}
.story-progress span{display:block;width:2px;height:16px;background:rgba(255,255,255,.22);transition:.3s var(--ease)}
.story-progress span.active{height:38px;background:#fff}

/* 02 - KINETIC STACK */
.stack-view{min-height:100vh;background:#111;padding-top:12vh}
.stack-wrap{padding:0 12px 22vh}
.stack-card{
  position:sticky;top:9vh;height:82svh;margin:0 0 10vh;border-radius:22px;overflow:hidden;background:#1a1a1a;
  transform-origin:center top;box-shadow:0 20px 70px rgba(0,0,0,.36)
}
.stack-card:after{
  content:"";position:absolute;inset:0;background:linear-gradient(180deg,transparent 45%,rgba(0,0,0,.78));
  pointer-events:none
}
.stack-card__meta{
  position:absolute;z-index:3;left:16px;right:16px;bottom:16px;
  display:flex;justify-content:space-between;align-items:flex-end
}
.stack-card__title{font-size:clamp(34px,10vw,62px);line-height:.9;letter-spacing:-.06em;margin:0}
.stack-card__no{font-size:10px;letter-spacing:.14em;text-transform:uppercase;color:rgba(255,255,255,.7)}

/* 03 - EDITORIAL INDEX */
.index-view{min-height:100svh;background:#efede7;color:#0f0f0f;position:relative}
.index-preview{
  position:fixed;inset:0;z-index:0;overflow:hidden;pointer-events:none
}
.index-preview:after{
  content:"";position:absolute;inset:0;background:rgba(239,237,231,.58);backdrop-filter:saturate(.75)
}
.index-preview-media{
  position:absolute;inset:0;opacity:0;transform:scale(1.06);
  transition:opacity .45s ease,transform .8s var(--ease)
}
.index-preview-media.active{opacity:1;transform:scale(1)}
.index-list{
  position:relative;z-index:2;padding:28vh 14px 28vh
}
.index-row{
  border-top:1px solid rgba(0,0,0,.18);
  min-height:92px;display:grid;grid-template-columns:42px 1fr auto;align-items:center;gap:8px;
  cursor:pointer;transition:opacity .25s ease
}
.index-row:last-child{border-bottom:1px solid rgba(0,0,0,.18)}
.index-row__no{font-size:10px;letter-spacing:.12em;color:rgba(0,0,0,.46)}
.index-row__title{
  font-size:clamp(34px,10vw,72px);line-height:.88;letter-spacing:-.065em;font-weight:600;
  transform:translateX(0);transition:transform .35s var(--ease)
}
.index-row__type{font-size:9px;letter-spacing:.12em;text-transform:uppercase;color:rgba(0,0,0,.5)}
.index-row.active .index-row__title{transform:translateX(10px)}
.index-row:not(.active){opacity:.48}
.index-label{
  position:fixed;z-index:4;left:14px;bottom:max(18px,env(safe-area-inset-bottom));
  font-size:10px;text-transform:uppercase;letter-spacing:.14em;color:rgba(0,0,0,.55)
}

/* shared */
.view-caption{
  position:fixed;z-index:120;left:16px;top:max(74px,calc(env(safe-area-inset-top) + 58px));
  color:white;mix-blend-mode:difference;pointer-events:none
}
.view-caption b{display:block;font-size:10px;letter-spacing:.15em;text-transform:uppercase}
.view-caption span{display:block;margin-top:5px;font-size:11px;opacity:.52}

@media(min-width:760px){
  .demo-nav{padding-left:26px;padding-right:26px}
  .demo-switch{flex-direction:row;gap:18px}
  .story-meta{left:28px;right:28px;bottom:28px}
  .story-title{font-size:min(8vw,120px)}
  .stack-wrap{max-width:1080px;margin:0 auto}
  .stack-card{height:78vh;border-radius:28px}
  .index-list{padding-left:28px;padding-right:28px}
  .index-row{min-height:120px;grid-template-columns:60px 1fr 120px}
  .index-label{left:28px}
}
@media(prefers-reduced-motion:reduce){
  *{scroll-behavior:auto!important;animation:none!important;transition:none!important}
}
</style>
</head>
<body>

<nav class="demo-nav">
  <a class="demo-brand" href="../index.php">Inflect Studio</a>
  <div class="demo-switch">
    <button class="active" data-view="stories">01 Stories</button>
    <button data-view="stack">02 Stack</button>
    <button data-view="index">03 Index</button>
  </div>
</nav>

<div class="view-caption">
  <b id="caption-title">Fullscreen Stories</b>
  <span id="caption-copy">Swipe / scroll to browse</span>
</div>

<main>
<section class="view active stories" id="stories">
<?php foreach(array_slice($media,0,12) as $i=>$m): ?>
  <article class="story" data-story="<?=$i?>">
    <div class="story-media">
      <?php if($m['video']): ?>
        <video data-src="../assets/projects/<?=htmlspecialchars($m['file'])?>" muted loop playsinline preload="none"></video>
      <?php else: ?>
        <img src="../assets/projects/<?=htmlspecialchars($m['file'])?>" alt="" loading="lazy">
      <?php endif; ?>
    </div>
    <div class="story-meta">
      <div>
        <div class="story-index"><?=str_pad((string)($i+1),2,'0',STR_PAD_LEFT)?> / <?=str_pad((string)min(12,count($media)),2,'0',STR_PAD_LEFT)?></div>
        <h2 class="story-title"><?=htmlspecialchars($m['title'])?></h2>
      </div>
      <div class="story-arrow">↗</div>
    </div>
  </article>
<?php endforeach; ?>
  <div class="story-progress">
  <?php foreach(array_slice($media,0,12) as $i=>$m): ?><span class="<?=$i===0?'active':''?>"></span><?php endforeach;?>
  </div>
</section>

<section class="view stack-view" id="stack">
  <div class="stack-wrap">
  <?php foreach(array_slice($media,0,12) as $i=>$m): ?>
    <article class="stack-card" data-stack="<?=$i?>">
      <?php if($m['video']): ?>
        <video data-src="../assets/projects/<?=htmlspecialchars($m['file'])?>" muted loop playsinline preload="none"></video>
      <?php else: ?>
        <img src="../assets/projects/<?=htmlspecialchars($m['file'])?>" alt="" loading="lazy">
      <?php endif; ?>
      <div class="stack-card__meta">
        <div>
          <div class="stack-card__no">Case <?=str_pad((string)($i+1),2,'0',STR_PAD_LEFT)?></div>
          <h2 class="stack-card__title"><?=htmlspecialchars($m['title'])?></h2>
        </div>
        <div class="story-arrow">↗</div>
      </div>
    </article>
  <?php endforeach; ?>
  </div>
</section>

<section class="view index-view" id="index">
  <div class="index-preview">
    <?php foreach(array_slice($media,0,16) as $i=>$m): ?>
      <div class="index-preview-media <?=$i===0?'active':''?>" data-preview="<?=$i?>">
        <?php if($m['video']): ?>
          <video data-src="../assets/projects/<?=htmlspecialchars($m['file'])?>" muted loop playsinline preload="none"></video>
        <?php else: ?>
          <img src="../assets/projects/<?=htmlspecialchars($m['file'])?>" alt="" loading="lazy">
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="index-list">
    <?php foreach(array_slice($media,0,16) as $i=>$m): ?>
      <div class="index-row <?=$i===0?'active':''?>" data-row="<?=$i?>">
        <span class="index-row__no"><?=str_pad((string)($i+1),2,'0',STR_PAD_LEFT)?></span>
        <span class="index-row__title"><?=htmlspecialchars($m['title'])?></span>
        <span class="index-row__type"><?=$m['video']?'Motion':'Visual'?></span>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="index-label">Selected work / Inflect Studio</div>
</section>
</main>

<script>
const $$=(s,p=document)=>[...p.querySelectorAll(s)];
const views={stories:['Fullscreen Stories','Swipe / scroll to browse'],stack:['Kinetic Stack','Layered sticky case studies'],index:['Editorial Index','Typography first / live preview']};

function hydrate(root){
  $$('video[data-src]',root).forEach(v=>{
    if(!v.src){v.src=v.dataset.src;v.play().catch(()=>{})}
  });
}
function switchView(id){
  $$('.view').forEach(v=>v.classList.toggle('active',v.id===id));
  $$('.demo-switch button').forEach(b=>b.classList.toggle('active',b.dataset.view===id));
  document.querySelector('#caption-title').textContent=views[id][0];
  document.querySelector('#caption-copy').textContent=views[id][1];
  document.body.style.overflowY = id==='stories' ? 'auto' : 'auto';
  window.scrollTo(0,0);
  hydrate(document.querySelector('#'+id));
}
$$('.demo-switch button').forEach(b=>b.onclick=()=>switchView(b.dataset.view));
hydrate(document.querySelector('#stories'));

// 01 stories
const stories=$$('.story');
const storyDots=$$('.story-progress span');
const storyObserver=new IntersectionObserver(entries=>{
  entries.forEach(e=>{
    if(e.isIntersecting){
      stories.forEach(s=>s.classList.toggle('is-current',s===e.target));
      const i=+e.target.dataset.story;
      storyDots.forEach((d,n)=>d.classList.toggle('active',n===i));
      const v=e.target.querySelector('video'); if(v)v.play().catch(()=>{});
    }
  });
},{threshold:.62});
stories.forEach(s=>storyObserver.observe(s));

// 02 stack
const stackCards=$$('.stack-card');
function stackRender(){
  if(!document.querySelector('#stack').classList.contains('active')) return;
  const vh=innerHeight;
  stackCards.forEach((card,i)=>{
    const r=card.getBoundingClientRect();
    const progress=Math.max(0,Math.min(1,(vh*.16-r.top)/(vh*.62)));
    const scale=1-progress*.055;
    const shade=progress*.28;
    card.style.transform=`scale(${scale})`;
    card.style.filter=`brightness(${1-shade})`;
    card.style.zIndex=String(i+1);
  });
}
addEventListener('scroll',stackRender,{passive:true});
stackRender();

// 03 editorial index
const rows=$$('.index-row');
const previews=$$('.index-preview-media');
function setIndexActive(i){
  rows.forEach((r,n)=>r.classList.toggle('active',n===i));
  previews.forEach((p,n)=>{
    p.classList.toggle('active',n===i);
    const v=p.querySelector('video');
    if(v && n===i) v.play().catch(()=>{});
  });
}
rows.forEach((r,i)=>{
  r.addEventListener('mouseenter',()=>setIndexActive(i));
  r.addEventListener('click',()=>setIndexActive(i));
});
const rowObserver=new IntersectionObserver(entries=>{
  entries.forEach(e=>{
    if(e.isIntersecting) setIndexActive(+e.target.dataset.row);
  });
},{rootMargin:'-44% 0px -44% 0px',threshold:0});
rows.forEach(r=>rowObserver.observe(r));
</script>
</body>
</html>