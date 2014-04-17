<?php
/**
 * Created by David Schomburg (DashTec - Services)
 *      www.dashtec.de
 *
 *  S:P (StreamersPanel)
 *  Support: http://board.streamerspanel.de
 *
 *  v 0.33
 *
 *  Kundennummer:   @KDNUM@
 *  Lizenznummer:   @RECHNR@
 *  Lizenz: http://login.streamerspanel.de/user/terms
 */
 
 
 
?>






<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>S:P - SystemCheck</title>
</head>
<body>
<?php

date_default_timezone_set('Europe/Berlin');

# PHP Versionen prüfen
if (version_compare(phpversion(), '5.5', '<')) {
    echo 'Sie benutzen PHP: ' . phpversion() .'<b> ein UPDATE IST erforderlich!</b>';
    $error = true;
}

echo '<b>PHPVersion: </b>'.PHP_VERSION.'<br>';
echo '<b>Apache: </b>'.$_SERVER['SERVER_SOFTWARE']. '<br>';
echo '<b>DOC-ROOT: </b>'.$_SERVER['DOCUMENT_ROOT']. '<br><br>';

# PHP Module und Extensions Prüfen
$allMods = get_loaded_extensions();
$impoMods = array('date','json', 'ssh2', 'curl', 'mcrypt','json');
$result = array_diff($impoMods, $allMods);
foreach($result as $wert => $key){
    echo 'PHP-Modul "' .$key . '" <b>NICHT vorhanden!</b><br>';
    $errorMod = true;
}
if (isset($errorMod)){
    if($error == true){
        echo '<h1 style="color: red"><b>S:P - Das System erfüllt <p style="font-size: 40pt;">NICHT</p> die Anforderungen zur Installation    </h1></b>';
    }else{
        echo '<h1  style="color: #0cff00"><b>S:P - Das System erfüllt die Anforderungen zur Installation</h1></b>';
    }
}


$loaded_extensions = get_loaded_extensions();
natcasesort($loaded_extensions);
echo "<br><br><h3><b>Installierte Module:</h3></b>";
foreach ($loaded_extensions as $loaded_extension) {
    echo (phpversion($loaded_extension) !== FALSE ? $loaded_extension . ' (' . phpversion($loaded_extension) . ')' : $loaded_extension) . '<br>';
}

if (isset($errorMod) or $error == true){
    echo phpinfo();
}



?>
</body>
</html>
