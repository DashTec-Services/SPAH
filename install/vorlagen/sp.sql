

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kundennummer` varchar(35) NOT NULL,
  `password` varchar(250) NOT NULL,
  `vorname` varchar(45) NOT NULL,
  `nachname` varchar(45) NOT NULL,
  `straße` varchar(55) NOT NULL,
  `hausnummer` int(4) NOT NULL,
  `ort` varchar(45) NOT NULL,
  `plz` int(5) NOT NULL,
  `telefon` varchar(45) NOT NULL,
  `handy` varchar(45) NOT NULL,
  `mail` varchar(60) NOT NULL,
  `usr_grp` enum('adm','user') NOT NULL,
  `is_aktiv` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Daten für Tabelle `accounts`
--

INSERT INTO `accounts` (`id`, `kundennummer`, `password`, `vorname`, `nachname`, `straße`, `hausnummer`, `ort`, `plz`, `telefon`, `handy`, `mail`, `usr_grp`, `is_aktiv`) VALUES
(8, 'aaa', '$2y$07$BCryptMyLosser432Must.ZGcdC6PByGTmS1lhJdx9enzFzK.JKvO', 'Super', 'Admin', '123123', 0, '', 0, '', '', '123123123', 'adm', 1),
(9, 'bbb', '$2y$07$BCryptMyLosser432Must.ZGcdC6PByGTmS1lhJdx9enzFzK.JKvO', 'David', 'Schomburg', 'Bergsiedlung', 8, 'Escheburg', 21039, '04152135015', '51053125140', 'info@dashtec.de', 'user', 1),
(12, 'ccc', '$2y$07$BCryptMyLosser432Must.ZGcdC6PByGTmS1lhJdx9enzFzK.JKvO', 'David', 'Schomburg', '', 0, '', 0, '', '', 'info@dashtec.de', 'user', 1),
(13, '4711', '$2y$07$BCryptMyLosser432Must.ZGcdC6PByGTmS1lhJdx9enzFzK.JKvO', 'Jasmo', 'Markler', 'Berg', 8, 'Escheburg', 21039, '0180', '555555', 'mail@fuckers.com', 'user', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_ip` varchar(15) NOT NULL,
  `root_user` varchar(15) NOT NULL,
  `root_password` varchar(55) NOT NULL,
  `ssh_port` int(11) NOT NULL,
  `sp_titel` varchar(150) NOT NULL,
  `doc_root` varchar(250) NOT NULL,
  `adminMail` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `config`
--

INSERT INTO `config` (`id`, `server_ip`, `root_user`, `root_password`, `ssh_port`, `sp_titel`, `doc_root`, `adminMail`) VALUES
(1, '78.47.200.102', 'root', 'sqnsQefK', 22, 'StreamersPanel V0.14', '/var/www/virtual/sappview.streamerspanel.com/htdocs', 'info@dashtec.de');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `dj_accounts`
--

CREATE TABLE IF NOT EXISTS `dj_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dj_name` varchar(150) DEFAULT NULL,
  `vorname` varchar(80) DEFAULT NULL,
  `nachname` varchar(150) DEFAULT NULL,
  `straße` varchar(150) DEFAULT NULL,
  `hausnummer` varchar(3) DEFAULT NULL,
  `ort` varchar(50) DEFAULT NULL,
  `plz` varchar(5) DEFAULT NULL,
  `telefon` varchar(75) DEFAULT NULL,
  `handy` varchar(75) DEFAULT NULL,
  `mail` varchar(75) DEFAULT NULL,
  `skype` varchar(50) DEFAULT NULL,
  `dj_of_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mp3`
--

CREATE TABLE IF NOT EXISTS `mp3` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org_file_titel` varchar(45) NOT NULL,
  `dir_titel` varchar(250) NOT NULL,
  `hash_titel` varchar(150) NOT NULL,
  `size` varchar(15) NOT NULL,
  `bitrate` varchar(3) NOT NULL,
  `playtime` varchar(5) NOT NULL,
  `year` varchar(5) DEFAULT NULL,
  `artist` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `mp3`
--

INSERT INTO `mp3` (`id`, `org_file_titel`, `dir_titel`, `hash_titel`, `size`, `bitrate`, `playtime`, `year`, `artist`) VALUES
(1, '12Hell.mp3', 'hell.mp3', '', '380,13 KB', '160', '0:19', '1988', 'Beck'),
(3, 'hell.mp3', '527f863a4de31_hell.mp3', '', '380,13 KB', '160', '0:19', '1988', 'Beck');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mp3_usr_rel`
--

