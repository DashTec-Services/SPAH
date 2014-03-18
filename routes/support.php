<?php
/**
 * Created by David Schomburg (DashTec - Services)
 *      www.dashtec.de
 *
 *  S:P (StreamersPanel)
 *  Support: http://board.streamerspanel.de
 *
 *  v 0.18
 *
 *  Kundennummer:   @KDNUM@
 *  Lizenznummer:   @RECHNR@
 * Lizenz: http://login.streamerspanel.de/user/terms
 */

/*
 *
 *      Admin Routes
 *
 */
// anzeigen der gesamten tickets
$app->get('/support/list', function() use ($app){
    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $supportTickets = DB::query("SELECT * FROM support WHERE user_id != 0");
    $app->render('support/supportlist.phtml', compact('supportTickets'));
})->name('support');


/*
 *
 *      User Routes
 *
 */
$app->get('/support/list', function() use ($app){
    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $supportTickets = DB::query("SELECT * FROM support WHERE user_id != 0");
    $app->render('support/supportuserlist.phtml', compact('supportTickets'));
})->name('support');

$app->get('/support/addticket', function() use ($app){
    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $app->render('support/addticket.phtml');
})->name('support');


$app->post('/support/chticket', function () use ($app) {


    if (isset($_POST['status'])) {
        $changer = explode(".", $_POST['status']);
        DB::update('support', array(
            'status' => $changer['1']
        ), "id=%s", $changer['0']);
    }


    if (isset($_POST['submit_button'])){
        $changer = explode(".", $_POST['submit_button']);
        $_SESSION['replyid'] = $changer['1'];
        $app->render('support/replyticket.phtml');
    }









    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $supportTickets = DB::query("SELECT * FROM support WHERE user_id != 0");
    $app->render('support/supportlist.phtml', compact('supportTickets'));
})->name('doLogin');





