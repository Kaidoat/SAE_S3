<?php
// Protection de l’espace interne
require_once 'back/auth-interne.php';
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Les Blouses Roses — Espace interne</title>

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

    <h2 class="text-center mb-5">
        Bienvenue <span class="text-rose"><?php echo htmlspecialchars($_SESSION['user']); ?></span> 🌷
    </h2>

    <!-- ================= DASHBOARD ================= -->
    <div class="row g-4 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card text-center shadow-sm border-0 h-100">
                <div class="card-body">
                    <i class="bi bi-calendar-event display-5 text-rose"></i>
                    <h5 class="mt-2">Prochain événement</h5>
                    <p class="text-muted mb-1">Atelier à l’hôpital Sainte-Marie</p>
                    <small class="text-secondary">12 nov. 2025 — 14 h 00</small>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card text-center shadow-sm border-0 h-100">
                <div class="card-body">
                    <i class="bi bi-clock-history display-5 text-rose"></i>
                    <h5 class="mt-2">Heures du mois</h5>
                    <p class="fw-bold fs-4 text-success mb-0">24 h</p>
                    <small class="text-secondary">Merci pour ton temps 💖</small>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card text-center shadow-sm border-0 h-100">
                <div class="card-body">
                    <i class="bi bi-chat-dots display-5 text-rose"></i>
                    <h5 class="mt-2">Messages non lus</h5>
                    <p class="fw-bold fs-4 text-warning mb-0">3</p>
                    <small class="text-secondary">Voir la messagerie</small>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card text-center shadow-sm border-0 h-100">
                <div class="card-body">
                    <i class="bi bi-bar-chart-line display-5 text-rose"></i>
                    <h5 class="mt-2">Interventions</h5>
                    <p class="fw-bold fs-4 text-primary mb-0">15</p>
                    <small class="text-secondary">Ce mois-ci</small>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= SECTIONS ================= -->
    <div class="row g-4">

        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-rose text-white fw-bold">
                    <i class="bi bi-calendar-week me-2"></i>Mon planning
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">🩺 Atelier dessin — CHU Lille — 10 nov.</li>
                        <li class="list-group-item">👵 Visite EHPAD — 13 nov.</li>
                        <li class="list-group-item">🎨 Atelier créatif — 15 nov.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-rose text-white fw-bold">
                    <i class="bi bi-stars me-2"></i>Événements à venir
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li>🌷 Formation “Accueil des enfants” — 20 nov.</li>
                        <li>🎁 Collecte de jouets — 25 nov.</li>
                        <li>👥 Réunion régionale — 2 déc.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-rose text-white fw-bold">
                    <i class="bi bi-envelope-paper-heart me-2"></i>Messagerie interne
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action">
                            <strong>Direction</strong> — Merci pour ta participation 🎁
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <strong>Équipe</strong> — Réunion le 12/11
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100 text-center">
                <div class="card-header bg-rose text-white fw-bold">
                    <i class="bi bi-person-circle me-2"></i>Mon profil
                </div>
                <div class="card-body">
                    <img src="https://cdn-icons-png.flaticon.com/512/6997/6997662.png"
                         class="rounded-circle mb-3"
                         width="80"
                         height="80"
                         alt="profil">

                    <h5><?php echo htmlspecialchars($_SESSION['user']); ?></h5>
                    <p class="text-muted">Membre de l’association</p>

                    <a href="#" class="btn btn-sm btn-outline-rose">Modifier mon profil</a>
                </div>
            </div>
        </div>

    </div>

    <!-- ================= LOGOUT ================= -->
    <div class="text-center mt-5">
        <a href="logout.php" class="btn btn-outline-danger">
            Se déconnecter
        </a>
    </div>

</main>

<div id="footer-container"></div>

<!-- ================= JS ================= -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/navbar.js"></script>
<script src="js/footer.js"></script>

</body>
</html>
