<?php

namespace components\Enum;


/**
 * Class DenyLogin
 */
class DenyLogin
{
    /**
     * @var array
     */
    private static $logins = [
        '���������',
        '��������',
        '�����������',
        '����������',
        '���������',
        'Merlin',
        '����������',
    ];

    /**
     * @param $login
     * @return bool
     */
    public static function isDenny($login)
    {
        foreach (self::$logins as $deny) {
            if (mb_strtoupper($login, "windows-1251") === mb_strtoupper($deny, "windows-1251")) {
                return true;
            }
        }

        return false;
    }
}