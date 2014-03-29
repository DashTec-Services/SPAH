<?php
/**
 * Created by David Schomburg (DashTec - Services)
 *      www.dashtec.de
 *
 *  S:P (StreamersPanel)
 *  Support: http://board.streamerspanel.de
 *
 *  v 0.21
 *
 *  Kundennummer:   @KDNUM@
 *  Lizenznummer:   @RECHNR@
 * Lizenz: http://login.streamerspanel.de/user/terms
 */

/*
 *      ADMIN ROUTES
 */


# Streamhinzufügen
$app->get('/station/add', function() use ($app){
    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $app->render('station/addstream.phtml', compact('license'));
})->name('license');

$app->get('/station/admedit', function() use ($app){
    $app->render('station/admineditstream.phtml', compact('license'));
})->name('license');

$app->get('/station/list', function() use ($app){
    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $app->render('station/adminshowlist.phtml', compact('license'));
})->name('license');


/*
 *      USER ROUTES
 */

$app->get('/station/showstream', function() use ($app){
    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $app->render('station/usershowstreams.phtml', compact('license'));
})->name('license');

$app->get('/station/autodj', function() use ($app){
    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $app->render('station/userautodj.phtml', compact('license'));
})->name('license');

$app->get('/station/editserv', function() use ($app){
    $app->render('station/usereditserver.phtml', compact('license'));
})->name('license');

