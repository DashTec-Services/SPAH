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
# Prüfen ob Extenstions vorhanden
# Anzeigen der gefundenen Einstellungen
# Lizenz eingeben + Prüfen
# Download der Datein vom Server
#

function aes_encrypt($to_encrypt, $key, $iv)
{
    /* Open the cipher */
    $td = mcrypt_module_open('rijndael-128', '', 'ofb', '');

    /* Create the IV and determine the keysize length, use MCRYPT_RAND
    * on Windows instead */
    #$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_DEV_RANDOM);
    $ks = mcrypt_enc_get_key_size($td);

    /* Create key */
    $key = substr($key, 0, $ks);

    /* Intialize encryption */
    mcrypt_generic_init($td, $key, $iv);

    /* Encrypt data */
    $encrypted[0] = mcrypt_generic($td, $to_encrypt);

    /* Terminate encryption handler */
    mcrypt_generic_deinit($td);

    #$encrypted[1] = $iv;
    $encrypted = $encrypted[0];

    return $encrypted;
}

function aes_decrypt($encrypted, $key, $iv)
{
    $td = mcrypt_module_open('rijndael-128', '', 'ofb', '');

    /* Initialize encryption module for decryption */
    mcrypt_generic_init($td, $key, $iv);

    /* Decrypt encrypted string */
    $decrypted = mdecrypt_generic($td, $encrypted);

    /* Terminate decryption handle and close module */
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);

    /* Return string */
    return $decrypted;
}

//set POST variables
$url = 'http://bill.streamerspanel.de/getUserInformation.php';
$data = array("first_name" => "First name",
    "last_name" => "last name",
    "email"=>"email@gmail.com",
    "addresses" => array ("address1" => "some address" ,
        "city" => "city",
        "country" => "CA",
        "first_name" =>  "Mother",
        "last_name" =>  "Lastnameson",
        "phone" => "555-1212",
        "province" => "ON",
        "zip" => "123 ABC" ) );
$ch=curl_init($url);
$data_string = urlencode(json_encode($data));
$data_string = aes_encrypt($data_string,'adf','');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, array("customer"=>$data_string));


$result = curl_exec($ch);
curl_close($ch);

