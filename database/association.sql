-- ===============================
-- BASE DE DONNÉES
-- ===============================
CREATE DATABASE IF NOT EXISTS association
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

USE association;

-- ===============================
-- TABLES PRINCIPALES
-- ===============================

CREATE TABLE Ville (
                       id_ville INT AUTO_INCREMENT PRIMARY KEY,
                       nom VARCHAR(100) NOT NULL
);

CREATE TABLE Competence (
                            id_competence INT AUTO_INCREMENT PRIMARY KEY,
                            libelle VARCHAR(100) NOT NULL
);

CREATE TABLE Regime_alimentaire (
                                    id_reg INT AUTO_INCREMENT PRIMARY KEY,
                                    type VARCHAR(100) NOT NULL
);

CREATE TABLE Contrainte (
                            id_contrainte INT AUTO_INCREMENT PRIMARY KEY,
                            type_contrainte VARCHAR(100),
                            description TEXT
);

CREATE TABLE Indicateur (
                            id_indicateur INT AUTO_INCREMENT PRIMARY KEY,
                            nom VARCHAR(100),
                            description TEXT,
                            categorie VARCHAR(100)
);

CREATE TABLE Materiel (
                          id_mat INT AUTO_INCREMENT PRIMARY KEY,
                          nom_materiel VARCHAR(100),
                          description TEXT
);

CREATE TABLE Responsable (
                             id_responsable INT AUTO_INCREMENT PRIMARY KEY,
                             prenom VARCHAR(100),
                             role VARCHAR(100)
);

CREATE TABLE Media (
                       id_media INT AUTO_INCREMENT PRIMARY KEY,
                       nom_media VARCHAR(100),
                       type_media VARCHAR(50)
);

CREATE TABLE Donateur (
                          id_donateur INT AUTO_INCREMENT PRIMARY KEY,
                          nom VARCHAR(100),
                          prenom VARCHAR(100),
                          type_donateur VARCHAR(50),
                          mdp_compte VARCHAR(255)
);

CREATE TABLE Partenaire (
                            id_partenaire INT AUTO_INCREMENT PRIMARY KEY,
                            nom_contact VARCHAR(100),
                            type_partenaire VARCHAR(100),
                            prenom_contact VARCHAR(100),
                            convention TEXT
);

-- ===============================
-- BENEVOLE
-- ===============================
CREATE TABLE Benevole (
                          id_benevole INT AUTO_INCREMENT PRIMARY KEY,
                          prenom VARCHAR(100),
                          nom VARCHAR(100),
                          date_naissance DATE,
                          disponibilite VARCHAR(100),
                          telephone VARCHAR(20),
                          email VARCHAR(150),
                          adresse TEXT,
                          origine VARCHAR(100),
                          statut VARCHAR(50),
                          mdp_compte VARCHAR(255),
                          id_ville INT,
                          FOREIGN KEY (id_ville) REFERENCES Ville(id_ville)
);

-- ===============================
-- MISSION
-- ===============================
CREATE TABLE Mission (
                         id_mission INT AUTO_INCREMENT PRIMARY KEY,
                         titre VARCHAR(150),
                         description TEXT,
                         date_debut DATE,
                         type_mission VARCHAR(100),
                         date_fin DATE,
                         nbr_benevole INT
);

-- ===============================
-- EVENEMENT
-- ===============================
CREATE TABLE Evenement (
                           id_evenement INT AUTO_INCREMENT PRIMARY KEY,
                           nom VARCHAR(150),
                           type_evenement VARCHAR(100),
                           date_event DATE,
                           logistique TEXT
);

-- ===============================
-- DON & SUBVENTION
-- ===============================
CREATE TABLE Don (
                     id_don INT AUTO_INCREMENT PRIMARY KEY,
                     date_don DATE,
                     montant DECIMAL(10,2),
                     type_don VARCHAR(50),
                     id_donateur INT,
                     FOREIGN KEY (id_donateur) REFERENCES Donateur(id_donateur)
);

CREATE TABLE Subvention (
                            id_subvention INT AUTO_INCREMENT PRIMARY KEY,
                            montant DECIMAL(10,2),
                            usage_prevu TEXT,
                            date_debut DATE,
                            date_fin DATE,
                            organisme VARCHAR(150)
);

