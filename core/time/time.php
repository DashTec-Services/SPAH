<?php
/**
 * Created by David Schomburg (DashTec - Services)
 *      www.dashtec.de
 *
 *  S:P (StreamersPanel)
 *  Support: http://board.streamerspanel.de
 *
 *  v 0.13
 *
 *  Kundennummer:   @KDNUM@
 *  Lizenznummer:   @RECHNR@
 * Lizenz: http://login.streamerspanel.de/user/terms
 */
namespace core\time;


class time {

    public function time2Seconds($time) {
        $aTime = explode(':', $time);
        return $aTime[2] + ($aTime[1] * 60) + ($aTime[0] * 3600);
    }



    public function seconds2Time($sekunden)
    {
        $stunden = floor($sekunden / 3600);
        $minuten = floor(($sekunden - ($stunden * 3600)) / 60);
        $sekunden = round($sekunden - ($stunden * 3600) - ($minuten * 60), 0);

        if ($stunden <= 9) {
            $strStunden = "0" . $stunden;
        } else {
            $strStunden = $stunden;
        }

        if ($minuten <= 9) {
            $strMinuten = "0" . $minuten;
        } else {
            $strMinuten = $minuten;
        }

        if ($sekunden <= 9) {
            $strSekunden = "0" . $sekunden;
        } else {
            $strSekunden = $sekunden;
        }

        return "$strStunden:$strMinuten:$strSekunden";
    }



}