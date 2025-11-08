document.addEventListener('DOMContentLoaded', () => {
  const navbarHTML = `
  <header class="site-header">

  <div class="header-top-wrapper">
    <div class="ribbon-bar">
      <div class="cta-bubbles-container d-none d-md-flex gap-3 me-5">
        <a href="#" class="cta-bubble bubble--s rounded-circle"><span>BOITE A<br>OUTILS</span></a>
        <a href="Benevole.html" class="cta-bubble bubble--m rounded-circle"><span>DEVENIR<br>BENEVOLE</span></a>
        <a href="faireDon.html" class="cta-bubble bubble--l rounded-circle"><span>JE FAIS<br>UN DON</span></a>
      </div>
    </div>

    <div class="container header-bottom-content d-flex flex-column align-items-center">
      <a href="index.html" class="logo-link logo-absolute" aria-label="Retour à l’accueil"> 
            <img src="img/logo_sans_fond.png" alt="Les Blouses Roses" style="max-width: 150px; height: auto;"> 
        </a>

      <div class="access-pills d-flex flex-column flex-md-row align-items-center justify-content-center gap-2">
        <a class="pill-custom d-flex align-items-center" href="espace-interne.html">
          <span class="pill-icon pill-icon-blue me-2" aria-hidden="true"><i class="bi bi-person"></i></span>
          <span>Mon espace interne</span>
        </a>
        <a class="pill-custom d-flex align-items-center" href="espacedon.html">
          <span class="pill-icon pill-icon-pink me-2" aria-hidden="true"><i class="bi bi-person-fill"></i></span>
          <span>Mon espace donateur</span>
        </a>
      </div>
    </div>
  </div>

  <nav class="navbar navbar-expand-lg navbar-light bg-light border-top border-bottom">
    <div class="container d-flex align-items-center justify-content-between">
      
    <!-- Bouton loupe à gauche -->
    <button class="search-btn search-btn--mobile search-trigger"
        aria-label="Rechercher"
        aria-controls="site-search"
        aria-expanded="false">
        <i class="bi bi-search" style="font-size: 1.3rem;"></i>
    </button>

    <form id="site-search" class="collapse p-3 bg-light rounded shadow-sm" role="search">
    <label for="search-input" class="visually-hidden">Rechercher</label>
    <input id="search-input" type="search" class="form-control mb-3" placeholder="Rechercher…" autocomplete="on" />
    <div id="search-results" class="search-results"></div>
    </form>

    <script id="search-data" type="application/json">
    [
        {"url":"index.html","title":"Accueil","content":"Bienvenue sur le site Les Blouses Roses"},
        {"url":"benevole.html","title":"Devenir bénévole","content":"Informations pour devenir bénévole"}
    ]
    </script>

      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#main-navbar"
        aria-controls="main-navbar" aria-expanded="false" aria-label="Basculer la navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-center" id="main-navbar">
        <ul class="navbar-nav text-uppercase fw-semibold text-center">
          <li class="nav-item"><a class="nav-link" href="index.html"><i class="bi bi-house-door-fill"></i></a></li>
          <li class="nav-item"><a class="nav-link active" href="#">Qui sommes nous ?</a></li>
          <li class="nav-item"><a class="nav-link" href="NousSoutenir.html">Nous soutenir</a></li>
          <li class="nav-item"><a class="nav-link" href="faire-appel-a-nous.html">Faire appel à nous</a></li>
          <li class="nav-item"><a class="nav-link" href="InfoBen.html">Nos bénévoles</a></li>
          <li class="nav-item"><a class="nav-link" href="Actualite.html">Actualités</a></li>
        </ul>
      </div>

    </div>
  </nav>

</header>
  `;
  document.getElementById('navbar-container').innerHTML = navbarHTML;
  document.dispatchEvent(new Event('navbar-loaded'));
});
