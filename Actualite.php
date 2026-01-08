<?php
require 'config/db.php';

// Pagination
$parPage = 6;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $parPage;

// Total d’articles
$total = $pdo->query("SELECT COUNT(*) FROM Actualite")->fetchColumn();
$pages = ceil($total / $parPage);

// Récupération des actus
$stmt = $pdo->prepare("
    SELECT 
        a.*,
        m.titre AS mission_titre,
        e.nom AS evenement_nom
    FROM Actualite a
    LEFT JOIN Mission m ON a.id_mission = m.id_mission
    LEFT JOIN Evenement e ON a.id_evenement = e.id_evenement
    ORDER BY a.date_publication DESC
    LIMIT :limit OFFSET :offset
");

$stmt->bindValue(':limit', $parPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$actus = $stmt->fetchAll();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Les Blouses Roses — Actualités</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="style.css">
    
</head>
<body id="top">

<a class="visually-hidden-focusable skip-link" href="#contenu">Aller au contenu principal</a>

<div id="navbar-container"></div>

<main id="contenu">
    
    <div class="container my-5">
        <h1 class="mb-5 text-center">Toutes nos Actualités</h1>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($actus as $actu): ?>
                <div class="col d-flex">
                    <div class="card h-100 shadow-sm">
                        <div class="card-img-top-placeholder">
                            <img class="card-img-actualite"
                                 src="<?= htmlspecialchars($actu['image_url']) ?>"
                                 alt="">
                        </div>

                        <div class="card-body d-flex flex-column">
                            <?php if (!empty($actu['mission_titre']) || !empty($actu['evenement_nom'])): ?>
                                <div class="mb-2">
                                    <?php if (!empty($actu['mission_titre'])): ?>
                                        <span class="badge bg-info text-dark me-1">
                <i class="bi bi-briefcase"></i>
                Mission : <?= htmlspecialchars($actu['mission_titre']) ?>
            </span>
                                    <?php endif; ?>

                                    <?php if (!empty($actu['evenement_nom'])): ?>
                                        <span class="badge bg-warning text-dark">
                <i class="bi bi-calendar-event"></i>
                Événement : <?= htmlspecialchars($actu['evenement_nom']) ?>
            </span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <h5 class="card-title">
                                <?= htmlspecialchars($actu['titre']) ?>
                            </h5>

                            <p class="card-text flex-grow-1">
                                <?= htmlspecialchars($actu['resume']) ?>
                            </p>

                            <a href="<?= htmlspecialchars($actu['lien']) ?>"
                               class="btn btn-rose mt-2"
                               target="_blank">
                                Lire la suite
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>

        <nav aria-label="Page navigation" class="mt-5">
            <ul class="pagination justify-content-center">

                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>">Précédent</a>
                </li>

                <?php for ($i = 1; $i <= $pages; $i++): ?>
                    <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?= $page >= $pages ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>">Suivant</a>
                </li>

            </ul>
        </nav>

    </div>

</main>

<div id="footer-container"></div>

<a href="#top" class="btn btn-secondary back-to-top position-fixed bottom-0 end-0 m-3" tabindex="-1" aria-label="Revenir en haut">
    <i class="bi bi-arrow-up"></i>
</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/navbar.js"></script>
<script src="js/Search.js"></script>
<script src="js/footer.js"></script>

</body>

</html>