CREATE TABLE IF NOT EXISTS `mp3_usr_rel` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mp3_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `mp3_usr_rel`
--

INSERT INTO `mp3_usr_rel` (`id`, `user_id`, `mp3_id`) VALUES
(0, 9, 1),
(0, 9, 2),
(0, 12, 3);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datum` date NOT NULL,
  `is_aktiv` tinyint(1) NOT NULL,
  `login_news` tinyint(1) NOT NULL,
  `headline` varchar(189) NOT NULL,
  `message` text NOT NULL,
  `type` enum('block','success','info','error') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Daten für Tabelle `news`
--

INSERT INTO `news` (`id`, `datum`, `is_aktiv`, `login_news`, `headline`, `message`, `type`) VALUES
(3, '0000-00-00', 1, 0, 'Welcome to my Life', 'Was total kacke ist!', 'block'),
(7, '0000-00-00', 1, 0, 'Na geht es jetzt', 'abba Sicha das', 'success');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `playlist`
--

CREATE TABLE IF NOT EXISTS `playlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `playlist_name` varchar(150) NOT NULL,
  `user_id` int(11) NOT NULL,
  `add_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `playlist`
--

INSERT INTO `playlist` (`id`, `playlist_name`, `user_id`, `add_date`) VALUES
(2, 'test', 9, '2013-11-04'),
(3, 'test', 12, '2013-11-10'),
(4, 'neww', 12, '2013-11-10');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `playlist_mp3_rel`
--

CREATE TABLE IF NOT EXISTS `playlist_mp3_rel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `playlist_id` int(11) NOT NULL,
  `mp3_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Daten für Tabelle `playlist_mp3_rel`
--

INSERT INTO `playlist_mp3_rel` (`id`, `playlist_id`, `mp3_id`) VALUES
(26, 2, 1),
(27, 3, 3),
(28, 4, 3);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sc_rel`
--

