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

class class_upgrade extends installer {




    public function __construct($app){


        #   1. Prüfung ob Upgrade machbar ist
        $this->CheckUpgradeVersions($app) ?    : die() ;



    }



    public function doUpgrade($ALL_VERSIONS, $Last_Version){
    #   2. Laden der akktuellen Klasse und einlesen der $VAR
    $key = array_search($this->getServConf('sp_version'), $ALL_VERSIONS);
    $classname = 'class_upgrade_'.$key.'.php';
    $classname_Oext = 'class_upgrade_'.$key;
    include_once $classname;

    # Initil Class
    $aktuKlass = new $classname_Oext;

    if ($aktuKlass->NEXT_LONG_VERSION == $Last_Version){
        $key = $aktuKlass->NEXT_SHORT_VERSION;
        require_once 'class_upgrade_'.$key.'.php';
        $classname = 'class_upgrade_'.$key;
        ${'class'.$key} = new $classname();
        #print_r(${'class'.$key});
        $aktu_steps = ${'class'.$key}->UPGRADE_STEPS;
        # Alle Steps aus der Klasse ausführen!

        while($aktu_steps > 0){

            $aktueller_step = 'step_'.$aktu_steps;

            ${'class'.$key}->$aktueller_step(); echo '<br>';

            $aktu_steps--;
        }
    }else{

        $returner = $this->getAllUpgradeVersionsToDo($ALL_VERSIONS, $Last_Version);


        foreach($returner['All_short_version'] as $vale => $key){


            $filename = __DIR__.'/class_upgrade_'.$key.'.php';
            if (file_exists($filename)){
                require_once 'class_upgrade_'.$key.'.php';
                $classname = 'class_upgrade_'.$key;
                ${'class'.$key} = new $classname();
                #print_r(${'class'.$key});
                $aktu_steps = ${'class'.$key}->UPGRADE_STEPS;
                # Alle Steps aus der Klasse ausführen!

                while($aktu_steps > 0){

                    $aktueller_step = 'step_'.$aktu_steps;

                    ${'class'.$key}->$aktueller_step(); echo '<br>';

                    $aktu_steps--;
                }

            }else{
                die('Wichtige Upgrade-Klasse fehlt!');
            }




        }
    }
}



/*
 *
 */
    public  function getAllUpgradeVersionsToDo ($ALL_VERSIONS, $Last_Version){
    $key = array_search($this->getServConf('sp_version'), $ALL_VERSIONS);
    $classname = 'class_upgrade_'.$key.'.php';
    $classname_Oext = 'class_upgrade_'.$key;
    include_once $classname;

    $class = new $classname_Oext;

    $next_long_version = $class->NEXT_LONG_VERSION;
    $next_short_version = $class->NEXT_SHORT_VERSION;

    $All_short_version ='';
    $All_long_version ='';
    $All_Steps= '';
    $All_short_version[] = $next_short_version;
    $All_long_version[] = $next_long_version;
    $All_Steps[]= $class->UPGRADE_STEPS;
    while ($next_long_version != $Last_Version)
    {
        $classname = 'class_upgrade_'.$next_short_version.'.php';
        $classname_Oext = 'class_upgrade_'.$next_short_version;
        include_once $classname;
        $class = new $classname_Oext;
        $next_short_version = $class->NEXT_SHORT_VERSION;
        $next_long_version = $class->NEXT_LONG_VERSION;
        $All_short_version[] = $next_short_version;
        $All_long_version[] = $next_long_version;
        $All_Steps[]= $class->UPGRADE_STEPS;
    }

    $returner = '';
    $returner['All_short_version'] = $All_short_version;
    $returner['All_long_version'] = $All_long_version;
    $returner['All_Steps'] = $All_Steps;

    return $returner;
}


/*      Prüfen ob Upgrade notwendig ist und vorhandene Versionen (DB / Conf gleich sind)
 *      @ boolen
 */
    protected function CheckUpgradeVersions($app){

        #   1
        # Letztes verfügbares Upgrade
        $lastUpdate = array_pop(installer::$versions);

        # Installierte Verison
        # InstalledDB_Version
        $installedVersionDB = $this->getServConf('sp_version');

        # Installed Conf_Version
        $installedVersionConf = $app->config('sp.version');

        #
        if($installedVersionConf == $installedVersionDB AND $installedVersionDB < $lastUpdate){

            return true;
        }else{
            if($installedVersionConf != $installedVersionDB){
                die(_('Die Version in der Konfiguration stimmt nicht mit der DB überein! Bitte Neuinstallation durchführen!'));
            }

            if($installedVersionDB >= $lastUpdate){
                die(_('Sie verwenden bereits die aktuelle Version! Upgrade nicht möglich!'));
            }
            return false;
        }




    }

/*
 *      Prüfung ob ein Upgrade möglich ist!
 */
    protected function CheckUpgradePossible($app){


        # Vergleiche InstallVersion mit DB WENN CONN


        # Aktuelle Installer Version
        $DB_SP_Version = DB::queryFirstRow("SELECT sp_version FROM config WHERE id=%s", '1');
        if($app->config('sp.version') < installer::$sp_version AND $DB_SP_Version['sp_version'] < installer::$sp_version){
            $upgrade = true;

        }else{
            $upgrade = false;
        }

        return $upgrade;
    } # true or false


    public function getUpdateVersion(){
        return installer::$sp_version;
    }


    public function getCountedSteps($ALL_VERSIONS, $LAST_VERSION){

        $retuned = $this->getAllUpgradeVersionsToDo($ALL_VERSIONS, $LAST_VERSION);

        return $retuned;
    }


}

