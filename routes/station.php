<?php
/**
 * Created by David Schomburg (DashTec - Services)
 *      www.dashtec.de
 *
 *  S:P (StreamersPanel)
 *  Support: http://board.streamerspanel.de
 *
 *  v 0.32
 *
 *  Kundennummer:   @KDNUM@
 *  Lizenznummer:   @RECHNR@
 *  Lizenz: http://login.streamerspanel.de/user/terms
 */

/*
 *      ADMIN ROUTES
 */



$app->get('/station/admedit', function() use ($app){
    $app->render('station/admineditstream.phtml', compact('license'));
    # Demoeinstellungen
    $demo = new \core\demo\demomod();
    $demo->CheckDemo($_SESSION['demo_mod']);
})->name('restricted');

$app->get('/station/list', function() use ($app){
    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $app->render('station/adminshowlist.phtml', compact('license'));

    # Demoeinstellungen
    $demo = new \core\demo\demomod();
    $demo->CheckDemo($_SESSION['demo_mod']);
})->name('restricted');


/*
 *      USER ROUTES
 */

$app->get('/station/showstream', function() use ($app){
    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $app->render('station/usershowstreams.phtml', compact('license'));

    # Demoeinstellungen
    $demo = new \core\demo\demomod();
    $demo->CheckDemo($_SESSION['demo_mod']);
})->name('license');

$app->get('/station/autodj', function() use ($app){
    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $app->render('station/userautodj.phtml', compact('license'));

    # Demoeinstellungen
    $demo = new \core\demo\demomod();
    $demo->CheckDemo($_SESSION['demo_mod']);
})->name('license');

$app->get('/station/editserv', function() use ($app){
    $app->render('station/usereditserver.phtml', compact('license'));
    # Demoeinstellungen
    $demo = new \core\demo\demomod();
    $demo->CheckDemo($_SESSION['demo_mod']);
})->name('license');

