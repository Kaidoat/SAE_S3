// Hamburger (mobile)
const btn = document.getElementById('nav-btn');
const menu = document.getElementById('mobile-menu');
function setOpen(state){
    btn.setAttribute('aria-expanded', String(state));
    btn.setAttribute('aria-label', state ? 'Fermer le menu' : 'Ouvrir le menu');
    document.documentElement.classList.toggle('nav-open', state);
}
btn.addEventListener('click', () => {
    const open = btn.getAttribute('aria-expanded') === 'true';
    setOpen(!open);
    (!open ? (menu.querySelector('a')||btn).focus() : btn.focus());
});
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && btn.getAttribute('aria-expanded') === 'true') {
        setOpen(false); btn.focus();
    }
});

// Recherche interne (desktop + mobile)
const searchTriggers = document.querySelectorAll('.search-trigger'); // les 2 loupes
const sForm  = document.getElementById('site-search');
const sInput = document.getElementById('search-input');
const sZone  = document.getElementById('search-results');

let SEARCH_INDEX = [];
try{ SEARCH_INDEX = JSON.parse(document.getElementById('search-data').textContent); }catch(_){}

function setSearchOpen(state){
    searchTriggers.forEach(b => b.setAttribute('aria-expanded', String(state)));
    document.documentElement.classList.toggle('search-open', state);
    state ? sInput.focus() : searchTriggers[0].focus();
}

const normalize = s => s.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g,'');
function score(item, terms){
    const t = normalize(item.title), c = normalize(item.content);
    let s = 0; for(const term of terms){ if(!term) continue;
        if (t.includes(term)) s += 5;
        s += Math.min((c.match(new RegExp(term,'g'))||[]).length, 5);
    } return s;
}
const mark = (text, terms) => terms.reduce(
    (acc,t)=> acc.replace(new RegExp(`(${t.replace(/[.*+?^${}()|[\\]\\\\]/g,'\\$&')})`,'ig'),'<mark>$1</mark>'),
    text
);
function search(q){
    const terms = normalize(q).trim().split(/\s+/).filter(Boolean);
    if(!terms.length){ sZone.innerHTML=''; return; }
    const res = SEARCH_INDEX.map(it=>({it, s:score(it,terms)})).filter(x=>x.s>0)
        .sort((a,b)=>b.s-a.s).slice(0,10);
    if(!res.length){ sZone.innerHTML = `<p class="no-results">Aucun résultat pour « ${q} »</p>`; return; }
    const html = ['<ul class="results-list" role="list">'];
    for(const {it} of res){
        const excerpt = mark(it.content.slice(0,160)+(it.content.length>160?'…':''), terms);
        html.push(`<li class="result"><a href="${it.url}"><strong>${it.title}</strong><span class="excerpt">${excerpt}</span></a></li>`);
    }
    html.push('</ul>');
    sZone.innerHTML = html.join('');
}

searchTriggers.forEach(b=>{
    b.addEventListener('click', () => {
        const open = document.documentElement.classList.contains('search-open');
        setSearchOpen(!open);
        if(!open && sInput.value.trim()) search(sInput.value);
    });
});
document.addEventListener('click', (e) => {
    const open = document.documentElement.classList.contains('search-open');
    if (open && !sForm.contains(e.target) && ![...searchTriggers].includes(e.target)) setSearchOpen(false);
});
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && document.documentElement.classList.contains('search-open')) setSearchOpen(false);
});
sInput.addEventListener('input', () => search(sInput.value));
sForm.addEventListener('submit', (e) => { e.preventDefault(); search(sInput.value); });

// Back-to-top : visible plus tôt et tabbable seulement quand visible
const backTop = document.querySelector('.back-to-top');
function toggleBackTop(){
    const show = window.scrollY > 120;
    backTop.classList.toggle('show', show);
    backTop.tabIndex = show ? 0 : -1;
}
toggleBackTop();
window.addEventListener('scroll', toggleBackTop);


