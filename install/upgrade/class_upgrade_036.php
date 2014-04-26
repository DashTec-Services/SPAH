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
class class_upgrade_036 {
    public $SHORT_VERSION = '036';
    public $LONG_VERSION  = '0.36';
    public $PREV_LONG_VERSION = '0.35';
    public $NEXT_LONG_VERSION = '0.37';
    public $NEXT_SHORT_VERSION = '037';
    public $VERSION_COMPAT_STARTS = ''; #Beginning version compatibility
    public $VERSION_COMPAT_ENDS   = ''; #Ending version compatibility
    public $UPGRADE_STEPS = '0';

    /**
     * Step #1
     *
     */
    public function step_1()
    {
        echo "step_1 -> 036";
    }

    public function step_2()
    {
        echo "step_2 -> 036";
    }



} 