CREATE TABLE IF NOT EXISTS `sc_rel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accounts_id` int(11) NOT NULL,
  `sc_serv_conf_id` int(11) NOT NULL,
  `sc_serv_version_id` int(11) NOT NULL,
  `sc_serv_pid` int(11) NOT NULL,
  `stream_userName` varchar(150) NOT NULL,
  `sc_trans_id` int(11) NOT NULL,
  `sc_trans_pid` int(11) NOT NULL,
  `sc_trans_version_id` int(11) NOT NULL,
  `play_list_id` int(11) NOT NULL,
  `startcount` int(11) NOT NULL,
  UNIQUE KEY `id_2` (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `sc_rel`
--

INSERT INTO `sc_rel` (`id`, `accounts_id`, `sc_serv_conf_id`, `sc_serv_version_id`, `sc_serv_pid`, `stream_userName`, `sc_trans_id`, `sc_trans_pid`, `sc_trans_version_id`, `play_list_id`, `startcount`) VALUES
(2, 9, 3, 1, 10477, 'testskkk', 1, 32661, 3, 4, 0),
(5, 9, 6, 2, 0, 'Let''S Playod', 6, 0, 3, 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sc_serv_conf`
--

CREATE TABLE IF NOT EXISTS `sc_serv_conf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `MaxUser` varchar(3) DEFAULT NULL,
  `Password` varchar(150) DEFAULT NULL,
  `PortBase` varchar(6) DEFAULT NULL,
  `LogFile` varchar(255) DEFAULT NULL,
  `RealTime` varchar(1) DEFAULT NULL,
  `ScreenLog` varchar(1) DEFAULT NULL,
  `ShowLastSongs` varchar(6) DEFAULT NULL,
  `TchLog` varchar(3) DEFAULT NULL,
  `WebLog` varchar(3) DEFAULT NULL,
  `W3CEnable` varchar(3) DEFAULT NULL,
  `W3CLog` varchar(255) DEFAULT NULL,
  `SrcIP` varchar(255) DEFAULT NULL,
  `DestIP` varchar(20) DEFAULT NULL,
  `Yport` varchar(3) DEFAULT NULL,
  `NameLookups` varchar(1) DEFAULT NULL,
  `RelayPort` varchar(6) DEFAULT NULL,
  `RelayServer` varchar(20) DEFAULT NULL,
  `AdminPassword` varchar(150) DEFAULT NULL,
  `AutoDumpUsers` varchar(1) DEFAULT NULL,
  `AutoDumpSourceTime` varchar(3) DEFAULT NULL,
  `ContentDir` varchar(255) DEFAULT NULL,
  `IntroFile` varchar(255) DEFAULT NULL,
  `BackupFile` varchar(255) DEFAULT NULL,
  `TitleFormat` varchar(150) DEFAULT NULL,
  `URLFormat` varchar(150) DEFAULT NULL,
  `PublicServer` varchar(150) DEFAULT NULL,
  `AllowRelay` varchar(3) DEFAULT NULL,
  `AllowPublicRelay` varchar(3) DEFAULT NULL,
  `MetaInterval` varchar(15) DEFAULT NULL,
  `ListenerTimer` varchar(8) DEFAULT NULL,
  `BanFile` varchar(255) DEFAULT NULL,
  `RipFile` varchar(255) DEFAULT NULL,
  `RIPOnly` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `sc_serv_conf`
--

INSERT INTO `sc_serv_conf` (`id`, `MaxUser`, `Password`, `PortBase`, `LogFile`, `RealTime`, `ScreenLog`, `ShowLastSongs`, `TchLog`, `WebLog`, `W3CEnable`, `W3CLog`, `SrcIP`, `DestIP`, `Yport`, `NameLookups`, `RelayPort`, `RelayServer`, `AdminPassword`, `AutoDumpUsers`, `AutoDumpSourceTime`, `ContentDir`, `IntroFile`, `BackupFile`, `TitleFormat`, `URLFormat`, `PublicServer`, `AllowRelay`, `AllowPublicRelay`, `MetaInterval`, `ListenerTimer`, `BanFile`, `RipFile`, `RIPOnly`) VALUES
(3, '32', 'jaro2812', '8200', '/var/www/virtual/sappview.streamerspanel.com/htdocs/shoutcastconf/8200/sc_serv.log', '1', '1', '15', NULL, NULL, 'Yes', '/var/www/virtual/sappview.streamerspanel.com/htdocs/shoutcastconf/8200/sc_w3c.log', NULL, NULL, NULL, '0', NULL, NULL, '2812jaro', '0', '30', NULL, NULL, NULL, '', '', 'public', 'Yes', 'Yes', '32768', NULL, NULL, NULL, NULL),
(6, '8', 'passwortddave', '8880', '/var/www/virtual/sappview.streamerspanel.com/htdocs/shoutcastconf/8880/sc_serv.log', '1', '0', '0', NULL, NULL, 'Yes', '/var/www/virtual/sappview.streamerspanel.com/htdocs/shoutcastconf/8880/sc_w3c.log', NULL, NULL, NULL, '0', NULL, NULL, 'passwortddave', '0', '30', NULL, NULL, NULL, '', '', 'public', 'Yes', 'Yes', '32768', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sc_trans_conf`
--

CREATE TABLE IF NOT EXISTS `sc_trans_conf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `encoder_1` varchar(10) NOT NULL DEFAULT 'aacp',
  `bitrate_1` varchar(15) NOT NULL DEFAULT '56000',
  `samplerate_1` varchar(10) DEFAULT NULL,
  `channels_1` varchar(2) DEFAULT NULL,
  `outprotocol_1` varchar(5) NOT NULL DEFAULT '3',
  `serverip_1` varchar(20) NOT NULL DEFAULT '127.0.0.1',
  `serverport_1` varchar(10) DEFAULT NULL,
  `password_1` varchar(150) DEFAULT NULL,
  `streamurl` varchar(150) DEFAULT NULL,
  `genre` varchar(150) DEFAULT NULL,
  `public` varchar(10) DEFAULT NULL,
  `log` int(1) NOT NULL,
  `playlistfile` varchar(250) DEFAULT NULL,
  `shuffle` varchar(1) NOT NULL DEFAULT '1',
  `xfade` varchar(1) NOT NULL DEFAULT '5',
  `xfadethreshold` varchar(3) NOT NULL DEFAULT '10',
  `logfile` varchar(250) NOT NULL,
  `screenlog` varchar(1) NOT NULL,
  `applyreplaygain` varchar(4) NOT NULL,
  `calculatereplaygain` varchar(1) NOT NULL,
  `djport` varchar(7) NOT NULL,
  `djpassword` varchar(45) NOT NULL,
  `autodumpsourcetime` varchar(10) NOT NULL,
  `djcapture` varchar(3) NOT NULL,
  `streamtitle` varchar(55) DEFAULT NULL,
  `aim` varchar(35) DEFAULT NULL,
  `icq` varchar(35) DEFAULT NULL,
  `irc` varchar(35) DEFAULT NULL,
  `unlockkeyname` varchar(45) DEFAULT NULL,
  `unlockkeycode` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `sc_trans_conf`
--

INSERT INTO `sc_trans_conf` (`id`, `encoder_1`, `bitrate_1`, `samplerate_1`, `channels_1`, `outprotocol_1`, `serverip_1`, `serverport_1`, `password_1`, `streamurl`, `genre`, `public`, `log`, `playlistfile`, `shuffle`, `xfade`, `xfadethreshold`, `logfile`, `screenlog`, `applyreplaygain`, `calculatereplaygain`, `djport`, `djpassword`, `autodumpsourcetime`, `djcapture`, `streamtitle`, `aim`, `icq`, `irc`, `unlockkeyname`, `unlockkeycode`) VALUES
(1, 'mp3', '128000', '44100', '2', '1', '127.0.0.1', '8000', 'qwertz', 'http://www.radio-wasweissich.de', 'Rock, Metal', '1', 1, '/var/www/virtual/sappview.streamerspanel.com/htdocs/shoutcastconf/8000/test.lst', '1', '2', '20', '/var/www/virtual/sappview.streamerspanel.com/htdocs/shoutcastconf/8000/123.lst', '1', '0', '0', '8100', 'qwerty', '30', '0', 'Radio WasWeissIch', '', '', '', 'David Schomburg', 'AJQ4P-C1BN9-8N5XB-X7NPD'),
(6, '', '128000', '44100', '1', '1', '127.0.0.1', '8880', 'passwortddave', '', '', '1', 1, NULL, '1', '2', '20', '/var/www/virtual/sappview.streamerspanel.com/htdocs/shoutcastconf/8880/sc_trans.log', '1', '0', '0', '8890', 'djpasswdave', '30', '0', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sc_version`
--

CREATE TABLE IF NOT EXISTS `sc_version` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  `file_name` varchar(45) NOT NULL,
  `version` varchar(7) NOT NULL,
  `typ` enum('serv','trans') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `sc_version`
--

INSERT INTO `sc_version` (`id`, `name`, `file_name`, `version`, `typ`) VALUES
(1, 'Serv-1.9.8', '1.9.8_sc_serv.bin', '1.9.8', 'serv'),
(2, 'Serv-2.0', '2_sc_serv.bin', '2', 'serv'),
(3, 'Trans-x86', 'sc_trans86.bin', '2', 'trans'),
(4, 'Trans-x64', 'sc_trans64.bin', '2', 'trans');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `support`
--

CREATE TABLE IF NOT EXISTS `support` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `replyid` int(11) NOT NULL,
  `is_adm_answ` tinyint(1) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `add_time` date NOT NULL,
  `status` enum('Offen','in Bearbeitung','erledigt') NOT NULL,
  `titel` varchar(190) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Daten für Tabelle `support`
--

INSERT INTO `support` (`id`, `replyid`, `is_adm_answ`, `user_id`, `add_time`, `status`, `titel`, `text`) VALUES
(28, 0, NULL, 9, '2014-01-03', 'Offen', 'Das ist der Titel', 'Test'),
(36, 28, 9, 0, '0000-00-00', 'Offen', '', 'user v1'),
(37, 28, NULL, 0, '0000-00-00', 'Offen', '', 'admv1');

