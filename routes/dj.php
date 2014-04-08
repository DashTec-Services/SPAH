<?php
/**
 * Created by David Schomburg (DashTec - Services)
 *      www.dashtec.de
 *
 *  S:P (StreamersPanel)
 *  Support: http://board.streamerspanel.de
 *
 *  v 0.30
 *
 *  Kundennummer:   @KDNUM@
 *  Lizenznummer:   @RECHNR@
 *  Lizenz: http://login.streamerspanel.de/user/terms
 */

$app->get('/dj/list', function () use ($app) {
    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $app->render('dj/listdj.phtml');
})->name('usr');

$app->get('/dj/add', function () use ($app) {
    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $app->render('dj/adddj.phtml');
})->name('usr');


$app->post('/dj/list', function () use ($app) {

    if (isset($_POST['editDjList']) AND !isset($_POST['entryDjtoStream'])) {
        $changer = explode(".", $_POST['editDjList']);
        $_SESSION['DJID'] = $changer[1];


        if($changer[0] == 'delDj'){
            // TODO: Absichern!!
            DB::delete('dj_accounts', "id=%s", $_SESSION['DJID']);
            $SPMenu = new SP\Menu\MenuInclusion();
            $SPMenu->MenuInclude($app);
            $growl = new core\sp_special\growl();
            $growl->writeGrowl('success','DJ - wurde zurgelöscht!','Zur Übernahme muss der Server neu gestartet werden');
            $app->render('dj/listdj.phtml');
        }

        # Lädt das Auswahlfenster um einen Benutzer einer Station hinzuzufügen
        if($changer[0] == 'djtoStation'){
            $SPMenu = new SP\Menu\MenuInclusion();
            $SPMenu->MenuInclude($app);
            $app->render('dj/listdj.phtml');
            $app->render('dj/stationselect.phtml', compact('supportTickets'));
        }

        # DJ bearbeiten
        if($changer[0] == 'editDj'){
            $SPMenu = new SP\Menu\MenuInclusion();
            $SPMenu->MenuInclude($app);
            $_SESSION['editDjId'] = $changer['1'];
            $DjData = DB::queryFirstRow("SELECt * FROM dj_accounts WHERE id=%s", $changer['1']);
            $app->render('dj/editdj.phtml', compact('DjData'));

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
        $growl->writeGrowl('info',_('DJ zum Stream hinzugefügt'),_('Stream benötigt einen Neustart!'));
        $app->render('dj/listdj.phtml');
    }

    if (isset($_POST['entryDjUser'])){

        $fromwork = new core\postget\postgetcoll();
        $mywork[] = $fromwork->collvars('POST');
        $mywork['0']['dj_of_user_id'] = $_SESSION['account_id'];
         unset($mywork['0']['entryDjUser']);
        \DB::insert('dj_accounts', $mywork);

        $SPMenu = new SP\Menu\MenuInclusion();
        $SPMenu->MenuInclude($app);
        $growl = new core\sp_special\growl();
        $growl->writeGrowl('info',_('DJ zum Account hinzugefügt '), _('Der Streamserver benötigt einen Neustart!'));
        $app->render('dj/listdj.phtml');
    }
})->name('usr');


$app->post('/dj/edit', function () use ($app) {
if (isset($_POST['editDjUser'])){

    $fromwork = new core\postget\postgetcoll();
    $mywork[] = $fromwork->collvars('POST');
    $mywork['0']['dj_of_user_id'] = $_SESSION['account_id'];
    unset($mywork['0']['editDjUser']);
    \DB::update('dj_accounts', $mywork, "id=%s", $_SESSION['editDjId']);



    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $growl = new core\sp_special\growl();
    $growl->writeGrowl('info',_('DJ bearbeitet'),'');
    $app->render('dj/listdj.phtml');
}
})->name('usr');