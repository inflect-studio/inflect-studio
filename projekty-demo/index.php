<?php
$manifest=__DIR__.'/../assets/projects/projects.json';
$projects=[];
if(is_file($manifest)){ $d=json_decode((string)file_get_contents($manifest),true); if(is_array($d))$projects=$d; }
$media=[];
foreach($projects as $p){
  $file=isset($p['file'])?basename((string)$p['file']):'';
  if(!$file)continue;
  $ext=strtolower(pathinfo($file,PATHINFO_EXTENSION));
  $media[]=['file'=>$file,'video'=>$ext==='mp4'];
}
function medium($m,$cls=''){
  $src='../assets/projects/'.htmlspecialchars($m['file']);
  if($m['video']) return '<video class="'.$cls.'" data-src="'.$src.'" muted loop playsinline preload="none"></video>';
  return '<img class="'.$cls.'" src="'.$src.'" alt="" loading="lazy">';
}
?>
<!doctype html><html lang="pl"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<meta name="theme-color" content="#090909"><title>Showcase - Inflect Studio</title>
<style>
:root{--bg:#090909;--fg:#f3f1eb;--line:rgba(255,255,255,.13);--ease:cubic-bezier(.22,1,.36,1)}
*{box-sizing:border-box}html,body{margin:0;background:var(--bg);color:var(--fg);font-family:Arial,Helvetica,sans-serif;-webkit-font-smoothing:antialiased}body{overflow-x:hidden}
img,video{display:block;width:100%;height:100%;object-fit:cover}.view{display:none;min-height:100svh}.view.active{display:block}
.nav{position:fixed;z-index:100;top:0;left:0;width:100%;display:flex;justify-content:space-between;align-items:flex-start;padding:max(16px,env(safe-area-inset-top)) 16px 0;mix-blend-mode:difference;color:#fff;pointer-events:none}
.brand{color:inherit;text-decoration:none;font-size:10px;font-weight:600;letter-spacing:.16em;text-transform:uppercase;pointer-events:auto}.switch{display:flex;flex-direction:column;align-items:flex-end;gap:5px;pointer-events:auto}.switch button{border:0;background:transparent;color:inherit;padding:0;font:inherit;font-size:9px;letter-spacing:.13em;text-transform:uppercase;opacity:.35}.switch button.active{opacity:1}
/* 01 KINETIC MASONRY */
.masonry{padding:18vh 10px 18vh}.masonry-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px;align-items:start}.m-col{display:flex;flex-direction:column;gap:8px;will-change:transform}.m-col:nth-child(2){padding-top:13vh}.m-item{overflow:hidden;background:#171717;min-height:130px}.m-item:nth-child(4n+1){aspect-ratio:3/4}.m-item:nth-child(4n+2){aspect-ratio:1}.m-item:nth-child(4n+3){aspect-ratio:4/5}.m-item:nth-child(4n){aspect-ratio:4/3}.m-item img,.m-item video{transition:transform .7s var(--ease)}.m-item:active img,.m-item:active video{transform:scale(1.03)}
/* 02 VISUAL STREAM */
.stream{height:100svh;overflow:hidden;position:relative;background:#efede7;color:#111;touch-action:none}.stream-world{position:absolute;left:50%;top:50%;width:1200px;height:2200px;transform:translate(-50%,-50%);will-change:transform}.stream-item{position:absolute;overflow:hidden;background:#ddd;box-shadow:0 20px 70px rgba(0,0,0,.12);will-change:transform}.stream-item:nth-child(6n+1){width:310px;height:390px}.stream-item:nth-child(6n+2){width:390px;height:260px}.stream-item:nth-child(6n+3){width:240px;height:320px}.stream-item:nth-child(6n+4){width:350px;height:350px}.stream-item:nth-child(6n+5){width:280px;height:190px}.stream-item:nth-child(6n){width:250px;height:360px}
/* 03 EDITORIAL CHAOS */
.chaos{padding:18vh 0 20vh;background:#0b0b0b}.chaos-grid{display:grid;grid-template-columns:repeat(12,1fr);row-gap:14vh}.chaos-item{overflow:hidden;background:#171717;min-height:180px}.chaos-item:nth-child(8n+1){grid-column:1/13;aspect-ratio:4/5}.chaos-item:nth-child(8n+2){grid-column:2/9;aspect-ratio:3/4}.chaos-item:nth-child(8n+3){grid-column:7/13;aspect-ratio:1}.chaos-item:nth-child(8n+4){grid-column:1/11;aspect-ratio:16/10}.chaos-item:nth-child(8n+5){grid-column:5/13;aspect-ratio:4/5}.chaos-item:nth-child(8n+6){grid-column:1/7;aspect-ratio:3/4}.chaos-item:nth-child(8n+7){grid-column:3/12;aspect-ratio:1}.chaos-item:nth-child(8n){grid-column:1/13;aspect-ratio:9/13}.chaos-spacer{height:7vh}
.caption{position:fixed;z-index:90;left:16px;bottom:max(16px,env(safe-area-inset-bottom));mix-blend-mode:difference;color:white;pointer-events:none}.caption b{font-size:9px;letter-spacing:.15em;text-transform:uppercase}.caption span{display:block;margin-top:4px;font-size:9px;opacity:.48;letter-spacing:.08em}
@media(min-width:760px){.nav{padding-left:26px;padding-right:26px}.switch{flex-direction:row;gap:18px}.masonry{padding-left:22px;padding-right:22px}.masonry-grid{grid-template-columns:repeat(3,1fr);gap:12px}.m-col{gap:12px}.m-col:nth-child(2){padding-top:20vh}.m-col:nth-child(3){padding-top:8vh}.chaos-grid{row-gap:20vh}.chaos-item:nth-child(8n+1){grid-column:2/11;aspect-ratio:16/10}.chaos-item:nth-child(8n+2){grid-column:2/6}.chaos-item:nth-child(8n+3){grid-column:8/12}.chaos-item:nth-child(8n+4){grid-column:1/9}.chaos-item:nth-child(8n+5){grid-column:7/12}.chaos-item:nth-child(8n+6){grid-column:2/6}.chaos-item:nth-child(8n+7){grid-column:5/11}.chaos-item:nth-child(8n){grid-column:3/10;aspect-ratio:4/5}}
@media(prefers-reduced-motion:reduce){*{transition:none!important}}
</style></head><body>
<nav class="nav"><a class="brand" href="../index.php">Inflect Studio</a><div class="switch"><button class="active" data-view="masonry">01 Masonry</button><button data-view="stream">02 Stream</button><button data-view="chaos">03 Chaos</button></div></nav>
<div class="caption"><b id="ct">Kinetic Masonry</b><span id="cc">Selected fragments / scroll</span></div>
<main>
<section class="view active masonry" id="masonry"><div class="masonry-grid">
<?php $cols=[[],[],[]]; foreach($media as $i=>$m)$cols[$i%3][]=$m; foreach($cols as $ci=>$col): ?><div class="m-col" data-col="<?=$ci?>"><?php foreach($col as $m): ?><div class="m-item"><?=medium($m)?></div><?php endforeach;?></div><?php endforeach;?>
</div></section>
<section class="view stream" id="stream"><div class="stream-world">
<?php foreach(array_slice($media,0,24) as $i=>$m): ?><div class="stream-item" data-i="<?=$i?>"><?=medium($m)?></div><?php endforeach;?>
</div></section>
<section class="view chaos" id="chaos"><div class="chaos-grid">
<?php foreach(array_slice($media,0,32) as $i=>$m): ?><div class="chaos-item"><?=medium($m)?></div><?php if($i%8===3):?><div class="chaos-spacer"></div><?php endif;?><?php endforeach;?>
</div></section>
</main>
<script>
const $$=(s,p=document)=>[...p.querySelectorAll(s)];
const labels={masonry:['Kinetic Masonry','Selected fragments / scroll'],stream:['Infinite Visual Stream','Drag the archive'],chaos:['Editorial Chaos','Selected fragments / scroll']};
function hydrate(root){$$('video[data-src]',root).forEach(v=>{if(!v.src){v.src=v.dataset.src;v.play().catch(()=>{})}})}
function show(id){$$('.view').forEach(v=>v.classList.toggle('active',v.id===id));$$('.switch button').forEach(b=>b.classList.toggle('active',b.dataset.view===id));ct.textContent=labels[id][0];cc.textContent=labels[id][1];scrollTo(0,0);hydrate(document.querySelector('#'+id));}
$$('.switch button').forEach(b=>b.onclick=()=>show(b.dataset.view));hydrate(masonry);
// masonry differential motion
let raf=0;function parallax(){raf=0;if(!masonry.classList.contains('active'))return;const y=scrollY;$$('.m-col').forEach((c,i)=>{const rates=[-.018,.025,-.01];c.style.transform=`translate3d(0,${y*rates[i]}px,0)`})}addEventListener('scroll',()=>{if(!raf)raf=requestAnimationFrame(parallax)},{passive:true});
// stream deterministic scattered field
const world=document.querySelector('.stream-world'),sis=$$('.stream-item');const spots=[[70,100],[510,40],[850,190],[180,510],[650,460],[910,650],[50,860],[430,800],[790,980],[160,1210],[600,1170],[900,1350],[60,1530],[440,1490],[780,1680],[180,1880],[610,1850],[900,1990],[360,300],[760,720],[330,1030],[720,1420],[90,2050],[620,2080]];
sis.forEach((el,i)=>{const p=spots[i%spots.length];el.style.left=p[0]+'px';el.style.top=p[1]+'px';el.style.transform=`rotate(${((i*17)%9)-4}deg)`});
let tx=0,ty=0,cx=0,cy=0,drag=false,lx=0,ly=0;
stream.onpointerdown=e=>{drag=true;lx=e.clientX;ly=e.clientY;stream.setPointerCapture(e.pointerId)};
stream.onpointermove=e=>{if(!drag)return;tx+=e.clientX-lx;ty+=e.clientY-ly;lx=e.clientX;ly=e.clientY};
stream.onpointerup=()=>drag=false;stream.onpointercancel=()=>drag=false;
stream.addEventListener('wheel',e=>{tx-=e.deltaX*.5;ty-=e.deltaY*.5},{passive:true});
function tick(){cx+=(tx-cx)*.075;cy+=(ty-cy)*.075;world.style.transform=`translate(calc(-50% + ${cx}px),calc(-50% + ${cy}px))`;requestAnimationFrame(tick)}tick();
</script></body></html>