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


$verbindung = mysql_connect ("localhost",
    "sappview_user", "SXFTjqbP12")
or die ("keine Verbindung möglich.
 Benutzername oder Passwort sind falsch");

mysql_select_db("sappview")
or die ("Die Datenbank existiert nicht.");

$error = '';
$file = file_get_contents('./sp.sql');
$sql = explode(';',$file);
for($i=0;$i<count($sql)-1 && $error=='';$i++){
    echo "<br><br>".$sql[$i];
    if(!mysql_query($sql[$i])) $error =  mysql_error();
}

if(!$error){
    echo '<br><br><font color="green">Tables created successfully!</font>';
}else{
    echo '<br><br><font color="red">'.$error.'</font>';
}
