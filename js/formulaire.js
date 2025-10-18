document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("benevoleForm");

    // === Validation simple du formulaire ===
    form.addEventListener("submit", (e) => {
        e.preventDefault();

        const requiredFields = form.querySelectorAll("[required]");
        let valid = true;

        requiredFields.forEach((field) => {
            if (!field.value.trim()) {
                field.classList.add("invalid");
                valid = false;
            } else {
                field.classList.remove("invalid");
            }
        });

        if (!valid) {
            alert("Merci de remplir tous les champs obligatoires (*)");
            return;
        }

        const btn = form.querySelector(".btn-submit");
        btn.textContent = "✔ Envoyé !";
        btn.style.backgroundColor = "#28a745";

        setTimeout(() => {
            btn.textContent = "ENVOYER";
            btn.style.backgroundColor = "#e6007e";
            form.reset();
        }, 2500);
    });
});
