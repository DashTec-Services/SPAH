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
 *      Main Route
 */

$app->get('/', function () use ($app) {

    if($_SESSION['group'] == 'adm'){
        $SPMenu = new SP\Menu\MenuInclusion();
        $SPMenu->MenuInclude($app);
        $growl = new \core\sp_special\growl();
        $app->render('spwelcome/adm.phtml', compact('Users'));
    }elseif($_SESSION['group']== 'user'){
            $SPMenu = new SP\Menu\MenuInclusion();
            $SPMenu->MenuInclude($app);
            $app->render('spwelcome/user.phtml', compact('Users'));
           // TODO: USER MAIN ANSICHT
    }elseif($_SESSION['group'] == 'dj'){
        $SPMenu = new SP\Menu\MenuInclusion();
        $SPMenu->MenuInclude($app);
        $app->render('spwelcome/dj.phtml', compact('Users'));    }
})->name('not-restricted');







