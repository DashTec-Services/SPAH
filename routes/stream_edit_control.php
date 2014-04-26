<?php
/**
 * Created by David Schomburg (DashTec - Services)
 *      www.dashtec.de
 *
 *  S:P (StreamersPanel)
 *  Support: http://board.streamerspanel.de
 *
 *  v 0.37
 *
 *  Kundennummer:   @KDNUM@
 *  Lizenznummer:   @RECHNR@
 *  Lizenz: http://login.streamerspanel.de/user/terms
 */


/*
 *      Select witch SC_edit to load
 */
$app->get('/stationaddeditcontrol/selectStream', function() use ($app){
    unset($_SESSION['stationAddmerker']);
    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $app->render('station/adminshowlist.phtml', compact('license'));

    # Demoeinstellungen
    $demo = new \core\demo\demomod();
    $demo->CheckDemo($app->config('demo_mod'));
})->name('restricted');



# Passende Stationconf laden
$app->post('/stationaddeditcontrol/selectStream', function() use ($app){

    $selectTempName = DB::queryFirstRow("SELECT * FROM sc_rel WHERE id=%s", $_POST['streamtoEdit']);



    # Bestimmung der zuladenden View
    $select_SCServ_FileName = DB::queryFirstRow("SELECT * FROM sc_version WHERE id=%s",$selectTempName['sc_serv_version_id']);
    $select_SCTrans_FileName = DB::queryFirstRow("SELECT * FROM sc_version WHERE id=%s",$selectTempName['sc_trans_version_id']);


    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    # Auslesen der Konfiguration
    $sc_trans = DB::queryFirstRow("SELECT * FROM sc_trans_conf WHERE id=%s", $selectTempName['sc_trans_id']);
    $sc_server = DB::queryFirstRow("SELECT * FROM sc_serv_conf WHERE id=%s",$selectTempName['sc_serv_conf_id']);

    $_SESSION['trans_id'] = $selectTempName['sc_trans_id'];
    $_SESSION['serv_id'] = $selectTempName['sc_serv_conf_id'];
    $_SESSION['streamID'] = $selectTempName['id'];

    $app->render('stationconf/'.$select_SCServ_FileName['editTempName'].$_SESSION['group'].'.phtml', compact('sc_server', 'sc_trans'));
    $app->render('stationconf/'.$select_SCTrans_FileName['editTempName'].$_SESSION['group'].'.phtml', compact('sc_server' , 'sc_trans'));
    # Demoeinstellungen
    $demo = new \core\demo\demomod();
    $demo->CheckDemo($app->config('demo_mod'));

})->name('allit');


# Passende Stationconf laden
$app->post('/station/useredit', function() use ($app){


    DB::update('sc_serv_conf', array(
        'Password'      => $_POST['sc_serv']['Password'],
        'AdminPassword' => $_POST['sc_serv']['AdminPassword'],
        'ShowLastSongs' => $_POST['sc_serv']['ShowLastSongs'],
        'TitleFormat'   => $_POST['sc_serv']['TitleFormat'],
        'URLFormat'     => $_POST['sc_serv']['TitleFormat']
        ), "id=%s", $_SESSION['serv_id']);

    DB::update('sc_trans_conf', array(
        'encoder'       => $_POST['sc_trans']['encoder'],
        'unlockkeyname' => $_POST['sc_trans']['unlockkeyname'],
        'unlockkeycode' => $_POST['sc_trans']['unlockkeycode'],
        'public'        => $_POST['PublicServer'],
       # 'adminuser'     => $_POST['sc_trans']['adminuser'],
        'adminpassword' => $_POST['sc_serv']['AdminPassword'],
       # 'djpassword'    => $_POST['sc_trans']['djpassword'],
        'streamurl'     => $_POST['sc_trans']['streamurl'],
        'genre'         => $_POST['sc_trans']['genre'],
        'shuffle'       => $_POST['sc_trans']['shuffle'],
        'aim'           => $_POST['sc_trans']['aim'],
        'icq'           => $_POST['sc_trans']['icq'],
        'irc'           => $_POST['sc_trans']['irc']
    ), "id=%s",  $_SESSION['trans_id']);
    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $app->render('station/usershowstreams.phtml', compact('license'));
})->name('user');


