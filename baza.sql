
CREATE TABLE `%PREFIKS%admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_nastavnik` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;

CREATE TABLE `%PREFIKS%datumi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_godina` int(11) NOT NULL,
  `dan` date NOT NULL,
  `aktivan` tinyint(1) NOT NULL,
  `redbr` int(11) NOT NULL,
  `tjedan` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;

CREATE TABLE `%PREFIKS%godine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `aktivan` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;

CREATE TABLE `%PREFIKS%login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ime` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `ip` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `uspjesno` int(11) NOT NULL,
  `vrijeme` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;

CREATE TABLE `%PREFIKS%nastavnici` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ime` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `pravo_ime` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `lozinka` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `email` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;

CREATE TABLE `%PREFIKS%obrisano` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_dan` int(11) NOT NULL,
  `id_predmet` int(11) NOT NULL,
  `id_nastavnik` int(11) NOT NULL,
  `razred` int(11) NOT NULL,
  `odjel` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `tip` char(1) COLLATE latin1_general_ci NOT NULL,
  `obrisan` int(11) NOT NULL,
  `potvrda` int(11) NOT NULL,
  `timestanp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;

CREATE TABLE `%PREFIKS%praznici` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dan` varchar(10) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;


INSERT INTO `%PREFIKS%praznici` (`id`, `dan`) VALUES
(1, '01.01'),
(2, '06.01'),
(3, '01.05'),
(4, '22.06'),
(5, '25.06'),
(6, '05.08'),
(7, '15.08'),
(8, '08.10'),
(9, '01.11'),
(10, '25.12'),
(11, '26.12');

CREATE TABLE `%PREFIKS%predmeti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `poredak` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;

CREATE TABLE `%PREFIKS%radi_u` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_nastavnik` int(11) NOT NULL,
  `razred` int(11) NOT NULL,
  `odjel` char(1) COLLATE latin1_general_ci NOT NULL,
  `id_predmet` int(11) NOT NULL,
  `id_godina` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;

CREATE TABLE `%PREFIKS%razredi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `razred` int(11) NOT NULL,
  `odjel` char(1) COLLATE latin1_general_ci NOT NULL,
  `id_razrednik` int(11) NOT NULL,
  `predmeti` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `napomena` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;

CREATE TABLE `%PREFIKS%vremenik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_dan` int(11) NOT NULL,
  `id_predmet` int(11) NOT NULL,
  `id_nastavnik` int(11) NOT NULL,
  `razred` int(11) NOT NULL,
  `odjel` char(1) COLLATE latin1_general_ci NOT NULL,
  `tip` int(11) NOT NULL,
  `obrisan` int(11) NOT NULL DEFAULT '0',
  `potvrda` int(11) NOT NULL DEFAULT '0',
  `zapravo_obrisan` int(11) NOT NULL DEFAULT '0',
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;
