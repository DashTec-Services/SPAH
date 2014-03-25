<?php
/**
 * Created by David Schomburg (DashTec - Services)
 *      www.dashtec.de
 *
 *  S:P (StreamersPanel)
 *  Support: http://board.streamerspanel.de
 *
 *  v 0.19
 *
 *  Kundennummer:   @KDNUM@
 *  Lizenznummer:   @RECHNR@
 * Lizenz: http://login.streamerspanel.de/user/terms
 */

$app->get('/dj/list', function () use ($app) {
    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $app->render('dj/listdj.phtml');
})->name('not-restricted');

$app->get('/dj/add', function () use ($app) {
    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $app->render('dj/adddj.phtml');
})->name('not-restricted');






$app->post('/dj/list', function () use ($app) {

    if (isset($_POST['editDjList']) AND !isset($_POST['entryDjtoStream'])) {
        $changer = explode(".", $_POST['editDjList']);
        $_SESSION['DJID'] = $changer[1];


        if($changer[0] == 'delDj'){
            // TODO: Absichern!!
            DB::delete('dj_accounts', "id=%s", $_SESSION['DJID']);
            $growl = new core\sp_special\growl();
            $growl->writeGrowl('success','DJ - wurde zurgelöscht!','Zur Übernahme muss der Server neu gestartet werden');
        }

        # Lädt das Auswahlfenster um einen Benutzer einer Station hinzuzufügen
        if($changer[0] == 'djtoStation'){
            $SPMenu = new SP\Menu\MenuInclusion();
            $SPMenu->MenuInclude($app);
            $app->render('dj/listdj.phtml');
            $app->render('dj/stationselect.phtml', compact('supportTickets'));
        }
    }


# Auswahl Menü um DJ einen Stream zuzuordnen
    if(isset($_POST['entryDjtoStream'])){
        DB::update('dj_accounts', array(
            'dj_of_sc_rel_id' => $_POST['entryDjtoStream']
        ), "id=%s", $_SESSION['DJID']);
        $SPMenu = new SP\Menu\MenuInclusion();
        $SPMenu->MenuInclude($app);
        $growl = new core\sp_special\growl();
        $growl->writeGrowl('info',_('Add DJ to Station'),_('Server reboot requierd'));
        $app->render('dj/listdj.phtml');
    }

})->name('doLogin');