-- ===============================
-- TABLES DE LIAISON
-- ===============================

-- Bénévole <-> Compétence
CREATE TABLE Benevole_Competence (
                                     id_benevole INT,
                                     id_competence INT,
                                     PRIMARY KEY (id_benevole, id_competence),
                                     FOREIGN KEY (id_benevole) REFERENCES Benevole(id_benevole),
                                     FOREIGN KEY (id_competence) REFERENCES Competence(id_competence)
);

-- Bénévole <-> Régime
CREATE TABLE Benevole_Regime (
                                 id_benevole INT,
                                 id_reg INT,
                                 PRIMARY KEY (id_benevole, id_reg),
                                 FOREIGN KEY (id_benevole) REFERENCES Benevole(id_benevole),
                                 FOREIGN KEY (id_reg) REFERENCES Regime_alimentaire(id_reg)
);

-- Bénévole <-> Contrainte
CREATE TABLE Benevole_Contrainte (
                                     id_benevole INT,
                                     id_contrainte INT,
                                     PRIMARY KEY (id_benevole, id_contrainte),
                                     FOREIGN KEY (id_benevole) REFERENCES Benevole(id_benevole),
                                     FOREIGN KEY (id_contrainte) REFERENCES Contrainte(id_contrainte)
);

-- Mission <-> Responsable
CREATE TABLE Mission_Responsable (
                                     id_mission INT,
                                     id_responsable INT,
                                     PRIMARY KEY (id_mission, id_responsable),
                                     FOREIGN KEY (id_mission) REFERENCES Mission(id_mission),
                                     FOREIGN KEY (id_responsable) REFERENCES Responsable(id_responsable)
);

-- Mission <-> Matériel
CREATE TABLE Mission_Materiel (
                                  id_mission INT,
                                  id_mat INT,
                                  quantite INT,
                                  PRIMARY KEY (id_mission, id_mat),
                                  FOREIGN KEY (id_mission) REFERENCES Mission(id_mission),
                                  FOREIGN KEY (id_mat) REFERENCES Materiel(id_mat)
);

-- Mission <-> Bénévole
CREATE TABLE Mission_Benevole (
                                  id_mission INT,
                                  id_benevole INT,
                                  PRIMARY KEY (id_mission, id_benevole),
                                  FOREIGN KEY (id_mission) REFERENCES Mission(id_mission),
                                  FOREIGN KEY (id_benevole) REFERENCES Benevole(id_benevole)
);

-- Evénement <-> Média
CREATE TABLE Evenement_Media (
                                 id_evenement INT,
                                 id_media INT,
                                 PRIMARY KEY (id_evenement, id_media),
                                 FOREIGN KEY (id_evenement) REFERENCES Evenement(id_evenement),
                                 FOREIGN KEY (id_media) REFERENCES Media(id_media)
);

-- Evénement <-> Bénévole
CREATE TABLE Evenement_Benevole (
                                    id_evenement INT,
                                    id_benevole INT,
                                    PRIMARY KEY (id_evenement, id_benevole),
                                    FOREIGN KEY (id_evenement) REFERENCES Evenement(id_evenement),
                                    FOREIGN KEY (id_benevole) REFERENCES Benevole(id_benevole)
);

-- Partenaire <-> Don
CREATE TABLE Partenaire_Don (
                                id_partenaire INT,
                                id_don INT,
                                PRIMARY KEY (id_partenaire, id_don),
                                FOREIGN KEY (id_partenaire) REFERENCES Partenaire(id_partenaire),
                                FOREIGN KEY (id_don) REFERENCES Don(id_don)
);

-- Partenaire <-> Subvention
CREATE TABLE Partenaire_Subvention (
                                       id_partenaire INT,
                                       id_subvention INT,
                                       PRIMARY KEY (id_partenaire, id_subvention),
                                       FOREIGN KEY (id_partenaire) REFERENCES Partenaire(id_partenaire),
                                       FOREIGN KEY (id_subvention) REFERENCES Subvention(id_subvention)
);
DROP TABLE IF EXISTS Utilisateur;

