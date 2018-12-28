<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 20.11.16
 * Time: 15:46
 */

namespace components\Helper;

use components\models\effect\Travma;
use components\models\NewDelo;
use components\models\User;

class PluginViolation
{
    /** @var User */
    protected $user;
    protected $message;
    protected $message1 = '�� ����������� �� (������), ����������� �������� �����. ����������, ������� ��� ������� ������ � ���������� ����������� ������ �� �������� ������� � ���������� ���� http://oldbk.com/encicl/?/plug.html';
    protected $message2 = '�� �� ��� ����������� ������, ����������� �������� �����. ����������, ������� ��� ������� ������ � ���������� ����������� ������ �� �������� ������� � ���������� ���� http://oldbk.com/encicl/?/plug.html. � ������ ���������� ��������� ��� �������� ������� ����� � ���� ����������� ������.';
    protected $message3 = '�� ������������� �������, ������������ �������� �����, ��� �������� �������� ����� � ���� ����������� ������ �� 1 ���. � ������ ���������� ��������� ���� ������ ����� �������� �� 1 ����. ���������� ����������� ������ ������� ����� �� �������� ������� � ���������� ���� http://oldbk.com/encicl/?/plug.html';
    protected $message4 = '�� ���������� ������������� �������, ������������ �������� �����, ��� �������� �������� ����� � ���� ����������� ������, 1 ���. ��� ������ ������ ����������� � ������������ ����� ������� http://oldbk.com/commerce/index.php?act=sendmess';

    private $_debug = false;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function make($num)
    {
        switch ($num) {
            case 1:
                return $this->violation1();
                break;
            case 2:
                return $this->violation2();
                break;
            case 3:
                return $this->violation3();
                break;
            case 4:
                return $this->violation4();
                break;
            default:
                return $this->violationDefault();
                break;
        }
    }

    protected function violation1()
    {
        $this->message = $this->message1;

        $_data = array(
            'owner'                 => $this->user->id,
            'owner_login'           => $this->user->login,
            'owner_balans_do'       => $this->user->money,
            'owner_balans_posle'    => $this->user->money,
            'item_count'            => 1,
            'add_info'              => '�������� �������������� � ������� ������������� ��������� ��������',
            'sdate'                 => time(),
            'type'                  => NewDelo::TYPE_PLUGIN_VIOLATION,
        );

        if($this->_debug === false && !NewDelo::addNew($_data)) {
            return false;
        }

        return true;
    }

    protected function violation2()
    {
        $this->message = $this->message2;

        $_data = array(
            'owner'                 => $this->user->id,
            'owner_login'           => $this->user->login,
            'owner_balans_do'       => $this->user->money,
            'owner_balans_posle'    => $this->user->money,
            'item_count'            => 2,
            'add_info'              => '�������� ��������� �������������� � ������� ������������� ��������� ��������',
            'sdate'                 => time(),
            'type'                  => NewDelo::TYPE_PLUGIN_VIOLATION,
        );

        if($this->_debug === false && NewDelo::addNew($_data) === false) {
            return false;
        }

        return true;
    }

    protected function violation3()
    {
        $this->message = $this->message3;

        $_data = array(
            'owner'                 => $this->user->id,
            'owner_login'           => $this->user->login,
            'owner_balans_do'       => $this->user->money,
            'owner_balans_posle'    => $this->user->money,
            'item_count'            => 3,
            'add_info'              => '�������� ������ �������������� � ������� ������������� ��������� ��������, ������� ����� � ���� ����������� ������, �� 1 ���',
            'sdate'                 => time(),
            'type'                  => NewDelo::TYPE_PLUGIN_VIOLATION,
        );

        if($this->_debug === false && NewDelo::addNew($_data) === false) {
            return false;
        }

        $finishTime = new \DateTime();
        $finishTime->modify('+1 hour');
        if($this->_debug === false && Travma::nelech($this->user->id, $finishTime, array('sila' => 70)) === false) {
            return false;
        }

        return true;
    }

    protected function violation4()
    {
        $this->message = $this->message4;

        $_data = array(
            'owner'                 => $this->user->id,
            'owner_login'           => $this->user->login,
            'owner_balans_do'       => $this->user->money,
            'owner_balans_posle'    => $this->user->money,
            'item_count'            => 4,
            'add_info'              => '�������� ��������� �������������� � ������� ������������� ��������� ��������, ������� ����� � ���� ����������� ������, 1 ���',
            'sdate'                 => time(),
            'type'                  => NewDelo::TYPE_PLUGIN_VIOLATION,
        );

        if($this->_debug === false && NewDelo::addNew($_data) === false) {
            return false;
        }

        $finishTime = new \DateTime();
        $finishTime->modify('+1 year');
        if($this->_debug === false && Travma::nelech($this->user->id, $finishTime, array('sila' => 70)) === false) {
            return false;
        }

        return true;
    }

    protected function violationDefault()
    {
        $this->message = $this->message4;

        return true;
    }

    public function getMessage()
    {
        return $this->message;
    }
}