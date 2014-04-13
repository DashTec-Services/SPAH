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
session_start();
include_once '../core/password/password.php';
include_once '../core/DB.php';

if(!isset($_SESSION['cryptpass'])){
    $passw = new \core\password\password();
    $pass = $passw->generatePassword();
    $cryptpass = $passw->createPassword($pass);
    $_SESSION['pass'] = $pass;
   $_SESSION['cryptpass'] = $cryptpass;
}


if (isset($_POST['finsih'])){


    $_SESSION['dbname'] = $_POST['dbname'];
    $_SESSION['dbuser'] = $_POST['dbuser'];
    $_SESSION['dbpass'] = $_POST['dbpass'];

    $_SESSION['serverip'] = $_POST['serverip'];
    $_SESSION['sshuser'] = $_POST['sshuser'];
    $_SESSION['sshpass'] = $_POST['sshpass'];
    $_SESSION['ssh_port'] = $_POST['ssh_port'];
    $_SESSION['serverdocroot'] = $_POST['serverdocroot'];

    $_SESSION['adminvname'] = $_POST['adminvname'];
    $_SESSION['adminnname'] = $_POST['adminnname'];

    $_SESSION['adminstreet'] = $_POST['adminstreet'];
    $_SESSION['hnum'] = $_POST['hnum'];
    $_SESSION['adminzip'] = $_POST['adminzip'];
    $_SESSION['admintown'] = $_POST['admintown'];
    $_SESSION['adminphone'] = $_POST['adminphone'];
    $_SESSION['adminmail'] = $_POST['adminmail'];

    $_SESSION['local'] = $_POST['local'];

    DB::$user = $_SESSION['dbuser'];
    DB::$password = $_SESSION['dbpass'];
    DB::$dbName = $_SESSION['dbname'];
    DB::$host = 'localhost';
    DB::$port = '3306';
    DB::$encoding = 'utf8';


$sql_filename = 'mysql.sql';
$mysqli = new mysqli('localhost', $_SESSION['dbuser'], $_SESSION['dbpass'], $_SESSION['dbname']);

if (mysqli_connect_error()) {
    die('Connect Error (' . mysqli_connect_errno() . ') '
        . mysqli_connect_error());
}


$sql = file_get_contents($sql_filename);
if (!$sql){
    die ('Error opening file');
}

mysqli_multi_query($mysqli,$sql);

    DB::insert('config', array(
        'server_ip' => $_SESSION['serverip'],
        'adminMail' => $_SESSION['adminmail'],
        'root_user' => $_SESSION['sshuser'],
        'root_password' => $_SESSION['sshpass'],
        'ssh_port' => $_SESSION['ssh_port'],
        'doc_root' => $_SESSION['serverdocroot'],
        'default_local' => $_SESSION['local'],
        'sp_titel' => 'S:P fresh install'
    ));

    DB::insert('accounts', array(
        'kundennummer' => 'spadmin',
        'mail' => $_SESSION['adminmail'],
        'vorname' => $_SESSION['adminvname'],
        'nachname' => $_SESSION['adminnname'],
        'street' => $_SESSION['adminstreet'],
        'hausnummer' => $_SESSION['hnum'],
        'plz' => $_SESSION['adminzip'],
        'telefon' => $_SESSION['adminphone'],
        'ort' => $_SESSION['admintown'],
        'password' => $_SESSION['cryptpass'],
        'local' => $_SESSION['local'],
        'is_aktiv' => '1',
        'usr_grp' => 'adm'
    ));

$mysqli->close();

    $file = "../index.php";
    $content = file_get_contents($file);
    $content = str_replace('@DBUSER@', $_SESSION['dbuser'], $content);
    $content = str_replace('@DBPASS@', $_POST['dbpass'], $content);
    $content = str_replace('@DBNAME@', $_SESSION['dbname'], $content);
    $content = str_replace('@DEMOMOD@', $_POST['demoMod'], $content);
    file_put_contents($file, $content);


$_SESSION['Setup_Done'] = true;


}

if($_SESSION['Setup_Done'] == true){
    session_unset();
    session_destroy();
	
	    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/");
    exit;
}










