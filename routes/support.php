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

/*
 *
 *      User Routes
 *
 */
// anzeigen der gesamten tickets
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

$app->post('/support/addticket', function() use ($app){
    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    if (isset($_POST['eintragen'])) {
        $form = new \core\postget\postgetcoll();
        $formData[] = $form->collvars('POST');
        // TODO: Datum bis wann angezeigt wird.
        $formData['0']['add_time'] = date("Y-m-d");
        $formData['0']['status'] = 'Offen';
        $formData['0']['user_id'] = $_SESSION['account_id'];
        unset($formData['0']['eintragen']);
        \DB::insert('support', $formData);
        $sp_growl = new core\sp_special\growl();
        $sp_growl->writeGrowl('success', _('Send Reply'), '');
    }
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


$app->post('/support/list', function () use ($app) {

    $changer = explode(".", $_POST['delentry']);

    if ($changer['0'] == 'del'){
        DB::delete('support', "id=%s", $changer['1']);
        $SPMenu = new SP\Menu\MenuInclusion();
        $SPMenu->MenuInclude($app);
        $supportTickets = DB::query("SELECT * FROM support WHERE user_id != 0");
        $app->render('support/supportlist.phtml', compact('supportTickets'));
    }




})->name('doLogin');




