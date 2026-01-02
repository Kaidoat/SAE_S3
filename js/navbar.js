document.addEventListener('DOMContentLoaded', () => {
  const navbarHTML = `
  <header class="site-header">

  <div class="header-top-wrapper">
    <div class="ribbon-bar">
      <div class="cta-bubbles-container d-none d-md-flex gap-3 me-5">
        <a href="boiteOutils.php" class="cta-bubble bubble--s rounded-circle"><span>BOITE A<br>OUTILS</span></a>
        <a href="Benevole.php" class="cta-bubble bubble--m rounded-circle"><span>DEVENIR<br>BENEVOLE</span></a>
        <a href="faireDon.php" class="cta-bubble bubble--l rounded-circle"><span>JE FAIS<br>UN DON</span></a>
      </div>
    </div>

    <div class="container header-bottom-content d-flex flex-column align-items-center">
      <a href="index.php" class="logo-link logo-absolute" aria-label="Retour à l’accueil"> 
            <img src="img/logo_sans_fond.png" alt="Les Blouses Roses" style="max-width: 150px; height: auto;"> 
        </a>

      <div class="access-pills d-flex flex-column flex-md-row align-items-center justify-content-center gap-2">
        <a class="pill-custom d-flex align-items-center" href="espace-interne.php">
          <span class="pill-icon pill-icon-blue me-2" aria-hidden="true"><i class="bi bi-person"></i></span>
          <span>Mon espace interne</span>
        </a>
        <a class="pill-custom d-flex align-items-center" href="espacedon.php">
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
      {"url":"index.html","title":"Accueil","content":"Bienvenue sur le site des Blouses Roses."},
      {"url":"Actualite.html","title":"Actualités","content":"Dernières nouvelles, événements et actions de l’association."},
      {"url":"Benevole.html","title":"Devenir bénévole","content":"Informations pour rejoindre l’association et devenir bénévole."},
      {"url":"InfoBen.html","title":"Informations bénévoles","content":"Ressources et outils destinés aux bénévoles des Blouses Roses."},
      {"url":"NousSoutenir.html","title":"Nous soutenir","content":"Faire un don, devenir partenaire ou mécène des Blouses Roses."},
      {"url":"accessibilite.html","title":"Accessibilité","content":"Informations sur l’accessibilité du site et nos engagements."},
      {"url":"boiteOutils.html","title":"Boîte à outils","content":"Documents et ressources utiles pour les bénévoles et partenaires."},
      {"url":"espace-interne.html","title":"Espace interne","content":"Accès réservé aux membres et bénévoles connectés."},
      {"url":"espacedon.html","title":"Espace donateur","content":"Accédez à votre espace donateur et suivez vos contributions."},
      {"url":"faire-appel-a-nous.html","title":"Faire appel à nous","content":"Comment solliciter l’intervention des Blouses Roses dans votre établissement."},
      {"url":"faireDon.html","title":"Faire un don","content":"Effectuer un don en ligne pour soutenir nos actions."},
      {"url":"infoGenerales.html","title":"Informations générales","content":"Données générales et présentation de l’association."},
      {"url":"mentions-legales.html","title":"Mentions légales","content":"Mentions légales et informations sur l’éditeur du site."},
      {"url":"plan-site.html","title":"Plan du site","content":"Carte complète du site Les Blouses Roses."},
      {"url":"politique-cookies.html","title":"Politique de cookies","content":"Détails sur notre politique d’utilisation des cookies."},
      {"url":"preferences-cookies.html","title":"Préférences de cookies","content":"Gérez vos préférences en matière de cookies."},
      {"url":"protection-donnees.html","title":"Protection des données","content":"Politique de confidentialité et protection des données personnelles."}
    ]
    </script>

      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#main-navbar"
        aria-controls="main-navbar" aria-expanded="false" aria-label="Basculer la navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-center" id="main-navbar">
        <ul class="navbar-nav text-uppercase fw-semibold text-center">
          <li class="nav-item"><a class="nav-link" href="index.php"><i class="bi bi-house-door-fill"></i></a></li>
          <li class="nav-item"><a class="nav-link active" href="infoGenerales.php">Qui sommes nous ?</a></li>
          <li class="nav-item"><a class="nav-link" href="NousSoutenir.php">Nous soutenir</a></li>
          <li class="nav-item"><a class="nav-link" href="faire-appel-a-nous.php">Faire appel à nous</a></li>
          <li class="nav-item"><a class="nav-link" href="InfoBen.php">Nos bénévoles</a></li>
          <li class="nav-item"><a class="nav-link" href="Actualite.php">Actualités</a></li>
          
        </ul>
      </div>

    </div>
  </nav>


</header>
  `;
  document.getElementById('navbar-container').innerHTML = navbarHTML;
  document.dispatchEvent(new Event('navbar-loaded'));

    if (userRole === 'admin') {
        const adminLink = document.createElement('a');
        adminLink.href = '/back/index.php';
        adminLink.textContent = 'Administration';
        document.querySelector('nav').appendChild(adminLink);
    }


});

