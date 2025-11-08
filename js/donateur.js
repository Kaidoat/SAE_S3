document.addEventListener("DOMContentLoaded", () => {

    // 🔹 Compte de démonstration
    const VALID_ID = "Sae";
    const VALID_PWD = "2Cen";

    // ==========================
    // 🔹 Sélecteurs principaux
    // ==========================
    const loginForm = document.getElementById("loginForm");
    const registerForm = document.getElementById("registerForm");
    const identifiantInput = document.getElementById("identifiant");
    const motdepasseInput = document.getElementById("motdepasse");
    const newIdentifiant = document.getElementById("newIdentifiant");
    const newMotdepasse = document.getElementById("newMotdepasse");
    const confirmMotdepasse = document.getElementById("confirmMotdepasse");
    const newContact = document.getElementById("newContact");
    const connexionSection = document.getElementById("connexion-donateur");
    const contentDonateur = document.getElementById("content-donateur");
    const userIdentifiant = document.getElementById("userIdentifiant");
    const errorMessage = document.getElementById("errorMessage");
    const registerMessage = document.getElementById("registerMessage");
    const totalDons = document.getElementById("totalDons");
    const sectionGenerosite = document.getElementById("sectionGenerosite");
    const btnLogout = document.getElementById("btnLogout");
    const btnReDon = document.getElementById("btnReDon");
    const createLink = document.getElementById("createLink");
    const backToLogin = document.getElementById("backToLogin");
    const forgotLink = document.getElementById("forgotLink");

    // ==========================
    // 🔁 Navigation entre formulaires
    // ==========================
    createLink.addEventListener("click", (e) => {
        e.preventDefault();
        loginForm.classList.add("d-none");
        registerForm.classList.remove("d-none");
        errorMessage.classList.add("d-none");
    });

    backToLogin.addEventListener("click", (e) => {
        e.preventDefault();
        registerForm.classList.add("d-none");
        loginForm.classList.remove("d-none");
        registerMessage.textContent = "";
    });

    // ==========================
    // 📊 Initialisation du compte de démo "Sae"
    // ==========================
    const profils = JSON.parse(localStorage.getItem("profilsDonateurs") || "{}");
    if (!profils[VALID_ID]) {
        profils[VALID_ID] = {
            totalDons: 560,
            historiqueDons: [120, 80, 150, 210],
            dernierDon: "2025-10-28",
            contact: "sae@example.com"
        };
        localStorage.setItem("profilsDonateurs", JSON.stringify(profils));
    }

    // ==========================
    // 🔐 Connexion
    // ==========================
    loginForm.addEventListener("submit", (e) => {
        e.preventDefault();

        const id = identifiantInput.value.trim();
        const pwd = motdepasseInput.value.trim();
        const comptes = JSON.parse(localStorage.getItem("comptesDonateurs") || "{}");

        if ((id === VALID_ID && pwd === VALID_PWD) || (comptes[id] && comptes[id] === pwd)) {
            sessionStorage.setItem("donateur", id);
            showContent(id);
        } else {
            errorMessage.classList.remove("d-none");
            errorMessage.textContent = "❌ Identifiant ou mot de passe incorrect.";
            motdepasseInput.value = "";
        }
    });

    // ==========================
    // 📝 Création de compte
    // ==========================
    registerForm.addEventListener("submit", (e) => {
        e.preventDefault();

        const id = newIdentifiant.value.trim();
        const pwd = newMotdepasse.value.trim();
        const confirmPwd = confirmMotdepasse.value.trim();
        const contact = newContact.value.trim();

        if (!id || !pwd || !confirmPwd || !contact) {
            registerMessage.textContent = "⚠️ Tous les champs sont obligatoires.";
            registerMessage.className = "text-danger text-center fw-semibold mt-3";
            return;
        }

        if (pwd !== confirmPwd) {
            registerMessage.textContent = "❌ Les mots de passe ne correspondent pas.";
            registerMessage.className = "text-danger text-center fw-semibold mt-3";
            return;
        }

        const comptes = JSON.parse(localStorage.getItem("comptesDonateurs") || "{}");

        if (comptes[id] || id === VALID_ID) {
            registerMessage.textContent = "❌ Cet identifiant existe déjà.";
            registerMessage.className = "text-danger text-center fw-semibold mt-3";
            return;
        }

        // ✅ Sauvegarde du compte
        comptes[id] = pwd;
        localStorage.setItem("comptesDonateurs", JSON.stringify(comptes));

        // 🌸 Création du profil avec total = 0
        profils[id] = {
            totalDons: 0,
            historiqueDons: [],
            dernierDon: null,
            contact: contact
        };
        localStorage.setItem("profilsDonateurs", JSON.stringify(profils));

        // 📨 Notification simulée
        alert(`✅ Un e-mail / message a été envoyé à ${contact} pour confirmer la création de votre compte.`);

        // 🩷 Message de succès
        registerMessage.textContent = "✅ Compte créé avec succès ! Vous pouvez maintenant vous connecter.";
        registerMessage.className = "text-success text-center fw-semibold mt-3";

        // Nettoyage
        newIdentifiant.value = "";
        newMotdepasse.value = "";
        confirmMotdepasse.value = "";
        newContact.value = "";

        // Retour auto à la connexion
        setTimeout(() => {
            registerForm.classList.add("d-none");
            loginForm.classList.remove("d-none");
            registerMessage.textContent = "";
        }, 1500);
    });

    // ==========================
    // 🔚 Mot de passe oublié (simulation)
    // ==========================
    forgotLink.addEventListener("click", (e) => {
        e.preventDefault();
        alert("📩 Un e-mail / message pour réinitialiser votre mot de passe vous a été envoyé !");
    });

    // ==========================
    // 🧾 Affichage du contenu après connexion
    // ==========================
    function showContent(identifiant) {
        connexionSection.classList.add("d-none");
        contentDonateur.classList.remove("d-none");
        userIdentifiant.textContent = identifiant;

        const profils = JSON.parse(localStorage.getItem("profilsDonateurs") || "{}");
        const profil = profils[identifiant];

        // 🔹 Affiche les données du profil
        if (profil) {
            totalDons.textContent = profil.totalDons + " €";

            // Si total = 0 → cacher la partie générosité
            if (profil.totalDons > 0) sectionGenerosite.classList.remove("d-none");
            else sectionGenerosite.classList.add("d-none");
        } else {
            totalDons.textContent = "0 €";
            sectionGenerosite.classList.add("d-none");
        }

        genererGraphique(identifiant);
    }

    // ==========================
    // 🚪 Déconnexion
    // ==========================
    btnLogout.addEventListener("click", () => {
        sessionStorage.removeItem("donateur");
        contentDonateur.classList.add("d-none");
        connexionSection.classList.remove("d-none");
    });

    // 🔁 Si déjà connecté
    const utilisateur = sessionStorage.getItem("donateur");
    if (utilisateur) showContent(utilisateur);

    // ==========================
    // 💝 Redirection vers la page de don
    // ==========================
    btnReDon.addEventListener("click", () => {
        window.location.href = "faireDon.html";
    });

    // ==========================
    // 📊 Génération du graphique
    // ==========================
    function genererGraphique(identifiant) {
        const ctx = document.getElementById("donChart");
        if (!ctx) return;

        const profils = JSON.parse(localStorage.getItem("profilsDonateurs") || "{}");
        const profil = profils[identifiant] || { historiqueDons: [] };

        const mois = ["Jan", "Fév", "Mars", "Avr", "Mai", "Juin", "Juil", "Août", "Sept", "Oct", "Nov", "Déc"];
        const dons = profil.historiqueDons.length ? profil.historiqueDons : Array(12).fill(0);

        new Chart(ctx, {
            type: "bar",
            data: {
                labels: mois.slice(0, dons.length),
                datasets: [{
                    label: "Montant des dons (€)",
                    data: dons,
                    backgroundColor: "#EC1F7A88",
                    borderColor: "#EC1F7A",
                    borderWidth: 2,
                    borderRadius: 8
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } },
                responsive: true
            }
        });
    }

});
