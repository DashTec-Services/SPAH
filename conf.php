<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 18.04.14
 * Time: 13:38
 */

$app = new \Slim\Slim([
    'sp.version' => '0.34',
    'db.user' => 'sapdevuserr',              # @DBUSER@
    'db.password' => 'jaro2812', 		    # @DBPASS@
    'db.name' => 'sapdev',		            # @DBNAME@
    'demo_mod' => 'false',                  # @DEMOMOD@
    'view' => new \SP\Views\MyUltimateView(),
    'templates.path' => __DIR__ . '/views',
    'db.host' => 'localhost',
    'db.port' => 3306,
    'db.encoding' => 'utf8',
    'php.timezone' => 'Europe/Berlin',
    'php.error-reporting' => E_ALL | E_STRICT,
    'middleware.authentication' => [
        'filter_mode' => \SP\Middleware\AbstractFilterableMiddleware::EXCLUSION,
        'route_names' => ['login', 'doLogin', 'doLogout'],
    ],
    'middleware.authorization' => [
        'filter_mode' => \SP\Middleware\AbstractFilterableMiddleware::INCLUSION,
        'route_names' => ['restricted'],
        'route_group_mappings' => [
            'restricted' => ['usr', 'adm', 'dj'],
        ],
    ],
]);

