/**
*   Création de la bd pour le site vino
*   @projet vino16628
*   @author Steve Bourgault
*   @date 03/11/2019
*   @file vinodb.sql
*/

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Structure de la table bouteille_type
--

CREATE TABLE bouteille_type (
  id_type int(11) NOT NULL AUTO_INCREMENT,
  type varchar(20) NOT NULL,
  PRIMARY KEY (id_type)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table bouteille_type
--

INSERT INTO bouteille_type VALUES 
    (1, 'Vin rouge'),
    (2, 'Vin blanc');

-- --------------------------------------------------------

--
-- Structure de la table pays
--

CREATE TABLE pays (
  id_pays int(11) NOT NULL AUTO_INCREMENT,
  pays varchar(40) NOT NULL,
  PRIMARY KEY (id_pays)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table pays
--

INSERT INTO pays (pays) VALUES 
    ('Afghanistan'),
    ('Afrique du Sud'),
    ('Albanie'),
    ('Algérie'),
    ('Allemagne'),
    ('Andorre'),
    ('Angola'),
    ('Antigua-et-Barbuda'),
    ('Arabie saoudite'),
    ('Argentine'),
    ('Arménie'),
    ('Australie'),
    ('Autriche'),
    ('Azerbaïdjan'),
    ('Bahamas'),
    ('Bahreïn'),
    ('Bangladesh'),
    ('Barbade'),
    ('Belgique'),
    ('Belize'),
    ('Bénin'),
    ('Bhoutan'),
    ('Biélorussie'),
    ('Birmanie'),
    ('Bolivie'),
    ('Bosnie-Herzégovine'),
    ('Botswana'),
    ('Brésil'),
    ('Brunei'),
    ('Bulgarie'),
    ('Burkina Faso'),
    ('Burundi'),
    ('Cambodge'),
    ('Cameroun'),
    ('Canada'),
    ('Cap-Vert'),
    ('République centrafricaine'),
    ('Chili'),
    ('Chine'),
    ('Chypre'),
    ('Colombie'),
    ('Comores'),
    ('République du Congo'),
    ('République démocratique du Congo'),
    ('îles Cook'),
    ('Corée du Nord'),
    ('Corée du Sud'),
    ('Costa Rica'),
    ('Côte d\'Ivoire'),
    ('Croatie'),
    ('Cuba'),
    ('Danemark'),
    ('Djibouti'),
    ('République dominicaine'),
    ('Dominique'),
    ('Égypte'),
    ('Émirats arabes unis'),
    ('Équateur'),
    ('Érythrée'),
    ('Espagne'),
    ('Estonie'),
    ('États-Unis'),
    ('Éthiopie'),
    ('Fidji'),
    ('Finlande'),
    ('France'),
    ('Gabon'),
    ('Gambie'),
    ('Géorgie'),
    ('Ghana'),
    ('Grèce'),
    ('Grenade'),
    ('Guatemala'),
    ('Guinée'),
    ('Guinée-Bissau'),
    ('Guinée équatoriale'),
    ('Guyana'),
    ('Haïti'),
    ('Honduras'),
    ('Hongrie'),
    ('Inde'),
    ('Indonésie'),
    ('Irak'),
    ('Iran'),
    ('Irlande'),
    ('Islande'),
    ('Israël'),
    ('Italie'),
    ('Jamaïque'),
    ('Japon'),
    ('Jordanie'),
    ('Kazakhstan'),
    ('Kenya'),
    ('Kirghizistan'),
    ('Kiribati'),
    ('Koweït'),
    ('Laos'),
    ('Lesotho'),
    ('Lettonie'),
    ('Liban'),
    ('Liberia'),
    ('Libye'),
    ('Liechtenstein'),
    ('Lituanie'),
    ('Luxembourg'),
    ('Macédoine du Nord'),
    ('Madagascar'),
    ('Malaisie'),
    ('Malawi'),
    ('Maldives'),
    ('Mali'),
    ('Malte'),
    ('Maroc'),
    ('îles Marshall'),
    ('Maurice'),
    ('Mauritanie'),
    ('Mexique'),
    ('Micronésie'),
    ('Moldavie'),
    ('Monaco'),
    ('Mongolie'),
    ('Monténégro'),
    ('Mozambique'),
    ('Namibie'),
    ('Nauru'),
    ('Népal'),
    ('Nicaragua'),
    ('Niger'),
    ('Nigeria'),
    ('Niue'),
    ('Norvège'),
    ('Nouvelle-Zélande'),
    ('Oman'),
    ('Ouganda'),
    ('Ouzbékistan'),
    ('Pakistan'),
    ('Palaos'),
    ('Palestine'),
    ('Panamá'),
    ('Papouasie-Nouvelle-Guinée'),
    ('Paraguay'),
    ('Pays-Bas'),
    ('Pérou'),
    ('Philippines'),
    ('Pologne'),
    ('Portugal'),
    ('Qatar'),
    ('Roumanie'),
    ('Royaume-Uni'),
    ('Russie'),
    ('Rwanda'),
    ('Saint-Christophe-et-Niévès'),
    ('Saint-Marin'),
    ('Saint-Vincent-et-les Grenadines'),
    ('Sainte-Lucie'),
    ('îles Salomon'),
    ('Salvador'),
    ('Samoa'),
    ('São Tomé-et-Principe'),
    ('Sénégal'),
    ('Serbie'),
    ('Seychelles'),
    ('Sierra Leone'),
    ('Singapour'),
    ('Slovaquie'),
    ('Slovénie'),
    ('Somalie'),
    ('Soudan'),
    ('Soudan du Sud'),
    ('Sri Lanka'),
    ('Suède'),
    ('Suisse'),
    ('Suriname'),
    ('Swaziland'),
    ('Syrie'),
    ('Tadjikistan'),
    ('Tanzanie'),
    ('Tchad'),
    ('République tchèque'),
    ('Thaïlande'),
    ('Timor oriental'),
    ('Togo'),
    ('Tonga'),
    ('Trinité-et-Tobago'),
    ('Tunisie'),
    ('Turkménistan'),
    ('Turquie'),
    ('Tuvalu'),
    ('Ukraine'),
    ('Uruguay'),
    ('Vanuatu'),
    ('Vatican'),
    ('Venezuela'),
    ('Viêt Nam'),
    ('Yémen'),
    ('Zambie'),
    ('Zimbabwe');
    
-- --------------------------------------------------------

--
-- Structure de la table bouteille
--

CREATE TABLE bouteille (
  id_bouteille int(11) NOT NULL AUTO_INCREMENT,
  nom varchar(200) NOT NULL,
  image varchar(200) DEFAULT 'image/default.jpg',/*à changer par le vrai lien de l'image par défault*/
  code_saq int(8) DEFAULT NULL,
  id_pays int(11) NOT NULL,
  prix decimal(8,2) NOT NULL,
  url_saq varchar(200) DEFAULT NULL,
  format int(5) NOT NULL,
  id_type int(11) NOT NULL,
  millesime int(4) DEFAULT NULL,
  non_liste tinyint(1) DEFAULT '0',
  PRIMARY KEY (id_bouteille),
  FOREIGN KEY(id_type) REFERENCES bouteille_type (id_type),
  FOREIGN KEY(id_pays) REFERENCES pays (id_pays)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Contenu de la table bouteille
--

INSERT INTO bouteille VALUES
    (1, 'Borsao Seleccion', '//s7d9.scene7.com/is/image/SAQ/10324623_is?$saq-rech-prod-gril$', 10324623, 60, 11, 'https://www.saq.com/page/fr/saqcom/vin-rouge/borsao-seleccion/10324623', 750, 1, 2000, 0),
    (2, 'Monasterio de Las Vinas Gran Reserva', '//s7d9.scene7.com/is/image/SAQ/10359156_is?$saq-rech-prod-gril$', 10359156, 60, 19, 'https://www.saq.com/page/fr/saqcom/vin-rouge/monasterio-de-las-vinas-gran-reserva/10359156', 750, 1, 2000, 0),
    (3, 'Castano Hecula', '//s7d9.scene7.com/is/image/SAQ/11676671_is?$saq-rech-prod-gril$', 11676671, 60, 12, 'https://www.saq.com/page/fr/saqcom/vin-rouge/castano-hecula/11676671', 750, 1, 2010, 0),
    (4, 'Campo Viejo Tempranillo Rioja', '//s7d9.scene7.com/is/image/SAQ/11462446_is?$saq-rech-prod-gril$', 11462446, 60, 14, 'https://www.saq.com/page/fr/saqcom/vin-rouge/campo-viejo-tempranillo-rioja/11462446', 750, 1, 2016, 0),
    (5, 'Bodegas Atalaya Laya 2017', '//s7d9.scene7.com/is/image/SAQ/12375942_is?$saq-rech-prod-gril$', 12375942, 60, 17, 'https://www.saq.com/page/fr/saqcom/vin-rouge/bodegas-atalaya-laya-2017/12375942', 750, 1, 2013, 0),
    (6, 'Vin Vault Pinot Grigio', '//s7d9.scene7.com/is/image/SAQ/13467048_is?$saq-rech-prod-gril$', 13467048, 62, 00, 'https://www.saq.com/page/fr/saqcom/vin-blanc/vin-vault-pinot-grigio/13467048', 3000, 2, 2013, 0),
    (7, 'Huber Riesling Engelsberg 2017', '//s7d9.scene7.com/is/image/SAQ/13675841_is?$saq-rech-prod-gril$', 13675841, 13, 22, 'https://www.saq.com/page/fr/saqcom/vin-blanc/huber-riesling-engelsberg-2017/13675841', 750, 2, 2013, 0),
    (8, 'Dominio de Tares Estay Castilla y Léon 2015', '//s7d9.scene7.com/is/image/SAQ/13802571_is?$saq-rech-prod-gril$', 13802571, 60, 18, 'https://www.saq.com/page/fr/saqcom/vin-rouge/dominio-de-tares-estay-castilla-y-leon-2015/13802571', 750, 1, 2005, 0),
    (9, 'Tessellae Old Vines Côtes du Roussillon 2016', '//s7d9.scene7.com/is/image/SAQ/12216562_is?$saq-rech-prod-gril$', 12216562, 66, 21, 'https://www.saq.com/page/fr/saqcom/vin-rouge/tessellae-old-vines-cotes-du-roussillon-2016/12216562', 750, 1, 2004, 0),
    (10, 'Tenuta Il Falchetto Bricco Paradiso -... 2015', '//s7d9.scene7.com/is/image/SAQ/13637422_is?$saq-rech-prod-gril$', 13637422, 88, 34, 'https://www.saq.com/page/fr/saqcom/vin-rouge/tenuta-il-falchetto-bricco-paradiso---barbera-dasti-superiore-docg-2015/13637422', 750, 1, 2011, 0);

-- --------------------------------------------------------

--
-- Structure de la table usager
--

CREATE TABLE usager(
  id_usager int(11) NOT NULL AUTO_INCREMENT,
  nom varchar(200) NOT NULL,
  prenom varchar(200) NOT NULL,
  email varchar(200) NOT NULL,
  motpasse varchar(255) NOT NULL,
  admin tinyint(1) NOT NULL,
  PRIMARY KEY (id_usager)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
--
-- Contenu de la table usager
--

--
-- password Jean: Admin123
-- password John: Usager123
--

INSERT INTO usager VALUES
    (1, 'Jean', 'Admin', 'adminvino1@gmail.com', '$2y$10$pd29mcjMNHZrgjXfn95nIuKRIoJTomEj91gnqs34ab.IOCKYpSbv2', 1), 
    (2, 'John', 'Usager', 'usagervino2@gmail.com', '$2y$10$fClA9uJwFty.BZGwKL3qOOGw47BihMTWcnYDKP1qZayD37RO32tGa', 0); 

-- --------------------------------------------------------

--
-- Structure de la table cellier
--

CREATE TABLE cellier (
  id_cellier int(11) NOT NULL AUTO_INCREMENT,
  id_usager int(11) NOT NULL,
  nom varchar(200) NOT NULL,
  PRIMARY KEY (id_cellier),
  FOREIGN KEY(id_usager) REFERENCES usager (id_usager)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
--
-- Contenu de la table cellier
--

INSERT INTO cellier VALUES(1, 2, 'cellier maison');

-- --------------------------------------------------------

--
-- Structure de la table cellier_contenu
--

CREATE TABLE cellier_contenu (
  id int(11) NOT NULL AUTO_INCREMENT,
  id_cellier int(11) NOT NULL,
  id_bouteille int(11) NOT NULL,
  date_achat date NOT NULL,
  garde_jusqua date DEFAULT NULL,
  quantite int(4) DEFAULT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (id_cellier) REFERENCES cellier (id_cellier),
  FOREIGN KEY (id_bouteille) REFERENCES bouteille (id_bouteille)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Contenu de la table cellier_contenu
--

INSERT INTO cellier_contenu VALUES
    (1, 1, 10, '2019-01-12', '2020-01-01', 3),
    (2, 1, 10, '2019-01-15', '2020-01-01', 1),
    (3, 1, 5, '2019-01-16', '2020-01-01', 10),
    (4, 1, 5, '2019-01-22', '2020-01-01', 2),
    (5, 1, 5, '2019-01-28', '2020-01-01', 1),
    (6, 1, 4, '2019-02-02', '2020-02-01', 3),
    (7, 1, 6, '2019-02-07', '2020-02-01', 4),
    (8, 1, 5, '2019-02-16', '2020-02-01', 2),
    (9, 1, 3, '2019-02-26', '2020-02-01', 1);

-- --------------------------------------------------------

--
-- Structure de la table usager_listeachat
--

CREATE TABLE usager_listeachat (
  id_usager int(11) NOT NULL,
  id_bouteille int(11) NOT NULL,
  date_ajout date NOT NULL,
  PRIMARY KEY (id_usager, id_bouteille),
  FOREIGN KEY(id_usager) REFERENCES usager (id_usager),
  FOREIGN KEY (id_bouteille) REFERENCES bouteille (id_bouteille)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
--
-- Contenu de la table usager_listeachat
--

INSERT INTO usager_listeachat VALUES
    (2, 2, '2019-03-02'),
    (2, 4, '2019-03-05');

-- --------------------------------------------------------

--
-- Structure de la table usager_historique
--

CREATE TABLE usager_historique (
  id_historique int(11) NOT NULL AUTO_INCREMENT,
  id_usager int(11) NOT NULL,
  id_bouteille int(11) NOT NULL,
  nom_action varchar(50) NOT NULL,
  date_action date NOT NULL,
  PRIMARY KEY (id_historique),
  FOREIGN KEY(id_usager) REFERENCES usager (id_usager),
  FOREIGN KEY (id_bouteille) REFERENCES bouteille (id_bouteille)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
--
-- Contenu de la table usager_historique
--

INSERT INTO usager_historique VALUES
    (1, 2, 3, 'ajouté', '2019-03-08'),
    (2, 2, 4, 'bu', '2019-03-09');

-- --------------------------------------------------------

--
-- Structure de la table usager_note
--

CREATE TABLE usager_note (
  id_usager int(11) NOT NULL,
  id_bouteille int(11) NOT NULL,
  note text NOT NULL,
  date_ecrit date NOT NULL,
  PRIMARY KEY (id_usager, id_bouteille),
  FOREIGN KEY(id_usager) REFERENCES usager (id_usager),
  FOREIGN KEY (id_bouteille) REFERENCES bouteille (id_bouteille)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
--
-- Contenu de la table usager_note
--

INSERT INTO usager_note VALUES
    (2, 3, 'ce vin est très bon', '2019-03-08'),
    (2, 4, 'ce vin n\'est pas bon', '2019-03-09');

-- --------------------------------------------------------