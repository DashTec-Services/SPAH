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

class installer
{

    /*
     *              !!!!!!!!!!!! DO NOT CHANGE BEHIND THIS LINE             !!!!!!!!!!!!
     *              !!!!!!!!!!!! BITTE KEINE ÄNDERUNGEN NACH DIESER ZEILE   !!!!!!!!!!!!
     *
     */
    static  $sp_version= "v 0.37";
    static  $install_sp_version_long = "0.37";
    static  $impoPHPv = '5.5';
    static  $impoMods = array('date','json', 'ssh2', 'curl', 'mcrypt','json','gettext');
    static  $versions = array(
        '035'    => '0.35',
        '036'    => '0.36',
        #'037'    => '0.37',
    );

    /*      RELEASE Was ist zu tun?
     *  1. Suche und ersetze alle Version n z.B v 0.37
     *  2. In der _conf.php die Version von Hand anpassen
     *  3. In dieser Datei $sp_version und $install_sp_version_long anpassen
     *  4. Router -> authentication.php Zeile 23 Einkommentieren
     *
     */


    public function __construct($app)
    {

        # Check Requirements      >>>>>     IF FAIL STOP AND SHOW ERROR
        $this->compareRequiremendCheck($app);
        if ( $this->compareRequiremendCheck($app) == true){
            $this->ShowErrorToUser();
            die();
        }


        # Prüfen ob DB Verbindung besteht !NOT makeInstall

        if($app == false){
            include_once dirname(__FILE__).'/../init_install.php';
        }else{
            if($this->CheckDBConnect($app) == true AND isset($app) != false){
                include_once dirname(__FILE__).'/../init_upgrade.php';
            }else{
                include_once dirname(__FILE__).'/../init_install.php';
            }
        }
    }


/*
 *      return $stop if Error
 */
    protected function ShowErrorToUser(){
        if (is_array($this->compareRequiremendCheck()) AND in_array("PHP", $this->compareRequiremendCheck())){
            echo '<h1 style="color: red"><b>'. _('Sie verwenden die falsche PHP Version! Installation nicht möglich!') .'</b></h1>';
            echo '<p>'._('Es wird PHP-Version: '). installer::$impoPHPv ._(' benötigt!')._(' Sie verwenden: '). phpversion().'</p>';
        }

        if (is_array($this->compareRequiremendCheck()) AND in_array("MOD", $this->compareRequiremendCheck())){
            echo '<h1 style="color: red"><b>'. _('Wichtige PHP-Module wurden nicht gefunden! Installation nicht möglich!') .'</b></h1>';
            echo '<p>'._('Es konnten folgende Module nicht gefunden werden!').'</p>';
            $allMods = get_loaded_extensions();
            $result = array_diff(installer::$impoMods, $allMods);
            foreach($result as $wert => $key){
                echo '>> <b>'.$key . '</b><br>';
            }
        }
    }

    protected function compareRequiremendCheck(){
       $error = false;
        # PHP Check
        if ($this->checkPHPVersion() == true){
            $error[] = 'PHP';
        }

        # Check Reqirements
        if ($this->checkSystemRequiremend() == true){
            $error[] = 'MOD';
        }

        return $error;
    }

    protected function checkSystemRequiremend(){
        # PHP Module und Extensions Prüfen
        $allMods = get_loaded_extensions();
        $result = array_diff(installer::$impoMods, $allMods);
        $NotOnSystem = false;
        foreach($result as $wert => $key){
           $NotOnSystem[] = $key;
        }
        return $NotOnSystem;
    }

    public function CheckDBConnect($app){
        $mysqli = @mysqli_connect('localhost', $app->config('db.user'), $app->config('db.password'), $app->config('db.name'));
        if(!$mysqli){
            $action = false;
        }else{
            $action = true;
        }

        return $action;
    }

    protected function checkPHPVersion(){
        $return = false;
        if (version_compare(phpversion(), installer::$impoPHPv, '<')) {
            $return = phpversion();
        }
        return $return;
    }

    protected function getServConf($parm){
        $test = \DB::queryFirstRow("SELECT * FROM config WHERE id=%s", '1');
       $returnit = $test[$parm];
        return $returnit;
    }

}