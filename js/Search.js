function initSearch() {
// === Initialisation ===
const searchTriggers = document.querySelectorAll('.search-trigger');
const sForm  = document.getElementById('site-search');
const sInput = document.getElementById('search-input');
const sZone  = document.getElementById('search-results');

let SEARCH_INDEX = [];
try {
  const rawData = document.getElementById('search-data')?.textContent;
  if (rawData) SEARCH_INDEX = JSON.parse(rawData);
} catch (err) {
  console.warn('Erreur lors du chargement de l’index de recherche :', err);
}

// === Fonctions principales ===
function setSearchOpen(state) {
  document.documentElement.classList.toggle('search-open', state);
  searchTriggers.forEach(b => b.setAttribute('aria-expanded', String(state)));
  if (state) {
    sForm.classList.add('show');
    sInput.focus();
  } else {
    sForm.classList.remove('show');
  }
}

const normalize = s => s.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
function score(item, terms) {
  const t = normalize(item.title), c = normalize(item.content);
  let s = 0;
  for (const term of terms) {
    if (!term) continue;
    if (t.includes(term)) s += 5;
    s += Math.min((c.match(new RegExp(term, 'g')) || []).length, 5);
  }
  return s;
}

const mark = (text, terms) =>
  terms.reduce(
    (acc, t) => acc.replace(new RegExp(`(${t.replace(/[.*+?^${}()|[\\]\\\\]/g, '\\$&')})`, 'ig'), '<mark>$1</mark>'),
    text
  );

function search(q) {
  const terms = normalize(q).trim().split(/\s+/).filter(Boolean);
  if (!terms.length) {
    sZone.innerHTML = '';
    return;
  }

  const results = SEARCH_INDEX
    .map(it => ({ it, s: score(it, terms) }))
    .filter(x => x.s > 0)
    .sort((a, b) => b.s - a.s)
    .slice(0, 10);

  if (!results.length) {
    sZone.innerHTML = `<p class="no-results">Aucun résultat pour « ${q} »</p>`;
    return;
  }

  const html = ['<ul class="results-list list-unstyled">'];
  for (const { it } of results) {
    const excerpt = mark(it.content.slice(0, 160) + (it.content.length > 160 ? '…' : ''), terms);
    html.push(`<li class="result mb-2">
                <a href="${it.url}" class="text-decoration-none">
                  <strong>${it.title}</strong><br>
                  <span class="text-muted small">${excerpt}</span>
                </a>
              </li>`);
  }
  html.push('</ul>');
  sZone.innerHTML = html.join('');
}

// === Événements ===
searchTriggers.forEach(b => {
  b.addEventListener('click', e => {
    e.preventDefault();
    const open = document.documentElement.classList.contains('search-open');
    setSearchOpen(!open);
    if (!open && sInput.value.trim()) search(sInput.value);
  });
});

document.addEventListener('click', e => {
  const open = document.documentElement.classList.contains('search-open');
  if (open && !sForm.contains(e.target) && ![...searchTriggers].includes(e.target)) setSearchOpen(false);
});

document.addEventListener('keydown', e => {
  if (e.key === 'Escape' && document.documentElement.classList.contains('search-open')) setSearchOpen(false);
});

sInput.addEventListener('input', () => search(sInput.value));
sForm.addEventListener('submit', e => {
  e.preventDefault();
  search(sInput.value);
});
}

// On attend que la navbar soit chargée
document.addEventListener('navbar-loaded', initSearch);
