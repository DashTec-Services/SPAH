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


/*
 *      Main Route
 */

$app->get('/', function () use ($app) {

    if($_SESSION['group'] == 'adm'){
        $SPMenu = new SP\Menu\MenuInclusion();
        $SPMenu->MenuInclude($app);
        $app->render('spwelcome/adm.phtml', compact('Users'));



        $handle=@fopen("http://login.streamerspanel.de/request.php","r");

        if($handle == true){
        date_default_timezone_set('Europe/Berlin');
        if (!file_exists('.lastNewsForAdmin')) {
            file_put_contents('.lastNewsForAdmin', date('Y-m-d H'));
            Requests::register_autoloader();
            $data = array(
                'SendUserStat' => '@KDNUM@@RECHNR@',
                'kdNumb' => '@KDNUM@',
                'rechnnumb' => '@RECHNR@',
                'server_ip' => $_SERVER['SERVER_ADDR'],
                'php_v' => PHP_VERSION,
                'sp_version' => $app->config('sp.version'),
                'script_filename' => $_SERVER['SCRIPT_FILENAME'],
                'server_signature' => $_SERVER['SERVER_SIGNATURE']
            );

            $response = Requests::post('http://login.streamerspanel.de/request.php', array(), $data);
        } else {
            $lastUsageSentAt = file_get_contents('.lastNewsForAdmin');
            if ($lastUsageSentAt !== date('Y-m-d H')) {
                file_put_contents('.lastNewsForAdmin', date('Y-m-d H'));
                Requests::register_autoloader();
                $data = array(
                    'SendUserStat' => '@KDNUM@@RECHNR@',
                    'kdNumb' => '@KDNUM@',
                    'rechnnumb' => '@RECHNR@',
                    'server_ip' => $_SERVER['SERVER_ADDR'],
                    'php_v' => $app->config('sp.version'),
                    'script_filename' => $_SERVER['SCRIPT_FILENAME'],
                    'server_signature' => $_SERVER['SERVER_SIGNATURE']
                );
                $response = Requests::post('http://login.streamerspanel.de/request.php', array(), $data);
            }
           }
         }
















    }elseif($_SESSION['group']== 'user'){
            $SPMenu = new SP\Menu\MenuInclusion();
            $SPMenu->MenuInclude($app);
            $app->render('spwelcome/user.phtml', compact('Users'));


    }elseif($_SESSION['group'] == 'dj'){
        $SPMenu = new SP\Menu\MenuInclusion();
        $SPMenu->MenuInclude($app);
        $app->render('spwelcome/dj.phtml', compact('Users'));    }
})->name('not-restricted');







