-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 19 avr. 2024 à 16:18
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `pfa`
--

-- --------------------------------------------------------

--
-- Structure de la table `bulletinpaie`
--

CREATE TABLE `bulletinpaie` (
  `idBulletin` int(11) NOT NULL,
  `idEmploye` int(11) NOT NULL,
  `date` date NOT NULL,
  `nbJoursTravailles` int(11) DEFAULT NULL,
  `tauxHoraire` double DEFAULT NULL,
  `SalaireBrut` double DEFAULT NULL,
  `cotisationCNSS` double DEFAULT NULL,
  `cotisationAMO` double DEFAULT NULL,
  `prevelementIGR` double DEFAULT NULL,
  `congesPayes` int(11) DEFAULT NULL,
  `congesSansSoldeMontant` int(11) DEFAULT NULL,
  `netAPayer` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `bulletinpaie`
--

INSERT INTO `bulletinpaie` (`idBulletin`, `idEmploye`, `date`, `nbJoursTravailles`, `tauxHoraire`, `SalaireBrut`, `cotisationCNSS`, `cotisationAMO`, `prevelementIGR`, `congesPayes`, `congesSansSoldeMontant`, `netAPayer`) VALUES
(1, 20, '2024-04-18', 253, 59.29, 15000, 100, 100, 450, 10, 1779, 12393.48),
(2, 20, '2024-04-18', 253, 59.29, 15000, 1, 1, 1, 1, 593, 14344.83),
(3, 21, '2024-04-18', 253, 27.67, 7000, 100, 200, 300, 10, 1107, 5182.61),
(4, 21, '2024-04-18', 253, 27.67, 7000, 1, 1, 1, 1, 277, 6692.65),
(5, 21, '2024-04-18', 253, 33.6, 8500, 100, 100, 500, 0, 0, 7800),
(6, 20, '2024-04-18', 253, 59.29, 15000, 100, 100, 500, 0, 0, 14300),
(7, 20, '2024-04-19', 253, 59.29, 15000, 1, 1, 1, 1, 593, 14344.83),
(8, 20, '2024-04-19', 253, 39.53, 10000, 100, 100, 500, 10, 1186, 7995.65),
(9, 20, '2024-04-19', 253, 39.53, 10000, 300, 200, 400, 10, 1186, 7795.65);

-- --------------------------------------------------------

--
-- Structure de la table `conge`
--

CREATE TABLE `conge` (
  `Id` int(11) NOT NULL,
  `TypeConge` varchar(255) DEFAULT NULL,
  `DateDebut` date DEFAULT NULL,
  `DateFin` date DEFAULT NULL,
  `Statut` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `conge`
--

INSERT INTO `conge` (`Id`, `TypeConge`, `DateDebut`, `DateFin`, `Statut`) VALUES
(9, 'Annuel', '2024-04-01', '2024-04-20', 'En cours'),
(10, 'Test', '2024-04-18', '2024-04-26', 'En cours'),
(11, 'hhh', '2024-04-01', '2024-04-08', 'Terminé');

-- --------------------------------------------------------

--
-- Structure de la table `contrat`
--

CREATE TABLE `contrat` (
  `Id` int(11) NOT NULL,
  `TypeContrat` varchar(50) DEFAULT NULL,
  `DateDebut` date DEFAULT NULL,
  `DateFin` date DEFAULT NULL,
  `SalaireBrut` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `contrat`
--

INSERT INTO `contrat` (`Id`, `TypeContrat`, `DateDebut`, `DateFin`, `SalaireBrut`) VALUES
(25, 'Test', '2024-04-19', '2024-06-08', 5000),
(26, NULL, NULL, NULL, NULL),
(27, 'Test', '1212-12-12', '1111-11-11', 1111111111),
(28, 'ZZ', '1111-11-11', '4444-04-04', 444444),
(29, NULL, NULL, NULL, NULL),
(30, NULL, NULL, NULL, NULL),
(31, NULL, NULL, NULL, NULL),
(32, NULL, NULL, NULL, NULL),
(33, NULL, NULL, NULL, NULL),
(34, 'TT', '0000-00-00', '2222-02-22', 222222),
(35, 'CDD ', '2024-04-26', '2024-05-31', 15000),
(36, 'CDD 2', '1111-11-11', '2222-02-22', 22222),
(37, 'CDD ', '1111-11-11', '2222-02-22', 10000);

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

CREATE TABLE `employe` (
  `Id` int(11) NOT NULL,
  `Matricule` varchar(50) NOT NULL,
  `CodeCNSS` varchar(50) NOT NULL,
  `Nom` varchar(255) NOT NULL,
  `Prenom` varchar(255) NOT NULL,
  `DateNaissance` date DEFAULT NULL,
  `Telephone` varchar(20) DEFAULT NULL,
  `Adresse` varchar(255) DEFAULT NULL,
  `SituationFamiliale` varchar(50) DEFAULT NULL,
  `PhotoIdentite` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `employe`
--

INSERT INTO `employe` (`Id`, `Matricule`, `CodeCNSS`, `Nom`, `Prenom`, `DateNaissance`, `Telephone`, `Adresse`, `SituationFamiliale`, `PhotoIdentite`) VALUES
(20, 'EMP001', 'CNSS66', 'Jesus', 'Christ', '2000-12-24', '123456789', '1234', 'Célibataire', './img/PI/662242e306d07_jesus.png'),
(21, 'EMP004', '111B', 'Fathi', 'Ahmed', '2024-04-04', '11111', '111', 'Célibataire', './img/PI/66217f752ef52_avatar2.png');

-- --------------------------------------------------------

--
-- Structure de la table `employeconge`
--

CREATE TABLE `employeconge` (
  `IdEmploye` int(11) DEFAULT NULL,
  `IdConge` int(11) DEFAULT NULL,
  `DateDebut` date DEFAULT NULL,
  `DateFin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `employeconge`
--

INSERT INTO `employeconge` (`IdEmploye`, `IdConge`, `DateDebut`, `DateFin`) VALUES
(20, 9, NULL, NULL),
(20, 10, NULL, NULL),
(21, 11, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `employecontrat`
--

CREATE TABLE `employecontrat` (
  `IdEmploye` int(11) DEFAULT NULL,
  `IdContrat` int(11) DEFAULT NULL,
  `DateDebut` date DEFAULT NULL,
  `DateFin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `employecontrat`
--

INSERT INTO `employecontrat` (`IdEmploye`, `IdContrat`, `DateDebut`, `DateFin`) VALUES
(20, 37, '1111-11-11', '2222-02-22');

-- --------------------------------------------------------

--
-- Structure de la table `employemetier`
--

CREATE TABLE `employemetier` (
  `IdEmploye` int(11) DEFAULT NULL,
  `IdMetier` int(11) DEFAULT NULL,
  `DateDebut` date DEFAULT NULL,
  `DateFin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `metier`
--

CREATE TABLE `metier` (
  `Id` int(11) NOT NULL,
  `Libelle` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `Nom` varchar(255) NOT NULL,
  `Prenom` varchar(255) NOT NULL,
  `Mail` varchar(255) NOT NULL,
  `MotDePasse` varchar(255) NOT NULL,
  `Role` enum('admin','utilisateur') NOT NULL DEFAULT 'utilisateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`Id`, `Nom`, `Prenom`, `Mail`, `MotDePasse`, `Role`) VALUES
(1, 'Soultan', 'Arsyl', 'ams@ams', '1234', 'admin');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `bulletinpaie`
--
ALTER TABLE `bulletinpaie`
  ADD PRIMARY KEY (`idBulletin`);

--
-- Index pour la table `conge`
--
ALTER TABLE `conge`
  ADD PRIMARY KEY (`Id`);

--
-- Index pour la table `contrat`
--
ALTER TABLE `contrat`
  ADD PRIMARY KEY (`Id`);

--
-- Index pour la table `employe`
--
ALTER TABLE `employe`
  ADD PRIMARY KEY (`Id`);

--
-- Index pour la table `employeconge`
--
ALTER TABLE `employeconge`
  ADD KEY `IdEmploye` (`IdEmploye`),
  ADD KEY `IdConge` (`IdConge`);

--
-- Index pour la table `employecontrat`
--
ALTER TABLE `employecontrat`
  ADD KEY `IdEmploye` (`IdEmploye`),
  ADD KEY `IdContrat` (`IdContrat`);

--
-- Index pour la table `employemetier`
--
ALTER TABLE `employemetier`
  ADD KEY `IdEmploye` (`IdEmploye`),
  ADD KEY `IdMetier` (`IdMetier`);

--
-- Index pour la table `metier`
--
ALTER TABLE `metier`
  ADD PRIMARY KEY (`Id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Mail` (`Mail`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `bulletinpaie`
--
ALTER TABLE `bulletinpaie`
  MODIFY `idBulletin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `conge`
--
ALTER TABLE `conge`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `contrat`
--
ALTER TABLE `contrat`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `employe`
--
ALTER TABLE `employe`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `metier`
--
ALTER TABLE `metier`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `employeconge`
--
ALTER TABLE `employeconge`
  ADD CONSTRAINT `employeconge_ibfk_1` FOREIGN KEY (`IdEmploye`) REFERENCES `employe` (`Id`),
  ADD CONSTRAINT `employeconge_ibfk_2` FOREIGN KEY (`IdConge`) REFERENCES `conge` (`Id`);

--
-- Contraintes pour la table `employecontrat`
--
ALTER TABLE `employecontrat`
  ADD CONSTRAINT `employecontrat_ibfk_1` FOREIGN KEY (`IdEmploye`) REFERENCES `employe` (`Id`),
  ADD CONSTRAINT `employecontrat_ibfk_2` FOREIGN KEY (`IdContrat`) REFERENCES `contrat` (`Id`),
  ADD CONSTRAINT `fk_contrat_id` FOREIGN KEY (`IdContrat`) REFERENCES `contrat` (`Id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `employemetier`
--
ALTER TABLE `employemetier`
  ADD CONSTRAINT `employemetier_ibfk_1` FOREIGN KEY (`IdEmploye`) REFERENCES `employe` (`Id`),
  ADD CONSTRAINT `employemetier_ibfk_2` FOREIGN KEY (`IdMetier`) REFERENCES `metier` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
