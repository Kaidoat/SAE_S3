document.addEventListener("DOMContentLoaded", () => {


    // Sections
    const sectionDemande = document.getElementById("demande-identification");
    const sectionContent = document.getElementById("internalContent");

    // Boutons
    const btnShowDemande = document.getElementById("showDemande");
    const btnBack        = document.getElementById("backToLogin");

    // Messages
    const successMsg = document.getElementById("internalSuccess");
    const errorMsg   = document.getElementById("internalError");

    // -------------------------------
    // Navigation interface (UX)
    // -------------------------------
    if (btnShowDemande && sectionDemande && sectionContent) {
        btnShowDemande.addEventListener("click", (e) => {
            e.preventDefault();
            sectionContent.classList.add("d-none");
            sectionDemande.classList.remove("d-none");
        });
    }

    if (btnBack && sectionDemande && sectionContent) {
        btnBack.addEventListener("click", (e) => {
            e.preventDefault();
            sectionDemande.classList.add("d-none");
            sectionContent.classList.remove("d-none");
        });
    }

    // ================================
    // FORMULAIRE DE DEMANDE + CAPTCHA
    // ================================
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
            for (let i = 0; i < n; i++) {
                s += letters[Math.floor(Math.random() * letters.length)];
            }
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
                if (i === letters.length - 1 && !hasTargetColor) {
                    color = targetColor;
                }
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
                <strong style="color:${targetColor}">
                    ${colorNames[targetColor]}
                </strong>.
            `;

            captchaInput.value = "";
        }

        function showAlert(type, message) {
            alertBox.className = `alert alert-${type} mt-3`;
            alertBox.textContent = message;
            alertBox.classList.remove("d-none");
        }

        if (refreshBtn) {
            refreshBtn.addEventListener("click", displayCaptcha);
        }

        displayCaptcha();

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
                .filter(item => item.color === targetColor)
                .map(item => item.char)
                .join("");

            const answer = captchaInput.value
                .toUpperCase()
                .replace(/[^A-Z]/g, "");

            if (answer !== expected) {
                showAlert("warning", "Captcha incorrect. Merci de réessayer.");
                displayCaptcha();
                return;
            }

            showAlert(
                "success",
                "✅ Votre demande a été envoyée. Un e-mail vous sera adressé avec vos identifiants."
            );

            formDemande.reset();
            displayCaptcha();
        });
    }
});
