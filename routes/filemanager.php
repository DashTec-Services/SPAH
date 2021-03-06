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

$app->get('/filemanager/list', function () use ($app) {
    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $app->render('filemanager/list.phtml', compact('Users'));
})->name('Users');

$app->get('/filemanager/playlist', function () use ($app) {
    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $app->render('filemanager/playlist.phtml', compact('Users'));
})->name('Users');

$app->get('/filemanager/upload', function () use ($app) {
    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $app->render('filemanager/upload.phtml', compact('Users'));
})->name('Users');

$app->get('/filemanager/playlist/edit', function () use ($app) {
    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $app->render('filemanager/editplaylist.phtml', compact('Users'));
})->name('Users');




/*
 *    -Übersicht aller Datein-
 */
$app->post('/filemanager/list', function () use ($app) {
if(isset($_POST['DelFromDB']) and !empty($_POST['DelFromDB'])){
    DB::delete('mp3_usr_rel', "id=%s", $_POST['DelFromDB']);
    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $app->render('filemanager/list.phtml');
    $sp_growl = new core\sp_special\growl();
    $sp_growl->writeGrowl('success', _('Datei gelöscht'), _('Die Datei wurde gelöscht!'));
}
})->name('Users');


$app->post('/filemanager/playlist', function () use ($app) {
/*
 *      Playlist-Edit-Funktionen
 */

    # Titel von Playlist löschen
    if(isset($_POST['delTitleFormEditPlaylist'])){
        DB::delete('playlist_mp3_rel', "id=%s", $_POST['delTitleFormEditPlaylist']);
        $SPMenu = new SP\Menu\MenuInclusion();
        $SPMenu->MenuInclude($app);
        $app->render('filemanager/editplaylist.phtml');
        $sp_growl = new core\sp_special\growl();
        $sp_growl->writeGrowl('success', _('Titel von der Playliste gelöscht'), $_POST['delTitleFormEditPlaylist']);
    }

    if(isset($_POST['addTitleToplst'])){
        DB::insert('playlist_mp3_rel', array(
            'playlist_id' => $_SESSION['playlistactiv'],
            'mp3_id' => $_POST['addTitleToplst']
        ));
        $SPMenu = new SP\Menu\MenuInclusion();
        $SPMenu->MenuInclude($app);
        $app->render('filemanager/editplaylist.phtml');
    }

    # Laden des Playliseditors
    if(isset($_POST['editPlaylst'])){
        $_SESSION['playlistactiv'] = $_POST['editPlaylst'];
        $SPMenu = new SP\Menu\MenuInclusion();
        $SPMenu->MenuInclude($app);
        $app->render('filemanager/editplaylist.phtml', compact('Users'));
    }

    if (isset($_POST['delFromlstEdit'])){
        DB::delete('playlist_mp3_rel', "id=%s", $_POST['delTitel']['id']);
        $SPMenu = new SP\Menu\MenuInclusion();
        $SPMenu->MenuInclude($app);
        $app->render('filemanager/editplaylist.phtml', compact('Users'));
    }








/*
 *      Playliste - Funktionen
 */
    # Neue Playliste anlegen
    if (isset($_POST['addplaylst']) && !empty($_POST['playlist_name'])){
        DB::insert('playlist', array(
            'playlist_name' => $_POST['playlist_name'],
            'add_date' => date('Y-m-d'),
            'user_id' => $_SESSION['account_id']
        ));
        $SPMenu = new SP\Menu\MenuInclusion();
        $SPMenu->MenuInclude($app);
        $app->render('filemanager/playlist.phtml');
    }elseif(isset($_POST['addplaylst']) && empty($_POST['playlist_name'])){
        $SPMenu = new SP\Menu\MenuInclusion();
        $SPMenu->MenuInclude($app);
        $app->render('filemanager/playlist.phtml');
        $sp_growl = new core\sp_special\growl();
        $sp_growl->writeGrowl('warning', _('Bitte einen Namen angeben'), _('Playliste kann nicht angelegt werden!'));
    }

    # Playliste löschen
    if(isset($_POST['delPlaylst'])){
        DB::delete('playlist', "id=%s", $_POST['delPlaylst']);
        $SPMenu = new SP\Menu\MenuInclusion();
        $SPMenu->MenuInclude($app);
        $app->render('filemanager/playlist.phtml');
        $sp_growl = new core\sp_special\growl();
        $sp_growl->writeGrowl('success', _('Playliste gelöscht'), _('Die Playliste wurde entfernt!'));
    }
})->name('Users');