CREATE TABLE Utilisateur (
                             id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
                             login VARCHAR(100) UNIQUE NOT NULL,
                             password_hash VARCHAR(255) NOT NULL,
                             role ENUM('admin','responsable','benevole') NOT NULL,

                             nom VARCHAR(100) NOT NULL,
                             prenom VARCHAR(100) NOT NULL,
                             email VARCHAR(150) NOT NULL,
                             telephone VARCHAR(20),
                             adresse TEXT,
                             code_postal VARCHAR(10),

                             id_ville INT,
                             FOREIGN KEY (id_ville) REFERENCES Ville(id_ville)
);


CREATE TABLE Actualite (
                           id_actualite INT AUTO_INCREMENT PRIMARY KEY,
                           titre VARCHAR(255) NOT NULL,
                           resume TEXT NOT NULL,
                           image_url VARCHAR(255),
                           lien VARCHAR(255),
                           date_publication DATE
);


-- ===============================
-- DONNÉES DE DÉMONSTRATION
-- ===============================

-- Villes
INSERT INTO Ville (nom) VALUES
                            ('Metz'),
                            ('Nancy'),
                            ('Thionville'),
                            ('ANGERS'),
                            ('ANNECY'),
                            ('BORDEAUX'),
                            ('LILLE'),
                            ('MARSEILLE'),
                            ('NANTES'),
                            ('PARIS'),
                            ('STRASBOURG'),
                            ('TOULOUSE'),
                            ('TOURS');


-- Compétences
INSERT INTO Competence (libelle) VALUES
                                     ('Animation'),
                                     ('Organisation'),
                                     ('Communication');

-- Régimes alimentaires
INSERT INTO Regime_alimentaire (type) VALUES
                                          ('Standard'),
                                          ('Végétarien'),
                                          ('Sans porc');

-- Contraintes
INSERT INTO Contrainte (type_contrainte, description) VALUES
                                                          ('Médicale', 'Allergie alimentaire'),
                                                          ('Horaire', 'Disponible uniquement le week-end'),
                                                          ('Physique', 'Pas de port de charges lourdes');

-- Matériel
INSERT INTO Materiel (nom_materiel, description) VALUES
                                                     ('Jeux de société', 'Jeux pour animations'),
                                                     ('Costumes', 'Costumes pour événements'),
                                                     ('Sono', 'Matériel audio');

-- Responsables
INSERT INTO Responsable (prenom, role) VALUES
                                           ('Chaïma', 'Responsable animation'),
                                           ('Eva', 'Responsable communication'),
                                           ('Nicolas', 'Responsable logistique');

-- Médias
INSERT INTO Media (nom_media, type_media) VALUES
                                              ('Photo événement', 'image'),
                                              ('Vidéo présentation', 'vidéo'),
                                              ('Affiche', 'document');

-- Bénévoles
INSERT INTO Benevole (
    prenom, nom, date_naissance, disponibilite,
    telephone, email, adresse, origine, statut,
    mdp_compte, id_ville
) VALUES
      ('Chaïma', 'Kherbach', '2005-06-12', 'Semaine',
       '0600000001', 'chaima@mail.com', 'Rue A', 'Étudiante', 'Actif',
       'demo', 1),

      ('Eva', 'Martin', '2004-03-20', 'Week-end',
       '0600000002', 'eva@mail.com', 'Rue B', 'Étudiante', 'Actif',
       'demo', 2),

      ('Celthans', 'Durand', '2003-11-05', 'Flexible',
       '0600000003', 'celthans@mail.com', 'Rue C', 'Étudiant', 'Actif',
       'demo', 3),

      ('Nicolas', 'Petit', '2004-01-18', 'Semaine',
       '0600000004', 'nicolas@mail.com', 'Rue D', 'Étudiant', 'Actif',
       'demo', 1);


-- Missions
INSERT INTO Mission (titre, description, date_debut, type_mission, date_fin, nbr_benevole) VALUES
                                                                                               ('Animation hôpital', 'Jeux avec enfants', '2025-06-01', 'Animation', '2025-06-01', 3),
                                                                                               ('Visite maison de retraite', 'Discussion et jeux', '2025-06-10', 'Social', '2025-06-10', 2),
                                                                                               ('Événement caritatif', 'Collecte de dons', '2025-06-20', 'Événement', '2025-06-20', 4);

