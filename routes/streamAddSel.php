<?php
/**
 * Created by David Schomburg (DashTec - Services)
 *      www.dashtec.de
 *
 *  S:P (StreamersPanel)
 *  Support: http://board.streamerspanel.de
 *
 *  v 0.33
 *
 *  Kundennummer:   @KDNUM@
 *  Lizenznummer:   @RECHNR@
 *  Lizenz: http://login.streamerspanel.de/user/terms
 */

$app->get('/station/add', function() use ($app){
    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $app->render('streamAddSelct/streamswitch.phtml', compact('license'));

    # Demoeinstellungen
    $demo = new \core\demo\demomod();
    $demo->CheckDemo($_SESSION['demo_mod']);

})->name('license');

$app->post('/station/add', function() use ($app){

    /*
     *              SC_Serv
     *          id          sc_Version
     *          1           1.9.8
     *          2           2
     *          5           1.9.9
     */
if(isset($_POST['addstreamswitch'])){
    // Session ID der Stream-Version speichern
    $_SESSION['streamID'] = $_POST['addstreamswitch'];

   if($_POST['addstreamswitch'] == '3'){
       $SPMenu = new SP\Menu\MenuInclusion();
       $SPMenu->MenuInclude($app);
       $app->render('streamAddSelct/sc20.phtml', compact('license'));
       $_SESSION['sc_serv_version'] =  $_POST['addstreamswitch'];

       # Demoeinstellungen
       $demo = new \core\demo\demomod();
       $demo->CheckDemo($_SESSION['demo_mod']);

   }elseif($_POST['addstreamswitch'] == '1' OR $_POST['addstreamswitch'] == '2'){
       $SPMenu = new SP\Menu\MenuInclusion();
       $SPMenu->MenuInclude($app);
       $app->render('streamAddSelct/sc198.phtml', compact('license'));
       $_SESSION['sc_serv_version'] =  $_POST['addstreamswitch'];
       # Demoeinstellungen
       $demo = new \core\demo\demomod();
       $demo->CheckDemo($_SESSION['demo_mod']);
   }else{
       $SPMenu = new SP\Menu\MenuInclusion();
       $SPMenu->MenuInclude($app);
       $app->render('station/adminshowlist.phtml', compact('license'));
   }
}

# Server hinzufügen
if (isset($_POST['addsrv']) AND $_SESSION['demo_mod'] == false) {

    $config = DB::queryFirstRow("SELECT doc_root FROM config WHERE id=%s", '1');
    $DocRoot = $config['doc_root'];

    $serverPort = $_POST['PortBase'];

    $form = new \core\postget\postgetcoll();
    $formData = $form->collvars('POST');

    $FolderDir = $DocRoot . "/shoutcastconf/" . $serverPort;

    if (is_dir($FolderDir)) {
        function deleteDirectory($dir) {
            if (!file_exists($dir)) return true;
            if (!is_dir($dir)) return unlink($dir);
            foreach (scandir($dir) as $item) {
                if ($item == '.' || $item == '..') continue;
                if (!deleteDirectory($dir.DIRECTORY_SEPARATOR.$item)) return false;
            }
            return rmdir($dir);
        }
        deleteDirectory($FolderDir);
        mkdir($FolderDir, 0700);
    } else {
        mkdir($FolderDir, 0700);
    }


    DB::insert('sc_serv_conf', array(
        'MaxUser' => $formData['MaxUser'],
        'Password' => $formData['Password'],
        'PortBase' => $formData['PortBase'],
        'logfile' => $FolderDir . '/sc_serv.log',
        'RealTime' => '1',
        'ScreenLog' => '1',
        'ShowLastSongs' => '10',
        'TchLog' => 'yes',
        'WebLog' => 'no',
        'W3CEnable' => 'Yes',
        'W3CLog' => $FolderDir . '/W3CLog.log',
        'SrcIP' => 'ANY',
        'DestIP' => 'ANY',
        'Yport' => '80',
        'NameLookups' => '0',
        // 'RelayPort' => '',
        // 'RelayServer' => '',
        'AdminPassword' => $formData['AdminPassword'],
        'AutoDumpUsers' => '0',
        'AutoDumpSourceTime' => '30',
        //'ContentDir' => '',
        //'IntroFile' => '',
        //'BackupFile' => '',
        //'TitleFormat' => '',
        //'URLFormat' => '',
        'PublicServer' => $formData['PublicServer'],
        'AllowRelay' => 'Yes',
        'AllowPublicRelay' => 'Yes',
        'MetaInterval' => '32768',
        //'ListenerTimer' => '',
        //'BanFile' => '',
        // 'RipFile' => '',
        // 'RIPOnly' => '',
    ));
    $sc_serv_id = DB::insertId();

    if ($formData['PublicServer'] == 'public') {
        $IsPublic = 1;
    } else {
        $IsPublic = 0;
    }
    DB::insert('sc_trans_conf', array(
        'encoder_1' => $formData['encoder_1'],
        'bitrate_1' => $formData['bitrate_1'],
        'samplerate_1' => $formData['samplerate_1'],
        'channels_1' => $formData['channels_1'],
        'outprotocol_1' => '1',
        'serverip_1' => '127.0.0.1',
        'serverport_1' => $serverPort,
        'password_1' => $formData['Password'],
        //'streamurl' => '',
        // 'genre' => '',
        'public' => $IsPublic,
        'log' => '1',
        //'playlistfile' => '',
        //'shuffle' =>'',
        'xfade' => '2',
        'xfadethreshold' => '20',
        'logfile' => $FolderDir . '/sc_trans.log',
        'screenlog' => '1',
        'applyreplaygain' => '0',
        'calculatereplaygain' => '0',
        'djport' => $formData['djport'],
        'djpassword' => $formData['djpassword'],
        'autodumpsourcetime' => '30',
        'djcapture' => '0',
        //'streamtitle' =>'',
        //'aim' => '',
        //'icq' => '',
        //'irc' => '',
        //'unlockkeyname' =>'',
        //'unlockkeycode' =>''
    ));
    $sc_trans_id = DB::insertId();







    DB::insert('sc_rel', array(
        'accounts_id' => $formData['usr_id'],
        'sc_serv_conf_id' => $sc_serv_id,
        'sc_serv_version_id' => $_SESSION['sc_serv_version'],
        'stream_userName' => 'Dein neuer Stream',
        'sc_trans_id' => $sc_trans_id,
        'sc_trans_version_id' => $formData['sc_trans_version']
    ));

    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $app->render('station/adminshowlist.phtml', compact('license'));
}})->name('license');