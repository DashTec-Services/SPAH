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
namespace core\sp_special;


class sctrans
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

    public function writeSc_TransConf($Sc_serv_conf_id)
    {

# Einlesen der Daten für SC_Serv
        $Sc_Serv_conf = \DB::queryFirstRow("SELECT * FROM sc_trans_conf WHERE id=%s", $Sc_serv_conf_id);

# Proof if Dir exist
        if (is_dir("shoutcastconf/" . $Sc_Serv_conf['serverport_1']) == false) {
            $this->creatDirHome($Sc_Serv_conf['serverport_1']);
        }

# ColumList aus der Datenbank
        $columns = \DB::columnList('sc_trans_conf');
        $Sc_Serv['trans'] = ''; # Array für die Spalte

# Datei öffnen
        $datei = fopen("shoutcastconf/" . $Sc_Serv_conf['serverport_1'] . "/sc_trans.conf", "w+");
        foreach ($columns as $column) {
            $Sc_Serv['trans'][$column] = $Sc_Serv_conf[$column]; # Speichert alles in einem Array für Fehlerauswerung
        }
        foreach ($Sc_Serv['trans'] as $name => $wert) {
            if ($name == 'id' OR $wert == '') {
            } else {
                fwrite($datei, $name . '=' . $wert . "\r\n");
            }
        }
        fclose($datei); # Datei schließen
    }

    public function startSc_Trans($sc_rel_id)
    {
        // Stream Conf
        $sc_serv_rel = \DB::queryFirstRow("SELECT * FROM sc_rel WHERE id=%s", $sc_rel_id);

        // StreamDaten
        $sc_serv_id = \DB::queryFirstRow("SELECT * FROM sc_serv_conf WHERE id=%s", $sc_serv_rel['sc_serv_conf_id']);

        // STREAMPORT
        $streamPort = $sc_serv_id['PortBase'];

        // SSH CONFIG ANLEGEN
        $this->writeSc_TransConf($sc_serv_rel['sc_serv_conf_id']);

        // SC_SERV Version
        $sc_trans = $this->getScTrans($sc_serv_rel['sc_trans_version_id']);

        // SSH AUSFÜHREN
        $SSHConf = $this->getSSHConf();
        $connection = ssh2_connect($SSHConf['ip'], $SSHConf['port']);
        ssh2_auth_password($connection, $SSHConf['user'], $SSHConf['pass']);
        $ssh2_exec_com = ssh2_exec($connection, $_SERVER['DOCUMENT_ROOT'] . '/shoutcast/./' . $sc_trans . ' ' . $_SERVER['DOCUMENT_ROOT'] . '/shoutcastconf/' . $streamPort . '/sc_trans.conf </dev/null 2>/dev/null >/dev/null & echo $!');
        sleep(3);

        $pid = stream_get_contents($ssh2_exec_com);


        $this->setPID($sc_rel_id, $pid);

    }

    public function killSc_Trans($sc_rel_id)
    {
        $PID = \DB::queryFirstRow("SELECT sc_trans_pid FROM sc_rel WHERE id=%s", $sc_rel_id);
        $SSHConf = $this->getSSHConf();
        $connection = ssh2_connect($SSHConf['ip'], $SSHConf['port']);
        ssh2_auth_password($connection, $SSHConf['user'], $SSHConf['pass']);
        ssh2_exec($connection, 'kill ' . $PID['sc_trans_pid']);
        sleep(3);
        $this->setPID($sc_rel_id, '0');
    }

    public function setPID($sc_serId, $PID)
    {
        \DB::update('sc_rel', array(
            'sc_trans_pid' => $PID
        ), "id=%s", $sc_serId);
    }

    public function getScTrans($tabelId)
    {

        $scservname = \DB::queryFirstRow("SELECT file_name FROM sc_version WHERE id=%s", $tabelId);
        return $scservname['file_name'];
    }


}