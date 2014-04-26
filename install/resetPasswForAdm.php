<?php
/**
 * Created by David Schomburg (DashTec - Services)
 *      www.dashtec.de
 *
 *  S:P (StreamersPanel)
 *  Support: http://board.streamerspanel.de
 *
 *  v 0.37
 *
 *  Kundennummer:   @KDNUM@
 *  Lizenznummer:   @RECHNR@
 *  Lizenz: http://login.streamerspanel.de/user/terms
 */
// ######################## SET PHP ENVIRONMENT ###########################
error_reporting(E_ALL & ~E_NOTICE);
chdir('./../');
session_start();
// ##################### DEFINE IMPORTANT CONSTANTS #######################
define('SP_AREA', 'Install');
define('TIMENOW', time());

header("Content-Type: text/html; charset=utf-8");
header('Expires: ' . gmdate("D, d M Y H:i:s", TIMENOW) . ' GMT');
header("Last-Modified: " . gmdate("D, d M Y H:i:s", TIMENOW) . ' GMT');

if(file_exists(dirname(dirname(__FILE__)).'/conf.php')){
    include_once 'index.php'; # Laden der Framework-Konfiguration
    include_once './core/password/password.php';
    include_once './core/DB.php';
}else{
die('Benötigte Dateien nicht vorhanden!');
}

$newPass = new \core\password\password();
$createdPass = $newPass->generatePassword(7);
$cryptedPass = $newPass->createPassword($createdPass);

?>
<h1 style="color: red"><b>Das neue Passwort:  <?= $createdPass ?></b></h1>
<?php

    DB::update('accounts', array(
        'password' => $cryptedPass
    ), "id=%s", '1');





