const comitesData = {
    // AIN
    '01': { name: 'Ain (Bourg-en-Bresse)', address: 'Comité local Les Blouses Roses', phone: '07 81 29 42 70', email: 'blousesroses01@gmail.com', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // AISNE
    '02': { name: 'Aisne (Saint-Quentin)', address: 'Comité local Les Blouses Roses', phone: '06 17 89 26 21', email: 'blousesroses02@gmail.com', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // ALPES-MARITIMES
    '06': { name: 'Alpes-Maritimes (Nice)', address: 'Comité local Les Blouses Roses', phone: '06 03 89 99 47', email: 'lesblousesrosesnice06@gmail.com', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // ARDÈCHE
    '07': { name: 'Ardèche (Annonay)', address: 'Comité local Les Blouses Roses', phone: '06 17 48 31 16', email: 'lesblousesrosesannonay@gmail.com', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // ARDENNES
    '08': { name: 'Ardennes (Charleville-Mézières)', address: 'Comité local Les Blouses Roses', phone: '06 82 23 80 50', email: 'blousesroses08@laposte.net', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // AUDE
    '11': { name: 'Aude (Narbonne)', address: 'Comité local Les Blouses Roses', phone: '06 72 23 57 28', email: 'blousesrosesnarbonne11@gmail.com', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // BOUCHES-DU-RHÔNE
    '13': { name: 'Bouches-du-Rhône (Salon de Provence)', address: 'Comité local Les Blouses Roses', phone: 'Non spécifié', email: 'lesblousesroses-salon@laposte.net', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // CALVADOS
    '14': { name: 'Calvados (Caen)', address: 'Comité local Les Blouses Roses', phone: '06 63 67 02 18', email: 'lesblousesroses14@gmail.com', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // CHARENTE
    '16': { name: 'Charente (Angoulême)', address: 'Comité local Les Blouses Roses', phone: '06 43 97 78 86', email: 'lesblousesroses16@orange.fr', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // CHARENTE-MARITIME
    '17': { name: 'Charente-Maritime (La Rochelle)', address: 'Comité local Les Blouses Roses', phone: '06 40 18 17 01', email: 'lesblousesroseslarochelle@gmail.com', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // CORSE-DU-SUD (Utilise l'ID 20a dans votre SVG)
    '20a': { name: 'Corse-du-Sud (Ajaccio)', address: 'Comité local Les Blouses Roses', phone: 'Non spécifié', email: 'Non trouvé. Contactez le siège national.', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // HAUTE-CORSE (Utilise l'ID 20b dans votre SVG)
    '20b': { name: 'Haute-Corse (Bastia)', address: 'Comité local Les Blouses Roses', phone: 'Non spécifié', email: 'Non trouvé. Contactez le siège national.', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // CÔTES-D'ARMOR
    '22': { name: 'Côtes-d\'Armor (Saint-Brieuc)', address: 'Comité local Les Blouses Roses', phone: '06 44 34 21 94', email: 'blousesroses.recrutement22@gmail.com', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // DORDOGNE
    '24': { name: 'Dordogne (Périgueux)', address: 'Comité local Les Blouses Roses', phone: '06 38 67 67 31', email: 'lesblousesroses24@gmail.com', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // DRÔME
    '26': { name: 'Drôme (Valence)', address: 'Comité local Les Blouses Roses', phone: '06 68 09 52 14', email: 'lesblousesroses26@gmail.com', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // EURE
    '27': { name: 'Eure (Évreux)', address: 'Comité local Les Blouses Roses', phone: '06 72 28 32 30', email: 'lesblousesroses27@gmail.com', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // FINISTÈRE
    '29': { name: 'Finistère (Brest/Quimper)', address: 'Comité local Les Blouses Roses', phone: '06 49 19 62 17', email: 'blousesroses.brest@gmail.com', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // GARD
    '30': { name: 'Gard (Nîmes)', address: 'Comité local Les Blouses Roses', phone: '06 60 03 11 64', email: 'lesblousesrosesdugard@gmail.com', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // HAUTE-GARONNE
    '31': { name: 'Haute-Garonne (Toulouse)', address: 'Comité local Les Blouses Roses', phone: '09 50 31 33 14 / 06 29 05 66 56', email: 'assolesblousesroses31@gmail.com', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // HÉRAULT
    '34': { name: 'Hérault (Sète/Montpellier)', address: 'Comité local Les Blouses Roses', phone: '07 82 65 94 00', email: 'lesblousesroses34@gmail.com', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // ILLE-ET-VILAINE
    '35': { name: 'Ille-et-Vilaine (Rennes)', address: 'Comité local Les Blouses Roses', phone: 'Non spécifié', email: 'recrutement@blousesroses35.fr', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // INDRE-ET-LOIRE
    '37': { name: 'Indre-et-Loire (Tours)', address: 'Comité local Les Blouses Roses', phone: '06 80 65 35 34', email: 'blousesroses37@gmail.com', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // ISÈRE
    '38': { name: 'Isère (Grenoble/Vernioz)', address: 'Comité local Les Blouses Roses', phone: '09 51 70 72 00', email: 'lesblousesroses.albon@gmail.com', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // JURA
    '39': { name: 'Jura (Lons-le-Saunier)', address: 'Comité local Les Blouses Roses', phone: '07 68 09 84 41', email: 'blousesroses39@orange.fr', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // LANDES
    '40': { name: 'Landes (Mont-de-Marsan)', address: 'Comité local Les Blouses Roses', phone: '06 68 18 20 54', email: 'blousesroses40@gmail.com', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // LOIRE
    '42': { name: 'Loire (Saint-Étienne)', address: 'Comité local Les Blouses Roses', phone: '06 49 74 37 89', email: 'blousesroses42@gmail.com', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // LOIRE-ATLANTIQUE
    '44': { name: 'Loire-Atlantique (Nantes)', address: 'Comité local Les Blouses Roses', phone: 'Non spécifié', email: 'lesblousesrosesnantes44@gmail.com', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // LOIRET
    '45': { name: 'Loiret (Orléans)', address: 'Comité local Les Blouses Roses', phone: '07 63 55 13 13', email: 'blousesrosesorleans45@gmail.com', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // MEURTHE-ET-MOSELLE
    '54': { name: 'Meurthe-et-Moselle (Nancy)', address: 'Comité local Les Blouses Roses', phone: '03 83 15 74 97 / 06 37 33 89 43', email: 'blousesroses54@gmail.com', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // MORBIHAN
    '56': { name: 'Morbihan (Pontivy)', address: 'Comité local Les Blouses Roses', phone: '06 42 92 11 69', email: 'lesblousesrosespontivy@gmail.com', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // NORD
    '59': { name: 'Nord (Roubaix / Terdeghem)', address: 'Comité local Les Blouses Roses', phone: '03 28 49 70 77 / 06 07 30 76 43 (Terdeghem)', email: 'blousesrosesrbx@gmail.com (Roubaix)', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // PAS-DE-CALAIS
    '62': { name: 'Pas-de-Calais (Saint-Omer / Rang du Fliers)', address: 'Comité local Les Blouses Roses', phone: '06 60 18 02 66 (St Omer) / 06 71 39 63 66 (Rang du Fliers)', email: 'lesblousesroses.saintomer@gmail.com', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // PYRÉNÉES-ORIENTALES
    '66': { name: 'Pyrénées-Orientales (Perpignan)', address: 'Comité local Les Blouses Roses', phone: '06 81 78 94 62', email: 'lesblousesroses.comite66@gmail.com', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // BAS-RHIN
    '67': { name: 'Bas-Rhin (Strasbourg)', address: 'Comité local Les Blouses Roses', phone: 'Non spécifié', email: 'recrutement.lesblousesroses67@gmail.com', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // HAUT-RHIN
    '68': { name: 'Haut-Rhin (Mulhouse)', address: 'Comité local Les Blouses Roses', phone: '06 81 22 22 55', email: 'blousesroses68@gmail.com', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // SEINE-MARITIME
    '76': { name: 'Seine-Maritime (Rouen)', address: 'Comité local Les Blouses Roses', phone: 'Non spécifié', email: 'lesblousesrosesrouen@hotmail.fr', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // DEUX-SÈVRES
    '79': { name: 'Deux-Sèvres (Niort)', address: 'Comité local Les Blouses Roses', phone: '06 22 97 65 78', email: 'blousesroses-niort@sfr.fr', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // VAR
    '83': { name: 'Var (Toulon)', address: 'Comité local Les Blouses Roses', phone: 'Non spécifié', email: 'contact@lesblousesrosestoulon.fr', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // VAUCLUSE
    '84': { name: 'Vaucluse (Pertuis)', address: 'Comité local Les Blouses Roses', phone: '06 63 53 93 72', email: 'lesblousesroses84@yahoo.fr', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // VOSGES
    '88': { name: 'Vosges (Remiremont)', address: 'Comité local Les Blouses Roses', phone: '06 76 07 30 00', email: 'blousesroses.remiremont@gmail.com', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    // ESSONNE
    '91': { name: 'Essonne (Évry)', address: 'Comité local Les Blouses Roses', phone: '06 63 94 99 74', email: 'lesblousesroses91@gmail.com', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },

    // ÎLE-DE-FRANCE / PETITE COURONNE (Regroupés par le comité de Paris)
    '75': { name: 'Paris et périphérie (75, 92, 93, 94)', address: 'Comité Paris et petite couronne', phone: '01 47 56 90 18', email: 'contact@lesblousesrosesparis.fr', link: 'http://www.lesblousesroses.asso.fr/' },
    '92': { name: 'Hauts-de-Seine (Plessis-Robinson)', address: 'Comité Paris et petite couronne', phone: '01 47 56 90 18', email: 'contact@lesblousesrosesparis.fr', link: 'http://www.lesblousesroses.asso.fr/' },
    '93': { name: 'Seine-Saint-Denis', address: 'Comité Paris et petite couronne', phone: '01 47 56 90 18', email: 'contact@lesblousesrosesparis.fr', link: 'http://www.lesblousesroses.asso.fr/' },
    '94': { name: 'Val-de-Marne', address: 'Comité Paris et petite couronne', phone: '01 47 56 90 18', email: 'contact@lesblousesrosesparis.fr', link: 'http://www.lesblousesroses.asso.fr/' },

    // YVELINES
    '78': { name: 'Yvelines (Saint-Germain-en-Laye)', address: 'Comité local Les Blouses Roses', phone: '07 87 62 23 26', email: 'lesblousesroses.saintgermain@gmail.com', link: 'https://www.lesblousesroses.asso.fr/fr/faire-appel-a-nous' },
    };

    document.addEventListener('DOMContentLoaded', (event) => {
        // 2. Récupération des éléments
        const svgMap = document.getElementById('svg_departements');
        const departmentPaths = svgMap ? svgMap.querySelectorAll('path[id^="departement"]') : [];
        
        const infoCard = document.getElementById('comite-info');
        const comiteName = document.getElementById('comite-name');
        const comiteAddress = document.getElementById('comite-address');
        const comitePhone = document.getElementById('comite-phone');
        const comiteEmail = document.getElementById('comite-email');
        const comiteLink = document.getElementById('comite-link');

        // 3. Définition des actions de clic
        departmentPaths.forEach(path => {
            path.addEventListener('click', function() {
                // Extrait le code départemental (ex: "13", "20a")
                const deptId = this.id;
                const deptCode = deptId.replace('departement', ''); 
                
                const committee = comitesData[deptCode];

                // Affiche les informations si un comité existe
                if (committee) {
                    infoCard.style.display = 'block';
                    comiteName.textContent = committee.name;
                    comiteAddress.textContent = committee.address;
                    comitePhone.textContent = committee.phone || 'Non spécifié';
                    
                    comiteEmail.textContent = committee.email;
                    comiteEmail.href = `mailto:${committee.email}`;
                    
                    comiteLink.href = committee.link || `mailto:${committee.email}`;
                    comiteLink.textContent = committee.link ? 'Visiter le site du comité' : 'Envoyer un email au comité';
                    comiteLink.classList.remove('disabled');
                    
                } else {
                    // Message par défaut si le comité n'est pas trouvé
                    infoCard.style.display = 'block';
                    comiteName.textContent = deptCode.toUpperCase();
                    comiteAddress.textContent = 'Aucun comité local "Les Blouses Roses" n\'a été trouvé pour ce département dans nos données.';
                    comitePhone.textContent = '';
                    comiteEmail.textContent = 'Contactez le Siège National pour plus d\'informations.';
                    comiteEmail.href = 'mailto:siegenational@lesblousesroses.asso.fr';
                    comiteLink.href = 'mailto:siegenational@lesblousesroses.asso.fr';
                    comiteLink.textContent = 'Contacter le Siège National';
                    comiteLink.classList.remove('disabled');
                }
            });
        });
    });