<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 19.10.2015
 */

$mode = 'production';
if($_SERVER['SERVER_NAME'] == 'oldbk.local' || PHP_OS === 'Darwin') {
    $mode = 'local';
} elseif($_SERVER['SERVER_NAME'] == 'dev.oldbk.com') {
    $mode = 'development';
}

require_once __DIR__ . '/bootstrap_base.php';


$key = $app->session->get('test_key');// ��� ���� ���???
/*if (PRODUCTION_MODE) {
    //���������� ��� ������ ������� � ���������� ���� ����. ���� ������ 30 ���� ���� ���������
    \components\Component\Slim\Log\MonologWriter::manualWriteData(
        'alldata',
        'All data',
        [
            'day' => 30,
            'level' => 'debug'
        ],
        true,
        false,
        'log'
    );
}*/