# USER - POST Action SC_Serv
$app->post('/station/showstream', function () use ($app) {

    $trans = new core\sp_special\sctrans();
    $serv = new core\sp_special\scserv();
    $sp_growl = new core\sp_special\growl();


    # Starten der Server + Transcoder nach ReBoot
    if (isset($_POST['rebooton'])) {
        $pid = DB::query("SELECT * FROM sc_rel WHERE sc_serv_pid!='0' ");

        foreach ($pid as $row) {
            $serv->startSc_Serv($row['id']);
            $trans->startSc_Trans($row['id']);
        }
        $SPMenu = new SP\Menu\MenuInclusion();
        $SPMenu->MenuInclude($app);
        $app->render('station/adminshowlist.phtml', compact('license'));
    }


    # Alle starten + Stoppen
    if (isset($_POST['switch'])) {
        if ($_POST['switch'] == 'off') {
            $pid = DB::query("SELECT * FROM sc_rel WHERE sc_serv_pid!='0' ");
            foreach ($pid as $row) {
                $serv->killSc_Serv($row['id']);
            }
        }

        if ($_POST['switch'] == 'on') {
            $pid = DB::query("SELECT * FROM sc_rel WHERE sc_serv_pid='0' ");
            foreach ($pid as $row) {
                $serv->startSc_Serv($row['id']);
            }
        }
        $SPMenu = new SP\Menu\MenuInclusion();
        $SPMenu->MenuInclude($app);
        $app->render('station/adminshowlist.phtml', compact('license'));
    }

    # Server + Transc conf sichern nach bearbeitung
    if (isset($_POST['servconfsave'])) {

        $serv_id = DB::queryFirstRow("SELECT * FROM sc_rel WHERE id=%s", $_SESSION['sec_rel_id']);

        DB::update('sc_trans_conf', array(
            'unlockkeyname' => $_POST['unlockkeyname'],
            'unlockkeycode' => $_POST['unlockkeycode'],
            'irc' => $_POST['irc'],
            'icq' => $_POST['icq'],
            'aim' => $_POST['aim'],
            'streamtitle' => $_POST['streamtitle'],
            'streamurl' => $_POST['streamurl'],
            'encoder_1' => $_POST['encoder_1'],
            'genre' => $_POST['genre'],
            'djpassword' => $_POST['djpassword'],
            'shuffle' => $_POST['shuffle'],
            'public' => $_POST['public']

        ), "id=%s", $serv_id['sc_trans_id']);

        DB::update('sc_serv_conf', array(
            'PublicServer' => $_POST['PublicServer'],
            'URLFormat' => $_POST['URLFormat'],
            'TitleFormat' => $_POST['TitleFormat']
        ), "id=%s", $serv_id['sc_serv_conf_id']);

        DB::update('sc_rel', array(
            'stream_userName' => $_POST['stream_userName']
        ), "id=%s", $_SESSION['sec_rel_id']);


        # Laden der Übersicht nach Änderungen
        if($_SESSION['group'] == 'adm'){
            $SPMenu = new SP\Menu\MenuInclusion();
            $SPMenu->MenuInclude($app);
            $app->render('station/adminshowlist.phtml', compact('license'));
        }elseif($_SESSION['group'] == 'user'){
            $SPMenu = new SP\Menu\MenuInclusion();
            $SPMenu->MenuInclude($app);
            $app->render('station/usershowstreams.phtml', compact('license'));
        }
    }




    # Start - Stop Server           # USER Befehl
    if (isset($_POST['onoffselc'])) {
        $changer = explode(".", $_POST['onoffselc']);
        if ($changer['1'] == '1') {
            $serv->startSc_Serv($changer['0']);
            $sp_growl->writeGrowl('success',  _('Server started'), '');
        } elseif ($changer['1'] == '0') {
            $serv->killSc_Serv($changer['0']);
            $sp_growl->writeGrowl('info',  _('Server stopped'), '');
        }
        # Laden der Übersicht nach Änderungen
        if($_SESSION['group'] == 'adm'){
            $SPMenu = new SP\Menu\MenuInclusion();
            $SPMenu->MenuInclude($app);
            $app->render('station/adminshowlist.phtml', compact('license'));
        }elseif($_SESSION['group'] == 'user'){
            $SPMenu = new SP\Menu\MenuInclusion();
            $SPMenu->MenuInclude($app);
            $app->render('station/usershowstreams.phtml', compact('license'));
        }
    }

    # Laden der Konfiguration für die Ausgabe der Servereinstellungen
    if (isset($_POST['changeConfServ'])) {
        $changer = explode(".", $_POST['changeConfServ']);

        if ($changer[1] == 'edit') {
            $changer = explode(".", $_POST['changeConfServ']);
            // TODO: Sichern prüfen ob Server den User gehört!
            $_SESSION['sec_rel_id'] = $_POST['changeConfServ'];

            if($_SESSION['group'] == 'adm'){
                $SPMenu = new SP\Menu\MenuInclusion();
                $SPMenu->MenuInclude($app);
                $sc_rel = DB::queryFirstRow("SELECT * FROM sc_rel WHERE id=%s", $changer['0']);
                $sc_serv = DB::queryFirstRow("SELECT * FROM sc_serv_conf WHERE id=%s", $sc_rel['sc_serv_conf_id']);
                $sc_trans = DB::queryFirstRow("SELECT * FROM sc_trans_conf WHERE id=%s", $sc_rel['sc_trans_id']);
                $app->render('station/admineditstream.phtml', compact('sc_serv', 'sc_trans', 'sc_rel'));
            }elseif($_SESSION['group'] == 'user'){
                $SPMenu = new SP\Menu\MenuInclusion();
                $SPMenu->MenuInclude($app);
                $sc_rel = DB::queryFirstRow("SELECT * FROM sc_rel WHERE id=%s", $changer['0']);
                $sc_serv = DB::queryFirstRow("SELECT * FROM sc_serv_conf WHERE id=%s", $sc_rel['sc_serv_conf_id']);
                $sc_trans = DB::queryFirstRow("SELECT * FROM sc_trans_conf WHERE id=%s", $sc_rel['sc_trans_id']);
                $app->render('station/usereditserver.phtml', compact('sc_serv', 'sc_trans', 'sc_rel'));
            }


        } elseif ($changer[1] == 'clear') {
            $changer = explode(".", $_POST['changeConfServ']);
            // TODO: Sichern prüfen ob Server den User gehört!
            $_SESSION['sec_rel_id'] = $_POST['changeConfServ'];
            $sc_rel = DB::queryFirstRow("SELECT * FROM sc_rel WHERE id=%s", $changer['0']);
            DB::delete('sc_rel', "id=%s", $changer['0']);
            DB::delete('sc_serv_conf', "id=%s", $sc_rel['sc_serv_conf_id']);
            DB::delete('sc_trans_conf', "id=%s", $sc_rel['sc_trans_id']);
            include_once $DTF->LoadView('list', 'station');
            $sp_growl->writeGrowl('success', _('Server delete'), '');
        }
    }

    # Server bearbeiten und Neu-Starten
    if (isset($_POST['editsrvandreboot'])) {

        $serv_id = DB::queryFirstRow("SELECT * FROM sc_rel WHERE id=%s", $_SESSION['sec_rel_id']);

        DB::update('sc_trans_conf', array(
            'unlockkeyname' => $_POST['unlockkeyname'],
            'unlockkeycode' => $_POST['unlockkeycode'],
            'irc' => $_POST['irc'],
            'icq' => $_POST['icq'],
            'aim' => $_POST['aim'],
            'streamtitle' => $_POST['streamtitle'],
            'streamurl' => $_POST['streamurl'],
            'encoder_1' => $_POST['encoder_1'],
            'genre' => $_POST['genre'],
            'public' => $_POST['public'],
            'shuffle' => $_POST['shuffle'],
            'djpassword' => $_POST['djpassword']
        ), "id=%s", $serv_id['sc_trans_id']);

        DB::update('sc_serv_conf', array(
            'PublicServer' => $_POST['PublicServer'],
            'URLFormat' => $_POST['URLFormat'],
            'TitleFormat' => $_POST['TitleFormat']
        ), "id=%s", $serv_id['sc_serv_conf_id']);

        DB::update('sc_rel', array(
            'stream_userName' => $_POST['stream_userName']
        ), "id=%s", $_SESSION['sec_rel_id']);

        // And Now Reboot SRV + Transcoder

        $serv->killSc_Serv($_SESSION['sec_rel_id']);
        $trans->killSc_Trans($_SESSION['sec_rel_id']);
        $trans->startSc_Trans($_SESSION['sec_rel_id']);
        $serv->startSc_Serv($_SESSION['sec_rel_id']);
            $SPMenu = new SP\Menu\MenuInclusion();
            $SPMenu->MenuInclude($app);
            $sc_rel = DB::queryFirstRow("SELECT * FROM sc_rel WHERE id=%s", $changer['0']);
            $sc_serv = DB::queryFirstRow("SELECT * FROM sc_serv_conf WHERE id=%s", $sc_rel['sc_serv_conf_id']);
            $sc_trans = DB::queryFirstRow("SELECT * FROM sc_trans_conf WHERE id=%s", $sc_rel['sc_trans_id']);
            $app->render('station/admineditstream.phtml', compact('sc_serv', 'sc_trans', 'sc_rel'));
    }





    # Neuen Server anlegen
    # Server hinzufügen
    if (isset($_POST['addsrv'])) {

        $config = DB::queryFirstRow("SELECT doc_root FROM config WHERE id=%s", '1');
        $DocRoot = $config['doc_root'];

        $serverPort = $_POST['PortBase'];

        $form = new \core\postget\postgetcoll();
        $formData = $form->collvars('POST');

        $FolderDir = $DocRoot . "/shoutcastconf/" . $serverPort;

        // Ordner anlegen
        mkdir($FolderDir, 0700);

        DB::insert('sc_serv_conf', array(
            'MaxUser' => $formData['MaxUser'],
            'Password' => $formData['Password'],
            'PortBase' => $formData['PortBase'],
            'logfile' => $FolderDir . '/sc_serv.log',
            'RealTime' => '1',
            'ScreenLog' => '0',
            'ShowLastSongs' => '0',
            //'TchLog' => 'NULL',
            //'WebLog' => 'NULL',
            'W3CEnable' => 'Yes',
            'W3CLog' => $FolderDir . '/sc_w3c.log',
            //'SrcIP' => '',
            //'DestIP' => '',
            //'Yport' => '',
            'NameLookups' => '0',
            // 'RelayPort' => '',
            // 'RelayServer' => '',
            'AdminPassword' => $formData['AdminPassword'],
            'AutoDumpUsers' => '0',
            'AutoDumpSourceTime' => '30',
            //'ContentDir' => '',
            //'IntroFile' => '',
            //'BackupFile' => '',
            //'TitleFormat' => '',
            //'URLFormat' => '',
            'PublicServer' => $formData['PublicServer'],
            'AllowRelay' => 'Yes',
            'AllowPublicRelay' => 'Yes',
            'MetaInterval' => '32768',
            //'ListenerTimer' => '',
            //'BanFile' => '',
            // 'RipFile' => '',
            // 'RIPOnly' => '',
        ));
        $sc_serv_id = DB::insertId();

        if ($formData['PublicServer'] == 'public') {
            $IsPublic = 1;
        } else {
            $IsPublic = 0;
        }


        DB::insert('sc_trans_conf', array(
            'encoder_1' => $formData['encoder_1'],
            'bitrate_1' => $formData['bitrate_1'],
            'samplerate_1' => $formData['samplerate_1'],
            'channels_1' => $formData['channels_1'],
            'outprotocol_1' => '1',
            'serverip_1' => '127.0.0.1',
            'serverport_1' => $serverPort,
            'password_1' => $formData['Password'],
            //'streamurl' => '',
            // 'genre' => '',
            'public' => $IsPublic,
            'log' => '1',
            //'playlistfile' => '',
            //'shuffle' =>'',
            'xfade' => '2',
            'xfadethreshold' => '20',
            'logfile' => $FolderDir . '/sc_trans.log',
            'screenlog' => '1',
            'applyreplaygain' => '0',
            'calculatereplaygain' => '0',
            'djport' => $formData['djport'],
            'djpassword' => $formData['djpassword'],
            'autodumpsourcetime' => '30',
            'djcapture' => '0',
            //'streamtitle' =>'',
            //'aim' => '',
            //'icq' => '',
            //'irc' => '',
            //'unlockkeyname' =>'',
            //'unlockkeycode' =>''
        ));
        $sc_trans_id = DB::insertId();


        DB::insert('sc_rel', array(
            'accounts_id' => $formData['usr_id'],
            'sc_serv_conf_id' => $sc_serv_id,
            'sc_serv_version_id' => $formData['sc_serv_version'],
            'stream_userName' => 'Dein neuer Stream',
            'sc_trans_id' => $sc_trans_id,
            'sc_trans_version_id' => $formData['sc_trans_version']
        ));

        $SPMenu = new SP\Menu\MenuInclusion();
        $SPMenu->MenuInclude($app);
        $app->render('station/adminshowlist.phtml', compact('license'));
    }

})->name('doLogin');