?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= _('S:P Installation') ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <!-- Styles -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/bootstrap-responsive.css" rel="stylesheet">
    <link href="../css/bootstrap-overrides.css" rel="stylesheet">

    <link href="../css/ui-lightness/jquery-ui-1.8.21.custom.css" rel="stylesheet">
    <link href="../js/plugins/smartwizard/smart_wizard.modified.css" rel="stylesheet">

    <link href="../css/slate.css" rel="stylesheet">
    <link href="../css/slate-responsive.css" rel="stylesheet">


    <!-- Javascript -->
    <script src="../js/jquery-1.7.2.min.js"></script>
    <script src="../js/jquery-ui-1.8.21.custom.min.js"></script>
    <script src="../js/jquery.ui.touch-punch.min.js"></script>
    <script src="../js/bootstrap.js"></script>

    <script src="../js/plugins/smartwizard/jquery.smartWizard-2.0.modified.js"></script>

    <script src="../js/Slate.js"></script>

    <script src="../js/demos/demo.wizard.js"></script>


    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->


</head>

<body>


<div id="header">

    <div class="container">

        <h1><a href="./install.php"><?= _('S:P Installation') ?></a></h1>

        <div id="info">

            <a href="javascript:;" id="info-trigger">
                <i class="icon-cog"></i>
            </a>

            <div id="info-menu">

                <div class="info-details">

                    <h4><?= _('S:P Installation') ?></h4>

                </div> <!-- /.info-details -->

            </div> <!-- /#info-menu -->

        </div> <!-- /#info -->

    </div> <!-- /.container -->

</div> <!-- /#header -->


<div id="nav">

    <div class="container">


    </div> <!-- /.container -->

</div> <!-- /#nav -->


<div id="content">

<div class="container">

<div class="row">

<div class="span12">

<div class="widget">

<div class="widget-header">
    <h3>
        <i class="icon-magic"></i>
        Wizard
    </h3>
</div> <!-- /widget-header -->

<div class="widget-content">



<form action="./install.php" method="POST" class="form-horizontal">

<div id="wizard" class="swMain">

<ul class="wizard-steps">
    <li>
        <a href="#step-1" class="">
            <div class="wizard-step-number">1</div>
            <div class="wizard-step-label"><?= _('MySql Daten') ?></div>
            <div class="wizard-step-bar"></div>
        </a>
    </li>
    <li>
        <a href="#step-2" class="">
            <div class="wizard-step-number">2</div>
            <div class="wizard-step-label"><?= _('SSH Daten') ?></div>
            <div class="wizard-step-bar"></div>
        </a>
    </li>
    <li>
        <a href="#step-3" class="">
            <div class="wizard-step-number">3</div>
            <div class="wizard-step-label"><?= _('Benutzer Daten') ?></div>
            <div class="wizard-step-bar"></div>
        </a>
    </li>
    <li>
        <a href="#step-4" class="">
            <div class="wizard-step-number">4</div>
            <div class="wizard-step-label"><?= _('Konfiguration') ?></div>
            <div class="wizard-step-bar"></div>
        </a>
    </li>
</ul>

