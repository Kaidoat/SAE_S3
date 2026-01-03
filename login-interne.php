<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: espace-interne.php");
    exit;
}
?>


<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Les Blouses Roses — Accueil</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Feuille de style personnalisée -->
    <link rel="stylesheet" href="style.css">
</head>
<body id="top">

<!-- Lien d’évitement -->
<a class="visually-hidden-focusable skip-link" href="#contenu">Aller au contenu principal</a>

<!-- ================= HEADER ================= -->
<div id="navbar-container"></div>

<main id="contenu">

    <section id="connexion-espace">
        <?php if (isset($_GET['error']) && $_GET['error'] === 'captcha'): ?>
            <p class="text-danger text-center fw-bold">
                ❌ Captcha incorrect. Veuillez réessayer.
            </p>
        <?php endif; ?>
    <h2>Connexion espace interne</h2>

        <?php if (isset($_GET['error'])): ?>
            <p class="text-danger">Identifiant ou mot de passe incorrect</p>
        <?php endif; ?>

        <form method="post" action="back/login-interne.php" class="mb-4">
            <input type="text" name="login" placeholder="Identifiant" class="form-control mb-2" required>
            <input type="password" name="password" placeholder="Mot de passe" class="form-control mb-2" required>
            <button class="btn btn-primary">Se connecter</button>
        </form>

        <button id="showDemande" class="btn btn-link">
            📄 Demande d’identification
        </button>
    </section>


<!-- DEMANDE D’IDENTIFICATION -->
    <section id="demande-identification" class="d-none">
        <h3>Demande d’identification</h3>

        <form method="post" action="back/demande-identification.php" id="form-identification">

            <input name="prenom" class="form-control mb-2" placeholder="Prénom" required>
            <input name="nom" class="form-control mb-2" placeholder="Nom" required>
            <input name="email" type="email" class="form-control mb-2" placeholder="Email" required>
            <input name="adresse" class="form-control mb-2" placeholder="Adresse" required>
            <input name="cp" class="form-control mb-2" placeholder="Code postal" required>
            <input name="ville" class="form-control mb-2" placeholder="Ville" required>
            <input name="telephone" class="form-control mb-2" placeholder="Téléphone" required>

            <select name="role" class="form-select mb-2" required>
                <option value="">Rôle</option>
                <option value="responsable">Responsable</option>
                <option value="admin">Admin</option>
                <option value="benevole">Bénévole</option>
            </select>

            <input type="password" name="password" class="form-control mb-2" placeholder="Mot de passe" required>
            <input type="password" name="password_confirm" class="form-control mb-2" placeholder="Confirmer mot de passe" required>

            <!-- ===== CAPTCHA ===== -->
            <label id="captcha-instruction" class="form-label mt-3">
                Pour valider votre formulaire, suivez l’instruction ci-dessous :
            </label>

            <div id="captcha-box" class="d-flex gap-2 mb-2"></div>

            <div class="input-group mb-2">
                <span class="input-group-text">Saisissez les lettres</span>
                <input type="text" id="captcha-input" class="form-control" required>
                <button type="button" id="captcha-refresh" class="btn btn-outline-secondary">↻</button>
            </div>

            <input type="hidden" name="captcha_valid" id="captcha_valid" value="0">

            <!-- Message JS -->
            <div id="form-alert" class="alert d-none mt-2"></div>

            <button class="btn btn-success mt-2">Envoyer la demande</button>
        </form>

        <button id="backToLogin" class="btn btn-link mt-3">
            ⬅️ Retour à la connexion
        </button>
    </section>



</main>


<div id="footer-container"></div>

<!-- ================= BOUTON RETOUR HAUT ================= -->
<a href="#top" class="btn btn-secondary back-to-top position-fixed bottom-0 end-0 m-3" tabindex="-1" aria-label="Revenir en haut">
    <i class="bi bi-arrow-up"></i>
</a>

<!-- ================= JS ================= -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="js/navbar.js"></script>
<script src="js/Search.js"></script>
<script src="js/footer.js"></script>
<script src="js/interne.js"></script>

</body>
</html>
