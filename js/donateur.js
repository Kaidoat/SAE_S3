document.addEventListener("DOMContentLoaded", () => {

    fetch("back/get-donateur.php")
        .then(res => res.json())
        .then(data => {

            // Total des dons
            document.getElementById("totalDons").textContent =
                data.totalDons + " €";

            // Historique
            const tbody = document.getElementById("tbodyHistorique");
            tbody.innerHTML = "";

            data.historiqueDetail.forEach(don => {
                tbody.innerHTML += `
                    <tr>
                        <td>${don.date}</td>
                        <td class="text-success fw-semibold">${don.montant} €</td>
                        <td>${don.mode}</td>
                    </tr>
                `;
            });

        })
        .catch(() => {
            console.error("Erreur chargement donateur");
        });

});