<div id="step-1">

    <h3><?= _('MySql Konfiguration') ?></h3>


    <br />


    <div class="row-fluid">

        <div class="span6">

            <div class="control-group">
                <label class="control-label" for="dbname"><?= _('DB Name') ?></label>
                <div class="controls">
                    <input type="text" class="input-medium" id="bizname" name="dbname" value="<?php if(isset($_SESSION['dbname'])){ echo $_SESSION['dbname'];} ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="dbuser"><?= _('DB Benutzer') ?></label>
                <div class="controls">
                    <input type="text" class="input-large" id="bizemail" name="dbuser" value="<?php if(isset($_SESSION['dbuser'])){ echo $_SESSION['dbuser'];} ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="dbpass"><?= _('DB Passwort') ?></label>
                <div class="controls">
                    <input type="text" class="input-large" id="bizaddress1" name="dbpass" value="<?php if(isset($_SESSION['dbpass'])){ echo $_SESSION['dbpass'];} ?>">
                </div>
            </div>

        </div> <!-- /span6 -->

        <div class="span5 offset1">

            <div class="well">
                <?php

                echo _('Systemanforderungen') .'<br>';
                $rights = substr(sprintf('%o', fileperms('../shoutcast')), -3);

                if (version_compare(phpversion(), '5.5', '<')) {
                    echo 'Sie benutzen PHP: ' . phpversion() .'<b> ein UPDATE IST erforderlich!</b>';
                }else{
                   # echo 'Sie benutzen PHP: ' . phpversion() .'<b>!</b>';
                }


                if (function_exists('curl_version')) {
                   # echo '<p class="message success">'._('<b>"cURL"</b> wurde gefunden').'</p>';
                } else {
                    echo '<p class="message error">'._('<b>"cURL"</b> wurde nicht gefunden!').'</p>';
                }


                if ($rights == '777') {
                    #echo '<p class="message success">'._('Ordner <b>"shoutcast"</b> besitzt die erforderlichen Rechte').'</p>';
                } else {
                    echo '<p class="message error">'._('Ordner <b>"shoutcast"</b> besitzt <b>NICHT</b> die erforderlichen Rechte').'</p>';
                }

                if (extension_loaded('ssh2')) {
                   # echo '<p class="message success">'._('Erweiterung: <b>"ssh2"</b> gefunden').'</p>';
                } else {
                    echo '<p class="message error">'._('Erweiterung: <b>"ssh2" - NICHT</b> gefunden').'</p>';
                }

                if (extension_loaded('mysql')) {
                  #  echo '<p class="message success">'._('Erweiterung: <b>"MySql"</b> gefunden ').'</p>';
                } else {
                    echo '<p class="message error">'._('Erweiterung: <b>"MySql" - NICHT</b> gefunden ').'</p>';
                }

                if (extension_loaded('safe_mode')) {
                    echo '<p class="message error">'._('Erweiterung: <b>"safe_mode" - NICHT</b> ist ON').'</p>';
                } else {
                  #  echo '<p class="message success">'._('Erweiterung: <b>"safe_mode"</b> is OFF! ').'</p>';
                }



                if ($rights == '777' AND !extension_loaded('safe_mode') AND extension_loaded('mysql') && extension_loaded('ssh2') && $rights == '777' ){
                    echo '<a href="st2.php"><button type="button" name="step2">'._('Schritt 2').'</button></a>';
                    $_SESSION['step1'] = 'true';
                }else{
                    echo '<p class="message error">'._('Es müssen alle Überprüfungen bestanden werden!!').'</p>';
                }

                ?>
            </div>

        </div> <!-- /span6 -->


    </div> <!-- /row-fluid -->

</div> <!-- /step -->



<div id="step-2">

    <h3><?= _('Profil - Einstellungen')?></h3>

    <br />


    <div class="row-fluid">

        <div class="span6">



            <div class="control-group">
                <label class="control-label" for="serverip"><?= _('Server IP') ?></label>
                <div class="controls">
                    <input class="input-medium" id="serverip" name="serverip" value="<?php if(isset($_SESSION['serverip'])){ echo $_SESSION['serverip'];}else{ echo  $_SERVER['SERVER_ADDR'];} ?>" >
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="sshuser"><?= _('ssh Benutzer') ?></label>
                <div class="controls">
                    <input class="input-large" id="sshuser"  name="sshuser" value="<?php if(isset($_SESSION['sshuser'])){ echo $_SESSION['sshuser'];} ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="sshpass"><?= _('ssh Passwort') ?></label>
                <div class="controls">
                    <input class="input-large" id="sshpass" name="sshpass" value="<?php if(isset($_SESSION['sshpass'])){ echo $_SESSION['sshpass'];} ?>" >
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="ssh_port"><?= _('ssh_port') ?></label>
                <div class="controls">
                    <input class="input-large" id="ssh_port" name="ssh_port" value="<?php if(isset($_SESSION['ssh_port'])){ echo $_SESSION['ssh_port'];} else{ echo '22';}?>" >
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="ssh_port"><?= _('Server_doc_root') ?></label>
                <div class="controls">
                    <input class="input-large" id="ssh_port" name="serverdocroot" value="<?php if(isset($_SESSION['serverdocroot'])){ echo $_SESSION['serverdocroot'];} else{ echo $_SERVER['DOCUMENT_ROOT'];}?>" >
                </div>
            </div>




        </div> <!-- /span6 -->

        <div class="span5 offset1">


            <div class="well">
<p><?= _('ssh Daten') ?></p>

            </div>



        </div> <!-- /span6 -->


    </div> <!-- /row-fluid -->


</div> <!-- /step -->

