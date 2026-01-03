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
    <title>Les Blouses Roses — login espace interne</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="style.css">
</head>

<body id="top">

<!-- Lien d’évitement -->
<a class="visually-hidden-focusable skip-link" href="#contenu">Aller au contenu principal</a>

<!-- ================= HEADER ================= -->
<div id="navbar-container"></div>

<!-- ================= CONTENU PRINCIPAL ================= -->
<main id="contenu" class="container my-5">

<h2>Connexion espace interne</h2>

<?php if (isset($_GET['error'])): ?>
    <p style="color:red;">Identifiant ou mot de passe incorrect</p>
<?php endif; ?>

<form method="post" action="back/login-interne.php">
    <label>
        Identifiant :
        <input type="text" name="login" required>
    </label><br><br>

    <label>
        Mot de passe :
        <input type="password" name="password" required>
    </label><br><br>

    <button type="submit">Se connecter</button>
</form>
</main>

<div id="footer-container"></div>

<!-- ================= JS ================= -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/navbar.js"></script>
<script src="js/footer.js"></script>

</body>
</html>
