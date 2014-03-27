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
    }

    # Laden der Konfiguration für die Ausgabe der Servereinstellungen
    if (isset($_POST['changeConfServ'])) {
        $changer = explode(".", $_POST['changeConfServ']);

        if ($changer[1] == 'edit') {
            $changer = explode(".", $_POST['changeConfServ']);
// TODO: Sichern prüfen ob Server den User gehört!
            $_SESSION['sec_rel_id'] = $_POST['changeConfServ'];
            $sc_rel = DB::queryFirstRow("SELECT * FROM sc_rel WHERE id=%s", $changer['0']);
            $sc_serv = DB::queryFirstRow("SELECT * FROM sc_serv_conf WHERE id=%s", $sc_rel['sc_serv_conf_id']);
            $sc_trans = DB::queryFirstRow("SELECT * FROM sc_trans_conf WHERE id=%s", $sc_rel['sc_trans_id']);

            if($_SESSION['usr_grp'] == 'adm'){
                include_once $DTF->LoadView('adm_editsetup', 'station');
            }elseif($_SESSION['usr_grp'] == 'user'){
                include_once $DTF->LoadView('us_editsetup', 'station');
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







    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $app->render('station/usershowstreams.phtml', compact('license'));
})->name('doLogin');