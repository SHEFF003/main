<?php


namespace components\Helper;

/**
 * Class RoutesHelper
 * @package components\Helper
 */
class RoutesHelper
{

    /**
     * @return mixed
     * � ����� �� ������ ���� ������ ����� ������ ��������!!!
     */
    public static function getRoutes()
    {
        return \Storage::files('/components/Routes');
    }
}