<?php
/**
 * Created by David Schomburg (DashTec - Services)
 *      www.dashtec.de
 *
 *  S:P (StreamersPanel)
 *  Support: http://board.streamerspanel.de
 *
 *  v 0.18
 *
 *  Kundennummer:   @KDNUM@
 *  Lizenznummer:   @RECHNR@
 * Lizenz: http://login.streamerspanel.de/user/terms
 */
# Erstellt am 06.10.2012 / D.Schomburg
# Module-confs

#$dfw_module_Name =  'demo';         # Name des Moduls !immer Verzeichnissnamen verwenden
#$dfw_module_Version = '0.1';        # Version zur Übersicht


# 2. Array mit CSS Styles die geladen werden sollen.
/*
$dfw_module_style = array(
                            "demo");
*/

# 3. JavaScript include
/*
$dfw_module_js = array(
    "demo");
*/

# Automatisches durchführen von Grundfunktionen

/*
 *          HTML-Header laden
 *
 *      Info:   Es sind verschiedene Möglichkeiten $dfw_Titel (Konfiguration in config/modulreg.php), oder mit "Freier Text"
 *              im phparray sämtliche css Datein eintragen die geladen werden sollen.
 */

#$DTF->HTML_Header('demo-Modul',$dfw_module_style,$dfw_module_Name);


/*
 *          Benötigte Core-Zuweisungen
 */
