<?php
session_start();
require_once __DIR__ . '/config/db.php';

$connecte = isset($_SESSION['donateur_id']);
$donateur = null;
$totalDons = 0;
$dons = [];
$stats = [];
$actus = [];

if ($connecte) {

    $idDonateur = $_SESSION['donateur_id'];

    /* ===== TOTAL DES DONS ===== */
    $stmt = $pdo->prepare("
        SELECT COALESCE(SUM(montant),0)
        FROM Don
        WHERE id_donateur = ?
    ");
    $stmt->execute([$idDonateur]);
    $totalDons = $stmt->fetchColumn();

    /* ===== HISTORIQUE ===== */
    $stmt = $pdo->prepare("
        SELECT date_don, montant, type_don
        FROM Don
        WHERE id_donateur = ?
        ORDER BY date_don DESC
    ");
    $stmt->execute([$idDonateur]);
    $dons = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /* ===== STATS PAR MOIS ===== */
    $stmt = $pdo->prepare("
        SELECT MONTH(date_don) AS mois, SUM(montant) AS total
        FROM Don
        WHERE id_donateur = ?
        GROUP BY MONTH(date_don)
    ");
    $stmt->execute([$idDonateur]);
    $stats = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    /* ===== ACTUALITÉS ===== */
    $actus = $pdo->query("
        SELECT titre, resume, lien
        FROM Actualite
        ORDER BY id_actualite DESC
        LIMIT 3
    ")->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Espace Donateur</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div id="navbar-container"></div>

<main class="container my-5">

    <?php if (!$connecte): ?>

        <!-- ================= CONNEXION ================= -->
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card p-4 shadow">
                    <h3 class="text-center text-rose mb-3">Espace Donateur</h3>

                    <form method="POST" action="back/login-donateur.php">
                        <input type="email" name="email" class="form-control mb-2" placeholder="E-mail" required>
                        <input type="password" name="motdepasse" class="form-control mb-3" placeholder="Mot de passe" required>

                        <?php if (isset($_GET['error'])): ?>
                            <p class="text-danger text-center">Identifiants incorrects</p>
                        <?php endif; ?>

                        <button class="btn btn-rose w-100">Se connecter</button>
                    </form>

                    <hr>

                    <p class="text-center">
                        <a href="#" id="showRegister">Créer un compte</a>
                    </p>

                    <!-- ===== INSCRIPTION ===== -->
                    <form method="POST"
                          action="back/register-donateur.php"
                          id="registerForm"
                          style="display:none;">

                        <input type="text"
                               name="nom"
                               class="form-control mb-2"
                               placeholder="Nom"
                               required>

                        <input type="text"
                               name="prenom"
                               class="form-control mb-2"
                               placeholder="Prénom"
                               required>

                        <input type="email"
                               name="email"
                               class="form-control mb-2"
                               placeholder="E-mail"
                               required>

                        <input type="password"
                               name="motdepasse"
                               class="form-control mb-2"
                               placeholder="Mot de passe"
                               required>

                        <input type="password"
                               name="confirm_motdepasse"
                               class="form-control mb-3"
                               placeholder="Confirmer le mot de passe"
                               required>

                        <?php if (isset($_GET['register_error'])): ?>
                            <p class="text-danger text-center">
                                <?php
                                if ($_GET['register_error'] === 'exists') {
                                    echo "Cet e-mail existe déjà";
                                } else {
                                    echo "Erreur lors de l'inscription";
                                }
                                ?>
                            </p>
                        <?php endif; ?>

                        <button class="btn btn-success w-100">
                            Créer mon compte
                        </button>
                    </form>

                </div>
            </div>
        </div>

    <?php else: ?>

        <!-- ================= DASHBOARD ================= -->
        <h1 class="text-center text-rose mb-4">
            Bienvenue <?= htmlspecialchars($_SESSION['donateur_prenom']) ?> 🌷
        </h1>

        <ul class="nav nav-pills justify-content-center mb-4">
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="pill" href="#dashboard">Tableau de bord</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#historique">Historique</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#messagerie">Messagerie</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#actus">Actus</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="pill" href="#compte">Mon compte</a></li>
        </ul>

        <div class="tab-content">

            <!-- ===== TABLEAU DE BORD ===== -->
            <div class="tab-pane fade show active" id="dashboard">

                <div class="card p-4 mb-4">
                    <h5 class="text-center text-rose">Évolution de vos dons par mois</h5>
                    <canvas id="donChart"></canvas>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="card p-3 text-center">
                            <h5 class="text-rose">Total de vos dons</h5>
                            <p class="fs-3 text-success"><?= number_format($totalDons,2) ?> €</p>
                            <button onclick="window.print()" class="btn btn-outline-rose btn-sm">
                                📄 Imprimer mon reçu fiscal
                            </button>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card p-3">
                            <h5 class="text-rose">Grâce à votre générosité 💖</h5>
                            <ul>
                                <li>🎈 Animations hospitalières</li>
                                <li>🧸 Jeux et matériel éducatif</li>
                                <li>💪 Ateliers adaptés</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="faireDon.php" class="btn btn-rose btn-lg">💝 Faire un don</a>
                    <br><br>
                    <a href="back/logout-donateur.php" class="btn btn-outline-danger btn-sm">Se déconnecter</a>
                </div>
            </div>

            <!-- ===== HISTORIQUE ===== -->
            <div class="tab-pane fade" id="historique">
                <div class="card p-3">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Montant</th>
                            <th>Mode</th>
                            <th>Remerciement</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($dons as $don): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($don['date_don'])) ?></td>
                                <td class="text-success"><?= number_format($don['montant'],2) ?> €</td>
                                <td><?= htmlspecialchars($don['type_don']) ?></td>
                                <td>🙏 Merci pour votre générosité</td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ===== MESSAGERIE ===== -->
            <div class="tab-pane fade" id="messagerie">
                <div class="card p-3">
                    <textarea class="form-control mb-2" placeholder="Écrire un message..."></textarea>
                    <button class="btn btn-rose btn-sm">Envoyer</button>
                    <hr>
                    <small>
                        📧 siegenational@lesblousesroses.asso.fr<br>
                        📞 01 46 22 82 32
                    </small>
                </div>
            </div>

            <!-- ===== ACTUS ===== -->
            <div class="tab-pane fade" id="actus">
                <div class="row">
                    <?php foreach ($actus as $a): ?>
                        <div class="col-md-4">
                            <div class="card p-3 h-100">
                                <h5 class="text-rose"><?= htmlspecialchars($a['titre']) ?></h5>
                                <p><?= htmlspecialchars($a['resume']) ?></p>
                                <a href="<?= $a['lien'] ?>" target="_blank" class="btn btn-outline-rose btn-sm">
                                    Lire la suite
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- ===== MON COMPTE ===== -->
            <div class="tab-pane fade" id="compte">
                <div class="card p-3">
                    <?php if (isset($_GET['pwd_success'])): ?>
    <div class="alert alert-success">
        ✅ Votre mot de passe a été modifié avec succès
    </div>
<?php endif; ?>

<?php if (isset($_GET['pwd_error'])): ?>
    <div class="alert alert-danger">
        <?php
        if ($_GET['pwd_error'] === 'wrong') {
            echo "❌ Mot de passe actuel incorrect";
        } elseif ($_GET['pwd_error'] === 'confirm') {
            echo "❌ Les nouveaux mots de passe ne correspondent pas";
        } else {
            echo "❌ Tous les champs sont obligatoires";
        }
        ?>
    </div>
<?php endif; ?>

                    <h5 class="text-rose">Changer mon mot de passe</h5>
                    <form method="POST" action="back/update-password.php">
                        <input type="password" name="old" class="form-control mb-2" placeholder="Mot de passe actuel">
                        <input type="password" name="new1" class="form-control mb-2" placeholder="Nouveau mot de passe">
                        <input type="password" name="new2" class="form-control mb-2" placeholder="Confirmer">
                        <button class="btn btn-rose btn-sm">Mettre à jour</button>
                    </form>
                </div>
            </div>

        </div>
    <?php endif; ?>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php if ($connecte): ?>
    <script>
        new Chart(document.getElementById('donChart'), {
            type: 'bar',
            data: {
                labels: ['Jan','Fév','Mar','Avr','Mai','Juin','Juil','Août','Sep','Oct','Nov','Déc'],
                datasets: [{
                    data: <?= json_encode(array_values($stats)) ?>,
                    backgroundColor: '#EC1F7A'
                }]
            },
            options: {
                plugins: { legend: { display:false } },
                scales: { y: { beginAtZero:true } }
            }
        });
    </script>
<?php endif; ?>
<div id="footer-container"></div>
<script src="js/navbar.js"></script>
<script src="js/footer.js"></script>
<script>
    document.getElementById("showRegister")?.addEventListener("click", e => {
        e.preventDefault();
        const form = document.getElementById("registerForm");
        form.style.display = form.style.display === "none" ? "block" : "none";
    });
</script>

</body>
</html>
