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


/*
 *
 *      Admin Routes
 *
 */
$app->get('/user/list', function () use ($app) {

    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $Users = DB::query("SELECT * FROM accounts");
    $app->render('benutzerverwaltung/listuser.phtml', compact('Users'));

})->name('not-restricted');

$app->get('/user/register', function () use ($app) {

    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $app->render('benutzerverwaltung/adduser.phtml');

})->name('not-restricted');


/*
 *
 *      User Routes
 *
 */


/*
 *
 *      POST Verarbeitung
 *
 */

$app->post('/user/list', function () use ($app) {
# Benutzer Aktiv/inaktiv

    if(!empty($_POST['useredit'])){
        $changer = explode(".", $_POST['useredit']);

        if($changer['1'] == 'deluser'){
            $addUser = new core\usercontrol\user();
            $addUser->delUserToDb($changer['0']);
            $SPMenu = new SP\Menu\MenuInclusion();
            $SPMenu->MenuInclude($app);
            $Users = DB::query("SELECT * FROM accounts");
            $app->render('benutzerverwaltung/listuser.phtml', compact('Users'));
            $sp_growl = new core\sp_special\growl();
            $sp_growl->writeGrowl('success', _('Benutzer gelöscht'), _('Der Benutzer wurde erfolgreich gelöscht!'));
        }

        if($changer['1'] == 'edituser'){

            $SPMenu = new SP\Menu\MenuInclusion();
            $SPMenu->MenuInclude($app);
            $Users = DB::queryFirstRow("SELECT * FROM accounts WHERE id=%s", $changer['0']);
            $_SESSION['merker'] = $changer[0];
            $app->render('benutzerverwaltung/edituser.phtml', compact('Users'));
            $sp_growl = new core\sp_special\growl();
            $sp_growl->writeGrowl('success', _('Benutzer bearbeitet'), '');

        }




    }else{
        $changer = explode(".", $_POST['is_aktiv']);
        DB::update('accounts', array(
            'is_aktiv' => $changer['1']
        ), "id=%s", $changer['0']);

        $SPMenu = new SP\Menu\MenuInclusion();
        $SPMenu->MenuInclude($app);
        $Users = DB::query("SELECT * FROM accounts");
        $app->render('benutzerverwaltung/listuser.phtml', compact('Users'));
        $sp_growl = new core\sp_special\growl();
        $sp_growl->writeGrowl('success', _('Benutzer wurde aktiviert'), '');
    }






})->name('doLogin');

$app->post('/user/list', function () use ($app) {

# Benutzer Aktiv/inaktiv
    if (isset($_POST['is_aktiv'])) {
        $changer = explode(".", $_POST['is_aktiv']);
        DB::update('accounts', array(
            'is_aktiv' => $changer['1']
        ), "id=%s", $changer['0']);
    }


})->name('doLogin');

$app->post('/user/edituser', function () use ($app) {

    if (isset($_POST['update']) AND
        !empty($_POST['vorname'])
        AND
        !empty($_POST['nachname'])
        AND
        !empty($_POST['mail'])
    ) {
        $formwork = new \core\postget\postgetcoll();
        $mywork[] = $formwork->collvars('POST');
        $addUser = new core\usercontrol\user();
        $addUser->updateUserToDb($mywork, $_SESSION['merker']);
        unset($_SESSION['merker']);

        $SPMenu = new SP\Menu\MenuInclusion();
        $SPMenu->MenuInclude($app);
        $Users = DB::query("SELECT * FROM accounts");
        $app->render('benutzerverwaltung/listuser.phtml', compact('Users'));
        $sp_growl = new core\sp_special\growl();
        $sp_growl->writeGrowl('success', 'Änderungen wurden übernommen', '');
    } elseif (isset($_POST['update'])) {
        $sp_growl = new core\sp_special\growl();
        $sp_growl->writeGrowl('error', _('Angaben nicht vollständig') ,  _('Name, Nachname und Mail werden benötigt') );
    }

})->name('doLogin');

/*
 *
 *      Add User
 *
 */
$app->post('/sap/benutzerverwaltung/list', function () use ($app) {

    $addUser = new core\usercontrol\user();
    $formwork = new core\postget\postgetcoll();


    if (isset($_POST['registeruser']) AND
        !empty($_POST['vorname'])
        AND
        !empty($_POST['nachname'])
        AND
        !empty($_POST['password'])
        AND
        !empty($_POST['mail'])
    ) {
        $mywork[] = $formwork->collvars('POST');
        $addUser->addUserToDb($mywork, 'registeruser');
        $SPMenu = new SP\Menu\MenuInclusion();
        $SPMenu->MenuInclude($app);
        $Users = DB::query("SELECT * FROM accounts");
        $app->render('benutzerverwaltung/listuser.phtml', compact('Users'));
        $sp_growl = new core\sp_special\growl();
        $sp_growl->writeGrowl('success', _('Benutzer wurde angelegt'), '');

    } else {

        if (isset($_POST['registeruser']) AND
            empty($_POST['vorname'])
            AND
            empty($_POST['nachname'])
            AND
            empty($_POST['password'])
            AND
            empty($_POST['mail'])
        ) {
            $SPMenu = new SP\Menu\MenuInclusion();
            $SPMenu->MenuInclude($app);
            $app->render('benutzerverwaltung/adduser.phtml');
        }
    }


})->name('doLogin');

