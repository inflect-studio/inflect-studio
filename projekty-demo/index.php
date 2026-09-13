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
/* 01 - THREE MASONRY SYSTEMS / ORIGINAL MEDIA RATIOS */
.masonry{padding:15vh 10px 18vh}
.masonry-mode{display:none}.masonry-mode.active{display:block}
.masonry-subnav{position:fixed;z-index:95;left:16px;top:max(72px,calc(env(safe-area-inset-top) + 54px));display:flex;gap:10px;mix-blend-mode:difference;color:#fff}
.masonry-subnav button{border:0;background:none;color:inherit;padding:0;font:inherit;font-size:9px;letter-spacing:.12em;text-transform:uppercase;opacity:.35}.masonry-subnav button.active{opacity:1}
.m-natural{columns:2;column-gap:8px}.m-natural .m-item{break-inside:avoid;margin:0 0 8px;overflow:hidden;background:#171717}.m-natural img,.m-natural video{height:auto;object-fit:contain}
.m-kinetic{display:grid;grid-template-columns:1fr 1fr;gap:8px;align-items:start}.m-col{display:flex;flex-direction:column;gap:8px;will-change:transform}.m-col:nth-child(2){padding-top:13vh}.m-kinetic .m-item{overflow:hidden;background:#171717}.m-kinetic img,.m-kinetic video{height:auto;object-fit:contain}
.m-editorial{display:grid;grid-template-columns:repeat(12,1fr);gap:9vh 0}.m-editorial .m-item{overflow:hidden;background:#171717}.m-editorial img,.m-editorial video{height:auto;object-fit:contain}.m-editorial .m-item:nth-child(6n+1){grid-column:1/13}.m-editorial .m-item:nth-child(6n+2){grid-column:1/8}.m-editorial .m-item:nth-child(6n+3){grid-column:7/13}.m-editorial .m-item:nth-child(6n+4){grid-column:2/12}.m-editorial .m-item:nth-child(6n+5){grid-column:1/7}.m-editorial .m-item:nth-child(6n){grid-column:5/13}
/* 02 VISUAL STREAM */
.stream{height:100svh;overflow:hidden;position:relative;background:#efede7;color:#111;touch-action:none}.stream-world{position:absolute;left:50%;top:50%;width:1200px;height:2200px;transform:translate(-50%,-50%);will-change:transform}.stream-item{position:absolute;overflow:hidden;background:#ddd;box-shadow:0 20px 70px rgba(0,0,0,.12);will-change:transform}.stream-item:nth-child(6n+1){width:310px;height:390px}.stream-item:nth-child(6n+2){width:390px;height:260px}.stream-item:nth-child(6n+3){width:240px;height:320px}.stream-item:nth-child(6n+4){width:350px;height:350px}.stream-item:nth-child(6n+5){width:280px;height:190px}.stream-item:nth-child(6n){width:250px;height:360px}
/* 03 EDITORIAL CHAOS */
.chaos{padding:18vh 0 20vh;background:#0b0b0b}.chaos-grid{display:grid;grid-template-columns:repeat(12,1fr);row-gap:14vh}.chaos-item{overflow:hidden;background:#171717;min-height:180px}.chaos-item:nth-child(8n+1){grid-column:1/13;aspect-ratio:4/5}.chaos-item:nth-child(8n+2){grid-column:2/9;aspect-ratio:3/4}.chaos-item:nth-child(8n+3){grid-column:7/13;aspect-ratio:1}.chaos-item:nth-child(8n+4){grid-column:1/11;aspect-ratio:16/10}.chaos-item:nth-child(8n+5){grid-column:5/13;aspect-ratio:4/5}.chaos-item:nth-child(8n+6){grid-column:1/7;aspect-ratio:3/4}.chaos-item:nth-child(8n+7){grid-column:3/12;aspect-ratio:1}.chaos-item:nth-child(8n){grid-column:1/13;aspect-ratio:9/13}.chaos-spacer{height:7vh}
.caption{position:fixed;z-index:90;left:16px;bottom:max(16px,env(safe-area-inset-bottom));mix-blend-mode:difference;color:white;pointer-events:none}.caption b{font-size:9px;letter-spacing:.15em;text-transform:uppercase}.caption span{display:block;margin-top:4px;font-size:9px;opacity:.48;letter-spacing:.08em}
@media(min-width:760px){.m-natural{columns:3;column-gap:12px}.m-natural .m-item{margin-bottom:12px}.m-kinetic{grid-template-columns:repeat(3,1fr);gap:12px}.masonry-subnav{left:26px}.nav{padding-left:26px;padding-right:26px}.switch{flex-direction:row;gap:18px}.masonry{padding-left:22px;padding-right:22px}.masonry-grid{grid-template-columns:repeat(3,1fr);gap:12px}.m-col{gap:12px}.m-col:nth-child(2){padding-top:20vh}.m-col:nth-child(3){padding-top:8vh}.chaos-grid{row-gap:20vh}.chaos-item:nth-child(8n+1){grid-column:2/11;aspect-ratio:16/10}.chaos-item:nth-child(8n+2){grid-column:2/6}.chaos-item:nth-child(8n+3){grid-column:8/12}.chaos-item:nth-child(8n+4){grid-column:1/9}.chaos-item:nth-child(8n+5){grid-column:7/12}.chaos-item:nth-child(8n+6){grid-column:2/6}.chaos-item:nth-child(8n+7){grid-column:5/11}.chaos-item:nth-child(8n){grid-column:3/10;aspect-ratio:4/5}}
@media(prefers-reduced-motion:reduce){*{transition:none!important}}
</style><style id="masonry-video-fix">
.masonry video{display:block;width:100%;height:auto;background:#141414}
.masonry-subnav{pointer-events:auto}
.masonry-subnav button{pointer-events:auto;cursor:pointer}
</style>
<style id="masonry-mobile-grid-fix">
/* Force true two-column mobile layouts while preserving intrinsic media ratios */
.m-natural{
  columns:auto !important;
  display:grid !important;
  grid-template-columns:minmax(0,1fr) minmax(0,1fr) !important;
  gap:8px !important;
  align-items:start;
}
.m-natural .m-item{
  width:100%;
  min-width:0;
  margin:0 !important;
  break-inside:auto;
}
.m-natural .m-item img,
.m-natural .m-item video,
.m-kinetic .m-item img,
.m-kinetic .m-item video{
  display:block;
  width:100%;
  height:auto !important;
  object-fit:contain;
}
.m-kinetic{
  display:grid !important;
  grid-template-columns:minmax(0,1fr) minmax(0,1fr) !important;
  gap:8px !important;
  align-items:start;
}
.m-kinetic .m-col{
  min-width:0;
  width:100%;
}
@media(min-width:760px){
  .m-natural{grid-template-columns:repeat(3,minmax(0,1fr)) !important;gap:12px !important}
  .m-kinetic{grid-template-columns:repeat(3,minmax(0,1fr)) !important;gap:12px !important}
}
</style>
</head><body>
<nav class="nav"><a class="brand" href="../index.php">Inflect Studio</a><div class="switch"><button class="active" data-view="masonry">Masonry Study</button></div></nav>
<div class="caption"><b id="ct">Kinetic Masonry</b><span id="cc">Selected fragments / scroll</span></div>
<main>
<section class="view active masonry" id="masonry">
<div class="masonry-subnav"><button class="active" data-masonry="natural">A Natural</button><button data-masonry="kinetic">B Kinetic</button><button data-masonry="editorial">C Editorial</button></div>

<div class="masonry-mode active" data-masonry-mode="natural"><div class="m-natural">
<?php foreach(array_slice($media,0,36) as $m): ?><div class="m-item"><?=medium($m)?></div><?php endforeach;?>
</div></div>

<div class="masonry-mode" data-masonry-mode="kinetic"><div class="m-kinetic">
<?php $cols=[[],[]]; foreach(array_slice($media,0,36) as $i=>$m)$cols[$i%2][]=$m; foreach($cols as $ci=>$col): ?><div class="m-col" data-col="<?=$ci?>"><?php foreach($col as $m): ?><div class="m-item"><?=medium($m)?></div><?php endforeach;?></div><?php endforeach;?>
</div></div>

<div class="masonry-mode" data-masonry-mode="editorial"><div class="m-editorial">
<?php foreach(array_slice($media,0,30) as $m): ?><div class="m-item"><?=medium($m)?></div><?php endforeach;?>
</div></div>
</section>
<section class="view stream" id="stream"><div class="stream-world">
<?php foreach(array_slice($media,0,24) as $i=>$m): ?><div class="stream-item" data-i="<?=$i?>"><?=medium($m)?></div><?php endforeach;?>
</div></section>
<section class="view chaos" id="chaos"><div class="chaos-grid">
<?php foreach(array_slice($media,0,32) as $i=>$m): ?><div class="chaos-item"><?=medium($m)?></div><?php if($i%8===3):?><div class="chaos-spacer"></div><?php endif;?><?php endforeach;?>
</div></section>
</main>
<script>
const $$=(s,p=document)=>Array.from((p||document).querySelectorAll(s));
function hydrate(root){
  if(!root)return;
  $$('video[data-src]',root).forEach(v=>{
    v.muted=true; v.defaultMuted=true; v.loop=true; v.autoplay=true; v.playsInline=true;
    v.setAttribute('muted',''); v.setAttribute('playsinline',''); v.setAttribute('webkit-playsinline','');
    if(!v.getAttribute('src')){ v.setAttribute('src',v.dataset.src); v.load(); }
    const play=()=>v.play().catch(()=>{});
    if(v.readyState>=2) play(); else v.addEventListener('canplay',play,{once:true});
  });
}
const modes={
 natural:['Natural Masonry','Original ratios / compact'],
 kinetic:['Kinetic Masonry','Original ratios / differential scroll'],
 editorial:['Editorial Masonry','Original ratios / composed rhythm']
};
$$('[data-masonry]').forEach(btn=>{
  btn.addEventListener('click',()=>{
    const mode=btn.dataset.masonry;
    $$('[data-masonry]').forEach(x=>x.classList.toggle('active',x===btn));
    $$('[data-masonry-mode]').forEach(x=>{
      const active=x.dataset.masonryMode===mode;
      x.classList.toggle('active',active);
      if(active) hydrate(x);
    });
    document.getElementById('ct').textContent=modes[mode][0];
    document.getElementById('cc').textContent=modes[mode][1];
    window.scrollTo(0,0);
    parallax();
  });
});
hydrate(document.querySelector('[data-masonry-mode="natural"]'));
let raf=0;
function parallax(){
  raf=0;
  const kinetic=document.querySelector('[data-masonry-mode="kinetic"]');
  const cols=$$('.m-col');
  if(!kinetic || !kinetic.classList.contains('active')){cols.forEach(x=>x.style.transform='');return;}
  const rates=[-.018,.025,-.01];
  cols.forEach((el,i)=>el.style.transform='translate3d(0,'+(window.scrollY*(rates[i]||0))+'px,0)');
}
window.addEventListener('scroll',()=>{if(!raf)raf=requestAnimationFrame(parallax)},{passive:true});
document.addEventListener('visibilitychange',()=>{if(!document.hidden){const active=document.querySelector('[data-masonry-mode].active');hydrate(active);}});
</script></body></html>