<?php
/**
 * Created by David Schomburg (DashTec - Services)
 *      www.dashtec.de
 *
 *  S:P (StreamersPanel)
 *  Support: http://board.streamerspanel.de
 *
 *  v 0.25
 *
 *  Kundennummer:   @KDNUM@
 *  Lizenznummer:   @RECHNR@
 *  Lizenz: http://login.streamerspanel.de/user/terms
 */
date_default_timezone_set($app->config('php.timezone'));
error_reporting($app->config('php.error-reporting'));

#   Titel des Programms
$app->view()->set('site_title', 'Streamers:Panel');

