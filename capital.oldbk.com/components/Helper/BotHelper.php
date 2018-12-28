<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 08.02.2016
 */

namespace components\Helper;


class BotHelper
{
    const BOT_CHARODEJKA        = 1;
    const BOT_NASTAVNICK        = 2;
    const BOT_ALHIMIK           = 3;
    const BOT_ORAKUL            = 4;
    const BOT_STRAZH            = 5;
    const BOT_KOMENDANT         = 6;
    const BOT_MASTER_KALVIS     = 7;
    const BOT_BARMEN_PYATNICO   = 8;
    const BOT_JULIA             = 10;
    const BOT_DU_RANDIR         = 11;
    const BOT_KLER              = 12;
    const BOT_FLOWER            = 13;
    const BOT_ARCHIVARIUS       = 14;
    const BOT_MAG               = 15;
    const BOT_ALISA             = 16;
    const BOT_ALEXANDRO         = 17;
    const BOT_GALIAS         	= 18;
    const BOT_JAMES         	= 19;

    public static $links_main = array(
        self::BOT_STRAZH => '/outcity.php',
    );

    public static $bots = array(
        self::BOT_STRAZH            => '�����',
        self::BOT_CHARODEJKA        => '���������',
        self::BOT_NASTAVNICK        => '����������',
        self::BOT_ALHIMIK           => '������� ������',
        self::BOT_ORAKUL            => '������',
        self::BOT_KOMENDANT         => '���������',
        self::BOT_MASTER_KALVIS     => '������ �������',
        self::BOT_BARMEN_PYATNICO   => '������ �������',
        self::BOT_JULIA             => '������',
        self::BOT_DU_RANDIR         => '�� ������',
        self::BOT_KLER              => '����',
        self::BOT_FLOWER            => '����������',
        self::BOT_ARCHIVARIUS       => '����������',
        self::BOT_MAG               => '���',
        self::BOT_ALISA             => '�����',
        self::BOT_ALEXANDRO         => '���������',
        self::BOT_GALIAS            => '�������� ������',
        self::BOT_JAMES            	=> '�������� ������',
    );

    public static function getBotLogin($bot_id)
    {
        return self::$bots[$bot_id];
    }
}