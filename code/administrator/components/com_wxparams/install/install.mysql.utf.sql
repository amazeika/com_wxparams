--
-- Structure de la table `#__wxparams_configurations`
--

CREATE TABLE IF NOT EXISTS `#__wxparams_configurations` (
  `wxparams_configuration_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `package` varchar(64) NOT NULL,
  `type` varchar(128) NOT NULL,
  `item_id` bigint(20) NOT NULL,
  `params` text NOT NULL COMMENT '''@Filter("raw")''',
  `default` tinyint(1) NOT NULL,
  `locked_by` int(11) NOT NULL DEFAULT '0',
  `locked_on` datetime NOT NULL,
  UNIQUE KEY `wxparams_configuration_id` (`wxparams_configuration_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
