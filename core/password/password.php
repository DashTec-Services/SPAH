<?php
/**
 * Created by David Schomburg (DashTec - Services)
 *      www.dashtec.de
 *
 *  S:P (StreamersPanel)
 *  Support: http://board.streamerspanel.de
 *
 *  v 0.19
 *
 *  Kundennummer:   @KDNUM@
 *  Lizenznummer:   @RECHNR@
 * Lizenz: http://login.streamerspanel.de/user/terms
 */
# Einfaches erstellen von sicheren Passswörtern. Dabei is der "salt" Key jeweils zu ersetzen! min. 22 Char!

namespace core\password;

class password
{
    public static $options = ['cost' => 7, 'salt' => 'BCryptMyLosser432MustBe22Char'];

    public static function createPassword($clearTextPassword)
    {
        $hash = password_hash($clearTextPassword, PASSWORD_BCRYPT, static::$options);

        return $hash;
    }

    public static function verifyPassword($clearTextPassword, $hash)
    {
        return password_verify($clearTextPassword, $hash);
    }
}