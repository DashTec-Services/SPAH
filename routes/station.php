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

    // TODO -> SELECTED ID
    $app->render('station/admineditstream.phtml', compact('license'));
})->name('license');

$app->get('/station/list', function() use ($app){
    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
// TODO -> SELECTED ID
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

// TODO -> SELECTED ID
    $app->render('station/usereditserver.phtml', compact('license'));
})->name('license');