document.addEventListener('DOMContentLoaded', () => {
  const footerHTML = `
  <footer class="footer text-light mt-5">

  <div class="footer-top py-4">
    <div class="container">
      <div class="row gy-4">

        <div class="col-md-6">
          <h5 class="fw-bold">Nous contacter</h5>
          <address class="mb-0">
            <strong>Les Blouses Roses</strong><br>
            5 rue Barye, 75017 PARIS<br>
            <a href="tel:+33146228232" class="text-light d-block">01 46 22 82 32</a>
            <a href="mailto:siegenational@lesblousesroses.asso.fr" class="text-light">
              siegenational@lesblousesroses.asso.fr
            </a>
          </address>
        </div>

        <div class="col-md-6">
          <ul class="list-unstyled mb-0">
            <li><a href="mentions-legales.html" class="text-light text-decoration-none">Mentions légales</a></li>
            <li><a href="politique-cookies.html" class="text-light text-decoration-none">Politique de cookies</a></li>
            <li><a href="protection-donnees.html" class="text-light text-decoration-none">Protection des données personnelles</a></li>
            <li><a href="preferences-cookies.html" class="text-light text-decoration-none">Préférences de cookies</a></li>
            <li><a href="accessibilite.html" class="text-light text-decoration-none">Accessibilité</a></li>
            <li><a href="plan-site.html" class="text-light text-decoration-none">Plan du site</a></li>
          </ul>
        </div>

      </div>
    </div>
  </div>

  <div class="footer-bottom py-3">
    <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">

      <div class="d-flex gap-3">
        <a href="https://www.facebook.com/people/Les-Blouses-Roses/100064446739294/" class="footer-social"><i class="bi bi-facebook"></i></a>
        <a href="https://x.com/lesblousesroses" class="footer-social"><i class="bi bi-twitter-x"></i></a>
        <a href="https://www.instagram.com/lesblousesrosesnational/" class="footer-social"><i class="bi bi-instagram"></i></a>
        <a href="https://www.linkedin.com/company/les-blouses-roses/?viewAsMember=true" class="footer-social"><i class="bi bi-linkedin"></i></a>
        <a href="https://www.youtube.com/@LESBLOUSESROSESNATIONAL" class="footer-social"><i class="bi bi-youtube"></i></a>
      </div>

      <a href="#" class="btn btn-outline-light newsletter-btn fw-bold">S'abonner à la NEWSLETTER</a>

    </div>
  </div>

</footer>
  `;
  document.getElementById('footer-container').innerHTML = footerHTML;
});