/*
 *      POST Datein
 */
/*
$app->post('/filemanager/32324234234', function () use ($app) {
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
            #unset($_SESSION['playlistactiv']);
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

    if(isset($_POST['savepllst'])){
        $SPMenu = new SP\Menu\MenuInclusion();
        $SPMenu->MenuInclude($app);
        $app->render('filemanager/playlist.phtml', compact('Users'));
    }


})->name('Users');
*/

# Upload-Funktionen
$app->post('/filemanager/upload', function () use ($app) {
/**
 * PHP Real Ajax Uploader 2.7
 * Copyright @Alban Xhaferllari
 * albanx@gmail.com
 * http://www.albanx.com/ajaxuploader
 * This PHP script handles all types of uploads, AJAX, FLASH and HTML
 * It expect 1 file per time in the $_FILES
 */


/**************************************************************************************************************
 * This function runs when file is uploaded successfully, insert here any function to run on file upload end
 **************************************************************************************************************/
function success($file_path)
{

}
/************************************************************************************************************/


/*****************************************************************************
 * EMAIL CONFIGURATION HERE
 *****************************************************************************/
$send_email 	= false;						//Enable email notification
$main_receiver 	= 'test@gmail.com';				//Who receive the email when files get uploaded
$cc 			= '';	//Other email that receive the email in CC
$from 			= 'from@ajaxupload.com';		//What should appear in the from bar, usually something like fromupload@mysite.com
/*****************************************************************************/

/***********************************************************************************************************
 * RECOMMENDED CONFIGURATION HERE
 * The following parameters can be changed, and is reccomended to change them from here for security reason
 ***********************************************************************************************************/
$upload_path	= isset($_REQUEST['ax-file-path']) && !empty($_REQUEST['ax-file-path']) ?$_REQUEST['ax-file-path']:'';
$max_file_size	= isset($_REQUEST['ax-max-file-size']) && !empty($_REQUEST['ax-max-file-size']) ?$_REQUEST['ax-max-file-size']:'10M';
$allow_ext		= (isset($_REQUEST['ax-allow-ext']) && !empty($_REQUEST['ax-allow-ext']))?explode('|', $_REQUEST['ax-allow-ext']):array();
$upload_path	.= (!in_array(substr($upload_path, -1), array('\\','/') ) )?DIRECTORY_SEPARATOR:'';//normalize path
/************************************************************************************************************/

/************************************************************************************************************
 * Settings for thumbnail generation, can be changed here or from js
 ************************************************************************************************************/
$thumb_height	= isset($_REQUEST['ax-thumbHeight'])?$_REQUEST['ax-thumbHeight']:0;
$thumb_width	= isset($_REQUEST['ax-thumbWidth'])?$_REQUEST['ax-thumbWidth']:0;
$thumbPostfix	= isset($_REQUEST['ax-thumbPostfix'])?$_REQUEST['ax-thumbPostfix']:'_thumb';
$thumb_path		= isset($_REQUEST['ax-thumbPath'])?$_REQUEST['ax-thumbPath']:$upload_path;
$thumbFormat	= isset($_REQUEST['ax-thumbFormat'])?$_REQUEST['ax-thumbFormat']:'png';
/************************************************************************************************************/

//------------------------------------------DO NOT EDIT BELOW THIS LINE, IF YOU ARE NOT SURE WHAT TO DO-------------------//


/********************************************************************************************************
 * HTML5 UPLOAD PARAMETERS, NOT TO CHANGE
 ********************************************************************************************************/
$file_name	= ( isset($_REQUEST['ax-file-name']) && !empty($_REQUEST['ax-file-name']) )?$_REQUEST['ax-file-name']:'';
$currByte	= isset($_REQUEST['ax-start-byte'])?$_REQUEST['ax-start-byte']:0;
$full_size	= isset($_REQUEST['ax-file-size'])?$_REQUEST['ax-file-size']:0;
$isLast		= isset($_REQUEST['ax-last-chunk'])?$_REQUEST['ax-last-chunk']:'true';
$is_ajax	= isset($_REQUEST['ax-last-chunk']) && isset($_REQUEST['ax-start-byte']);
/************************************************************************************************************/


/*
 * Create upload path if do not exits
 */
if(!file_exists($upload_path) && !empty($upload_path))
{
    mkdir($upload_path, 0777, true);
}

/*
 * Create thumb path if do not exits
 */
if(!file_exists($thumb_path) && !empty($thumb_path))
{
    mkdir($thumb_path, 0777, true);
}

/*
 * Make all extension to lower case
 */
$allow_ext = array_map('strtolower', $allow_ext);

/**
 *
 * Create a image thumb
 * @param unknown_type $filepath
 * @param unknown_type $thumb_path
 * @param unknown_type $postfix
 * @param unknown_type $maxwidth
 * @param unknown_type $maxheight
 * @param unknown_type $format
 * @param unknown_type $quality
 */
function createThumbGD($filepath, $thumb_path, $postfix, $maxwidth, $maxheight, $format='jpg', $quality=75)
{
    if($maxwidth<=0 && $maxheight<=0)
    {
        return 'No valid width and height given';
    }

    $web_formats= array('jpg','jpeg','png','gif');//web formats
    $file_name	= pathinfo($filepath);
    if(empty($format)) $format = $file_name['extension'];

    if(!in_array(strtolower($file_name['extension']), $web_formats))
    {
        return 'Not supported file type';
    }

    $thumb_name	= $file_name['filename'].$postfix.'.'.$format;//filename 5.2++

    if(empty($thumb_path))
    {
        $thumb_path=$file_name['dirname'];
    }
    $thumb_path.= (!in_array(substr($thumb_path, -1), array('\\','/') ) )?DIRECTORY_SEPARATOR:'';//normalize path

    // Get new dimensions
    list($width_orig, $height_orig) = getimagesize($filepath);
    if($width_orig>0 && $height_orig>0)
    {
        $ratioX	= $maxwidth/$width_orig;
        $ratioY	= $maxheight/$height_orig;
        $ratio 	= min($ratioX, $ratioY);
        $ratio	= ($ratio==0)?max($ratioX, $ratioY):$ratio;
        $newW	= $width_orig*$ratio;
        $newH	= $height_orig*$ratio;

        // Resample
        $thumb = imagecreatetruecolor($newW, $newH);
        $image = imagecreatefromstring(file_get_contents($filepath));

        imagecopyresampled($thumb, $image, 0, 0, 0, 0, $newW, $newH, $width_orig, $height_orig);

        // Output
        switch (strtolower($format)) {
            case 'png':
                imagepng($thumb, $thumb_path.$thumb_name, 9);
                break;

            case 'gif':
                imagegif($thumb, $thumb_path.$thumb_name);
                break;

            default:
                imagejpeg($thumb, $thumb_path.$thumb_name, $quality);;
                break;
        }
        imagedestroy($image);
        imagedestroy($thumb);
    }
    else
    {
        return false;
    }
}

/**
 *
 * Check if file size is allowed
 * @param unknown_type $size
 * @param unknown_type $max_file_size
 */
function checkSize($size, $max_file_size)
{
    //------------------max file size check from js
    $rang 		= substr($max_file_size,-1);
    $max_size 	= !is_numeric($rang) && !is_numeric($max_file_size)? str_replace($rang, '', $max_file_size): $max_file_size;
    if($rang && $max_size)
    {
        switch (strtoupper($rang))//1024 or 1000??
        {
            case 'T': $max_size = $max_size*1024;
            case 'G': $max_size = $max_size*1024;
            case 'M': $max_size = $max_size*1024;
            case 'K': $max_size = $max_size*1024;
        }
    }

    if(!empty($max_file_size) && $size>$max_size)
    {
        return false;
    }
    //-----------------End max file size check

    return true;
}


/**
 *
 * Check if file name is allowed and remove illegal windows chars
 * @param string $filename
 */
function checkName($filename)
{
    //comment if not using windows web server
    $windowsReserved	= array('CON', 'PRN', 'AUX', 'NUL','COM1', 'COM2', 'COM3', 'COM4', 'COM5', 'COM6', 'COM7', 'COM8', 'COM9',
        'LPT1', 'LPT2', 'LPT3', 'LPT4', 'LPT5', 'LPT6', 'LPT7', 'LPT8', 'LPT9');
    $badWinChars		= array_merge(array_map('chr', range(0,31)), array("<", ">", ":", '"', "/", "\\", "|", "?", "*"));

    $filename	= str_replace($badWinChars, '', $filename);

    //check if legal windows file name
    if(in_array($filename, $windowsReserved))
    {
        return false;
    }
    return $filename;
}

/**
 *
 * Check if file type is allowed for upload
 * @param string $file
 * @param array $allowExt
 */
function checkExt($file, $allow_ext)
{
    $file_ext = strtolower( pathinfo($file, PATHINFO_EXTENSION) );
    //extensions not allowed for security reason
    $deny_ext = array('php','php3', 'php4', 'php5', 'phtml', 'exe', 'pl', 'cgi', 'html', 'htm', 'js', 'asp', 'aspx', 'bat', 'sh', 'cmd');
    if(in_array($file_ext, $deny_ext))
    {
        return false;
    }

    //check if is allowed extension
    if(!in_array($file_ext, $allow_ext) && count($allow_ext))
    {
        return false;
    }
    return true;
}

/**
 *
 * Check if a file exits or not and calculates a new name for not oovverring other files
 * @param String $filename
 * @param String $uploadPath
 */
function checkFileExits($filename, $upload_path)
{
    usleep(rand(100, 900));
    $file_data 	= pathinfo($filename);
    $file_base	= $file_data['filename'];
    $file_ext	= $file_data['extension'];//PHP 5.2>

    $full_path 	= $upload_path.$filename;
    //Disable this lines of code to allow file override
    $c=0;
    while(file_exists($full_path))
    {
        $find = preg_match('/\((.*?)\)/', $filename, $match);
        if(!$find) $match[1] = 0;
        else
            $file_base = str_replace("(".$match[1].")", "", $file_base);

        $match[1]++;

        $filename	= $file_base."(".$match[1].").".$file_ext;
        $full_path 	= $upload_path.$filename;
        //echo $full_path;
    }
    // end
    return $full_path;
}

/**
 *
 * Simle email sender function
 * @param unknown_type $main_receiver
 * @param unknown_type $cc
 * @param unknown_type $file_path
 * @param unknown_type $from
 */

function send_notification($main_receiver, $cc='', $file_path, $from='ajax@uploader')
{
    $msg = '<p> New file uploaded to your site at '.date('Y-m-i H:i'). ' from IP '.$_SERVER['REMOTE_ADDR'].':</p>';
    $msg.= '<div style="overflow:auto;padding:10px;border:1px solid black;border-radius:5px;">';
    $msg.= $file_path;
    $msg.= '</div>';


    $headers = 'From: '.$from. "\r\n" .'Reply-To: '.$from. "\r\n" ;
    $headers .= 'Cc: '.$cc . "\r\n";
    $headers .= "Content-type: text/html\r\n";

    @mail($main_receiver, 'New file uploaded', $msg, $headers);
}

/**
 * standard upload errors
 * Enter description here ...
 * @var unknown_type
 */
$upload_errors = array(
    UPLOAD_ERR_OK        	=> "No errors.",
    UPLOAD_ERR_INI_SIZE    	=> "The uploaded file exceeds the upload_max_filesize directive in php.ini",
    UPLOAD_ERR_FORM_SIZE    => "Larger than form MAX_FILE_SIZE.",
    UPLOAD_ERR_PARTIAL   	=> "Partial upload.",
    UPLOAD_ERR_NO_FILE      => "No file.",
    UPLOAD_ERR_NO_TMP_DIR   => "No temporary directory.",
    UPLOAD_ERR_CANT_WRITE   => "Can't write to disk.",
    UPLOAD_ERR_EXTENSION    => "File upload stopped by extension."
);

/*
 * get the original filename or get the renamed file name
 */
$file_name 	= !empty($file_name)? $file_name:$_FILES['ax_file_input']['name'];

/*
 *If there is any upload error stop and raise error
 */
if(isset($_FILES['ax_file_input']))
{
    if( $_FILES['ax_file_input']['error'] !== UPLOAD_ERR_OK )
    {
        echo json_encode(array('name'=>$file_name, 'size'=>$_FILES['ax_file_input']['size'], 'status'=>-1, 'info'=>$upload_errors[$_FILES['ax_file_input']['error']]));
        return false;
    }
}


/*
* get the file size. In html5 upload by chunks we get the full file size from javascript
* In a standard upload full size is returned by Global $_FILES
*/
$full_size	= ($full_size)?$full_size:$_FILES['ax_file_input']['size'];

//This checks are just one time
if($currByte==0)
{
    /*
     * If files size is greater than allowed then stop upload and return error
     * $max_file_size format: 12K, 13M, 6G ...
     */
    if(!checkSize($full_size, $max_file_size))
    {
        echo json_encode(array('name'=>$file_name, 'size'=>$full_size, 'status'=>-1, 'info'=>'File size exceeded maximum allowed: '.$max_file_size));
        return false;
    }

    /*
     * Check if the file name has not allowed characters, removes them, and check if it is windows reserved
     */
    $tmp_fn = $file_name;
    $file_name = checkName($file_name);
    if(!$file_name)
    {
        echo json_encode(array('name'=>$tmp_fn, 'size'=>$full_size, 'status'=>-1,'info'=>'File name is not allowed. Windows reserved.'));
        return false;
    }

    /*
     * Check if file extension is in the allowed extensions
     * By defaul php, exe, html, js... are deny
     */
    if(!checkExt($file_name, $allow_ext))
    {
        echo json_encode(array('name'=>$file_name, 'size'=>$full_size, 'status'=>-1,'info'=>'File extension is not allowed'));
        return false;
    }
}


/*
 * Calculate full upload path and check if file already exists.
 * If file exists just rename it in the format :filename(N).ext
 */
$full_path = '';
if($is_ajax)//Ajax Upload, FormData Upload and FF3.6 php://input upload
{
    //we get the path only for the first chunk
    $full_path 	= ($currByte==0) ? checkFileExits($file_name, $upload_path):$upload_path.$file_name;

    //Just optional, avoid to write on exisiting file, but in theory filename should be unique from the checkFileExits function
    $flag 		= ($currByte==0) ? 0:FILE_APPEND;

    //formData post files just normal upload in $_FILES, older ajax upload post it in input
    $post_bytes	= isset($_FILES['ax_file_input'])? file_get_contents($_FILES['ax_file_input']['tmp_name']):file_get_contents('php://input');

    //some rare times (on very very fast connection), file_put_contents will be unable to write on the file, so we try until it writes
    while(@file_put_contents($full_path, $post_bytes, $flag) === false)
    {
        usleep(50);
    }

    //delete the temporany chunk
    if(isset($_FILES['ax_file_input']))
    {
        @unlink($_FILES['ax_file_input']['tmp_name']);
    }

    //if it is not the last chunk just return success chunk upload
    if($isLast!='true')
    {
        echo json_encode(array('name'=>basename($full_path), 'size'=>$full_size, 'status'=>1, 'info'=>'Chunk uploaded'));
    }
}
else //Normal html and flash upload
{
    $isLast 	= 'true';//we cannot upload by chunks here so assume it is the last single chunk
    $full_path 	= checkFileExits($file_name, $upload_path);
    $result 	= move_uploaded_file($_FILES['ax_file_input']['tmp_name'], $full_path);//make the upload
    if(!$result) //if any error return the error
    {
        echo json_encode( array('name'=>basename($full_path), 'size'=>$full_size, 'status'=>-1, 'info'=>'File move error') );
        return  false;
    }
}


if($isLast == 'true')
{
    createThumbGD($full_path, $thumb_path, $thumbPostfix, $thumb_width, $thumb_height, $thumbFormat);
    if($send_email)	send_notification($main_receiver, $cc, $full_path, $from);
    echo json_encode(array('name'=>basename($full_path), 'size'=>$full_size, 'status'=>1, 'info'=>'File uploaded'));
    @success($full_path);

    $NewDBFileName = uniqid($_SESSION['account_id']);
    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
    rename($upload_path.$file_name,$upload_path.$NewDBFileName.'.'.$ext);

    $path_to_your_file = './core/getid3';
    require_once $path_to_your_file . '/getid3.php';
    $getID3 = new getID3;
    $ThisFileInfo = $getID3->analyze($upload_path.$NewDBFileName.'.'.$ext);
    getid3_lib::CopyTagsToComments($ThisFileInfo);




    #    Für DEBUG!!!
   # echo '<pre>'. print_r($ThisFileInfo).'</pre>';

        # Überprüfung ob IDV3 läuft

        if(!empty($ThisFileInfo['audio']['bitrate'])){

            if (strpos($ThisFileInfo['audio']['bitrate'], ',') == true){

                $tim = new core\time\time();
                $parts = explode(':', $tim->onlineTime($ThisFileInfo['playtime_string']));
                $seconds = 0;
                foreach ($parts as $i => $val) {
                    $seconds += $val * pow(60, 2 - $i);
                }

                $filesize_to = $ThisFileInfo['filesize'] * 8;
                echo $filesize_to;
                #$bitrate= $filesize_to / $seconds;
// TODO Bitrate lesen
                $bitrate = '0';
            }else{
                $bitrate = "'".$ThisFileInfo['audio']['bitrate'] . "'";
            }

        }else{
            $bitrate = '0';
        }

        if(!empty($ThisFileInfo['comments_html']['artist'])){
            $artist = $ThisFileInfo['comments_html']['artist'];
        }else{
            $artist = "none";
        }

        if(!empty($ThisFileInfo['playtime_string'])){
            $tim = new core\time\time();
            $playtime = $tim->onlineTime($ThisFileInfo['playtime_string']);
           # $playtime = $ThisFileInfo['playtime_string'];

        }else{
            $playtime = "none";
        }


    DB::insert('mp3', array(
        'org_file_titel' => $file_name,
        'dir_titel' => $NewDBFileName.'.'.$ext,
        'hash_titel' => $NewDBFileName,
        'size' => $ThisFileInfo['filesize'],
        'bitrate' => '0',
        'playtime' => $playtime,
        'artist' => $artist
    ));


    $joe_id = DB::insertId();
    DB::insert('mp3_usr_rel', array(
        'user_id' => $_SESSION['account_id'],
        'mp3_id' => $joe_id
    ));

}

})->name('Users');
