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

    // Nouveaux sélecteurs
    const tbodyHistorique = document.getElementById("tbodyHistorique");
    const totalPeriode = document.getElementById("totalPeriode");
    const filtreMode = document.getElementById("filtreMode");
    const filtreDate = document.getElementById("filtreDate");
    const thread = document.getElementById("thread");
    const msgForm = document.getElementById("msgForm");
    const msgInput = document.getElementById("msgInput");
    const btnReceipt = document.getElementById("btnReceipt");
    const newsCards = document.getElementById("newsCards");
    const profilForm = document.getElementById("profilForm");
    const profilContact = document.getElementById("profilContact");
    const profilMsg = document.getElementById("profilMsg");
    const pwdForm = document.getElementById("pwdForm");
    const pwdOld = document.getElementById("pwdOld");
    const pwdNew = document.getElementById("pwdNew");
    const pwdNew2 = document.getElementById("pwdNew2");
    const pwdMsg = document.getElementById("pwdMsg");

    // ==========================
    // 📊 Initialisation du profil de démo
    // ==========================
    const defaultDemoProfil = {
        totalDons: 560,
        historiqueDons: [120, 80, 150, 210], // Montants répartis sur quelques mois
        // Détail (date + mode), si absent on le fabrique
        historiqueDetail: [
            { date: "2025-10-28", montant: 210, mode: "Carte bancaire" },
            { date: "2025-08-12", montant: 150, mode: "Virement" },
            { date: "2025-06-03", montant: 80,  mode: "Carte bancaire" },
            { date: "2025-03-14", montant: 120, mode: "Chèque" }
        ],
        dernierDon: "2025-10-28",
        contact: "sae@example.com"
    };

    const profilsAll = JSON.parse(localStorage.getItem("profilsDonateurs") || "{}");
    if (!profilsAll[VALID_ID]) {
        profilsAll[VALID_ID] = defaultDemoProfil;
        localStorage.setItem("profilsDonateurs", JSON.stringify(profilsAll));
    } else if (!Array.isArray(profilsAll[VALID_ID].historiqueDetail)) {
        // Migration douce si ancien format
        profilsAll[VALID_ID] = { ...defaultDemoProfil, ...profilsAll[VALID_ID] };
        localStorage.setItem("profilsDonateurs", JSON.stringify(profilsAll));
    }

    // ==========================
    // 🔁 Navigation entre formulaires
    // ==========================
    createLink?.addEventListener("click", (e) => {
        e.preventDefault();
        loginForm.classList.add("d-none");
        registerForm.classList.remove("d-none");
        errorMessage.classList.add("d-none");
    });

    backToLogin?.addEventListener("click", (e) => {
        e.preventDefault();
        registerForm.classList.add("d-none");
        loginForm.classList.remove("d-none");
        registerMessage.textContent = "";
    });

    // ==========================
    // 🔐 Connexion
    // ==========================
    loginForm?.addEventListener("submit", (e) => {
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
    registerForm?.addEventListener("submit", (e) => {
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
        const profils = JSON.parse(localStorage.getItem("profilsDonateurs") || "{}");
        if (comptes[id] || id === VALID_ID) {
            registerMessage.textContent = "❌ Cet identifiant existe déjà.";
            registerMessage.className = "text-danger text-center fw-semibold mt-3";
            return;
        }

        // Sauvegarde
        comptes[id] = pwd;
        localStorage.setItem("comptesDonateurs", JSON.stringify(comptes));
        profils[id] = {
            totalDons: 0,
            historiqueDons: [],
            historiqueDetail: [],
            dernierDon: null,
            contact
        };
        localStorage.setItem("profilsDonateurs", JSON.stringify(profils));

        alert(`✅ Un e-mail / message a été envoyé à ${contact} pour confirmer la création de votre compte.`);
        registerMessage.textContent = "✅ Compte créé avec succès ! Vous pouvez maintenant vous connecter.";
        registerMessage.className = "text-success text-center fw-semibold mt-3";

        newIdentifiant.value = "";
        newMotdepasse.value = "";
        confirmMotdepasse.value = "";
        newContact.value = "";

        setTimeout(() => {
            registerForm.classList.add("d-none");
            loginForm.classList.remove("d-none");
            registerMessage.textContent = "";
        }, 1200);
    });

    // ==========================
    // 🔚 Mot de passe oublié (simulation)
    // ==========================
    forgotLink?.addEventListener("click", (e) => {
        e.preventDefault();
        alert("📩 Un e-mail / message pour réinitialiser votre mot de passe vous a été envoyé !");
    });

    // ==========================
    // 🧾 AFFICHAGE APRES CONNEXION
    // ==========================
    function showContent(identifiant) {
        connexionSection.classList.add("d-none");
        contentDonateur.classList.remove("d-none");
        userIdentifiant.textContent = identifiant;

        const profils = JSON.parse(localStorage.getItem("profilsDonateurs") || "{}");
        const profil = profils[identifiant];

        if (profil) {
            totalDons.textContent = (profil.totalDons || 0) + " €";
            if ((profil.totalDons || 0) > 0) sectionGenerosite.classList.remove("d-none");
            else sectionGenerosite.classList.add("d-none");

            // Pré-remplir “Mon compte”
            profilContact.value = profil.contact || "";
        } else {
            totalDons.textContent = "0 €";
            sectionGenerosite.classList.add("d-none");
        }

        // Init contenu onglets
        genererGraphique(identifiant);
        renderHistorique(identifiant);
        renderMessages(identifiant);
        renderNews(identifiant);
    }

    // 🔁 Si déjà connecté
    const utilisateur = sessionStorage.getItem("donateur");
    if (utilisateur) showContent(utilisateur);

    // ==========================
    // 🚪 Déconnexion
    // ==========================
    btnLogout?.addEventListener("click", () => {
        sessionStorage.removeItem("donateur");
        contentDonateur.classList.add("d-none");
        connexionSection.classList.remove("d-none");
    });

    // ==========================
    // 💝 Redirection vers la page de don
    // ==========================
    btnReDon?.addEventListener("click", () => {
        window.location.href = "faireDon.php";
    });

    // ==========================
    // 📊 Graphique
    // ==========================
    function genererGraphique(identifiant) {
        const ctx = document.getElementById("donChart");
        if (!ctx) return;

        const profils = JSON.parse(localStorage.getItem("profilsDonateurs") || "{}");
        const profil = profils[identifiant] || { historiqueDons: [] };

        const mois = ["Jan", "Fév", "Mars", "Avr", "Mai", "Juin", "Juil", "Août", "Sept", "Oct", "Nov", "Déc"];
        const dons = profil.historiqueDons.length ? profil.historiqueDons : Array(12).fill(0);

        // Détruire un ancien chart si recréé
        if (ctx._chartInstance) ctx._chartInstance.destroy();

        const chart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: mois.slice(0, Math.max(dons.length, 1)),
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
        ctx._chartInstance = chart;
    }

    // ==========================
    // 📜 Historique détaillé (2)
    // ==========================
    function renderHistorique(identifiant) {
        const profils = JSON.parse(localStorage.getItem("profilsDonateurs") || "{}");
        const profil = profils[identifiant];
        if (!profil) return;

        const rows = (profil.historiqueDetail || []).slice().sort((a, b) => b.date.localeCompare(a.date));
        applyHistoriqueFilters(rows);
    }

    function applyHistoriqueFilters(rows) {
        const mode = (filtreMode?.value || "").trim();
        const ym = (filtreDate?.value || "").trim(); // "YYYY-MM"
        let total = 0;

        const filtered = rows.filter(r => {
            const okMode = !mode || r.mode === mode;
            const okDate = !ym || (r.date && r.date.startsWith(ym));
            return okMode && okDate;
        });

        tbodyHistorique.innerHTML = filtered.map(r => {
            total += Number(r.montant || 0);
            return `
        <tr>
          <td>${formatDateFR(r.date)}</td>
          <td class="fw-semibold text-success">${Number(r.montant).toFixed(2)} €</td>
          <td>${r.mode}</td>
          <td>🙏 Merci pour votre générosité !</td>
        </tr>
      `;
        }).join("") || `<tr><td colspan="4" class="text-center text-muted">Aucun don pour cette période.</td></tr>`;

        totalPeriode.textContent = `${total.toFixed(2)} €`;
    }

    filtreMode?.addEventListener("change", () => {
        const id = sessionStorage.getItem("donateur");
        if (!id) return;
        const p = JSON.parse(localStorage.getItem("profilsDonateurs") || "{}")[id];
        applyHistoriqueFilters((p?.historiqueDetail)||[]);
    });
    filtreDate?.addEventListener("input", () => {
        const id = sessionStorage.getItem("donateur");
        if (!id) return;
        const p = JSON.parse(localStorage.getItem("profilsDonateurs") || "{}")[id];
        applyHistoriqueFilters((p?.historiqueDetail)||[]);
    });

    // ==========================
    // 💬 Messagerie (1)
    // ==========================
    function storageKeyMsg(id){ return `messages_${id}`; }
    function getMessages(id){ return JSON.parse(localStorage.getItem(storageKeyMsg(id)) || "[]"); }
    function setMessages(id, arr){ localStorage.setItem(storageKeyMsg(id), JSON.stringify(arr)); }

    function renderMessages(identifiant){
        const msgs = getMessages(identifiant);
        thread.innerHTML = msgs.map(m => bubbleHTML(m)).join("") || `
      <div class="text-center text-muted">Aucun message. Lancez la discussion 💌</div>
    `;
        // Scroll bottom
        thread.scrollTop = thread.scrollHeight;
    }

    function bubbleHTML(m){
        const side = m.from === "me" ? "end" : "start";
        const color = m.from === "me" ? "bg-rose text-white" : "bg-light";
        return `
      <div class="d-flex justify-content-${side}">
        <div class="rounded-4 p-2 px-3 ${color}" style="max-width: 80%;">
          <div class="small opacity-75">${formatDateTimeFR(m.date)}</div>
          <div>${escapeHTML(m.text)}</div>
        </div>
      </div>
    `;
    }

    msgForm?.addEventListener("submit", (e) => {
        e.preventDefault();
        const id = sessionStorage.getItem("donateur");
        if (!id) return;

        const text = (msgInput.value || "").trim();
        if(!text) return;

        const now = new Date().toISOString();
        const msgs = getMessages(id);
        msgs.push({ from: "me", text, date: now });
        setMessages(id, msgs);
        msgInput.value = "";
        renderMessages(id);

        // Auto-réponse simulée
        setTimeout(() => {
            const rep = {
                from: "org",
                text: "Merci pour votre message 💗 Nous revenons vers vous rapidement.",
                date: new Date().toISOString()
            };
            const m2 = getMessages(id);
            m2.push(rep);
            setMessages(id, m2);
            renderMessages(id);
        }, 700);
    });

    // ==========================
    // 📰 Actus personnalisées (5)
    // ==========================
    function renderNews(identifiant){
        const profils = JSON.parse(localStorage.getItem("profilsDonateurs") || "{}");
        const total = profils[identifiant]?.totalDons || 0;

        const cards = [
            {
                title: "Atelier créatif en pédiatrie",
                text: "Vos dons financent peintures, gommettes et petits cadeaux pour égayer les chambres.",
                cta: "Je participe 💞"
            },
            {
                title: "Sortie cinéma pour 12 enfants",
                text: "Transport + encadrement + goûters : un moment d’évasion rendu possible grâce à vous.",
                cta: "Soutenir 🎬"
            },
            {
                title: `Objectif de fin d’année`,
                text: `Nous visons 5 000 € pour multiplier les ateliers musicaux. Il manque encore ${Math.max(0, 5000 - total)} €.`,
                cta: "Contribuer 🎶"
            }
        ];

        newsCards.innerHTML = cards.map(c => `
      <div class="col-md-4 mb-3">
        <div class="card h-100 shadow-sm">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title text-rose">${c.title}</h5>
            <p class="card-text flex-grow-1">${c.text}</p>
            <a href="faireDon.html" class="btn btn-rose mt-2 align-self-start">${c.cta}</a>
          </div>
        </div>
      </div>
    `).join("");
    }

    // ==========================
    // ⚙️ Mon compte (7)
    // ==========================
    profilForm?.addEventListener("submit", (e) => {
        e.preventDefault();
        const id = sessionStorage.getItem("donateur");
        if (!id) return;

        const profils = JSON.parse(localStorage.getItem("profilsDonateurs") || "{}");
        if (!profils[id]) return;

        profils[id].contact = (profilContact.value || "").trim();
        localStorage.setItem("profilsDonateurs", JSON.stringify(profils));
        profilMsg.textContent = "✅ Enregistré";
        profilMsg.className = "text-success small ms-2";
        setTimeout(()=>{ profilMsg.textContent=""; }, 1500);
    });

    pwdForm?.addEventListener("submit", (e) => {
        e.preventDefault();
        const id = sessionStorage.getItem("donateur");
        if (!id) return;

        const comptes = JSON.parse(localStorage.getItem("comptesDonateurs") || "{}");
        const isDemo = (id === VALID_ID); // démo : on autorise quand même avec l’ancien mdp
        const oldOk = isDemo ? (pwdOld.value === VALID_PWD) : (comptes[id] === pwdOld.value);

        if (!oldOk){
            pwdMsg.textContent = "❌ Mot de passe actuel incorrect";
            pwdMsg.className = "text-danger small ms-2";
            return;
        }
        if (pwdNew.value.length < 4 || pwdNew.value !== pwdNew2.value){
            pwdMsg.textContent = "❌ Vérifiez le nouveau mot de passe";
            pwdMsg.className = "text-danger small ms-2";
            return;
        }

        if (!isDemo){
            comptes[id] = pwdNew.value;
            localStorage.setItem("comptesDonateurs", JSON.stringify(comptes));
        }
        pwdOld.value = pwdNew.value = pwdNew2.value = "";
        pwdMsg.textContent = "✅ Mot de passe mis à jour";
        pwdMsg.className = "text-success small ms-2";
        setTimeout(()=>{ pwdMsg.textContent=""; }, 1500);
    });

    // ==========================
    // 🧾 Reçu fiscal imprimable (3)
    // ==========================
    btnReceipt?.addEventListener("click", () => {
        const id = sessionStorage.getItem("donateur");
        if (!id) return;
        const profils = JSON.parse(localStorage.getItem("profilsDonateurs") || "{}");
        const p = profils[id] || { totalDons: 0, historiqueDetail: [] };

        const now = new Date();
        const annee = now.getFullYear();
        const lignes = (p.historiqueDetail||[])
            .filter(r => r.date?.startsWith(String(annee)))
            .sort((a,b)=>a.date.localeCompare(b.date))
            .map(r => `<tr><td>${formatDateFR(r.date)}</td><td style="text-align:right">${Number(r.montant).toFixed(2)} €</td><td>${r.mode}</td></tr>`)
            .join("");

        const totalAnnee = (p.historiqueDetail||[])
            .filter(r => r.date?.startsWith(String(annee)))
            .reduce((s,r)=>s+Number(r.montant||0),0);

        const win = window.open("", "_blank", "width=800,height=900");
        win.document.write(`
      <!doctype html><html lang="fr"><head>
        <meta charset="utf-8"><title>Reçu fiscal ${annee}</title>
        <style>
          body{font-family:system-ui,Segoe UI,Roboto,Arial;margin:32px}
          h1{color:#EC1F7A;margin:0 0 8px}
          table{width:100%;border-collapse:collapse;margin-top:16px}
          th,td{border:1px solid #ddd;padding:8px}
          th{background:#fff0f7;text-align:left}
          .tot{margin-top:12px;text-align:right;font-weight:700}
          .badge{display:inline-block;background:#EC1F7A;color:#fff;padding:4px 10px;border-radius:999px;font-size:12px}
          .small{color:#666;font-size:12px}
          @media print{button{display:none}}
        </style>
      </head><body>
        <h1>Attestation de don — Les Blouses Roses</h1>
        <p class="small">Émise le ${formatDateTimeFR(now.toISOString())}</p>
        <p><span class="badge">Donateur</span> <strong>${escapeHTML(id)}</strong><br>
           Contact : ${escapeHTML(p.contact || "—")}</p>

        <table>
          <thead><tr><th>Date</th><th style="text-align:right">Montant</th><th>Mode</th></tr></thead>
          <tbody>${lignes || `<tr><td colspan="3">Aucun don sur ${annee}</td></tr>`}</tbody>
        </table>
        <p class="tot">Total ${annee} : ${totalAnnee.toFixed(2)} €</p>

        <p class="small">Document à valeur informative. L’attestation officielle peut être transmise par l’association.</p>
        <button onclick="print()">🖨️ Imprimer / Enregistrer en PDF</button>
      </body></html>
    `);
        win.document.close();
    });

    // ==========================
    // 🧩 Utilitaires
    // ==========================
    function formatDateFR(iso){
        if(!iso) return "—";
        const [y,m,d] = iso.split("-"); return `${d}/${m}/${y}`;
    }
    function formatDateTimeFR(iso){
        const dt = new Date(iso);
        return dt.toLocaleString("fr-FR");
    }
    function escapeHTML(s){
        return String(s||"").replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]));
    }
});
