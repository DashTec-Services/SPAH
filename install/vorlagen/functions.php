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

?>

<h1>Systemanforderungen</h1>
                <?php
                $rights = substr(sprintf('%o', fileperms('../shoutcast')), -3);

if (version_compare(phpversion(), '5.5', '<')) {
    echo 'Sie benutzen PHP: ' . phpversion() .'<b> ein UPDATE IST erforderlich!</b>';
}else{
    echo 'Sie benutzen PHP: ' . phpversion() .'<b>!</b>';
}


                if ($rights == '777') {
                    echo '<p class="message success">Ordner <b>"linux"</b> besitzt die erforderlichen Rechte</p>';
                } else {
                    echo '<p class="message error">Ordner <b>"linux"</b> besitzt <b>NICHT</b> die erforderlichen Rechte</p>';
                }

                if (extension_loaded('ssh2')) {
                    echo '<p class="message success">Erweiterung: <b>"ssh2"</b> gefunden</p>';
                } else {
                    echo '<p class="message error">Erweiterung: <b>"ssh2" - NICHT</b> gefunden</p>';
                }

                if (extension_loaded('mysql')) {
                    echo '<p class="message success">Erweiterung: <b>"MySql"</b> gefunden</p>';
                } else {
                    echo '<p class="message error">Erweiterung: <b>"MySql" - NICHT</b> gefunden</p>';
                }

                if (extension_loaded('safe_mode')) {
                    echo '<p class="message error">Erweiterung: <b>"safe_mode" - NICHT</b> ist ON</p>';
                } else {
                    echo '<p class="message success">Erweiterung: <b>"safe_mode"</b> is OFF!</p>';
                }



                                        if ($rights == '777' AND !extension_loaded('safe_mode') AND extension_loaded('mysql') && extension_loaded('ssh2') && $rights == '777' ){
                                            echo '<a href="st2.php"><button type="button" name="step2">Schritt 2</button></a>';
                                            $_SESSION['step1'] = 'true';
                                        }else{
                                            echo '<p class="message error">Es müssen alle Überprüfungen bestanden werden!!</p>';
                                        }


                                    ?>