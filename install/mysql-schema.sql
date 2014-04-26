CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kundennummer` varchar(35) NOT NULL,
  `password` varchar(250) NOT NULL,
  `vorname` varchar(45) NOT NULL,
  `nachname` varchar(45) NOT NULL,
  `street` varchar(55) NOT NULL,
  `hausnummer` int(4) NOT NULL,
  `ort` varchar(45) NOT NULL,
  `plz` int(5) NOT NULL,
  `telefon` varchar(45) NOT NULL,
  `handy` varchar(45) NOT NULL,
  `mail` varchar(60) NOT NULL,
  `skype` varchar(45) NOT NULL,
  `local` varchar(15) NOT NULL,
  `usr_grp` enum('adm','user','dj') NOT NULL,
  `dj_limit_count` int(11) DEFAULT NULL,
  `dj_name` varchar(56) NOT NULL,
  `dj_of_user_id` int(11) DEFAULT NULL,
  `is_aktiv` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_ip` varchar(15) NOT NULL,
  `root_user` varchar(15) NOT NULL,
  `root_password` varchar(55) NOT NULL,
  `ssh_port` int(11) NOT NULL,
  `sp_titel` varchar(150) NOT NULL,
  `doc_root` varchar(250) NOT NULL,
  `default_local` varchar(5) NOT NULL,
  `adminMail` varchar(55) NOT NULL,
  `wartungsmodus` tinyint(1) NOT NULL,
  `sp_version` varchar(15) DEFAULT NULL,
  `upd_message` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `dj_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dj_of_user_id` int(11) DEFAULT NULL,
  `dj_of_sc_rel_id` int(11) NOT NULL,
  `dj_accounts_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mp3` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org_file_titel` varchar(45) NOT NULL,
  `dir_titel` varchar(250) NOT NULL,
  `hash_titel` varchar(150) NOT NULL,
  `size` varchar(15) NOT NULL,
  `bitrate` varchar(3) NOT NULL,
  `playtime` varchar(50) NOT NULL,
  `year` varchar(5) DEFAULT NULL,
  `artist` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mp3_usr_rel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `mp3_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datum` date NOT NULL,
  `is_aktiv` tinyint(1) NOT NULL,
  `login_news` tinyint(1) NOT NULL,
  `headline` varchar(189) NOT NULL,
  `message` text NOT NULL,
  `type` enum('block','success','info','error') DEFAULT NULL,
  `have_to_read` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `news_to_read` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `user_read_it` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `playlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `playlist_name` varchar(150) NOT NULL,
  `user_id` int(11) NOT NULL,
  `add_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `playlist_mp3_rel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `playlist_id` int(11) NOT NULL,
  `mp3_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `sc_serv_conf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `MaxUser` varchar(3) DEFAULT NULL,
  `Password` varchar(150) DEFAULT NULL,
  `PortBase` varchar(6) DEFAULT NULL,
  `LogFile` varchar(255) DEFAULT NULL,
  `RealTime` varchar(1) DEFAULT NULL,
  `ScreenLog` varchar(1) DEFAULT '1',
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `sc_trans_conf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `encoder` varchar(10) NOT NULL DEFAULT 'aac',
  `bitrate` varchar(15) NOT NULL DEFAULT '56000',
  `samplerate` varchar(10) DEFAULT NULL,
  `channels` varchar(2) DEFAULT NULL,
  `outprotocol` varchar(5) NOT NULL DEFAULT '1',
  `serverip` varchar(20) NOT NULL DEFAULT '127.0.0.1',
  `serverport` varchar(10) DEFAULT NULL,
  `password` varchar(150) DEFAULT NULL,
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
  `adminport` varchar(8) NOT NULL,
  `adminuser` varchar(45) DEFAULT NULL,
  `adminpassword` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `sc_version` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  `file_name` varchar(45) NOT NULL,
  `version` varchar(7) NOT NULL,
  `typ` enum('serv','trans') NOT NULL,
  `editTempName` varchar(75) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

INSERT INTO `sc_version` (`id`, `name`, `file_name`, `version`, `typ`, `editTempName`) VALUES
(1, 'ShoutCast 1.9.8', '1.9.8_sc_serv.bin', '1.9.8', 'serv', 'sc10serv_'),
(2, 'ShoutCast 1.9.9', '1.9.9_sc_serv.bin', '1.9.9', 'serv', 'sc10serv_'),
(3, 'ShoutCast 2.0', '2_sc_serv.bin', '2', 'serv', 'sc20serv_'),
(4, 'Trans-x64', 'sc_trans64.bin', '2', 'trans', 'sc20trans_'),
(5, 'Trans-x86', 'sc_trans86.bin', '2', 'trans', 'sc20trans_');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
