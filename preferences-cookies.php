<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Préférences de cookies — Les Blouses Roses numériques</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-light">
<main class="container py-5">
    <h1 class="text-center text-rose mb-5">Préférences de cookies</h1>

    <section class="bg-white p-4 rounded-4 shadow-sm">
        <p><strong>Gestion de vos préférences</strong></p>
        <p>Ce site n’utilise pas de cookies réels, mais cette page illustre comment un utilisateur pourrait choisir ses préférences s’il s’agissait d’un site en production.</p>

        <form class="mt-4">
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="cookieTech" checked disabled>
                <label class="form-check-label" for="cookieTech">Cookies techniques (obligatoires)</label>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="cookieStats">
                <label class="form-check-label" for="cookieStats">Cookies de mesure d’audience (fictif)</label>
            </div>

            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" id="cookiePerso">
                <label class="form-check-label" for="cookiePerso">Cookies de personnalisation (fictif)</label>
            </div>

            <button type="submit" class="btn btn-rose">Enregistrer mes préférences</button>
        </form>

        <p class="mt-4 text-muted small">
            Ces options sont purement démonstratives et ne modifient aucun paramètre réel.
        </p>
    </section>

    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-outline-rose"><i class="bi bi-arrow-left"></i> Retour à l'accueil</a>
    </div>
</main>
</body>
</html>
