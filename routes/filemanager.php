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



$app->post('/filemanager/upload', function () use ($app) {
$valid_formats = array("jpg", "png", "gif", "zip", "bmp");
$max_file_size = 1024*100; //100 kb
$path = "mp3collection/"; // Upload directory
$count = 0;

if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
    // Loop $_FILES to exeicute all files
    foreach ($_FILES['files']['name'] as $f => $name) {
        if ($_FILES['files']['error'][$f] == 4) {
            continue; // Skip file if any error found
        }
        if ($_FILES['files']['error'][$f] == 0) {
            if ($_FILES['files']['size'][$f] > $max_file_size) {
                $message[] = "$name is too large!.";
                continue; // Skip large files
            }
            elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
                $message[] = "$name is not a valid format";
                continue; // Skip invalid file formats
            }
            else{ // No error found! Move uploaded files
                if(move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path.$name))
                    $count++; // Number of successfully uploaded file
            }
        }
    }
}
})->name('doLogin');