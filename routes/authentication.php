<?php
/**
 * Created by David Schomburg (DashTec - Services)
 *      www.dashtec.de
 *
 *  S:P (StreamersPanel)
 *  Support: http://board.streamerspanel.de
 *
 *  v 0.25
 *
 *  Kundennummer:   @KDNUM@
 *  Lizenznummer:   @RECHNR@
 *  Lizenz: http://login.streamerspanel.de/user/terms
 */
use core\password\password;

$app->get('/not-restricted', function () use ($app) {
    echo 'aloha';
})->name('not-restricted');

$app->get('/restricted', function () use ($app) {
    echo 'ich bin garnicht da';
})->name('restricted');

// zeigt die loginseite an
$app->get('/login', function () use ($app) {
    $newsListing = DB::query("SELECT * FROM news WHERE is_aktiv=%s  AND login_news=%s", '1', '1');
    $app->render('authentication/login.phtml', compact('newsListing'));
})->name('login');

// fuehrt den login des benutzers durch
$app->post('/login', function () use ($app) {
    $username = $app->request()->post('username');
    $password = $app->request()->post('password');

    if (!$username || !$password) {
        $app->redirect('/login', 303);
    }

    $account = DB::queryFirstRow("SELECT * FROM accounts WHERE kundennummer=%s", $username);
    if (!$account) {
        $app->flash('error', _('Keinen Account gefunden'));
        $app->redirect('/', 303);
    }

    $passwordIsCorrect = password::verifyPassword($password, $account['password']);
    if (!$passwordIsCorrect || !$account['is_aktiv']) {
        $app->flash('error', _('Benutzer nicht gefunden!'));
        $app->redirect('/login', 303);
    }

    # Session setzen
    $_SESSION['account_id'] = (int)$account['id'];
    $_SESSION['group'] = $account['usr_grp'];
    $_SESSION['USERNAME'] = $account['vorname'].' '. $account['nachname'];

    $app->flash('success', _('Login erfolgreich'));
    $app->redirect('/');
})->name('doLogin');

// fuehrt den logout des benutzers durch
$app->get('/logout', function () use ($app) {
    $_SESSION = array();
    session_destroy();

    $app->flash('success', _('Abmelden erfolgreich'));
    $app->redirect('/login');
})->name('doLogout');

