<?php
$manifest = __DIR__ . '/../assets/projects/projects.json';
$projects = [];
if (is_file($manifest)) {
  $decoded = json_decode((string) file_get_contents($manifest), true);
  if (is_array($decoded)) $projects = $decoded;
}
$media = [];
foreach ($projects as $p) {
  $file = isset($p['file']) ? basename((string)$p['file']) : '';
  if (!$file) continue;
  $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
  $media[] = ['file'=>$file,'video'=>$ext === 'mp4'];
}
?>
<!doctype html>
<html lang="pl">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Projekty Demo - Inflect Studio</title>
<style>
:root{--bg:#0b0b0b;--fg:#f4f2ec;--muted:#8f8f8b;--line:rgba(255,255,255,.16)}
*{box-sizing:border-box}html,body{margin:0;background:var(--bg);color:var(--fg);font-family:Arial,Helvetica,sans-serif}body{overflow-x:hidden}
header{position:fixed;z-index:50;top:0;left:0;width:100%;display:flex;justify-content:space-between;padding:22px 28px;mix-blend-mode:difference;color:#fff;font-size:12px;letter-spacing:.16em;text-transform:uppercase;pointer-events:none}
header a{color:inherit;text-decoration:none;pointer-events:auto}.switcher{display:flex;gap:18px;pointer-events:auto}.switcher button{border:0;background:transparent;color:inherit;cursor:pointer;font:inherit;letter-spacing:inherit;text-transform:uppercase;opacity:.45}.switcher button.active{opacity:1}
main{min-height:100vh}.view{display:none;min-height:100vh}.view.active{display:block}
.intro{position:fixed;z-index:10;left:28px;bottom:25px;max-width:420px;pointer-events:none}.intro h1{margin:0;font-size:clamp(42px,6vw,96px);line-height:.88;letter-spacing:-.065em}.intro p{margin:14px 0 0;color:#aaa;font-size:12px;letter-spacing:.1em;text-transform:uppercase}
/* 01 depth */
.depth{height:700vh;position:relative}.depth-stage{position:sticky;top:0;height:100vh;overflow:hidden;perspective:1100px}.depth-world{position:absolute;inset:0;transform-style:preserve-3d}.depth-card{position:absolute;left:50%;top:50%;width:min(42vw,680px);aspect-ratio:4/3;overflow:hidden;background:#161616;box-shadow:0 30px 90px rgba(0,0,0,.45);will-change:transform,opacity}.depth-card img,.depth-card video{width:100%;height:100%;object-fit:cover;display:block}
/* 02 rail */
.rail{height:100vh;display:flex;align-items:center;overflow:hidden;cursor:grab}.rail:active{cursor:grabbing}.rail-track{display:flex;align-items:center;gap:clamp(18px,2vw,34px);padding:0 16vw;will-change:transform}.rail-item{flex:0 0 auto;width:clamp(250px,32vw,570px);aspect-ratio:4/3;overflow:hidden;background:#161616;transform-origin:center;transition:transform .5s cubic-bezier(.22,1,.36,1),opacity .5s}.rail-item:nth-child(3n+2){width:clamp(210px,25vw,440px);aspect-ratio:3/4}.rail-item img,.rail-item video{width:100%;height:100%;object-fit:cover;display:block}
/* 03 field */
.field{height:100vh;overflow:hidden;position:relative;cursor:move}.field-world{position:absolute;left:50%;top:50%;width:2200px;height:1500px;transform:translate(-50%,-50%);will-change:transform}.field-item{position:absolute;width:300px;overflow:hidden;background:#161616;box-shadow:0 18px 70px rgba(0,0,0,.3);transition:transform .45s cubic-bezier(.22,1,.36,1),z-index 0s}.field-item:hover{transform:scale(1.08);z-index:5}.field-item img,.field-item video{width:100%;height:auto;display:block}.field-label{position:absolute;left:18px;top:18px;z-index:3;font-size:11px;letter-spacing:.14em;text-transform:uppercase;color:#fff;mix-blend-mode:difference}
@media(max-width:700px){header{padding:18px 16px;align-items:flex-start}.switcher{gap:8px;flex-direction:column;align-items:flex-end}.intro{left:16px;bottom:18px}.depth-card{width:72vw}.rail-track{padding:0 24vw}.rail-item{width:68vw}.field-world{transform:translate(-50%,-50%) scale(.7)}}
</style>
</head>
<body>
<header><a href="../index.php">INFLECT STUDIO</a><div class="switcher"><button data-view="depth" class="active">01 DEPTH</button><button data-view="rail">02 RAIL</button><button data-view="field">03 FIELD</button></div></header>
<main>
<section id="depth" class="view active depth"><div class="depth-stage"><div class="depth-world">
<?php foreach(array_slice($media,0,18) as $i=>$m): ?><figure class="depth-card" data-i="<?=$i?>"><?php if($m['video']):?><video data-src="../assets/projects/<?=htmlspecialchars($m['file'])?>" muted loop playsinline preload="none"></video><?php else:?><img src="../assets/projects/<?=htmlspecialchars($m['file'])?>" alt="" loading="lazy"><?php endif;?></figure><?php endforeach;?>
</div></div></section>
<section id="rail" class="view rail"><div class="rail-track">
<?php foreach(array_slice($media,0,24) as $i=>$m): ?><figure class="rail-item"><?php if($m['video']):?><video data-src="../assets/projects/<?=htmlspecialchars($m['file'])?>" muted loop playsinline preload="none"></video><?php else:?><img src="../assets/projects/<?=htmlspecialchars($m['file'])?>" alt="" loading="lazy"><?php endif;?></figure><?php endforeach;?>
</div></section>
<section id="field" class="view field"><div class="field-world">
<?php foreach(array_slice($media,0,20) as $i=>$m): ?><figure class="field-item" data-i="<?=$i?>"><span class="field-label"><?=str_pad((string)($i+1),2,'0',STR_PAD_LEFT)?></span><?php if($m['video']):?><video data-src="../assets/projects/<?=htmlspecialchars($m['file'])?>" muted loop playsinline preload="none"></video><?php else:?><img src="../assets/projects/<?=htmlspecialchars($m['file'])?>" alt="" loading="lazy"><?php endif;?></figure><?php endforeach;?>
</div></section>
</main>
<div class="intro"><h1 id="view-title">Depth<br>Archive</h1><p id="view-copy">Scroll-driven spatial gallery / 01</p></div>
<script>
const $$=(s,p=document)=>[...p.querySelectorAll(s)];
function hydrate(root){$$('video[data-src]',root).forEach(v=>{if(!v.src){v.src=v.dataset.src;v.play().catch(()=>{})}})}
const titles={depth:['Depth<br>Archive','Scroll-driven spatial gallery / 01'],rail:['Infinite<br>Rail','Velocity-driven horizontal archive / 02'],field:['Project<br>Field','Draggable infinite-style canvas / 03']};
$$('.switcher button').forEach(b=>b.onclick=()=>{$$('.switcher button').forEach(x=>x.classList.toggle('active',x===b));$$('.view').forEach(v=>v.classList.toggle('active',v.id===b.dataset.view));document.querySelector('#view-title').innerHTML=titles[b.dataset.view][0];document.querySelector('#view-copy').textContent=titles[b.dataset.view][1];hydrate(document.querySelector('#'+b.dataset.view));});
hydrate(document.querySelector('#depth'));
// depth z-stack
const depth=document.querySelector('#depth'),cards=$$('.depth-card');
function depthRender(){if(!depth.classList.contains('active'))return;const max=depth.scrollHeight-innerHeight;const p=max?scrollY/max:0;const travel=p*(cards.length+2);cards.forEach((el,i)=>{const d=i-travel;const z=-d*430;const y=d*34;const x=Math.sin(i*1.71)*170;const rot=Math.sin(i*.83)*5;const scale=Math.max(.35,1+d*.018);el.style.transform=`translate(-50%,-50%) translate3d(${x}px,${y}px,${z}px) rotateZ(${rot}deg) scale(${scale})`;el.style.opacity=d<-1.2||d>8?0:1;});}addEventListener('scroll',depthRender,{passive:true});depthRender();
// rail drag + wheel
const rail=document.querySelector('#rail'),track=document.querySelector('.rail-track');let rx=0,rv=0,drag=false,last=0;
rail.addEventListener('wheel',e=>{if(rail.classList.contains('active')){e.preventDefault();rv-=e.deltaY*.55}},{passive:false});rail.onpointerdown=e=>{drag=true;last=e.clientX;rail.setPointerCapture(e.pointerId)};rail.onpointermove=e=>{if(drag){rv+=(e.clientX-last)*1.15;last=e.clientX}};rail.onpointerup=()=>drag=false;
function railTick(){if(rail.classList.contains('active')){rx+=rv;rv*=.9;const min=-(track.scrollWidth-innerWidth+120);rx=Math.max(min,Math.min(0,rx));track.style.transform=`translate3d(${rx}px,0,0)`;const center=innerWidth/2;$$('.rail-item').forEach(el=>{const r=el.getBoundingClientRect(),d=Math.abs((r.left+r.width/2)-center)/innerWidth;el.style.transform=`scale(${1-Math.min(.22,d*.22)}) rotateY(${((r.left+r.width/2)-center)/innerWidth*8}deg)`;el.style.opacity=1-Math.min(.5,d*.45)})}requestAnimationFrame(railTick)}railTick();
// field layout + inertial drag
const field=document.querySelector('#field'),world=document.querySelector('.field-world'),fis=$$('.field-item');fis.forEach((el,i)=>{const col=i%5,row=Math.floor(i/5);el.style.left=(130+col*390+(row%2)*80)+'px';el.style.top=(100+row*340+(col%2)*55)+'px';el.style.width=(230+(i%3)*55)+'px'});
let fx=0,fy=0,tx=0,ty=0,fd=false,lx=0,ly=0;field.onpointerdown=e=>{fd=true;lx=e.clientX;ly=e.clientY;field.setPointerCapture(e.pointerId)};field.onpointermove=e=>{if(fd){tx+=e.clientX-lx;ty+=e.clientY-ly;lx=e.clientX;ly=e.clientY}};field.onpointerup=()=>fd=false;field.addEventListener('wheel',e=>{tx-=e.deltaX*.45;ty-=e.deltaY*.45},{passive:true});function fieldTick(){fx+=(tx-fx)*.08;fy+=(ty-fy)*.08;world.style.transform=`translate(calc(-50% + ${fx}px),calc(-50% + ${fy}px))`;requestAnimationFrame(fieldTick)}fieldTick();
</script>
</body></html>