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

    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    if($_SESSION['group'] == 'adm'){
        $app->render('spwelcome/adm.phtml', compact('Users'));
    }elseif($_SESSION['group']== 'user'){
        $app->render('spwelcome/user.phtml', compact('Users'));
           // TODO: USER MAIN ANSICHT
    }elseif($_SESSION['group'] == 'dj'){
        // TODO : DJ MAIN Ansicht
    }
})->name('not-restricted');







