<?php
/**
 * Created by David Schomburg (DashTec - Services)
 *      www.dashtec.de
 *
 *  S:P (StreamersPanel)
 *  Support: http://board.streamerspanel.de
 *
 *  v 0.30
 *
 *  Kundennummer:   @KDNUM@
 *  Lizenznummer:   @RECHNR@
 *  Lizenz: http://login.streamerspanel.de/user/terms
 */

DB::$user = $app->config('db.user');
DB::$password = $app->config('db.password');
DB::$dbName = $app->config('db.name');
DB::$host = $app->config('db.host');
DB::$port = $app->config('db.port');
DB::$encoding = $app->config('db.encoding');

