-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : ven. 23 juin 2023 à 21:08
-- Version du serveur : 5.7.39
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `thebigproject`
--
CREATE DATABASE IF NOT EXISTS `thebigproject` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `thebigproject`;

-- --------------------------------------------------------

--
-- Structure de la table `matchs`
--

CREATE TABLE `matchs` (
  `id` int(11) NOT NULL,
  `tournament_id` int(11) NOT NULL,
  `score1_player1` int(11) DEFAULT NULL,
  `score1_player2` int(11) DEFAULT NULL,
  `score2_player1` int(11) DEFAULT NULL,
  `score2_player2` int(11) DEFAULT NULL,
  `player1` int(11) NOT NULL,
  `player2` int(11) DEFAULT NULL,
  `step` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `matchs`
--

INSERT INTO `matchs` (`id`, `tournament_id`, `score1_player1`, `score1_player2`, `score2_player1`, `score2_player2`, `player1`, `player2`, `step`) VALUES
(1, 1, 1, 2, 1, 2, 1, 2, 0);

-- --------------------------------------------------------

--
-- Structure de la table `tournaments`
--

CREATE TABLE `tournaments` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `game` varchar(255) NOT NULL,
  `nbParticipants` int(11) NOT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `tournaments`
--

INSERT INTO `tournaments` (`id`, `title`, `game`, `nbParticipants`, `date_start`, `date_end`) VALUES
(1, 'Tournoi 1vs1 Juin', 'Rocket League', 16, '2023-06-01 00:00:00', '2023-06-30 23:59:00'),
(2, 'Tournoi 1vs1 Juillet', 'Rocket League', 16, '2023-07-01 00:00:00', '2023-07-31 23:59:00'),
(3, 'Tournoi 1vs1 Aout', 'Rocket League', 16, '2023-08-01 00:00:00', '2023-08-31 23:59:00'),
(4, 'Tournoi 1vs1 Septembre', 'Rocket League', 16, '2023-09-01 00:00:00', '2023-09-30 23:59:00'),
(5, 'Tournoi 1vs1 Octobre', 'Rocket League', 16, '2023-10-01 00:00:00', '2023-10-31 23:59:00'),
(6, 'Tournoi 1vs1 Novembre', 'Rocket League', 16, '2023-11-01 00:00:00', '2023-11-30 23:59:00');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(128) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `token` varchar(128) NOT NULL DEFAULT '',
  `active` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `email`, `password`, `salt`, `token`, `active`) VALUES
(1, 'Theo', 'theo.menchon@hotmail.fr', '$2y$10$9SEWX7dICYqvOXE4DNPCOufzCOdvZuyjXI86UJU1koneSfOMEOg1K', '9015d7022ebe8d9606b05cd28de0727a', 'f6d287ce7e8c8b27b228f313a2f8c19d86039c6d5273b20904567ea1a9e353f4', 1),
(2, 'Jean', 'jean@outlook.fr', '$2y$10$01vRrEQUuun0PSZWZqKPS.auiyGp3V0hKSq1K9k9Ll4y6I2NDFBHy', '5d56c4e6dbf7f2e3ebeb9d70ec469788', '99c870c0d911fbb6cf7846101e924ae86d610a5b9c427179d1e61f5330597da8', 1);

-- --------------------------------------------------------

--
-- Structure de la table `users_tournaments`
--

CREATE TABLE `users_tournaments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tournament_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users_tournaments`
--

INSERT INTO `users_tournaments` (`id`, `user_id`, `tournament_id`) VALUES
(1, 1, 1),
(8, 2, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `matchs`
--
ALTER TABLE `matchs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tournament` (`tournament_id`),
  ADD KEY `player1` (`player1`) USING BTREE,
  ADD KEY `player2` (`player2`) USING BTREE;

--
-- Index pour la table `tournaments`
--
ALTER TABLE `tournaments`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `users_tournaments`
--
ALTER TABLE `users_tournaments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id_2` (`user_id`,`tournament_id`),
  ADD KEY `tournament_id` (`tournament_id`) USING BTREE,
  ADD KEY `user_id` (`user_id`) USING BTREE;

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `matchs`
--
ALTER TABLE `matchs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `tournaments`
--
ALTER TABLE `tournaments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `users_tournaments`
--
ALTER TABLE `users_tournaments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `matchs`
--
ALTER TABLE `matchs`
  ADD CONSTRAINT `id_tournament` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `users_tournaments`
--
ALTER TABLE `users_tournaments`
  ADD CONSTRAINT `tournaments_id` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`),
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
