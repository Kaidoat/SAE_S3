
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accessibilité — Les Blouses Roses numériques</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Ton style -->
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-light">
<main class="container py-5">
    <h1 class="text-center text-rose mb-5">Accessibilité</h1>

    <section class="bg-white p-4 rounded-4 shadow-sm">
        <p><strong>Engagement</strong></p>
        <p>
            Ce site a été réalisé dans un cadre universitaire (BUT Informatique – Université Paris Cité, groupe 205, année 2025–2026).
            Nous visons une expérience accessible au plus grand nombre, conformément aux bonnes pratiques
            du <abbr title="Référentiel Général d’Amélioration de l’Accessibilité">RGAA</abbr> et des <abbr title="Web Content Accessibility Guidelines">WCAG 2.1</abbr> (niveau AA).
        </p>

        <hr>

        <h2 class="h4 mt-3">État de conformité</h2>
        <p>
            Évaluation <em>autodéclarative</em> (projet pédagogique). Objectif : respect des critères essentiels
            (structure sémantique, contrastes, navigation clavier, alternatives textuelles, liens explicites).
        </p>

        <h3 class="h5 mt-3">Points mis en œuvre</h3>
        <ul>
            <li>Structure HTML sémantique (titres hiérarchisés, sections, listes).</li>
            <li>Liens d’évitement “Aller au contenu principal”.</li>
            <li>Navigation au clavier : ordre logique, focus visible.</li>
            <li>Alternatives textuelles pour les images décoratives/porteuses d’info.</li>
            <li>Couleurs et contrastes renforcés (thème rose avec teintes suffisamment contrastées).</li>
            <li>Formulaires : labels associés, indications d’erreur, champs requis.</li>
            <li>Icônes accompagnées d’un texte ou aria-label quand nécessaire.</li>
        </ul>

        <h3 class="h5 mt-3">Limitations connues (projet étudiant)</h3>
        <ul>
            <li>Certains graphiques ou éléments dynamiques (ex. captchas colorés) peuvent nécessiter une alternative textuelle renforcée.</li>
            <li>Absence d’audit par un tiers indépendant.</li>
            <li>Contenus purement démonstratifs pouvant évoluer sans recette complète d’accessibilité.</li>
        </ul>

        <hr>

        <h2 class="h4">Aide à la navigation</h2>
        <ul>
            <li><strong>Clavier :</strong> utilisez <kbd>Tab</kbd> / <kbd>Shift</kbd>+<kbd>Tab</kbd> pour parcourir les éléments interactifs, <kbd>Entrée</kbd> pour activer, <kbd>Espace</kbd> pour cocher/décocher.</li>
            <li><strong>Zoom :</strong> <kbd>Ctrl</kbd> + <kbd>+</kbd> (ou <kbd>Cmd</kbd> + <kbd>+</kbd> sur Mac) pour augmenter la taille, <kbd>Ctrl</kbd> + <kbd>-</kbd> pour diminuer, <kbd>Ctrl</kbd> + <kbd>0</kbd> pour réinitialiser.</li>
            <li><strong>Lecteurs d’écran :</strong> contenu rédigé en français (lang="fr"), titres structurés, liens explicites.</li>
        </ul>

        <h2 class="h4 mt-3">Compatibilité technique</h2>
        <p>Le site est conçu pour fonctionner avec les navigateurs modernes : Chrome, Firefox, Edge, Safari (versions récentes) sur desktop et mobile.</p>

        <hr>

        <h2 class="h4">Retour d’information & contact</h2>
        <p>
            Si vous rencontrez un défaut d’accessibilité (problème de navigation clavier, contraste, alternative manquante, etc.),
            écrivez-nous : <a href="mailto:projet-blousesroses@paris-cite.fr">projet-blousesroses@paris-cite.fr</a>.
            Nous ferons au mieux pour proposer une solution alternative dans le cadre du projet.
        </p>

        <h3 class="h5 mt-3">Voies de recours</h3>
        <p class="mb-0">
            Si vous constatez un défaut d’accessibilité vous empêchant d’accéder à un contenu et que vous ne parvenez pas à nous joindre,
            vous pouvez contacter le <a href="https://www.defenseurdesdroits.fr/" target="_blank" rel="noopener">Défenseur des droits</a> (France).
        </p>

        <hr>

        <h2 class="h4">Méthodologie d’évaluation (projet)</h2>
        <ul class="mb-0">
            <li>Auto-contrôles manuels : structure des titres, alternatives, labels/formulaires, navigation clavier.</li>
            <li>Vérifications automatiques indicatives (ex. extensions Lighthouse / WAVE) – résultats non contractuels.</li>
            <li>Date de la dernière mise à jour : <time datetime="2025-11-08">8 novembre 2025</time>.</li>
        </ul>

        <p class="text-center text-muted small mt-4">© 2025–2026 — Projet universitaire Les Blouses Roses numériques — Université Paris Cité, groupe 205.</p>
    </section>

    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-outline-rose"><i class="bi bi-arrow-left"></i> Retour à l'accueil</a>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
