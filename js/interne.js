document.addEventListener("DOMContentLoaded", () => {

    // ============= Connexion / Authentification =============
    const sectionConnexion = document.getElementById("connexion-espace");
    const sectionDemande   = document.getElementById("demande-identification");
    const sectionContent   = document.getElementById("internalContent");

    const formLogin  = document.getElementById("internalLoginForm");
    const idInput    = document.getElementById("identifiantInterne");
    const pwdInput   = document.getElementById("motdepasseInterne");
    const forgotLink = document.getElementById("forgotPwdLink");
    const errorMsg   = document.getElementById("internalError");
    const successMsg = document.getElementById("internalSuccess");
    const btnShowDemande = document.getElementById("showDemande");
    const btnBack        = document.getElementById("backToLogin");
    const logoutBtn      = document.getElementById("btnLogoutInterne");
    const userName       = document.getElementById("userInternal");

    // --- Si un utilisateur est déjà connecté (sessionStorage), on garde la connexion
    const currentUser = sessionStorage.getItem("internalUser");
    if (currentUser) {
        showInternalContent(currentUser);
    }

    // --- Aller à la demande d’identification
    btnShowDemande.addEventListener("click", (e) => {
        e.preventDefault();
        sectionConnexion.classList.add("d-none");
        sectionDemande.classList.remove("d-none");
    });

    // --- Retour à la connexion
    btnBack.addEventListener("click", (e) => {
        e.preventDefault();
        sectionDemande.classList.add("d-none");
        sectionConnexion.classList.remove("d-none");
    });

    // --- Connexion
    formLogin.addEventListener("submit", (e) => {
        e.preventDefault();
        const id = idInput.value.trim();
        const pwd = pwdInput.value.trim();

        if (id === "Chaïma" && pwd === "test") {
            sessionStorage.setItem("internalUser", id);
            showInternalContent(id);
        } else {
            errorMsg.textContent = "❌ Identifiant ou mot de passe incorrect.";
            errorMsg.classList.remove("d-none");
            successMsg.classList.add("d-none");
        }
    });

    // --- Fonction d’affichage du tableau de bord
    function showInternalContent(user) {
        sectionConnexion.classList.add("d-none");
        sectionDemande.classList.add("d-none");
        sectionContent.classList.remove("d-none");
        userName.textContent = user;
        errorMsg.classList.add("d-none");
        successMsg.classList.add("d-none");
    }

    // --- Mot de passe oublié
    forgotLink.addEventListener("click", (e) => {
        e.preventDefault();
        successMsg.textContent = "📩 Un e-mail de réinitialisation de mot de passe a été envoyé.";
        successMsg.classList.remove("d-none");
        errorMsg.classList.add("d-none");
    });

    // --- Déconnexion (efface seulement la session)
    logoutBtn.addEventListener("click", () => {
        sessionStorage.removeItem("internalUser");
        sectionContent.classList.add("d-none");
        sectionConnexion.classList.remove("d-none");
    });

    // ============= Formulaire de demande d’identification avec captcha couleur 🎨 =============
    const formDemande        = document.getElementById("form-identification");
    const alertBox           = document.getElementById("form-alert");
    const captchaBox         = document.getElementById("captcha-box");
    const captchaInput       = document.getElementById("captcha-input");
    const refreshBtn         = document.getElementById("captcha-refresh");
    const captchaInstruction = document.getElementById("captcha-instruction");

    if (formDemande) {
        let captchaData = [];
        let targetColor = "";
        const colorNames = {
            "#FFB3BA": "rose",
            "#FFDFBA": "pêche",
            "#FFFFBA": "jaune",
            "#BAFFC9": "vert",
            "#BAE1FF": "bleu",
            "#E6BAFF": "violet"
        };
        const colorList = Object.keys(colorNames);

        function generateLetters(n = 6) {
            const letters = "ABCDEFGHJKLMNPQRSTUVWXYZ";
            let s = "";
            for (let i = 0; i < n; i++) s += letters[Math.floor(Math.random() * letters.length)];
            return s;
        }

        function displayCaptcha() {
            captchaData = [];
            captchaBox.innerHTML = "";

            targetColor = colorList[Math.floor(Math.random() * colorList.length)];
            const letters = generateLetters(6);
            let hasTargetColor = false;

            for (let i = 0; i < letters.length; i++) {
                let color = colorList[Math.floor(Math.random() * colorList.length)];
                if (i === letters.length - 1 && !hasTargetColor) color = targetColor;
                if (color === targetColor) hasTargetColor = true;

                captchaData.push({ char: letters[i], color });
                const span = document.createElement("span");
                span.textContent = letters[i];
                span.className = "fw-bold px-2 py-1 border rounded";
                span.style.background = color;
                span.style.color = "#000";
                captchaBox.appendChild(span);
            }

            captchaInstruction.innerHTML = `
        Pour valider votre formulaire, saisissez les lettres sur fond 
        <strong style="color:${targetColor}">${colorNames[targetColor]}</strong>.
      `;

            captchaInput.value = "";
        }

        refreshBtn.addEventListener("click", displayCaptcha);
        displayCaptcha();

        function showAlert(type, message) {
            alertBox.className = `alert alert-${type} mt-3`;
            alertBox.textContent = message;
            alertBox.classList.remove("d-none");
        }

        formDemande.addEventListener("submit", (e) => {
            e.preventDefault();
            alertBox.classList.add("d-none");

            const requiredFields = formDemande.querySelectorAll("input[required], select[required]");
            for (let field of requiredFields) {
                if (!field.value.trim()) {
                    showAlert("danger", "Veuillez remplir tous les champs obligatoires (*)");
                    field.focus();
                    return;
                }
            }

            const expected = captchaData
                .filter((item) => item.color === targetColor)
                .map((item) => item.char)
                .join("");
            const answer = captchaInput.value.toUpperCase().replace(/[^A-Z]/g, "");

            if (answer !== expected) {
                showAlert("warning", "Captcha incorrect. Merci de réessayer.");
                displayCaptcha();
                return;
            }

            showAlert("success", "✅ Votre demande a été envoyée. Un e-mail vous sera adressé avec votre code et votre mot de passe.");
            formDemande.reset();
            displayCaptcha();
        });
    }
});
