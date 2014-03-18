<?php
/*
 * Small File Uploader 
 * by DenonStudio
 * http://codecanyon.net/item/small-file-uploader/220176
 * v2.0
 */

$ONE_KB       = 1024;
$maxFileSize  = $ONE_KB * $ONE_KB;
$allowedTypes = array("jpg","jpeg","gif","png","pdf");

require_once __DIR__ . '/includes.php';

function handleUpload($file)
{
    $fileDestinationFolder = "./mp3collection/";
    $fileTmpName           = $file["tmp_name"];
    $fileName              = $fileDestinationFolder . $file["name"];

    move_uploaded_file($fileTmpName, $fileName);
}