-- Événements
INSERT INTO Evenement (nom, type_evenement, date_event, logistique) VALUES
                                                                        ('Journée solidaire', 'Animation', '2025-07-01', 'Salle + matériel'),
                                                                        ('Collecte annuelle', 'Collecte', '2025-08-15', 'Stand + flyers'),
                                                                        ('Fête associative', 'Festif', '2025-09-10', 'Sono + déco');



-- Utilisateurs (login réel)
INSERT INTO Utilisateur
(login, password_hash, role, nom, prenom, email, telephone, adresse, code_postal, id_ville)
VALUES
    (
        'chaima',
        'demo1',
        'admin',
        'Kherbach',
        'Chaïma',
        'chaima.kherbach@example.com',
        '0612345678',
        '12 rue des Fleurs',
        '59000',
        1
    ),

    (
        'eva',
        'demo1',
        'responsable',
        'Martin',
        'Eva',
        'eva.martin@example.com',
        '0623456789',
        '8 avenue Victor Hugo',
        '75000',
        2
    ),

    (
        'celthans',
        'demo1',
        'benevole',
        'Dupont',
        'Celthans',
        'celthans.dupont@example.com',
        '0634567890',
        '3 place du Capitole',
        '31000',
        3
    ),

    (
        'nicolas',
        'demo1',
        'benevole',
        'Durand',
        'Nicolas',
        'nicolas.durand@example.com',
        '0645678901',
        '25 rue de la République',
        '44000',
        4
    );

/*--Actualitées*/

