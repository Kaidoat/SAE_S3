<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Les Blouses Roses — Faire un don</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Feuille de style personnalisée -->
    <link rel="stylesheet" href="style.css">
</head>
<body id="top">

<a class="visually-hidden-focusable skip-link" href="#contenu">Aller au contenu principal</a>

<div id="navbar-container"></div>

<main id="contenu" class="container py-5">

    <h1 class="section-title text-center mb-5">Je fais un don</h1>

    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <div class="alert alert-success text-center">
            💖 Merci pour votre don !
            <br>
            Votre contribution a bien été enregistrée.
        </div>
    <?php endif; ?>

    <section class="contact-section">

        <h2 class="h5 mb-4"><i class="bi bi-heart-fill text-rose"></i> Pourquoi nous donner</h2>
        <p>
            Vos soutiens permettent aux Blouses Roses d’acheter le matériel nécessaire aux animations,
            de créer de nouveaux comités, de recruter et de former toujours plus de bénévoles.
        </p>

        <hr class="my-4">

        <!-- FORMULAIRE DE DON -->
        <form id="donForm" class="benevole-form" method="POST" action="back/traitement-don.php">

            <div class="row g-4">

                <!-- Colonne gauche -->
                <div class="col-md-6">
                    <fieldset>
                        <legend>Je donne <strong>UNE FOIS</strong></legend>
                        <div class="mb-2">
                            <label><input type="radio" name="don_unique" value="35"> 35 €</label>
                            <label class="ms-3"><input type="radio" name="don_unique" value="50"> 50 €</label>
                            <label class="ms-3"><input type="radio" name="don_unique" value="80"> 80 €</label>
                            <label class="ms-3"><input type="radio" name="don_unique" value="120"> 120 €</label>
                        </div>
                        <label class="form-label mt-2">Autre montant</label>
                        <input type="number" name="autreMontantUnique" placeholder="€" min="1">
                    </fieldset>

                    <fieldset class="mt-4">
                        <legend>Je donne <strong>TOUS LES MOIS</strong></legend>
                        <div class="mb-2">
                            <label><input type="radio" name="don_mensuel" value="10"> 10 €</label>
                            <label class="ms-3"><input type="radio" name="don_mensuel" value="15"> 15 €</label>
                            <label class="ms-3"><input type="radio" name="don_mensuel" value="20"> 20 €</label>
                            <label class="ms-3"><input type="radio" name="don_mensuel" value="25"> 25 €</label>
                        </div>
                        <label class="form-label mt-2">Autre montant</label>
                        <input type="number" name="autreMontantMensuel" placeholder="€" min="1">
                    </fieldset>

                    <div class="alert alert-light border-0 mt-4 small">
                        Si vous êtes imposable, après déduction fiscale,
                        <strong>votre don ne vous coûtera que 34 %</strong>.
                    </div>
                </div>

                <!-- Colonne droite -->
                <div class="col-md-6">
                    <div class="p-3 border rounded-4 bg-white shadow-sm mb-4">
                        <p class="mb-2"><i class="bi bi-gift text-rose"></i> 50 € = une après-midi d’activités</p>
                        <p class="mb-2">80 € = deux jeux de société</p>
                        <p class="mb-0">120 € = une journée de formation bénévole</p>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-6">
                            <label>Nom *</label>
                            <input type="text" name="nom" required>
                        </div>
                        <div class="col-md-6">
                            <label>Prénom *</label>
                            <input type="text" name="prenom" required>
                        </div>
                    </div>

                    <label class="mt-2">E-mail *</label>
                    <input type="email" name="email" required>

                    <label class="mt-2">Adresse *</label>
                    <input type="text" name="adresse" required>

                    <div class="row g-2 mt-2">
                        <div class="col-md-4">
                            <label>CP *</label>
                            <input type="text" name="cp" pattern="[0-9]{5}" required>
                        </div>
                        <div class="col-md-8">
                            <label>Ville *</label>
                            <input type="text" name="ville" required>
                        </div>
                    </div>

                    <label class="mt-2">Téléphone</label>
                    <input type="tel" name="telephone">
                </div>
            </div>

            <!-- champ caché pour le mode de paiement -->
            <input type="hidden" name="mode_paiement" id="mode_paiement">

            <!-- Boutons de paiement -->
            <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
                <button type="submit" class="btn-submit"
                        style="background-color:#9e9e9e;"
                        onclick="setModePaiement('Carte bancaire')">
                    Validez et procédez au paiement par<br><strong>CARTE BANCAIRE</strong>
                </button>

                <button type="submit" class="btn-submit"
                        style="background-color:#b3a180;"
                        onclick="setModePaiement('Chèque')">
                    Validez et procédez au paiement par<br><strong>CHÈQUE</strong>
                </button>

                <button type="submit" class="btn-submit"
                        style="background-color:#c9a762;"
                        onclick="setModePaiement('Prélèvement')">
                    Validez et procédez au paiement par<br><strong>PRÉLÈVEMENT</strong>
                </button>
            </div>

        </form>
    </section>
</main>

<div id="footer-container"></div>

<a href="#top" class="btn btn-secondary back-to-top position-fixed bottom-0 end-0 m-3">
    <i class="bi bi-arrow-up"></i>
</a>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/navbar.js"></script>
<script src="js/Search.js"></script>
<script src="js/footer.js"></script>

<script>
    function setModePaiement(mode) {
        document.getElementById('mode_paiement').value = mode;
    }
</script>

</body>
</html>
