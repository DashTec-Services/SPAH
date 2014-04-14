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
namespace core\sp_special;


class StationXML {

    public function getXMLParms($port, $passw){

        $curl_handle=curl_init();
        curl_setopt($curl_handle, CURLOPT_URL,$_SERVER['SERVER_ADDR'].':'.$port.'/admin.cgi?pass='.$passw.'&mode=viewxml');
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        $query = curl_exec($curl_handle);
        curl_close($curl_handle);
        $xml  = new \SimpleXMLElement(utf8_encode($query));

        # Alle Informationen ausgeben
        #print_r($xml);

        return $xml;
    }

} 