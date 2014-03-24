<?php
/**
 * Created by David Schomburg (DashTec - Services)
 *      www.dashtec.de
 *
 *  S:P (StreamersPanel)
 *  Support: http://board.streamerspanel.de
 *
 *  v 0.19
 *
 *  Kundennummer:   @KDNUM@
 *  Lizenznummer:   @RECHNR@
 * Lizenz: http://login.streamerspanel.de/user/terms
 */

namespace SP\Menu;



class MenuInclusion
{


    public function MenuInclude ($app){

        if(isset($_SESSION['group'])){
            $app->flash('success', _('Login successful'));
            $Users = \DB::query("SELECT * FROM accounts");

            if($_SESSION['group'] == 'adm'){
                $app->render('menu/admin.phtml', compact('Users'));
            }elseif($_SESSION['group']== 'user'){
                $app->render('menu/user.phtml', compact('Users'));
            }elseif($_SESSION['group'] == 'dj'){
                // TODO : DJ Ansicht
            }
        }else{
            $app->redirect('/logout', 303);
        }
    }












}


