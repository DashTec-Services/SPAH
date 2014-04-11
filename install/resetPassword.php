<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 11.04.14
 * Time: 18:07
 */
include_once '../core/DB.php';
include_once '../core/DB.php';
include_once '../index.php';


DB::$user = $app->config('db.user');
DB::$password = $app->config('db.password');
DB::$dbName = $app->config('db.name');
DB::$host = $app->config('db.host');
DB::$port = $app->config('db.port');
DB::$encoding = $app->config('db.encoding');




