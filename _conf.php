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

# Prüfung das install_DIR gelöscht wurde


$app = new \Slim\Slim([
    'sp.version' => '0.37',
    'db.user' => '@DBUSER@',
    'db.password' => '@DBPASS@',
    'db.name' => '@DBNAME@',
    'demo_mod' => @DEMOMOD@,
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
