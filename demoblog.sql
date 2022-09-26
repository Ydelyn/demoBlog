-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : lun. 05 sep. 2022 à 08:07
-- Version du serveur : 5.7.33
-- Version de PHP : 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `demoblog`
--
CREATE DATABASE IF NOT EXISTS `demoblog` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `demoblog`;

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `title`, `content`, `image`, `created_at`) VALUES
(1, 'Titre de l\'article n°1', '<p>Voici mon premier article</p>', 'https://picsum.photos/seed/picsum/200/300', '2022-09-03 10:13:22'),
(2, 'Titre de l\'article n°2', '<p>Contenu de l\'article n°2</p>', 'https://picsum.photos/seed/picsum/200/300', '2022-09-03 10:13:22'),
(3, 'Titre de l\'article n°3', '<p>Contenu de l\'article n°3</p>', 'https://picsum.photos/seed/picsum/200/300', '2022-09-03 10:13:22'),
(4, 'Titre de l\'article n°4', '<p>Contenu de l\'article n°4</p>', 'https://picsum.photos/seed/picsum/200/300', '2022-09-03 10:13:22'),
(5, 'Titre de l\'article n°5', '<p>Contenu de l\'article n°5</p>', 'https://picsum.photos/seed/picsum/200/300', '2022-09-03 10:13:22'),
(6, 'Titre de l\'article n°6', '<p>Contenu de l\'article n°6</p>', 'https://picsum.photos/seed/picsum/200/300', '2022-09-03 10:13:22'),
(7, 'Titre de l\'article n°7', '<p>Contenu de l\'article n°7</p>', 'https://picsum.photos/seed/picsum/200/300', '2022-09-03 10:13:22'),
(8, 'Titre de l\'article n°8', '<p>Contenu de l\'article n°8</p>', 'https://picsum.photos/seed/picsum/200/300', '2022-09-03 10:13:22'),
(9, 'Titre de l\'article n°9', '<p>Contenu de l\'article n°9</p>', 'https://picsum.photos/seed/picsum/200/300', '2022-09-03 10:13:22'),
(10, 'Titre de l\'article n°10', '<p>Contenu de l\'article n°10</p>', 'https://picsum.photos/seed/picsum/200/300', '2022-09-03 10:13:22');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220903100720', '2022-09-03 10:07:52', 98);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
