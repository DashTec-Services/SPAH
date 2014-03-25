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


$app->get('/server/conf', function () use ($app) {
    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $server = DB::queryFirstRow("SELECT * FROM config");

    $app->render('server/serverconf.phtml', compact('server'));
})->name('not-restricted');

$app->get('/server/license', function () use ($app) {
    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    $app->render('server/licenseshow.phtml');
})->name('not-restricted');



$app->post('/server/conf', function () use ($app) {
    $SPMenu = new SP\Menu\MenuInclusion();
    $SPMenu->MenuInclude($app);
    if (isset($_POST['saveserverconf'])) {

        $fromwork = new core\postget\postgetcoll();
        $mywork[] = $fromwork->collvars('POST');

        // TODO: [0] entfernen ;-)
        # Update ServerConf
        DB::update('config', array(
            'server_ip' => $mywork[0]['server_ip'],
            'root_user' => $mywork[0]['root_user'],
            # 'root_password' => $mywork[0]['root_password'],
            'ssh_port' => $mywork[0]['ssh_port'],
            'sp_titel' => $mywork[0]['sp_titel'],
            'doc_root' => $mywork[0]['doc_root'],
            'adminMail' => $mywork[0]['adminMail']
        ), "id=%s", '1');

        if (!empty($mywork[0]['root_password'])) {

            DB::update('config', array(
                'root_password' => $mywork[0]['root_password']
            ), "id=%s", '1');
        }

        echo "
 <script>

 $.msgGrowl ({
        type: 'success'
        , title: '".('Settings saved')."'
        , position: $(this).attr ('rel')
    });

</script> ";
    }






    $server = DB::queryFirstRow("SELECT * FROM config");
    $app->render('server/serverconf.phtml', compact('server'));

})->name('doLogin');




