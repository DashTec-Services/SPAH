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
class install {

    public $dirFolder = './shoutcast';
    public $dirPermissions = '0775';
    public $filePermissions = '0777';


   public function __construct(){

       # Alle Rechte von Ordnern und Dateien testen
       $this->CompareFolderandFileCheck();

   }

    public function CompareFolderandFileCheck(){


        if($this->CheckFolderPerms() != '0775'){
            die(_('<b>Ordner "shoutcast" besitzt nicht die erforderlichen Rechte! -> 775</b>'));
        }


        $allPermis = array_unique($this->CheckFilePerms());
        $counts = array_count_values($allPermis);
        $counter = count($allPermis);
        if ($allPermis['0'] == "777" AND $counter == 1 ){
        }else{
            die(_('<b>Fehler bei den Dateirechten! (Dateien im Ordner "shoutcast")</b> bitte Rechte 777 setzen!'));
        }

    }


    public function CheckFilePerms(){
        function getFilePermission($file) {
            $length = strlen(decoct(fileperms($file)))-3;
            return substr(decoct(fileperms($file)),$length);
        }
        $ordner=opendir("shoutcast/");
        $fileperms = '';
        while(($datei=readdir($ordner))!=false) {
            if($datei!="." && $datei!="..") {
               $fileperms[] = getFilePermission('./shoutcast/'.$datei);
            } }
        return $fileperms;
    }


    public function CheckFolderPerms(){
        $rights = substr(sprintf('%o', fileperms($this->dirFolder)), -4);

        return $rights;
    }

    public function insertMySqlSchema($DBUSER, $DBPASS, $DBNAME){
        $sql_filename = dirname(__FILE__).'/../mysql-schema.sql';
        $mysqli = new mysqli('localhost', $DBUSER, $DBPASS, $DBNAME);

        if (mysqli_connect_error()) {
            die('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
        }

        $sql = file_get_contents($sql_filename);
        if (!$sql){
            die ('Error opening file');
        }
        mysqli_multi_query($mysqli,$sql);
    }

    public function insertDataToDB($postVar){


        $this->insertMySqlSchema($postVar['dbuser'], $postVar['dbpass'],$postVar['dbname']);


        DB::$user = $postVar['dbuser'];
        DB::$password = $postVar['dbpass'];
        DB::$dbName = $postVar['dbname'];
        DB::$host = $postVar['dbhost'];
        DB::$port = $postVar['dbport'];
        DB::$encoding = $postVar['encoding'];

        DB::insert('accounts', array(
            'kundennummer' => 'spadmin',
            'mail' => $postVar['adminmail'],
            'vorname' => $postVar['adminvname'],
            'nachname' => $postVar['adminnname'],
            'street' => $postVar['adminstreet'],
            'hausnummer' => $postVar['hnum'],
            'plz' => $postVar['adminzip'],
            'telefon' => $postVar['adminphone'],
            'ort' => $postVar['admintown'],
            'password' => $_SESSION['cryptpass'],
            'local' => $postVar['local'],
            'is_aktiv' => '1',
            'usr_grp' => 'adm'
        ));

        DB::insert('config', array(
            'server_ip' => $postVar['serverip'],
            'adminMail' => $postVar['adminmail'],
            'root_user' => $postVar['sshuser'],
            'root_password' => $postVar['sshpass'],
            'ssh_port' => $postVar['ssh_port'],
            'doc_root' => $postVar['serverdocroot'],
            'default_local' => $postVar['local'],
            'sp_titel' => 'S:P fresh install',
            'sp_version' => installer::$install_sp_version_long
        ));

        $_SESSION['installDone'] = true;

        $this->replaceString($postVar['dbuser'], $postVar['dbpass'], $postVar['dbname'],  $postVar['demoMod']);
    }


    public function replaceString($DBUSER, $DBPASS, $DBNAME, $DEMOMOD){


        $file = __DIR__."/../../_conf.php";

        $content = file_get_contents($file);
        $content = str_replace('@DBUSER@', $DBUSER, $content);
        $content = str_replace('@DBPASS@', $DBPASS, $content);
        $content = str_replace('@DBNAME@', $DBNAME, $content);
        $content = str_replace('@DEMOMOD@', $DEMOMOD, $content);
        file_put_contents($file, $content);
        rename($file,"conf.php");

    }







} 