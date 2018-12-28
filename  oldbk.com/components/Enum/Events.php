<?php


namespace components\Enum;
use Carbon\Carbon;


/**
 * Class Events
 * @package components\Enum
 */
class Events
{
    public $current_month = 0;
    public $current_year = 0;
    public $events = [];

    public function __construct()
    {
        $this->current_month = Carbon::now()->month;
        $this->current_year = Carbon::now()->year;


        //���������� ������
        $this->setEvents([
            // � 1 ������� �� 31 ������
            'sertstart' => $this->current_month == 12 ? mktime(0, 0, 0, 12, 1, $this->current_year) : mktime(0, 0, 0, 1, 1, $this->current_year),
            'sertend' => $this->current_month == 12 ? mktime(23, 59, 59, 12, 31, $this->current_year) : mktime(23, 59, 59, 1, 30, $this->current_year),

            /*
                [2:06:53] �������: �� 55600008
                �� 55600047
                [2:07:14] �������: �� ������� ���� ������. ������� 1 �������. ������ - ������ �������
                ��� ������� ���� ��������
            */


            /*
                ����� � 10 ������� �� 31 ������� // ��������� ���������
            */
            'larcistart' => mktime(0, 0, 0, 12, 10, $this->current_year - 2),
            'larciend' => mktime(23, 59, 59, 12, 31, $this->current_year - 2),


            /* ���� �� �� � 15 ������� �� 30 ������ 23:59  */
            'elkacpstart' => $this->current_month == 12 ? mktime(0, 0, 0, 12, 15, $this->current_year) : mktime(0, 0, 0, 1, 1, $this->current_year),
            'elkacpend' => $this->current_month == 12 ? mktime(23, 59, 59, 12, 31, $this->current_year) : mktime(23, 59, 59, 2, 29, $this->current_year),


            /* ������� �� ���� ����� ����� � 20 ������� � 1:30 ���� �� 29 ������ 23:59  */
            'elkacpgiftstart' => $this->current_month == 12 ? mktime(1, 30, 0, 12, 20, $this->current_year) : mktime(0, 0, 0, 1, 1, $this->current_year),
            'elkacpgiftend' => $this->current_month == 12 ? mktime(23, 59, 59, 12, 31, $this->current_year) : mktime(23, 59, 59, 1, 29, $this->current_year),

            /* ��� �� ���� ����� ����� � 29 ������� �� 2 ������ 23:59  */
            'elkacpeatstart' => $this->current_month == 12 ? mktime(0, 0, 0, 12, 29, $this->current_year) : mktime(0, 0, 0, 1, 1, $this->current_year),
            'elkacpeatend' => $this->current_month == 12 ? mktime(23, 59, 59, 1, 2, $this->current_year + 1) : mktime(23, 59, 59, 1, 2, $this->current_year),

            /* ����� �� ���� ����� ����� � 20 ������� c 1:30 �� 10 ������ 23:59  */
            'elkacpcarnavalstart' => $this->current_month == 12 ? mktime(1, 30, 0, 12, 20, $this->current_year) : mktime(0, 0, 0, 1, 1, $this->current_year),
            'elkacpcarnavalend' => $this->current_month == 12 ? mktime(23, 59, 59, 12, 31, $this->current_year) : mktime(23, 59, 59, 1, 10, $this->current_year),

            /* ������� ���� � ��������� */
            'elkadropstart' => $this->current_month == 12 ? mktime(0, 0, 0, 12, 15, $this->current_year) : mktime(0, 0, 0, 1, 1, $this->current_year),
            'elkadropend' => $this->current_month == 12 ? mktime(23, 59, 59, 2, 28, $this->current_year + 1) : mktime(23, 59, 59, 2, 28, $this->current_year),

            /* 10% ����� �� ��������� � 29 ������� �� 2 ������ 23:59  */
            'ngloseexpstart' => $this->current_month == 12 ? mktime(0, 0, 0, 12, 29, $this->current_year) : mktime(0, 0, 0, 1, 1, $this->current_year),
            'ngloseexpend' => $this->current_month == 12 ? mktime(23, 59, 59, 12, 31, $this->current_year) : mktime(23, 59, 59, 1, 2, $this->current_year),

            /* 10% ����� �� ��������� � 00:00 14 �� �� 23:59 15 ������  */
            'hbloseexpstart' => mktime(0, 0, 0, 1, 14, $this->current_year),
            'hbloseexpend' => mktime(23, 59, 59, 1, 15, $this->current_year),

            /* ������ */
            'skupkastart' => mktime(0, 0, 0, 12, 29, $this->current_year),
            'skupkaend' => mktime(23, 59, 59, 12, 30, $this->current_year),

            /* �������� ����� ����� */
            'nghaosstart' => $this->current_month == 12 ? mktime(0, 0, 0, 12, 29, $this->current_year) : mktime(0, 0, 0, 1, 1, $this->current_year),
            'nghaosend' => $this->current_month == 12 ? mktime(23, 59, 59, 12, 31, $this->current_year) : mktime(23, 59, 59, 1, 2, $this->current_year),

            /* ����� �� ��������� � 00:00 14 �� �� 23:59 15 ������ */
            'hbhaosstart' => mktime(0, 0, 0, 1, 14, $this->current_year),
            'hbhaosend' => mktime(23, 59, 59, 1, 15, $this->current_year),
        ]);

    }

    public function setEvents(array $events)
    {
        $this->events = $events;
    }


}