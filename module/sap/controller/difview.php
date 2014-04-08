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
namespace module\sap\controller;

class difview
{
    public function loadDiffView($grp, $view)
    {
        $DTF = new \dfwconf();
        $Phtml_View = "./module/sap/view/" . $view['2'] . '_' . $grp . '.phtml';
        if (file_exists($Phtml_View)) {
            require $Phtml_View;
        } else {
            $var = "./module/" . $view['2'] . "/index.php";
            require $var;
        }
    }
}