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


class scserv
{

    # Auslesen der SSH Config aus der DB
    public function getSSHConf()
    {

        $config = \DB::queryFirstRow("SELECT * FROM config WHERE id='1'");

        $SSHConf['ip'] = $config['server_ip'];
        $SSHConf['user'] = $config['root_user'];
        $SSHConf['pass'] = $config['root_password'];
        $SSHConf['port'] = $config['ssh_port'];

        return $SSHConf;
    }

    # Start the Server
    public function startSc_Serv($sc_serv_conf_rel_id)
    {

        // Stream Conf
        $sc_serv_rel = \DB::queryFirstRow("SELECT * FROM sc_rel WHERE id=%s", $sc_serv_conf_rel_id);

        // StreamDaten
        $sc_serv_id = \DB::queryFirstRow("SELECT * FROM sc_serv_conf WHERE id=%s", $sc_serv_rel['sc_serv_conf_id']);

        // STREAMPORT
        $streamPort = $sc_serv_id['PortBase'];

        // SSH CONFIG ANLEGEN
        $this->writeStationConf($sc_serv_rel['sc_serv_conf_id']);

        // SC_SERV Version
        $sc_serv = $this->getScServ($sc_serv_rel['sc_serv_version_id']);

        // SSH AUSFÜHREN
        $SSHConf = $this->getSSHConf();
        $connection = ssh2_connect($SSHConf['ip'], $SSHConf['port']);
        ssh2_auth_password($connection, $SSHConf['user'], $SSHConf['pass']);
        $ssh2_exec_com = ssh2_exec($connection, $_SERVER['DOCUMENT_ROOT'] . '/shoutcast/./' . $sc_serv . ' ' . $_SERVER['DOCUMENT_ROOT'] . '/shoutcastconf/' . $streamPort . '/sc_serv.conf </dev/null 2>/dev/null >/dev/null & echo $!');

        sleep(3);

        $pid = stream_get_contents($ssh2_exec_com);

        $this->setPID($sc_serv_conf_rel_id, $pid);

    }

    # Write the Station config to File
    public function writeStationConf($Sc_serv_conf_id)
    {

# Einlesen der Daten für SC_Serv
        $Sc_Serv_conf = \DB::queryFirstRow("SELECT * FROM sc_serv_conf WHERE id=%s", $Sc_serv_conf_id);

# Proof if Dir exist
        if (is_dir("shoutcastconf/" . $Sc_Serv_conf['PortBase']) == false) {
            $this->creatDirHome($Sc_Serv_conf['PortBase']);
        }

# ColumList aus der Datenbank
        $columns = \DB::columnList('sc_serv_conf');
        $Sc_Serv['conf'] = ''; # Array für die Spalte

# Datei öffnen
        $datei = fopen("shoutcastconf/" . $Sc_Serv_conf['PortBase'] . "/sc_serv.conf", "w+");
        foreach ($columns as $column) {
            $Sc_Serv['conf'][$column] = $Sc_Serv_conf[$column]; # Speichert alles in einem Array für Fehlerauswerung
        }
        foreach ($Sc_Serv['conf'] as $name => $wert) {
            if ($name == 'id' OR $wert == '') {
            } else {
                fwrite($datei, $name . '=' . $wert . "\r\n");
            }
        }
        fclose($datei); # Datei schließen
    }

    # Create the Home-Dir for StreamId
    private function creatDirHome($StreamPort)
    {
        mkdir('shoutcastconf/' . $StreamPort, 0755, true);
    }

    # Remove the Home Dir
    private function rmDir($StreamPort)
    {
        $this->rmDirLogic('shoutcastconf/' . $StreamPort);
    }

    # Logic for Remove non empty Folder
    private function rmDirLogic($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir") rrmdir($dir . "/" . $object); else unlink($dir . "/" . $object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    # Set PID to DB
    private function setPID($sc_serv_conf_id, $PID)
    {
        \DB::update('sc_rel', array(
            'sc_serv_pid' => $PID
        ), "id=%s", $sc_serv_conf_id);
    }

    # Stop and Kill the Server
    public function killSc_Serv($sc_serv_conf_rel_id)
    {

        $PID = \DB::queryFirstRow("SELECT sc_serv_pid FROM sc_rel WHERE id=%s", $sc_serv_conf_rel_id);
        $SSHConf = $this->getSSHConf();
        $connection = ssh2_connect($SSHConf['ip'], $SSHConf['port']);
        ssh2_auth_password($connection, $SSHConf['user'], $SSHConf['pass']);
        ssh2_exec($connection, 'kill -9 ' . $PID['sc_serv_pid']);
        sleep(3);
        $this->setPID($sc_serv_conf_rel_id, '0');
    }

    public function getScServ($tabelId)
    {
        $scservname = \DB::queryFirstRow("SELECT file_name FROM sc_version WHERE id=%s", $tabelId);
        return $scservname['file_name'];
    }


}