<div id="step-3">

    <h3><?= _('Benutzer Daten') ?></h3>

    <br />

    <div class="row-fluid">

        <div class="span6">

            <br />

            <div class="control-group">
                <label class="control-label" for="adminvname"><?= _('Vorname') ?></label>
                <div class="controls">
                    <input type="text" class="input-medium" id="adminvname" name="adminvname" value="<?php if(isset($_SESSION['adminvname'])){ echo $_SESSION['adminvname'];} ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="adminnname"><?= _('Nachname') ?></label>
                <div class="controls">
                    <input type="text" class="input-medium" id="adminnname" name="adminnname" value="<?php if(isset($_SESSION['adminnname'])){ echo $_SESSION['adminnname'];} ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="adminstreet"><?= _('Straße') ?></label>
                <div class="controls">
                    <input type="text" class="input-medium" id="adminstreet" name="adminstreet" value="<?php if(isset($_SESSION['adminstreet'])){ echo $_SESSION['adminstreet'];} ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="hnum"><?= _('Hausnummer') ?></label>
                <div class="controls">
                    <input type="text" class="input-medium" id="hnum" name="hnum" value="<?php if(isset($_SESSION['hnum'])){ echo $_SESSION['hnum'];} ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="adminzip"><?= _('PLZ') ?></label>
                <div class="controls">
                    <input type="text" class="input-large" id="adminzip" name="adminzip" value="<?php if(isset($_SESSION['adminzip'])){ echo $_SESSION['adminzip'];} ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="admintown"><?= _('Ort') ?></label>
                <div class="controls">
                    <input type="text" class="input-large" id="admintown" name="admintown" value="<?php if(isset($_SESSION['admintown'])){ echo $_SESSION['admintown'];} ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="adminphone"><?= _('Tel') ?></label>
                <div class="controls">
                    <input type="text" class="input-large" id="adminphone" name="adminphone" value="<?php if(isset($_SESSION['adminphone'])){ echo $_SESSION['adminphone'];} ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="adminmail"><?= _('Mail') ?></label>
                <div class="controls">
                    <input type="text" class="input-large" id="adminmail" name="adminmail" value="<?php if(isset($_SESSION['adminmail'])){ echo $_SESSION['adminmail'];} ?>">
                </div>
            </div>

        </div> <!-- /span6 -->

        <div class="span5 offset1">




            <div class="well">


                </div>

        </div> <!-- /span6 -->


    </div> <!-- /row-fluid -->


</div> <!-- /step -->

<div id="step-4">

    <h3><?= _('Komplett') ?></h3>

    <br />


    <div class="row-fluid">

        <div class="span6">
<p><?= _('Admin - Benutzer') ?>: spadmin
    <br>
    <?= _('Admin - Passwort') ?>:  <?= $_SESSION['pass']; ?></p>
            <br />

            <div class="control-group">
                <label class="control-label" for="loacal"><?= _('Bitte wählen Sie Ihre Sprache') ?></label>
                <div class="controls">
                    <select name="local" size="1">
                        <option selected value="de_DE"><?= _('Bitte wählen Sie Ihre Sprache') ?></option>
                        <option value="de_DE"><?= _('Deutsch'); ?></option>
                        <option value="en_US"><?= _('Englisch'); ?></option>
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="loacal"><?= _('Demo-Modus') ?></label>
                <div class="controls">
                    <select name="demoMod" size="1">
                        <option value="false"><?= _('Nein'); ?></option>
                        <option value="true"><?= _('Ja'); ?></option>
                    </select>
                </div>
            </div>


            <div class="alert alert-error">
                <h4 class="alert-heading"><?= _('Warnung') ?></h4>
                <p><?= _('Der Ordner install ist noch vorhanden!') ?></p>
            </div> <!-- ./alert -->



            <button class="btn btn-primary btn-large" name="finsih" ><?= _('Fertig') ?></button>



        </div> <!-- /span6 -->


    </div> <!-- /row-fluid -->

</div> <!-- /step -->




</div> <!-- /wizard -->

</form>


</div> <!-- /widget-content -->

</div> <!-- /widget -->

</div> <!-- /.span12 -->



</div> <!-- /row -->




</div> <!-- /.container -->

</div> <!-- /#content -->


<div id="footer">
    <div class="container">

        &copy;  <a href="http://board.streamerspanel.com/">board.streamerspanel.com</a>
        <small>   &raquo; <a href="http://changelog.streamerspanel.com/" target="_blank">Changelog</a></small>

        <br />

        <span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">StreamersPanel</span> von
        <a xmlns:cc="http://creativecommons.org/ns#" href="http://board.streamerspanel.de" property="cc:attributionName" rel="cc:attributionURL">
            David Schomburg</a> ist lizenziert unter einer

        <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/">
            Creative Commons Namensnennung - Nicht kommerziell - Keine Bearbeitungen 4.0 International Lizenz</a>.

    </div> <!-- /.container -->

</div> <!-- /#footer -->




</body>
</html>
