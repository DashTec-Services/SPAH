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

$app->get('/filemanager/list', function () use ($app) {

    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);

    $app->render('filemanager/list.phtml', compact('Users'));

})->name('list');

$app->get('/filemanager/playlist', function () use ($app) {

    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);

    $app->render('filemanager/playlist.phtml', compact('Users'));

})->name('list');

$app->get('/filemanager/upload', function () use ($app) {

    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);

    $app->render('filemanager/upload.phtml', compact('Users'));

})->name('list');