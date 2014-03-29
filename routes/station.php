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

# USER - POST Action
$app->post('/station/showstream', function () use ($app) {

    $serv = new core\sp_special\scserv();
    $sp_growl = new core\sp_special\growl();


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
})->name('doLogin');