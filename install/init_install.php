<?php
/**
 * Created by David Schomburg (DashTec - Services)
 *      www.dashtec.de
 *
 *  S:P (StreamersPanel)
 *  Support: http://board.streamerspanel.de
 *
 *  v 0.36
 *
 *  Kundennummer:   @KDNUM@
 *  Lizenznummer:   @RECHNR@
 *  Lizenz: http://login.streamerspanel.de/user/terms
 */

include_once 'upgrade/class_install.php';
include_once 'upgrade/class_installer.php';
include_once './core/password/password.php';
include_once './core/DB.php';


$installer = new install();

if(!isset($_SESSION['pass'])){
    $passw = new \core\password\password();
    $pass = $passw->generatePassword();
    $cryptpass = $passw->createPassword($pass);
    $_SESSION['pass'] = $pass;
    $_SESSION['cryptpass'] = $cryptpass;
}

if (isset($_POST['finsih'])){
    $installer->insertDataToDB($_POST, $_SESSION['cryptpass']);
}
if (isset($_SESSION['installDone']) == false){
include_once 'install_view.phtml';
}else{
    session_unset();
    session_destroy();
    header("Location: ../");
}