<?php
$dataPath = __DIR__ . '/restaurants.json';
$restaurants = [];
if (is_file($dataPath)) {
  $decoded = json_decode((string) file_get_contents($dataPath), true);
  if (is_array($decoded)) $restaurants = $decoded;
}
?>
<!doctype html>
<html lang="pl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<meta name="theme-color" content="#0c0c0c">
<title>Sushi Kraków - ranking sushi</title>
<style>
:root{
  --bg:#0c0c0c;
  --surface:#151515;
  --surface-2:#1d1d1d;
  --fg:#f5f2ea;
  --muted:#9e9b95;
  --line:rgba(255,255,255,.12);
  --accent:#d7ff4b;
  --danger:#ff5a5f;
  --radius:22px;
}
*{box-sizing:border-box}
html{background:var(--bg);scroll-behavior:smooth}
body{margin:0;background:var(--bg);color:var(--fg);font-family:Inter,Arial,Helvetica,sans-serif;-webkit-font-smoothing:antialiased}
button,input{font:inherit}
a{color:inherit}
.app{max-width:560px;margin:0 auto;min-height:100vh;padding:0 16px 112px}
.topbar{position:sticky;top:0;z-index:30;display:flex;align-items:center;justify-content:space-between;padding:16px 0 12px;background:linear-gradient(var(--bg) 70%,rgba(12,12,12,0))}
.brand{font-weight:800;letter-spacing:-.05em;font-size:23px}
.city{font-size:11px;text-transform:uppercase;letter-spacing:.16em;color:var(--muted)}
.icon-btn{width:42px;height:42px;border:1px solid var(--line);border-radius:50%;background:rgba(255,255,255,.04);color:var(--fg)}
.hero{padding:18px 0 10px}
.kicker{font-size:11px;text-transform:uppercase;letter-spacing:.18em;color:var(--accent);margin-bottom:12px}
h1{font-size:clamp(44px,12vw,74px);line-height:.88;letter-spacing:-.07em;margin:0;max-width:500px}
.hero p{color:var(--muted);font-size:15px;line-height:1.5;max-width:420px;margin:18px 0 20px}
.search{display:flex;gap:10px;align-items:center;background:var(--surface);border:1px solid var(--line);border-radius:18px;padding:0 14px;height:52px}
.search input{flex:1;background:transparent;border:0;outline:0;color:var(--fg);min-width:0}
.search input::placeholder{color:#6d6b67}
.chips{display:flex;gap:8px;overflow:auto;padding:14px 0 4px;scrollbar-width:none}
.chips::-webkit-scrollbar{display:none}
.chip{flex:0 0 auto;border:1px solid var(--line);background:transparent;color:var(--muted);border-radius:999px;padding:9px 13px;font-size:12px}
.chip.active{background:var(--fg);color:#111;border-color:var(--fg)}
.section{margin-top:34px}
.section-head{display:flex;align-items:end;justify-content:space-between;margin-bottom:14px}
.section-head h2{margin:0;font-size:24px;letter-spacing:-.04em}
.section-head button{border:0;background:none;color:var(--muted);font-size:12px}
.featured{display:flex;gap:12px;overflow-x:auto;scroll-snap-type:x mandatory;padding-bottom:4px;scrollbar-width:none}
.featured::-webkit-scrollbar{display:none}
.feature-card{position:relative;flex:0 0 88%;height:390px;border-radius:26px;overflow:hidden;background:var(--surface);scroll-snap-align:start}
.feature-card img{width:100%;height:100%;object-fit:cover;display:block}
.feature-card:after{content:"";position:absolute;inset:0;background:linear-gradient(180deg,transparent 35%,rgba(0,0,0,.88) 100%)}
.badges{position:absolute;z-index:2;top:14px;left:14px;display:flex;gap:7px;flex-wrap:wrap}
.badge{padding:7px 10px;border-radius:999px;font-size:10px;letter-spacing:.08em;text-transform:uppercase;background:rgba(12,12,12,.75);backdrop-filter:blur(12px)}
.badge.accent{background:var(--accent);color:#111}
.feature-info{position:absolute;z-index:2;left:18px;right:18px;bottom:18px}
.feature-info h3{font-size:34px;letter-spacing:-.05em;margin:0 0 8px}
.meta{display:flex;gap:10px;align-items:center;color:#d7d3ca;font-size:12px}
.rank-list{display:flex;flex-direction:column;gap:10px}
.rank-card{display:grid;grid-template-columns:42px 78px 1fr auto;gap:12px;align-items:center;padding:10px;border:1px solid var(--line);border-radius:20px;background:var(--surface)}
.rank-no{font-size:22px;font-weight:700;color:var(--muted);text-align:center}
.rank-card img{width:78px;height:78px;border-radius:15px;object-fit:cover}
.rank-main{min-width:0}
.rank-main h3{font-size:17px;margin:0 0 6px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.rank-main p{font-size:11px;color:var(--muted);margin:0 0 7px}
.tagline{display:flex;gap:5px;flex-wrap:wrap}
.tag{font-size:9px;text-transform:uppercase;letter-spacing:.08em;color:#b7b4ae}
.vote-btn{width:48px;height:48px;border-radius:16px;border:1px solid var(--line);background:#202020;color:var(--fg);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:1px}
.vote-btn.voted{background:var(--accent);color:#111;border-color:var(--accent)}
.vote-btn span{font-size:10px}
.deals{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.deal{min-height:165px;padding:14px;border-radius:20px;background:var(--accent);color:#111;display:flex;flex-direction:column;justify-content:space-between}
.deal.dark{background:var(--surface);color:var(--fg);border:1px solid var(--line)}
.deal-name{font-size:12px;opacity:.72}
.deal-value{font-size:38px;line-height:.9;letter-spacing:-.06em;font-weight:800}
.deal-code{font-family:ui-monospace,SFMono-Regular,Menlo,monospace;font-size:11px}
.new-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.new-card{border-radius:20px;overflow:hidden;background:var(--surface);border:1px solid var(--line)}
.new-card img{width:100%;aspect-ratio:1/1;object-fit:cover}
.new-card .body{padding:12px}
.new-card h3{margin:0 0 4px;font-size:15px}
.new-card p{margin:0;color:var(--muted);font-size:11px}
.bottom-nav{position:fixed;z-index:40;left:50%;bottom:max(12px,env(safe-area-inset-bottom));transform:translateX(-50%);width:min(calc(100% - 24px),536px);display:grid;grid-template-columns:repeat(4,1fr);background:rgba(20,20,20,.88);backdrop-filter:blur(20px);border:1px solid var(--line);border-radius:22px;padding:7px}
.nav-btn{border:0;background:transparent;color:var(--muted);padding:10px 5px;border-radius:16px;font-size:10px;text-transform:uppercase;letter-spacing:.08em}
.nav-btn.active{background:var(--fg);color:#111}
.view{display:none}.view.active{display:block}
.sheet{position:fixed;z-index:100;inset:0;display:none;align-items:flex-end;background:rgba(0,0,0,.56)}
.sheet.open{display:flex}
.sheet-card{width:min(100%,560px);max-height:92vh;margin:0 auto;background:#111;border-radius:28px 28px 0 0;overflow:auto;padding-bottom:36px}
.sheet-hero{position:relative;height:320px}
.sheet-hero img{width:100%;height:100%;object-fit:cover}
.sheet-close{position:absolute;right:14px;top:14px;width:42px;height:42px;border-radius:50%;border:0;background:rgba(0,0,0,.65);color:#fff;font-size:20px}
.sheet-body{padding:18px}
.sheet-title{font-size:38px;letter-spacing:-.055em;margin:0 0 8px}
.sheet-desc{color:var(--muted);line-height:1.5;font-size:14px}
.info-row{display:flex;justify-content:space-between;gap:20px;padding:15px 0;border-top:1px solid var(--line);font-size:13px}
.coupon{margin-top:18px;border-radius:20px;padding:16px;background:var(--accent);color:#111}
.coupon small{display:block;text-transform:uppercase;letter-spacing:.12em;margin-bottom:8px}
.coupon strong{font-size:32px;letter-spacing:-.04em}
.coupon button{margin-top:12px;width:100%;border:0;background:#111;color:white;border-radius:14px;padding:12px}
.empty{padding:28px 0;color:var(--muted);text-align:center}
.demo-note{margin-top:28px;padding:14px;border:1px dashed var(--line);border-radius:16px;color:var(--muted);font-size:11px;line-height:1.45}
@media(min-width:700px){body{background:#090909}.app{border-left:1px solid rgba(255,255,255,.04);border-right:1px solid rgba(255,255,255,.04)}}

/* UI refinement */
body{background:
  radial-gradient(900px 480px at 50% -220px,rgba(215,255,75,.075),transparent 68%),
  var(--bg)}
.app{padding-left:18px;padding-right:18px}
.topbar{padding-top:max(18px,env(safe-area-inset-top));padding-bottom:14px}
.brand{font-size:21px;letter-spacing:-.055em}
.city{margin-top:3px;font-size:9px;letter-spacing:.19em}
.hero{padding-top:30px}
.hero .kicker{margin-bottom:15px}
.hero h1{font-size:clamp(52px,15vw,82px);line-height:.84;letter-spacing:-.075em}
.hero p{max-width:360px;font-size:14px;line-height:1.55;margin-top:20px;margin-bottom:24px}
.search{height:56px;border-radius:18px;background:#131313;border-color:rgba(255,255,255,.1);transition:border-color .25s,background .25s}
.search:focus-within{border-color:rgba(215,255,75,.55);background:#171717}
.chips{padding-top:12px;gap:7px}
.chip{padding:9px 14px;border-color:rgba(255,255,255,.1);transition:.22s ease}
.chip.active{background:var(--accent);border-color:var(--accent);color:#111}
.section{margin-top:42px}
.section-head{margin-bottom:16px}
.section-head h2{font-size:25px;letter-spacing:-.05em}
.section-head button{color:#85827d}
.feature-card{flex-basis:91%;height:420px;border-radius:24px}
.feature-card:after{background:linear-gradient(180deg,rgba(0,0,0,.02) 28%,rgba(0,0,0,.92) 100%)}
.feature-info{left:20px;right:20px;bottom:20px}
.feature-info h3{font-size:36px;line-height:.95}
.rank-list{gap:8px}
.rank-card{grid-template-columns:38px 72px 1fr auto;padding:9px;border-radius:18px;background:#111;border-color:rgba(255,255,255,.085);transition:transform .2s,background .2s}
.rank-card:active{transform:scale(.985);background:#171717}
.rank-card img{width:72px;height:72px;border-radius:13px}
.rank-no{font-size:18px;letter-spacing:-.05em}
.vote-btn{width:46px;height:46px;border-radius:15px;background:#191919}
.vote-btn b{font-size:17px}
.deals{gap:8px}
.deal{min-height:175px;border-radius:18px;padding:15px}
.deal-value{font-size:42px}
.new-grid{gap:8px}
.new-card{border-radius:18px;border-color:rgba(255,255,255,.085)}
.bottom-nav{bottom:max(10px,env(safe-area-inset-bottom));border-radius:20px;padding:6px;background:rgba(18,18,18,.84);box-shadow:0 12px 45px rgba(0,0,0,.45)}
.nav-btn{padding:11px 5px;border-radius:14px;font-size:9px}
.nav-btn.active{background:var(--accent)}
.sheet{backdrop-filter:blur(5px)}
.sheet-card{background:#101010;border-radius:26px 26px 0 0}
.sheet-hero{height:350px}
.sheet-body{padding:20px}
.sheet-title{font-size:42px;line-height:.94}
.info-row{border-color:rgba(255,255,255,.09)}
.coupon{border-radius:18px}
@media(max-width:380px){
  .app{padding-left:14px;padding-right:14px}
  .hero h1{font-size:50px}
  .rank-card{grid-template-columns:32px 64px 1fr auto;gap:9px}
  .rank-card img{width:64px;height:64px}
}

</style>
</head>
<body>
<div class="app">
  <header class="topbar">
    <div><div class="brand">SUSHI KRAKÓW</div><div class="city">Kraków / city guide</div></div>
    <button class="icon-btn" id="randomBtn" aria-label="Losuj restaurację">✦</button>
  </header>

  <section class="view active" data-view="home">
    <div class="hero">
      <div class="kicker">Sushi guide / Kraków</div>
      <h1>Gdzie dziś<br>na sushi?</h1>
      <p>Najciekawsze sushi w Krakowie - wybierane przez ludzi, którzy naprawdę je jedzą.</p>
      <label class="search"><span>⌕</span><input id="searchInput" type="search" placeholder="Szukaj restauracji lub dzielnicy"></label>
      <div class="chips" id="chips"><button class="chip active" data-filter="all">Wszystko</button><button class="chip" data-filter="promo">Promocje</button><button class="chip" data-filter="new">Nowe</button><button class="chip" data-filter="featured">Wyróżnione</button></div>
    </div>

    <section class="section">
      <div class="section-head"><h2>Wyróżnione</h2><button data-go="ranking">Zobacz ranking →</button></div>
      <div class="featured" id="featuredList"></div>
    </section>

    <section class="section">
      <div class="section-head"><h2>Top w Krakowie</h2><button data-go="ranking">Pełna lista →</button></div>
      <div class="rank-list" id="homeRanking"></div>
    </section>

    <section class="section">
      <div class="section-head"><h2>Kody i promocje</h2><button data-go="deals">Wszystkie →</button></div>
      <div class="deals" id="homeDeals"></div>
    </section>

    <section class="section">
      <div class="section-head"><h2>Nowe miejsca</h2><button data-go="new">Zobacz nowe →</button></div>
      <div class="new-grid" id="homeNew"></div>
    </section>
    
  </section>

  <section class="view" data-view="ranking">
    <div class="hero"><div class="kicker">Community ranking</div><h1>Ranking<br>Krakowa.</h1><p>Głosuj na lokale, które faktycznie polecasz. Ranking aktualizuje się lokalnie w tym MVP.</p></div>
    <div class="rank-list" id="fullRanking"></div>
  </section>

  <section class="view" data-view="deals">
    <div class="hero"><div class="kicker">Partner benefits</div><h1>Kody.<br>Promocje.</h1><p>Jedno miejsce na aktywne benefity i kody dla użytkowników Sushi Kraków.</p></div>
    <div class="deals" id="allDeals"></div>
  </section>

  <section class="view" data-view="new">
    <div class="hero"><div class="kicker">Fresh spots</div><h1>Nowe<br>w Krakowie.</h1><p>Nowo dodane lokale i miejsca, które dopiero budują swoją pozycję.</p></div>
    <div class="new-grid" id="allNew"></div>
  </section>
</div>

<nav class="bottom-nav">
  <button class="nav-btn active" data-go="home">Start</button>
  <button class="nav-btn" data-go="ranking">Ranking</button>
  <button class="nav-btn" data-go="deals">Kody</button>
  <button class="nav-btn" data-go="new">Nowe</button>
</nav>

<div class="sheet" id="sheet">
  <div class="sheet-card" id="sheetCard"></div>
</div>

<script>
const baseData = <?=json_encode($restaurants, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)?>;
const voteStore = JSON.parse(localStorage.getItem('sushikrakow_votes') || '{}');
let currentFilter='all', query='';

const esc=s=>String(s??'').replace(/[&<>"']/g,m=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]));
const data=()=>baseData.map(r=>({...r,score:r.score+(voteStore[r.id]?1:0),votes:r.votes+(voteStore[r.id]?1:0)})).sort((a,b)=>b.score-a.score);
function filtered(){
  return data().filter(r=>{
    const q=(r.name+' '+r.district+' '+(r.tags||[]).join(' ')).toLowerCase();
    const qok=!query||q.includes(query.toLowerCase());
    const fok=currentFilter==='all'||(currentFilter==='promo'&&r.discount?.active)||(currentFilter==='new'&&r.new)||(currentFilter==='featured'&&r.featured);
    return qok&&fok;
  });
}
function rankCard(r,i){
  return `<article class="rank-card" data-open="${r.id}">
    <div class="rank-no">#${String(i+1).padStart(2,'0')}</div>
    <img src="${esc(r.image)}" alt="">
    <div class="rank-main"><h3>${esc(r.name)}</h3><p>${esc(r.district)} · ${esc(r.price)}</p><div class="tagline">${(r.tags||[]).slice(0,3).map(t=>`<span class="tag">${esc(t)}</span>`).join('')}</div></div>
    <button class="vote-btn ${voteStore[r.id]?'voted':''}" data-vote="${r.id}" aria-label="Poleć"><b>↑</b><span>${r.votes}</span></button>
  </article>`;
}
function featuredCard(r){
 return `<article class="feature-card" data-open="${r.id}"><img src="${esc(r.image)}" alt=""><div class="badges">${r.featured?'<span class="badge accent">Wyróżnione</span>':''}${r.discount?.active?'<span class="badge">Kod</span>':''}</div><div class="feature-info"><h3>${esc(r.name)}</h3><div class="meta"><span>${esc(r.district)}</span><span>·</span><span>↑ ${r.votes} poleceń</span></div></div></article>`;
}
function dealCard(r,i){
 const d=r.discount; return `<article class="deal ${i%2?'dark':''}" data-open="${r.id}"><div class="deal-name">${esc(r.name)}</div><div class="deal-value">${esc(d.label)}</div><div class="deal-code">${esc(d.code)}</div></article>`;
}
function newCard(r){return `<article class="new-card" data-open="${r.id}"><img src="${esc(r.image)}" alt=""><div class="body"><h3>${esc(r.name)}</h3><p>${esc(r.district)}</p></div></article>`}

function render(){
 const d=filtered();
 document.querySelector('#featuredList').innerHTML=d.filter(r=>r.featured).map(featuredCard).join('')||'<div class="empty">Brak wyników</div>';
 document.querySelector('#homeRanking').innerHTML=d.slice(0,5).map(rankCard).join('')||'<div class="empty">Brak wyników</div>';
 document.querySelector('#homeDeals').innerHTML=d.filter(r=>r.discount?.active).slice(0,4).map(dealCard).join('')||'<div class="empty">Brak aktywnych kodów</div>';
 document.querySelector('#homeNew').innerHTML=d.filter(r=>r.new).slice(0,4).map(newCard).join('')||'<div class="empty">Brak nowych miejsc</div>';
 const all=data();
 document.querySelector('#fullRanking').innerHTML=all.map(rankCard).join('');
 document.querySelector('#allDeals').innerHTML=all.filter(r=>r.discount?.active).map(dealCard).join('');
 document.querySelector('#allNew').innerHTML=all.filter(r=>r.new).map(newCard).join('');
 bindDynamic();
}
function bindDynamic(){
 document.querySelectorAll('[data-open]').forEach(el=>el.onclick=e=>{if(e.target.closest('[data-vote]'))return;openSheet(el.dataset.open)});
 document.querySelectorAll('[data-vote]').forEach(btn=>btn.onclick=e=>{e.stopPropagation();const id=btn.dataset.vote;voteStore[id]=!voteStore[id];if(!voteStore[id])delete voteStore[id];localStorage.setItem('sushikrakow_votes',JSON.stringify(voteStore));render()});
}
function openSheet(id){
 const r=data().find(x=>x.id===id); if(!r)return;
 const coupon=r.discount?.active?`<div class="coupon"><small>Kod dla użytkowników</small><strong>${esc(r.discount.label)} · ${esc(r.discount.code)}</strong><p>${esc(r.discount.description)}</p><button data-copy="${esc(r.discount.code)}">Kopiuj kod</button></div>`:'';
 document.querySelector('#sheetCard').innerHTML=`<div class="sheet-hero"><img src="${esc(r.image)}" alt=""><button class="sheet-close">×</button></div><div class="sheet-body"><div class="kicker">${esc(r.district)} / ${esc(r.price)}</div><h2 class="sheet-title">${esc(r.name)}</h2><p class="sheet-desc">${esc(r.description)}</p><div class="info-row"><span>Ranking</span><strong>↑ ${r.votes} poleceń</strong></div><div class="info-row"><span>Adres</span><strong>${esc(r.address)}</strong></div><div class="info-row"><span>Tagi</span><strong>${esc((r.tags||[]).join(' · '))}</strong></div>${coupon}</div>`;
 document.querySelector('#sheet').classList.add('open');
 document.querySelector('.sheet-close').onclick=closeSheet;
 const copy=document.querySelector('[data-copy]'); if(copy)copy.onclick=async()=>{try{await navigator.clipboard.writeText(copy.dataset.copy);copy.textContent='Skopiowano ✓'}catch{copy.textContent=copy.dataset.copy}};
}
function closeSheet(){document.querySelector('#sheet').classList.remove('open')}
document.querySelector('#sheet').onclick=e=>{if(e.target.id==='sheet')closeSheet()};
document.querySelector('#searchInput').addEventListener('input',e=>{query=e.target.value;render()});
document.querySelectorAll('.chip').forEach(ch=>ch.onclick=()=>{document.querySelectorAll('.chip').forEach(x=>x.classList.toggle('active',x===ch));currentFilter=ch.dataset.filter;render()});
function go(view){document.querySelectorAll('.view').forEach(v=>v.classList.toggle('active',v.dataset.view===view));document.querySelectorAll('.nav-btn').forEach(b=>b.classList.toggle('active',b.dataset.go===view));scrollTo({top:0,behavior:'smooth'})}
document.querySelectorAll('[data-go]').forEach(b=>b.onclick=()=>go(b.dataset.go));
document.querySelector('#randomBtn').onclick=()=>{const d=data();openSheet(d[Math.floor(Math.random()*d.length)].id)};
render();
</script>
</body>
</html>