<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 17.04.14
 * Time: 23:42
 */


class upgrade
{

    protected $sp_version= "0.35";
    protected $impoPHPv = '5.5';
    protected $impoMods = array('date','json', 'ssh2', 'curl', 'mcrypt','json');
    protected $versions = array(
        '035'    => '0.35',
    );

    public function __construct($app)
    {
        # Check Requirements      >>>>> IF FAIL STOP AND SHOW ERROR
        $this->compareRequiremendCheck($app);
        if ( $this->compareRequiremendCheck($app) == true){
            $this->ShowErrorToUser();
            die();
        }

        # Prüfen ob DB Verbindung besteht !NOT makeInstall


            # Prüfung ob Verbindung zur DB möglich!
        $mysqli = @mysqli_connect('localhost', $app->config('db.user'), $app->config('db.password'), $app->config('db.name'));
        if(!$mysqli){
            $action = 'install';
        }else{
            $action = 'upgrade';
        }







        # Check SP-Version

        #var_dump($this->CheckUpgradePossible($app));

    }

    /*
     *      Prüfung ob ein Upgrade möglich ist!
     */
    protected function CheckUpgradePossible($app){


        # Vergleiche InstallVersion mit DB WENN CONN





        # Aktuelle Installer Version
        $DB_SP_Version = DB::queryFirstRow("SELECT sp_version FROM config WHERE id=%s", '1');
        if($app->config('sp.version') < $this->sp_version AND $DB_SP_Version['sp_version'] < $this->sp_version){
           $upgrade = true;

       }else{
           $upgrade = false;
       }

        return $upgrade;
    } # true or false


/*
 *      return $stop if Error
 */
    protected function ShowErrorToUser(){
        if (is_array($this->compareRequiremendCheck()) AND in_array("PHP", $this->compareRequiremendCheck())){
            echo '<h1 style="color: red"><b>'. _('Sie verwenden die falsche PHP Version! Installation nicht möglich!') .'</b></h1>';
            echo '<p>'._('Es wird PHP-Version: ').$this->impoPHPv ._(' benötigt')._(' Sie verwenden: '). phpversion().'</p>';
        }

        if (is_array($this->compareRequiremendCheck()) AND in_array("MOD", $this->compareRequiremendCheck())){
            echo '<h1 style="color: red"><b>'. _('Wichtige PHP-Module wurden nicht gefunden! Installation nicht möglich!') .'</b></h1>';
            echo '<p>'._('Es konnten folgende Module nicht gefunden werden!').'</p>';
            $allMods = get_loaded_extensions();
            $result = array_diff($this->impoMods, $allMods);
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
        $result = array_diff($this->impoMods, $allMods);
        $NotOnSystem = false;
        foreach($result as $wert => $key){
           $NotOnSystem[] = $key;
        }
        return $NotOnSystem;
    }

    protected function checkPHPVersion(){
        $return = false;
        if (version_compare(phpversion(), $this->impoPHPv, '<')) {
            $return = phpversion();
        }
        return $return;
    }

    protected function getServConf($parm){
        $test = \DB::queryFirstRow("SELECT * FROM config WHERE id=%s", '1');
        return $test[$parm];
    }

    public function showRequiredMods(){
        return $this->impoMods;
    }

    public function showRequiredPHPv(){
        return $this->impoPHPv;
    }

}