# USER - POST Action SC_Serv
$app->post('/station/showstream', function () use ($app) {

    $trans = new core\sp_special\sctrans();
    $serv = new core\sp_special\scserv();
    $sp_growl = new core\sp_special\growl();


    # Starten der Server + Transcoder nach ReBoot
    if (isset($_POST['rebooton']) AND $_SESSION['demo_mod'] == false) {
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
    if (isset($_POST['switch']) AND $_SESSION['demo_mod'] == false) {
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
    if (isset($_POST['servconfsave']) AND $_SESSION['demo_mod'] == false) {

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

    # Server + Transc conf sichern nach bearbeitung und Neu-Starten
    if (isset($_POST['editsrvandreboot']) AND $_SESSION['demo_mod'] == false) {

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
    if (isset($_POST['onoffselc']) AND $_SESSION['demo_mod'] == false ) {
        $changer = explode(".", $_POST['onoffselc']);
        if ($changer['1'] == '1') {
            $serv->startSc_Serv($changer['0']);
            # Laden der Übersicht nach Änderungen
            if($_SESSION['group'] == 'adm'){
                $SPMenu = new SP\Menu\MenuInclusion();
                $SPMenu->MenuInclude($app);
                $app->render('station/adminshowlist.phtml', compact('license'));
                $sp_growl->writeGrowl('success',  _('Server gestartet'), '');

            }elseif($_SESSION['group'] == 'user'){
                $SPMenu = new SP\Menu\MenuInclusion();
                $SPMenu->MenuInclude($app);
                $app->render('station/usershowstreams.phtml', compact('license'));
                $sp_growl->writeGrowl('success',  _('Server gestartet'), '');

            }
        } elseif ($changer['1'] == '0') {
            $serv->killSc_Serv($changer['0']);
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
            $sp_growl->writeGrowl('info',  _('Server gestoppt'), '');
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
                # Demoeinstellungen
                $demo = new \core\demo\demomod();
                $demo->CheckDemo($_SESSION['demo_mod']);

            }elseif($_SESSION['group'] == 'user'){
                $SPMenu = new SP\Menu\MenuInclusion();
                $SPMenu->MenuInclude($app);
                $sc_rel = DB::queryFirstRow("SELECT * FROM sc_rel WHERE id=%s", $changer['0']);
                $sc_serv = DB::queryFirstRow("SELECT * FROM sc_serv_conf WHERE id=%s", $sc_rel['sc_serv_conf_id']);
                $sc_trans = DB::queryFirstRow("SELECT * FROM sc_trans_conf WHERE id=%s", $sc_rel['sc_trans_id']);
                $app->render('station/usereditserver.phtml', compact('sc_serv', 'sc_trans', 'sc_rel'));
                # Demoeinstellungen
                $demo = new \core\demo\demomod();
                $demo->CheckDemo($_SESSION['demo_mod']);
            }


        } elseif ($changer[1] == 'clear' AND $_SESSION['demo_mod'] == false  ) {
            $changer = explode(".", $_POST['changeConfServ']);
            // TODO: Sichern prüfen ob Server den User gehört!
            $_SESSION['sec_rel_id'] = $_POST['changeConfServ'];
            $sc_rel = DB::queryFirstRow("SELECT * FROM sc_rel WHERE id=%s", $changer['0']);
            DB::delete('sc_rel', "id=%s", $changer['0']);
            DB::delete('sc_serv_conf', "id=%s", $sc_rel['sc_serv_conf_id']);
            DB::delete('sc_trans_conf', "id=%s", $sc_rel['sc_trans_id']);

            $SPMenu = new SP\Menu\MenuInclusion();
            $SPMenu->MenuInclude($app);
            $sc_rel = DB::queryFirstRow("SELECT * FROM sc_rel WHERE id=%s", $changer['0']);
            $sc_serv = DB::queryFirstRow("SELECT * FROM sc_serv_conf WHERE id=%s", $sc_rel['sc_serv_conf_id']);
            $sc_trans = DB::queryFirstRow("SELECT * FROM sc_trans_conf WHERE id=%s", $sc_rel['sc_trans_id']);
            $app->render('station/adminshowlist.phtml', compact('sc_serv', 'sc_trans', 'sc_rel'));
            $sp_growl->writeGrowl('success', _('Server gelöscht'), '');

        }
    }


})->name('doLogin');

# User POST SC_Trans
$app->post('/station/autodj', function () use ($app) {


# Neue Playliste übernehmen

    if (isset($_POST['playlstswitch']) AND $_POST['playlstswitch'] != '' AND $_SESSION['demo_mod'] == false) {
        # Trennen der übergebenen Par.
        $changer = explode(".", $_POST['playlstswitch']);

        #changer 0 = sc_rel ID
        #changer 1 = playlist ID
        #changer 3 = Playlistname

        # Auslesen der conf ID
        $servTrans = DB::queryFirstRow("SELECT sc_serv_conf_id, sc_trans_id FROM sc_rel WHERE id=%s", $changer['0']);

        # Setzen der neuen ID
        \DB::update('sc_rel', array(
            'play_list_id' => $changer['1']
        ), "id=%s", $changer['0']);

        # Port abfragen
        $PortBase = DB::queryFirstRow("SELECT PortBase FROM sc_serv_conf WHERE id=%s", $servTrans['sc_trans_id']);

        # Eintragen der Playliste in die DB
        \DB::update('sc_trans_conf', array(
            'playlistfile' => $_SERVER['DOCUMENT_ROOT'] . '/shoutcastconf/' . $PortBase['PortBase'] . '/' . $changer['2'] . '.lst'
        ), "id=%s", $servTrans['sc_trans_id']);

        $trans = new core\sp_special\sctrans();

        # Neue Konfiguration schreiben
        $trans->writeSc_TransConf($servTrans['sc_serv_conf_id']);

    }

    # Start - Stop Transcoder
    if (isset($_POST['djSwitch']) AND $_SESSION['demo_mod'] == false) {
        $changer = explode(".", $_POST['djSwitch']);
        if ($changer['1'] == '1') {
            $trans = new \core\sp_special\sctrans();
            $trans->startSc_Trans($changer['0']);
        } elseif ($changer['1'] == '0') {
            $trans = new \core\sp_special\sctrans();
            $trans->killSc_Trans($changer['0']);
        }
    }


    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $app->render('station/userautodj.phtml', compact('license'));
})->name('doLogin');


# Funktionen für DJ - Benutzer
$app->post('/station/djfunction', function () use ($app) {
    # Start - Stop Transcoder
    if (isset($_POST['djSwitch']) AND $_SESSION['demo_mod'] == false) {
        $changer = explode(".", $_POST['djSwitch']);
        if ($changer['1'] == '1') {
            $trans = new \core\sp_special\sctrans();
            $trans->startSc_Trans($changer['0']);
        } elseif ($changer['1'] == '0') {
            $trans = new \core\sp_special\sctrans();
            $trans->killSc_Trans($changer['0']);
        }
    }

    # DJ - Nächsten Song spielen
    if(isset($_POST['kickdj'])){
        $sc_trans_con = DB::queryFirstRow("SELECT * FROM sc_trans_conf WHERE id=%s", $_POST['kickdj']);
        $adminport = $sc_trans_con['adminport'];
        $username = $sc_trans_con['adminuser'];
        $password = $sc_trans_con['adminpassword'];
        $context = stream_context_create(array(
            'http' => array(
                'header'  => "Authorization: Basic " . base64_encode("$username:$password")
            )
        ));
        $data = file_get_contents('http://sappview.streamerspanel.com:'.$adminport.'/kickdj', false, $context);
    }


    # DJ - Nächsten Song spielen
    if(isset($_POST['dj_nextSong'])){
        $sc_trans_con = DB::queryFirstRow("SELECT * FROM sc_trans_conf WHERE id=%s", $_POST['dj_nextSong']);
        $adminport = $sc_trans_con['adminport'];
        $username = $sc_trans_con['adminuser'];
        $password = $sc_trans_con['adminpassword'];
        $context = stream_context_create(array(
            'http' => array(
                'header'  => "Authorization: Basic " . base64_encode("$username:$password")
            )
        ));
        $data = file_get_contents('http://sappview.streamerspanel.com:'.$adminport.'/nextsong', false, $context);
    }





    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $app->render('spwelcome/dj.phtml', compact('license'));
})->name('dj');