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
namespace core\sp_special;


class growl {

    public function writeGrowl($type, $title, $text){
        echo "  <script>
                 $.msgGrowl ({
                        type: '".$type."'
                        , title: '".$title."'
                        , text: '".$text."'
                        , position: $(this).attr ('rel')
                    });
                </script> ";
    }

} 