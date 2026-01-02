
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

    <!-- =================== SECTION CONNEXION =================== -->
    <section class="contact-section" id="connexion-donateur">
        <h2>Espace Donateur</h2>
        <p class="text-center text-muted mb-4">Connectez-vous pour accéder à votre espace 💖</p>

        <div class="container d-flex justify-content-center">
            <div class="card shadow-lg p-4 rounded-4" style="max-width: 420px; width: 100%;">

                <!-- 🔹 Formulaire de connexion -->
                <form id="loginForm" novalidate>
                    <div class="mb-3">
                        <label for="identifiant" class="form-label">Identifiant</label>
                        <input type="text" class="form-control" id="identifiant" placeholder="Votre identifiant" required>
                    </div>

                    <div class="mb-2">
                        <label for="motdepasse" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="motdepasse" placeholder="Votre mot de passe" required>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <a href="#" id="forgotLink" class="text-decoration-none small text-rose">Mot de passe oublié ?</a>
                        <a href="#" id="createLink" class="text-decoration-none small text-rose">Créer un compte</a>
                    </div>

                    <button type="submit" id="btnLogin" class="btn btn-rose w-100">Se connecter</button>
                    <p id="errorMessage" class="text-danger text-center fw-semibold mt-3 d-none"></p>
                </form>

                <!-- 🔹 Formulaire d'inscription (caché au départ) -->
                <form id="registerForm" class="d-none" novalidate>
                    <h5 class="text-center mb-3 text-rose">Créer un compte</h5>

                    <div class="mb-3">
                        <label for="newIdentifiant" class="form-label">Identifiant</label>
                        <input type="text" class="form-control" id="newIdentifiant" placeholder="Choisissez un identifiant" required>
                    </div>

                    <div class="mb-3">
                        <label for="newMotdepasse" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="newMotdepasse" placeholder="Choisissez un mot de passe" required>
                    </div>

                    <div class="mb-3">
                        <label for="confirmMotdepasse" class="form-label">Confirmer le mot de passe</label>
                        <input type="password" class="form-control" id="confirmMotdepasse" placeholder="Retapez votre mot de passe" required>
                    </div>

                    <div class="mb-3">
                        <label for="newContact" class="form-label">E-mail ou numéro (pour notifications)</label>
                        <input type="text" class="form-control" id="newContact" placeholder="ex : mon@mail.com ou 06xxxxxxx" required>
                    </div>

                    <button type="submit" class="btn btn-rose w-100">Créer le compte</button>
                    <p id="registerMessage" class="text-center fw-semibold mt-3"></p>

                    <p class="text-center mt-3">
                        <a href="#" id="backToLogin" class="text-decoration-none small text-rose">⬅️ Retour à la connexion</a>
                    </p>
                </form>

            </div>
        </div>
    </section>

    <!-- =================== SECTION ESPACE DONATEUR =================== -->
    <section id="content-donateur" class="container d-none my-5">

        <div class="text-center mb-4">
            <h2 class="section-title">Bienvenue <span id="userIdentifiant"></span> 🌷</h2>
            <p class="text-muted">Merci pour ta fidélité et ton soutien précieux aux Blouses Roses 💖</p>
        </div>

        <!-- Onglets -->
        <ul class="nav nav-pills justify-content-center gap-2 mb-4" id="donateurTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="tab-dashboard" data-bs-toggle="pill" data-bs-target="#pane-dashboard" type="button" role="tab">Tableau de bord</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-histo" data-bs-toggle="pill" data-bs-target="#pane-histo" type="button" role="tab">Historique des dons</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-msg" data-bs-toggle="pill" data-bs-target="#pane-msg" type="button" role="tab">Messagerie</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-news" data-bs-toggle="pill" data-bs-target="#pane-news" type="button" role="tab">Actus personnalisées</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-compte" data-bs-toggle="pill" data-bs-target="#pane-compte" type="button" role="tab">Mon compte</button>
            </li>
        </ul>

        <div class="tab-content">

            <!-- === Tableau de bord === -->
            <div class="tab-pane fade show active" id="pane-dashboard" role="tabpanel" aria-labelledby="tab-dashboard">
                <div class="row justify-content-center mb-4">
                    <div class="col-md-8">
                        <div class="card p-4 shadow-sm">
                            <h5 class="text-center text-rose mb-3">Évolution de vos dons par mois</h5>
                            <canvas id="donChart" height="150"></canvas>
                        </div>
                    </div>
                </div>

                <div class="row mt-4 text-center">
                    <div class="col-md-4 mb-3">
                        <div class="card p-3 shadow-sm">
                            <h5 class="text-rose">Montant total de vos dons</h5>
                            <p class="fs-4 fw-bold text-success" id="totalDons">0 €</p>
                            <button id="btnReceipt" class="btn btn-outline-rose btn-sm mt-2">📄 Imprimer mon reçu fiscal</button>
                        </div>
                    </div>

                    <div class="col-md-8 mb-3" id="sectionGenerosite">
                        <div class="card p-3 shadow-sm">
                            <h5 class="text-rose">Grâce à votre générosité 🌼</h5>
                            <ul class="list-unstyled text-muted mb-0" id="impactList">
                                <li>🎈 Une sortie récréative pour les enfants hospitalisés</li>
                                <li>🧸 Du matériel d’activités pour les services pédiatriques</li>
                                <li>💪 Des ateliers adaptés pour personnes en situation de handicap</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button id="btnReDon" class="btn btn-rose btn-lg">💝 Faire un nouveau don</button>
                    <p class="mt-3"><button id="btnLogout" class="btn btn-outline-danger btn-sm">Se déconnecter</button></p>
                </div>
            </div>

            <!-- === Historique des dons === -->
            <div class="tab-pane fade" id="pane-histo" role="tabpanel" aria-labelledby="tab-histo">
                <div class="card p-3 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                        <h5 class="mb-0 text-rose">Historique détaillé</h5>
                        <div class="d-flex gap-2">
                            <select id="filtreMode" class="form-select form-select-sm" style="width:180px">
                                <option value="">Tous les modes</option>
                                <option>Carte bancaire</option>
                                <option>Virement</option>
                                <option>Chèque</option>
                                <option>Espèces</option>
                            </select>
                            <input id="filtreDate" type="month" class="form-control form-control-sm" />
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Montant</th>
                                <th>Mode</th>
                                <th>Remerciement</th>
                            </tr>
                            </thead>
                            <tbody id="tbodyHistorique"></tbody>
                        </table>
                    </div>
                    <p class="text-end fw-semibold">Total période : <span id="totalPeriode">0 €</span></p>
                </div>
            </div>

            <!-- === Messagerie === -->
            <div class="tab-pane fade" id="pane-msg" role="tabpanel" aria-labelledby="tab-msg">
                <div class="row g-3">
                    <div class="col-md-8">
                        <div class="card p-3 shadow-sm h-100">
                            <div id="thread" class="d-flex flex-column gap-2" style="min-height:280px;"></div>
                            <form id="msgForm" class="mt-3">
                                <div class="input-group">
                                    <input id="msgInput" class="form-control" placeholder="Écrire un message à l'association…">
                                    <button class="btn btn-rose" type="submit">Envoyer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-3 shadow-sm">
                            <h6 class="text-rose">Infos utiles</h6>
                            <ul class="small text-muted mb-0">
                                <li>Réponse sous 24–48h ouvrées</li>
                                <li>Urgent ? 01 46 22 82 32</li>
                                <li>Mail : siegenational@lesblousesroses.asso.fr</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- === Actus personnalisées (légères) === -->
            <div class="tab-pane fade" id="pane-news" role="tabpanel" aria-labelledby="tab-news">
                <div class="row" id="newsCards"></div>
            </div>

            <!-- === Mon compte === -->
            <div class="tab-pane fade" id="pane-compte" role="tabpanel" aria-labelledby="tab-compte">
                <div class="row g-3">
                    <div class="col-lg-6">
                        <div class="card p-3 shadow-sm">
                            <h5 class="text-rose">Mes informations</h5>
                            <form id="profilForm" class="mt-2">
                                <div class="mb-2">
                                    <label class="form-label">Contact (mail ou numéro)</label>
                                    <input id="profilContact" class="form-control" placeholder="ex: mon@mail.com ou 06…" />
                                </div>
                                <button class="btn btn-rose btn-sm">Enregistrer</button>
                                <span id="profilMsg" class="ms-2 small"></span>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card p-3 shadow-sm">
                            <h5 class="text-rose">Modifier mon mot de passe</h5>
                            <form id="pwdForm" class="mt-2">
                                <div class="mb-2">
                                    <label class="form-label">Mot de passe actuel</label>
                                    <input id="pwdOld" type="password" class="form-control" />
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Nouveau mot de passe</label>
                                    <input id="pwdNew" type="password" class="form-control" />
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Confirmer le nouveau</label>
                                    <input id="pwdNew2" type="password" class="form-control" />
                                </div>
                                <button class="btn btn-rose btn-sm">Mettre à jour</button>
                                <span id="pwdMsg" class="ms-2 small"></span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
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
<script src="js/donateur.js"></script>
</body>
</html>
