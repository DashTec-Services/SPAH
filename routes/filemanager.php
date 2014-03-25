<?php
/**
 * Created by David Schomburg (DashTec - Services)
 *      www.dashtec.de
 *
 *  S:P (StreamersPanel)
 *  Support: http://board.streamerspanel.de
 *
 *  v 0.21
 *
 *  Kundennummer:   @KDNUM@
 *  Lizenznummer:   @RECHNR@
 * Lizenz: http://login.streamerspanel.de/user/terms
 */

$app->get('/filemanager/list', function () use ($app) {
    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $app->render('filemanager/list.phtml', compact('Users'));
})->name('list');

$app->get('/filemanager/playlist', function () use ($app) {
    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $app->render('filemanager/playlist.phtml', compact('Users'));
})->name('list');

$app->get('/filemanager/upload', function () use ($app) {
    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $app->render('filemanager/upload.phtml', compact('Users'));
})->name('list');

$app->get('/filemanager/playlist/edit', function () use ($app) {
    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $app->render('filemanager/editplaylist.phtml', compact('Users'));
})->name('list');

$app->post('/filemanager/playlist', function () use ($app) {
    if (isset($_POST['pllstaction'])){
        $changer = explode("#",$_POST['pllstaction']);

        if($changer['0'] == 'del'){
            DB::delete('playlist', "id=%s", $changer['1']);
            $SPMenu = new SP\Menu\MenuInclusion();
            $SPMenu->MenuInclude($app);
            $app->render('filemanager/editplaylist.phtml', compact('Users'));
        }

        if($changer['0'] == 'activ'){
            $_SESSION['playlistactiv'] = $changer['1'];
            $SPMenu = new SP\Menu\MenuInclusion();
            $SPMenu->MenuInclude($app);
            $app->render('filemanager/editplaylist.phtml', compact('Users'));
        }

        if($changer['0'] == 'save'){
            unset($_SESSION['playlistactiv']);
            $SPMenu = new SP\Menu\MenuInclusion();
            $SPMenu->MenuInclude($app);
            $app->render('filemanager/playlist.phtml', compact('Users'));
        }
    }
    if (isset($_POST['addTitel'])){
        DB::insert('playlist_mp3_rel', array(
            'playlist_id' => $_SESSION['playlistactiv'],
            'mp3_id' => $_POST['addTitel']['id']
        ));
        $SPMenu = new SP\Menu\MenuInclusion();
        $SPMenu->MenuInclude($app);
        $app->render('filemanager/editplaylist.phtml', compact('Users'));
    }

    if (isset($_POST['addplaylst']) && !empty($_POST['playlist_name'])){
        DB::insert('playlist', array(
            'playlist_name' => $_POST['playlist_name'],
            'add_date' => date('Y-m-d'),
            'user_id' => $_SESSION['account_id']
        ));
        $SPMenu = new SP\Menu\MenuInclusion();
        $SPMenu->MenuInclude($app);
        $app->render('filemanager/playlist.phtml', compact('Users'));
    }

    if(isset($_POST['savepllst'])){
        $SPMenu = new SP\Menu\MenuInclusion();
        $SPMenu->MenuInclude($app);
        $app->render('filemanager/playlist.phtml', compact('Users'));
    }

    if (isset($_POST['ddd'])){
        DB::delete('playlist_mp3_rel', "id=%s", $_POST['delTitel']['id']);
        $SPMenu = new SP\Menu\MenuInclusion();
        $SPMenu->MenuInclude($app);
        $app->render('filemanager/editplaylist.phtml', compact('Users'));
    }



})->name('doLogin');