INSERT INTO Actualite (titre, resume, image_url, lien, date_publication) VALUES
                                                                             ('Des jeux XXL pour nos bénéficiaires', 'Grâce à la Fondation MMA Solidarité, les 85 comités Blouses Roses sont désormais équipés de jeux XXL pour leurs interventions auprès des perso…', 'https://www.lesblousesroses.asso.fr/mediacenter/uploads/m/remerciement-mma.png', 'https://www.lesblousesroses.asso.fr/fr/actualites/des-jeux-xxl-pour-nos-beneficiaires', NULL),
                                                                             ('ENTENDRE, un partenaire fidèle', 'Depuis 2021, le groupement des audioprothésistes ENTENDRE soutient notre association :
Formations des Blouses Roses : plus de 3 800 bénévoles ont p…', 'https://www.lesblousesroses.asso.fr/mediacenter/uploads/m/remerciement-entreprises2.png', 'https://www.lesblousesroses.asso.fr/fr/actualites/entendre-un-partenaire-fidele', NULL),
                                                                             ('Une nouvelle antenne Blouse Rose à Charleville-Mézières', 'Bienvenu au futur comité de Charleville-Mézières !!
Le 2 juin 2025, le CH Nord Ardennes et Les Blouses Roses s''engageaient ensemble pour le bien-ê…', 'https://www.lesblousesroses.asso.fr/mediacenter/uploads/m/charleville-meziere-juillet.jpeg', 'https://www.lesblousesroses.asso.fr/fr/actualites/une-nouvelle-antenne-blouse-rose-a-charleville-mezieres', NULL),
                                                                             ('Quand les Supers Héros au Grand Cœur rencontrent Les Blouses Roses', 'Quand les Supers Héros au Grand Coeur s’associent avec Les Blouses Roses de Toulouse et de Perpignan, ça donne des journées incroyables pour les …', 'https://www.lesblousesroses.asso.fr/mediacenter/uploads/m/toulouse-super-heros-grand-coeur-juin.jpeg', 'https://www.lesblousesroses.asso.fr/fr/actualites/quand-les-supers-heros-au-grand-coeur-rencontrent-les-blouses-roses', NULL),
                                                                             ('Une AG 2025 sous le signe de la convivialité', 'Mercredi 21 mai, plus de 150 Blouses et Blousons Roses (présidente(e)s, vice-président(e)s, trésorier(e)s, délégués régionaux, membres du CA) …', 'https://www.lesblousesroses.asso.fr/mediacenter/uploads/m/51.jpeg', 'https://www.lesblousesroses.asso.fr/fr/actualites/une-ag-2025-sous-le-signe-de-la-convivialite', NULL),
                                                                             ('Bonne année de la part des 4 400 Blouses Roses', '', 'https://www.lesblousesroses.asso.fr/mediacenter/uploads/m/voeux---copie.jpeg', 'https://www.lesblousesroses.asso.fr/fr/actualites/bonne-annee-de-la-part-des-4-400-blouses-roses', NULL),
                                                                             ('Quand les animaux thérapeutiques apaisent les maux ...', 'Dans le monde des soins aux personnes âgées, l''introduction d''animaux thérapeutiques dans les EHPAD a révolutionné la manière dont le bien-être…', 'https://www.lesblousesroses.asso.fr/mediacenter/uploads/m/toulouse-peluche-2.jpeg', 'https://www.lesblousesroses.asso.fr/fr/actualites/quand-les-animaux-therapeutiques-apaisent-les-maux-', NULL),
                                                                             ('Les délégués régionaux Blouses Roses', 'Lors des différentes JER, Journée d''Etudes Régionale, les 85 comités Blouses Roses ont élus ou réélus leurs délégués régionaux !
Leur rôle…', 'https://www.lesblousesroses.asso.fr/mediacenter/uploads/m/dr-oct-2024.png', 'https://www.lesblousesroses.asso.fr/fr/actualites/les-delegues-regionaux-blouses-roses', NULL),
                                                                             ('La journée CARREFOUR au profit des Blouses Roses', 'Partenaire fidèle depuis plus de 10 ans, cette année encore, les magasins Carrefour ont ouvert leurs portes aux Blouses et Blousons Roses pour une j…', 'https://www.lesblousesroses.asso.fr/mediacenter/uploads/m/affiche-carrefour-2024.png', 'https://www.lesblousesroses.asso.fr/fr/actualites/la-journee-carrefour-au-profit-des-blouses-roses', NULL),
                                                                             ('Reportage France 3 sur les Blouses Roses de Lille', 'France 3 Nord Pas de Calais a tourné dans le service Hôpital de Jour de l''hôpital Jeanne de Flandre CHU de Lille quelques images au sein des chambr…', 'https://www.lesblousesroses.asso.fr/mediacenter/uploads/m/lille-france-3ici.jpeg', 'https://www.lesblousesroses.asso.fr/fr/actualites/reportage-france-3-sur-les-blouses-roses-de-lille', NULL);
ALTER TABLE Subvention
    ADD statut ENUM('en attente','acceptée','refusée') DEFAULT 'en attente',
ADD date_reponse DATE,
ADD montant_demande DECIMAL(10,2);

ALTER TABLE Donateur
    ADD email VARCHAR(150) NOT NULL,
ADD UNIQUE (email);


INSERT INTO Donateur (nom, prenom, email, mdp_compte, type_donateur)
VALUES
    ('Dupont', 'Marie', 'marie.dupont@mail.com', 'mdp123', 'particulier'),
    ('Lemoine', 'Paul', 'paul.lemoine@mail.com', 'secret456', 'particulier'),
    ('Rossi', 'Clara', 'clara.rossi@mail.com', 'azerty', 'particulier');

INSERT INTO Donateur (nom, prenom, email, mdp_compte, type_donateur)
VALUES
    ('Société ABC', 'Contact', 'contact@abc.fr', 'entreprise', 'entreprise');

INSERT INTO Don (montant, date_don, type_don, id_donateur)
VALUES
    (25.00, '2025-01-10', 'Carte bancaire', 1),
    (40.00, '2025-03-15', 'Prélèvement', 1);
INSERT INTO Don (montant, date_don, type_don, id_donateur)
VALUES
    (15.00, '2025-02-01', 'Chèque', 2);
INSERT INTO Don (montant, date_don, type_don, id_donateur)
VALUES
    (60.00, '2025-04-05', 'Carte bancaire', 3),
    (20.00, '2025-05-01', 'Carte bancaire', 3);