# User POST SC_Trans
$app->post('/station/autodj', function () use ($app) {


# Neue Playliste übernehmen
    if (isset($_POST['playlstswitch'])) {
        # Trennen der übergebenen Par.
        $changer = explode(".", $_POST['playlstswitch']);

        # Ausleden der conf ID
        $servTrans = DB::queryFirstRow("SELECT sc_serv_conf_id FROM sc_rel WHERE id=%s", $changer['0']);

        # Setzen der neuen ID
        \DB::update('sc_rel', array(
            'play_list_id' => $changer['1']
        ), "id=%s", $changer['0']);

        # Port abfragen
        $PortBase = DB::queryFirstRow("SELECT PortBase FROM sc_serv_conf WHERE id=%s", $servTrans['sc_serv_conf_id']);

        # Eintragen der Playliste in die DB
        \DB::update('sc_trans_conf', array(
            'playlistfile' => $_SERVER['DOCUMENT_ROOT'] . '/shoutcastconf/' . $PortBase['PortBase'] . '/' . $changer['2'] . '.lst'
        ), "id=%s", $changer['1']);

        #Ausgabe zum Testen der Pfade
      #  echo $_SERVER['DOCUMENT_ROOT'] . '/shoutcastconf/' . $PortBase['PortBase'] . '/' . $changer['2'] . '.lst';

        $playlist = new core\sp_special\station();
        $trans = new core\sp_special\sctrans();
        # Neue Playliste Schreiben
        $playlist->createPlaylst($changer['0']);

        # Neue Konfiguration schreiben
        $trans->writeSc_TransConf($servTrans['sc_serv_conf_id']);
    }

    # Start - Stop Transcoder
    if (isset($_POST['djSwitch'])) {
        $changer = explode(".", $_POST['djSwitch']);
        if ($changer['1'] == '1') {
            $trans->startSc_Trans($changer['0']);
        } elseif ($changer['1'] == '0') {
            $trans->killSc_Trans($changer['0']);
        }
    }


    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $app->render('station/userautodj.phtml', compact('license'));
})->name('doLogin');