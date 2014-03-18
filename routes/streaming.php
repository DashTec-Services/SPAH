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

$app->get('/sp/license', function() use ($app){
    $license = DB::query("SELECT * FROM config");
$app->render('streaming/licenseshow.phtml', compact('license'));
})->name('license');


$app->get('/sp/serverconf', function() use ($app){
    $app->render('streaming/serverconf.phtml', compact('supportTickets'));
})->name('serverconf');


