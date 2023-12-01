-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 01 déc. 2023 à 17:28
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `loufok`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

CREATE TABLE `administrateur` (
  `id` int(11) NOT NULL,
  `ad_mail_administrateur` varchar(50) NOT NULL,
  `mot_de_passe_administrateur` varchar(50) NOT NULL,
  `token` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `administrateur`
--

INSERT INTO `administrateur` (`id`, `ad_mail_administrateur`, `mot_de_passe_administrateur`, `token`) VALUES
(1, 'admin@loufok.com', 'AvSp#OtSg69', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `contribution`
--

CREATE TABLE `contribution` (
  `id` int(11) NOT NULL,
  `texte` varchar(280) NOT NULL,
  `date_soumission` date NOT NULL,
  `ordre_soumission` int(11) NOT NULL,
  `id_joueur` int(11) DEFAULT NULL,
  `id_loufokerie` int(11) NOT NULL,
  `id_administrateur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déclencheurs `contribution`
--
DELIMITER $$
CREATE TRIGGER `contribution_in_period` BEFORE INSERT ON `contribution` FOR EACH ROW BEGIN
    DECLARE loufokerie_start_date DATE;
    DECLARE loufokerie_end_date DATE;

    -- Get the start and end dates of the associated loufokerie
    SELECT date_debut_loufokerie, date_fin_loufokerie
    INTO loufokerie_start_date, loufokerie_end_date
    FROM `loufokerie`
    WHERE id = NEW.id_loufokerie;

    -- Check if the contribution date is within the valid period
    IF NEW.date_soumission < loufokerie_start_date OR NEW.date_soumission > loufokerie_end_date THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Error: Contribution date must be within the loufokerie period';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `contribution_lenght` BEFORE INSERT ON `contribution` FOR EACH ROW BEGIN
    IF LENGTH(NEW.texte) < 50 OR LENGTH(NEW.texte) > 280 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Error: Contribution texte must have a character length between 50 and 280';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `contribution_nb_max` BEFORE INSERT ON `contribution` FOR EACH ROW BEGIN
    DECLARE total_length INT;

    -- Calculate the total length of contributions for the loufokerie
    SELECT COUNT(*) INTO total_length
    FROM `contribution`
    WHERE id_loufokerie = NEW.id_loufokerie;

    -- Check if adding the new contribution exceeds the limit
    IF total_length >= (
        SELECT nb_contributions
        FROM `loufokerie`
        WHERE id = NEW.id_loufokerie
    ) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Error: Total length of contributions exceeds the limit for the loufokerie';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `joueur`
--

CREATE TABLE `joueur` (
  `id` int(11) NOT NULL,
  `nom_plume` varchar(50) NOT NULL,
  `ad_mail_joueur` varchar(50) NOT NULL,
  `sexe` varchar(50) DEFAULT NULL,
  `ddn` date DEFAULT NULL,
  `mot_de_passe_joueur` varchar(50) NOT NULL,
  `token` varchar(50) DEFAULT NULL,
  `reservation` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `joueur`
--

INSERT INTO `joueur` (`id`, `nom_plume`, `ad_mail_joueur`, `sexe`, `ddn`, `mot_de_passe_joueur`, `token`, `reservation`) VALUES
(1, 'Corbeau', 'corbeau@loufok.com', 'M', '2003-11-11', 'AvSp#OtSg69', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `loufokerie`
--

CREATE TABLE `loufokerie` (
  `id` int(11) NOT NULL,
  `titre_loufokerie` varchar(50) NOT NULL,
  `date_debut_loufokerie` date NOT NULL,
  `date_fin_loufokerie` date NOT NULL,
  `nb_contributions` int(11) NOT NULL,
  `nb_jaime` int(11) DEFAULT NULL,
  `id_administrateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déclencheurs `loufokerie`
--
DELIMITER $$
CREATE TRIGGER `loufokerie_dates_order` BEFORE INSERT ON `loufokerie` FOR EACH ROW BEGIN
    IF NEW.date_debut_loufokerie > NEW.date_fin_loufokerie THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Error: date_debut_loufokerie must be less than date_fin_loufokerie';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `loufokerie_nb_contrib` BEFORE INSERT ON `loufokerie` FOR EACH ROW BEGIN
    IF NEW.nb_contributions < 1 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Error: nb_contributions must be superior to 1';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `loufokerie_period` BEFORE INSERT ON `loufokerie` FOR EACH ROW BEGIN
    DECLARE overlap_count INT;

    -- Check if there is any overlapping loufokerie
    SELECT COUNT(*)
    INTO overlap_count
    FROM `loufokerie`
    WHERE NEW.date_debut_loufokerie <= date_fin_loufokerie
      AND NEW.date_fin_loufokerie >= date_debut_loufokerie
      AND id != NEW.id; -- Exclude the current loufokerie if updating
    
    -- Check if date_debut_loufokerie is not earlier than today's date
    IF NEW.date_debut_loufokerie < CURDATE() THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Error: date_debut_loufokerie cannot be earlier than today';
    END IF;

    -- If there is an overlap, raise an error
    IF overlap_count > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Error: Overlapping date range with an existing loufokerie';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `random`
--

CREATE TABLE `random` (
  `id_joueur` int(11) NOT NULL,
  `id_loufokerie` int(11) NOT NULL,
  `id_contribution` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ad_mail_administrateur` (`ad_mail_administrateur`);

--
-- Index pour la table `contribution`
--
ALTER TABLE `contribution`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_joueur_per_loufokerie` (`id_joueur`,`id_loufokerie`),
  ADD KEY `contribution_id_loufokerie` (`id_loufokerie`),
  ADD KEY `contribution_id_administrateur` (`id_administrateur`);

--
-- Index pour la table `joueur`
--
ALTER TABLE `joueur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom_plume` (`nom_plume`),
  ADD UNIQUE KEY `ad_mail_joueur` (`ad_mail_joueur`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Index pour la table `loufokerie`
--
ALTER TABLE `loufokerie`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `titre_loufokerie` (`titre_loufokerie`),
  ADD UNIQUE KEY `date_debut_loufokerie` (`date_debut_loufokerie`),
  ADD UNIQUE KEY `date_fin_loufokerie` (`date_fin_loufokerie`),
  ADD KEY `loufokerie_id_administrateur` (`id_administrateur`);

--
-- Index pour la table `random`
--
ALTER TABLE `random`
  ADD KEY `id_joueur` (`id_joueur`),
  ADD KEY `random_id_loufokerie` (`id_loufokerie`),
  ADD KEY `random_id_contribution` (`id_contribution`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `administrateur`
--
ALTER TABLE `administrateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `contribution`
--
ALTER TABLE `contribution`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `joueur`
--
ALTER TABLE `joueur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `loufokerie`
--
ALTER TABLE `loufokerie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `contribution`
--
ALTER TABLE `contribution`
  ADD CONSTRAINT `contribution_id_administrateur` FOREIGN KEY (`id_administrateur`) REFERENCES `administrateur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contribution_id_joueur` FOREIGN KEY (`id_joueur`) REFERENCES `joueur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contribution_id_loufokerie` FOREIGN KEY (`id_loufokerie`) REFERENCES `loufokerie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `loufokerie`
--
ALTER TABLE `loufokerie`
  ADD CONSTRAINT `loufokerie_id_administrateur` FOREIGN KEY (`id_administrateur`) REFERENCES `administrateur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `random`
--
ALTER TABLE `random`
  ADD CONSTRAINT `random_id_contribution` FOREIGN KEY (`id_contribution`) REFERENCES `contribution` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `random_id_joueur` FOREIGN KEY (`id_joueur`) REFERENCES `joueur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `random_id_loufokerie` FOREIGN KEY (`id_loufokerie`) REFERENCES `loufokerie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
