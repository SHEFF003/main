<?php
namespace components;
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 03.11.2015
 */
class Helper
{
    public static function login_fix_for_delo($rec)
    {
        if($rec[type]==35)     {$row[target_login]="���� �������� ��������";}
        elseif($rec[type]==80) {$rec[target_login]="������ �������� �����";}
        elseif($rec[type]==19) {$rec[target_login]="�������� ��������";}
        elseif($rec[type]==401){$rec[target_login]="��������� �������";}
        elseif($rec[type]==172){$rec[target_login]="�������� �����";}

        elseif($rec[type]==270 || $rec[type]==271) {$rec[target_login]="������ ��������";}
        elseif($rec[type]==1 || $rec[type]==34) {$rec[target_login]="��������������� �������";}
        elseif($rec[type]==251 && $rec[target_login]=='����1') {$rec[target_login]="�������� (�������)";}
        elseif($rec[type]==251 && $rec[target_login]=='����2') {$rec[target_login]="�������� (�����������)";}
        elseif($rec[type]==251 && $rec[target_login]=='����3') {$rec[target_login]="�������� (����������)";}
        elseif($rec[type]==120 || $rec[type]==124) {$rec[target_login]="������������ �������";}
        elseif($rec[type]==191 || $rec[type]==198 || $rec[type]==197 || $rec[type]==177 || $rec[type]==193 || $rec[type]==194 || $rec[type]== 179) {$rec[target_login]="��������� ����������";}

        return $rec;
    }

    /**
     * @param $rec
     * @param $al
     * @param string $sql_str
     * @param $add_info_off
     * @return mixed|string
     */
    public static function get_delo_rec($rec,$al,$sql_str="",$add_info_off)
    {
        //  $rec['owner']
        //  $rec['owner_login']
        //  $rec['owner_balans_do']
        //  $rec['owner_balans_posle']

        //  $rec['owner_rep_do']
        //  $rec['owner_rep_posle']

        //  $rec['target'] ����
        //  $rec['target_login']+
        //  $rec['type']+
        //  $rec['sdate']+
        //  $rec['sum_kr']+
        //  $rec['sum_ekr']+
        //  $rec['sum_rep']+
        //  $rec['sum_kom']+
        //  $rec['item_id']+'������� �� c ������� ����� �������'
        //  $rec['item_name'] +
        //  $rec['item_count']+
        //  $rec['item_type']
        //  $rec['item_cost']+
        //  $rec['item_dur']+
        //  $rec['item_maxdur']+
        //  $rec['item_ups']+
        //  $rec['item_unic']+
        //  $rec['item_incmagic']
        //  $rec['item_incmagic_count']
        //  $rec['item_arsenal']
        //  $rec['battle']
        //  $rec['bank_id']
        //  $rec['add_info'] -- ���� ���� �����

        //��������� ������

        //����� ����� ����� ����

        $delo_type[10001]="��������� ���� \"{$rec['item_name']}\".";
        $delo_type[10002]="\"{$rec['owner_login']}\" ������� {$rec['add_info']} ���������� �� ������ \"{$rec['target_login']}\".";
        $delo_type[10003]="\"{$rec['owner_login']}\" ������� ����������, ���� ����� \"{$rec['target_login']}\".";
        $delo_type[10007]="� ��������� \"{$rec['owner_login']}\", ������� �������������� � ����������� ����� �{$rec['bank_id']}, ����� \"{$rec['sum_ekr']}\" ���.";
        //��� ������� (�������, �����, ������� � �� -�� ������, ������, ������ � ��...) ��� ���������!!
        //�����/����/����
        {
            //�����
            {
                //�������
                {

                    $delo_type[7]="\"{$rec['owner_login']}\" ������� {$rec['sum_kr']} ��. ������� ������ �� ������ �� ���.";
                    $delo_type[10]="\"{$rec['owner_login']}\" ������� {$rec['sum_kr']} ��. ��� ������ ��� ";
                    $delo_type[286]="\"{$rec['owner_login']}\" ������� {$rec['sum_kr']} ��. �� ������� � ��������, ������� {$rec['add_info']} ";
                    $delo_type[12]="\"{$rec['owner_login']}\" ������� {$rec['sum_kr']} ��. �� \"{$rec['target_login']}\" (� ���������).";
                    $delo_type[13]="\"{$rec['owner_login']}\" ������� {$rec['sum_kr']} ��. �� \"{$rec['target_login']}\" (�� ��� � ���������).";
                    $delo_type[15]="\"{$rec['owner_login']}\" ������� {$rec['sum_kr']} ��. �� ������ � �������� �{$rec['battle']}";
                    $delo_type[1515]="\"{$rec['owner_login']}\" ������� {$rec['sum_kr']} ��. �������� �{$rec['battle']}";
                    $delo_type[16]="\"{$rec['owner_login']}\" ������� {$rec['sum_kr']} ��. �� ����� � �������� �{$rec['battle']}";
                    $delo_type[18]="\"{$rec['owner_login']}\" ������� {$rec['sum_kr']} ��. ������� ������ (������ � ������ �� ������).";
                    $delo_type[25]="\"{$rec['owner_login']}\" �������� �� {$rec['sum_kr']} ��. ���� ���� �.{$rec['bank_id']} � �����.";
                    $delo_type[26]="\"{$rec['owner_login']}\" ���� {$rec['sum_kr']} ��. �� ������ ����� �.{$rec['bank_id']} � �����.";
                    $delo_type[27]="\"{$rec['owner_login']}\" ������� {$rec['sum_ekr']} ���. �� {$rec['sum_kr']} ��. �� ����� ����� �.{$rec['bank_id']} � �����.";
                    $delo_type[37]="�������� ������� {$rec['sum_kr']} ��. �� \"{$rec['target_login']}\" � \"{$rec['owner_login']}\"".($rec['add_info']!=''?' ������ �������:<b>'.$rec['add_info'].'</b>':'');
                    $delo_type[43]="\"{$rec['owner_login']}\" ������� {$rec['sum_kr']} �� �� ������ ����������� �������� \"{$rec['item_name']}\"  �� \"{$rec['target_login']}\"";
                    $delo_type[50]="\"{$rec['owner_login']}\" ������� {$rec['sum_kr']} ��. �� ���� ���� �.{$rec['bank_id']} � ����� �� ����� �{$rec['add_info']} ��������� \"{$rec['target_login']}\" ������� {$rec['sum_kom']} ��.";
                    $delo_type[57]="\"{$rec['owner_login']}\" ������� {$rec['sum_kr']} ��. , �� ������ \"{$rec['target_login']}\" �� �������� �����.";
                    $delo_type[69]="\"{$rec['owner_login']}\" ������� {$rec['sum_kr']} ��., ������� ������ (������ � ������ �� ������).";
                    $delo_type[101]="\"{$rec['owner_login']}\" ������� {$rec['sum_kr']} ��., {$rec['sum_rep']} ��������� �� ������� � ������� ����� ������";
                    $delo_type[102]="\"{$rec['owner_login']}\" ��������� ��� �� {$rec['sum_kr']} ��. � �����������";
                    $delo_type[104]="\"{$rec['owner_login']}\" ������� ������� �� ������� ����� {$rec['sum_kr']} ��.";

                    $delo_type[1104]="\"{$rec['owner_login']}\" �������� {$rec['sum_kr']} ��. ��  \"{$rec['target_login']}\".";

                    $delo_type[105]="\"{$rec['owner_login']}\" ���������� {$rec['sum_kr']} ��. �� ��������� ������(��) (x{$rec['item_count']} �� �����).";
                    $delo_type[108]="\"{$rec['owner_login']}\" ���������� {$rec['sum_kr']} ��. �� ����� ������ �� ����� � ������ {$rec['target_login']}.";
                    $delo_type[110]="\"{$rec['owner_login']}\" ������� {$rec['sum_kr']} ��. �� ����� ������� ������ (x{$rec['item_count']} ������) � ����� � ������������ ���� � �������.";
                    $delo_type[111]="\"{$rec['owner_login']}\" ������� {$rec['sum_kr']} ��. �� ����� � ������ �� ����� {$rec['target_login']}.";
                    $delo_type[112]="\"{$rec['owner_login']}\" ������� {$rec['sum_kr']} ��. �� ����� ������ �� ������ � ����� � ����� {$rec['target_login']}.";
                    $delo_type[113]="\"{$rec['owner_login']}\" �������� ������� �� 14� �������. ������� ����� +100% ����� ���� �� ����� �������:{$rec['add_info']} ����� ";
                    $delo_type[114]="\"{$rec['owner_login']}\" ����� +100% ����� �������, �������:{$rec['add_info']} �����.";
                    $delo_type[167]="������ �������� ������� {$rec['sum_kr']} ��. �� \"{$rec['target_login']}\" � \"{$rec['owner_login']}\"";
                    $delo_type[181]="\"{$rec['owner_login']}\" ������� {$rec['sum_kr']} ��. �� ���������� ������ \"{$rec['add_info']}\".";
                    $delo_type[184]="\"{$rec['owner_login']}\" ������� {$rec['sum_kr']} ��. �� ������ � ��������� �� ���� \"{$rec['target_login']}\".";
                    $delo_type[201]="\"{$rec['owner_login']}\" ������ {$rec['sum_kr']} ��. �� ������� � ������� �� ������";
                    $delo_type[258]="\"{$rec['owner_login']}\" ������� {$rec['sum_kr']} ��. �� ������� ������ ������";
                    $delo_type[259]="\"{$rec['owner_login']}\" ������� {$rec['sum_kr']} ��. �� ���������� ����";
                    $delo_type[262]="\"{$rec['owner_login']}\" ������� {$rec['sum_kr']} ��. �� �������";
                    $delo_type[408]="\"{$rec['owner_login']}\" ������� {$rec['sum_kr']} ��. �� ����� ����� {$rec['add_info']} ";
                    $delo_type[342]="\"{$rec['owner_login']}\" ������� {$rec['sum_kr']} ��. �� ����� ����� {$rec['add_info']}, �� ������� �������.";
                    $delo_type[367]="\"{$rec['owner_login']}\" ������� {$rec['sum_kr']} ��. ������� ��� ������ ������� �������.";
                    $delo_type[368]="\"{$rec['owner_login']}\" ������� {$rec['sum_kr']} ��. ������� �� ������ \"��������� ���� {$rec['item_ups']}\" ";
                    $delo_type[511]="\"{$rec['owner_login']}\" �������  {$rec['sum_kr']} ��. �� ���� {$rec['bank_id']} �� �������  {$rec['sum_ekr']} ���. �� �����";

                }
                //��������
                {
                    $delo_type[289]="\"{$rec['owner_login']}\" ����������� {$rec['sum_kr']} ��., {$rec['sum_ekr']} ���., {$rec['sum_rep']} ��������� �� ������������� ����� ����� �����������.";
                    $delo_type[290]="\"{$rec['owner_login']}\" ����������� \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��. �� ������������� ����� ����� �����������.";
                    $delo_type[287]="\"{$rec['owner_login']}\" �������� {$rec['sum_kr']} ��. �� ����� � �������� ���������.";
                    $delo_type[24]="\"{$rec['owner_login']}\" �������� {$rec['sum_kr']} ��. �� �������� ����� �.{$rec['bank_id']} � �����.";
                    $delo_type[6]="\"{$rec['owner_login']}\" �������� {$rec['sum_kr']} ��. �� ������� � ��������.";
                    $delo_type[366]="\"{$rec['owner_login']}\" �������� {$rec['sum_kr']} ��. �� ������� � ������� �������.";
                    $delo_type[17]="\"{$rec['owner_login']}\" �������� {$rec['sum_kr']} ��. ����� ������ �������������.";
                    $delo_type[36]="���������� ������� {$rec['sum_kr']} ��. �� \"{$rec['owner_login']}\" � \"{$rec['target_login']}\"".($rec['add_info']!=''?' ������ �������:<b>'.$rec['add_info'].'</b>':'');
                    $delo_type[42]="\"{$rec['owner_login']}\" �������� {$rec['sum_kr']} �� �� ����������� ����:\"{$rec['item_name']}\" ����� ���� \"{$rec['target_login']}\" (��������:{$rec['sum_kom']} ��.)";
                    $delo_type[44]="\"{$rec['owner_login']}\" �������� {$rec['sum_ekr']} ���. �� ������ ����� �.{$rec['bank_id']} � ����� �� ����� ������.";
                    $delo_type[47]="\"{$rec['owner_login']}\" �������� {$rec['sum_ekr']} ���. �� ������ ����� �.{$rec['bank_id']} � ����� �� ������� ������ ����������.";
                    $delo_type[48]="\"{$rec['owner_login']}\" �������� {$rec['sum_ekr']} ���. �� ������ ����� �.{$rec['bank_id']} � ����� �� ������� ����������� ����������.";
                    $delo_type[96]="\"{$rec['owner_login']}\" �������� {$rec['sum_ekr']} ���. �� ������ ����� �.{$rec['bank_id']} � ����� �� ������� ������� ����������.";
                    $delo_type[97]="\"{$rec['owner_login']}\" �������� {$rec['sum_ekr']} ���. �� ������ ����� �.{$rec['bank_id']} � ����� �� ����� ���� �� {$rec['add_info']} .";
                    $delo_type[49]="\"{$rec['owner_login']}\" ������� {$rec['sum_kr']} ��. �� ������ ����� �.{$rec['bank_id']} � ����� �� ���� �{$rec['add_info']} ��������� \"{$rec['target_login']}\" ������� {$rec['sum_kom']} ��.";
                    $delo_type[100]="\"{$rec['owner_login']}\" �������� {$rec['sum_kr']} ��. �� ������� � ������� ����� ������";
                    $delo_type[103]="\"{$rec['owner_login']}\" ������ {$rec['sum_kr']} �� � ������ �����.";
                    $delo_type[106]="\"{$rec['owner_login']}\" �������� {$rec['sum_kr']} ��. �� ����� ����� {$rec['target_login']} �� �����.";
                    $delo_type[107]="\"{$rec['owner_login']}\" �������� {$rec['sum_kr']} ��. �� ����� ����� {$rec['target_login']} �� ������ � �����.";
                    $delo_type[109]="\"{$rec['owner_login']}\" �������� {$rec['sum_kr']} ��. �� ����� �� ����� �� ����� {$rec['target_login']}.";
                    $delo_type[124]="\"{$rec['owner_login']}\" �������� {$rec['sum_kr']} ��. �� ����� ���� �� ������� \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}].";
                    $delo_type[130]="\"{$rec['owner_login']}\" �������� {$rec['sum_kr']} ��. 5 �������� ���������.";
                    $delo_type[131]="\"{$rec['owner_login']}\" �������� {$rec['sum_kr']} ��. �� ������������� ���������.";
                    $delo_type[132]="\"{$rec['owner_login']}\" �������� {$rec['sum_kr']} ��. �� ������� ������.";
                    $delo_type[133]="\"{$rec['owner_login']}\" �������� {$rec['sum_kr']} ��. �� �������� �� ����� ���������.";
                    $delo_type[134]="\"{$rec['owner_login']}\" ������� {$rec['sum_kr']} ��. � ����� ����� {$rec['target_login']}. ({$rec['add_info']})";
                    $delo_type[135]="\"{$rec['owner_login']}\" �������� {$rec['sum_kr']} ��. �� ����������� ��������� {$rec['target_login']} � ����.";
                    $delo_type[166]="������ ���������� ������� {$rec['sum_kr']} ��. �� \"{$rec['owner_login']}\" � \"{$rec['target_login']}\", ����� �������� {$rec['sum_kom']}. ������ �������:{$rec['add_info']}";
                    $delo_type[170]="\"{$rec['owner_login']}\" �������� {$rec['sum_kr']} ��. �� ����������������� ������ � �������.";
                    $delo_type[171]="\"{$rec['owner_login']}\" �������� {$rec['sum_kr']} ��. �� ����� ������ � �������.";
                    $delo_type[5010]="\"{$rec['owner_login']}\" �������� {$rec['sum_kr']} ��. �� ����� ������ � �������.";

                    $delo_type[1105]="\"{$rec['owner_login']}\" �������� {$rec['sum_kr']} ��. �  \"{$rec['target_login']}\".";

                    $delo_type[175]="\"{$rec['owner_login']}\" �������� {$rec['sum_kr']}��. �� ������� ������ � ��.";
                    $delo_type[1175]="\"{$rec['owner_login']}\" �������� {$rec['sum_kr']}��. �� ������� ������ � ���������.";
                    $delo_type[190]="\"{$rec['owner_login']}\" �������� {$rec['sum_kr']} ��. �� ��������� ���������� �� ������� \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��.";
                    $delo_type[191]="\"{$rec['owner_login']}\" �������������� ������� \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��. �� ".($rec['sum_kr']>0?$rec['sum_kr']." ��.":$rec['sum_ekr']." ���.");
                    $delo_type[192]="\"{$rec['owner_login']}\" ������� �� �������� \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��. �� {$rec['sum_kr']} ��.";
                    $delo_type[193]="\"{$rec['owner_login']}\" ������� ����� �������� \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��. �� {$rec['sum_kr']} ��.";
                    $delo_type[194]="\"{$rec['owner_login']}\" ������� �� �������� \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��. �� {$rec['sum_kr']} ��.";
                    $delo_type[197]="\"{$rec['owner_login']}\" ����������� ������� \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��. �� {$rec['sum_ekr']} ���.";
                    $delo_type[200]="\"{$rec['owner_login']}\" �������� {$rec['sum_kr']} ��. �� ������� � ������� �� ������";
                    $delo_type[252]="\"{$rec['owner_login']}\" �������� {$rec['sum_kr']} ��. ���������� ����";
                    $delo_type[257]="\"{$rec['owner_login']}\" �������� {$rec['sum_kr']} ��. ������ �� ������� ������";
                    $delo_type[263]="\"{$rec['owner_login']}\" ��� �������� �� {$rec['sum_kr']} ��.";
                    $delo_type[320]="\"{$rec['owner_login']}\" �������� {$rec['sum_kom']} ��. �� ��������� �������� �������� :\"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] � ������������ ��������.";
                    $delo_type[321]="\"{$rec['owner_login']}\" �������� {$rec['sum_kr']} ��. �� �������� ������ ��������!";
                    $delo_type[322]="\"{$rec['owner_login']}\" �������� {$rec['sum_kr']} ��. �� ����� �������� � �������!";
                    $delo_type[402]="\"{$rec['owner_login']}\" �������� {$rec['sum_kr']} ��. �� �������� �������\" {$rec['item_name']} [{$rec['item_dur']}/{$rec['item_maxdur']}] ";
                    $delo_type[406]="\"{$rec['owner_login']}\" ������ ���� ����� ��� �����  �������{$rec['add_info']} ";
                    $delo_type[407]="\"{$rec['owner_login']}\" �������� ����� ����� {$rec['add_info']} �� {$rec['sum_kr']} ��.";
                }
            }
            //����
            {
                //�������
                {
                    $delo_type[409]="\"{$rec['owner_login']}\" ������� {$rec['sum_ekr']} ���. �� ���� {$rec['bank_id']} �� ����� ����� {$rec['bank_id']} ";
                    $delo_type[11]="\"{$rec['owner_login']}\" ������� {$rec['sum_ekr']} ���. �� ���� {$rec['bank_id']} �� ������������� �� ���������� ���������� \"{$rec['target_login']}\" ������ ";
                    $delo_type[1111]="\"{$rec['owner_login']}\" ������� {$rec['sum_ekr']} ���. �� ���� {$rec['bank_id']} �� ������������� �� ��������� ������ \"������ ����\" ";
                    $delo_type[29]="\"{$rec['owner_login']}\" ������� {$rec['sum_kr']} ��. �� {$rec['sum_ekr']} ���. �� ����� ����� �.{$rec['bank_id']} � �����.";
                    $delo_type[51]="\"{$rec['owner_login']}\" ������� {$rec['sum_ekr']} ���. �� ���� ���� �.{$rec['bank_id']} � �����, �� ������ \"{$rec['target_login']}\" ";
                    $delo_type[52]="\"{$rec['owner_login']}\" ����� ������ �� {$rec['sum_ekr']} ���, ����� ������ \"{$rec['target_login']}\".";
                    $delo_type[55]="\"{$rec['owner_login']}\" ������� ����� �� ������� ���������� {$rec['sum_ekr']} ���. �� ���� ���� �{$rec['bank_id']} � �����, �� ������ \"{$rec['target_login']}\" ";
                    $delo_type[355]="\"{$rec['owner_login']}\" ������� ����� �� ������� {$rec['sum_ekr']} ���. �� ���� ���� �{$rec['bank_id']} � �����, �� ������ \"{$rec['target_login']}\" ";
                    $delo_type[356]="\"{$rec['owner_login']}\" ������� ����� �� ��������� ����������� {$rec['sum_ekr']} ���. �� ���� ���� �{$rec['bank_id']} � �����.";
                    $delo_type[357]="\"{$rec['owner_login']}\" ������� ����� �� ����� {$rec['sum_ekr']} ���. �� ���� ���� �{$rec['bank_id']} � �����.";
                    $delo_type[68]="\"{$rec['owner_login']}\" ������� {$rec['sum_ekr']} ���. �� ���� {$rec['bank_id']} ����� ����.";
                    $delo_type[45]="\"{$rec['owner_login']}\" ������� {$rec['sum_ekr']} ���. �� ���� ���� �.{$rec['bank_id']} � ����� �� ����� ���������� �������.";
                    $delo_type[46]="\"{$rec['owner_login']}\" ������� {$rec['sum_ekr']} ���. �� ���� ���� �.{$rec['bank_id']} � ����� �� ����� \"{$rec['item_name']}\" (x{$rec['item_count']}).";
                    $delo_type[261]="\"{$rec['owner_login']}\" �������� ���� ���� �.{$rec['bank_id']} � �����, �� {$rec['sum_ekr']} ���.";
                    $delo_type[311]="\"{$rec['owner_login']}\" ������� {$rec['sum_ekr']} ���. �� ���� �.{$rec['bank_id']} � �����, ��� ������ ����� ������������� ������, ����� ����� �{$rec['add_info']}";
                    $delo_type[312]="\"{$rec['owner_login']}\" ������ ������ � ����� � �������� ����� ����� �� {$rec['sum_ekr']} ���.";
                    $delo_type[370]="\"{$rec['owner_login']}\" ������� {$rec['sum_ekr']} ���. �� ���� {$rec['bank_id']} �� ����� \"{$rec['target_login']}\".";
                    $delo_type[3369]="\"{$rec['owner_login']}\" ������� {$rec['sum_ekr']} ���. �� ���� ������������� ������, � ��������� \"{$rec['target_login']}\".";
                    $delo_type[3370]="\"{$rec['owner_login']}\" ������� {$rec['sum_ekr']} ���. �� ���� ��, �� ����� �{$rec['bank_id']} �� ��������� \"{$rec['target_login']}\".";
                    $delo_type[3371]="\"{$rec['owner_login']}\" ������� {$rec['sum_ekr']} ���. �� ���� �{$rec['bank_id']} � ��������� \"{$rec['target_login']}\" (�������).";
                    $delo_type[3372]="\"{$rec['owner_login']}\" ������� {$rec['sum_ekr']} ���. �� ���� �{$rec['bank_id']} �� ��������� \"{$rec['target_login']}\" (�������).";
                    $delo_type[510]="\"{$rec['owner_login']}\" ����� {$rec['sum_ekr']} ���. �� ���� {$rec['bank_id']} �� {$rec['sum_kr']} ��.  �� �����";
                    $delo_type[1106]="\"{$rec['owner_login']}\" �������� {$rec['sum_ekr']} ���. ��  \"{$rec['target_login']}\", �� ����� �{$rec['bank_id']}.";
                }
                //��������
                {
                    $delo_type[323]="\"{$rec['owner_login']}\" �������� {$rec['sum_ekr']} e��. �� ����� �{$rec['bank_id']},  �� �������  ����� ������ � �������!";
                    $delo_type[8]="\"{$rec['owner_login']}\" �������� {$rec['sum_ekr']} ���. �� ������ ����� {$rec['bank_id']} �� ������ �������� \"{$rec['item_name']}\" �� {$rec['add_info']}.";
                    $delo_type[9]="\"{$rec['owner_login']}\" �������� {$rec['sum_ekr']} ���. �� ������ ����� {$rec['bank_id']} �� ��������� ������ �������� \"{$rec['item_name']}\" �� {$rec['add_info']}.";
                    $delo_type[30]="\"{$rec['owner_login']}\" �������� {$rec['sum_ekr']} ���. �� ������ ����� �.{$rec['bank_id']} � ����� �� ����������������� ������.";
                    $delo_type[31]="\"{$rec['owner_login']}\" �������� {$rec['sum_ekr']} ���. �� ������ ����� �.{$rec['bank_id']} � ����� �� ����������������� ������.";
                    $delo_type[53]="\"{$rec['owner_login']}\" ������� ������ �����, ����� ������ \"{$rec['target_login']}\".";
                    $delo_type[58]="\"{$rec['owner_login']}\" ����� {$rec['add_info']} ���������� �� {$rec['sum_ekr']} ���, ����� ������ \"{$rec['target_login']}\".";

                    $delo_type[59]="\"{$rec['owner_login']}\" ��������/������� Silver account �� {$rec['sum_ekr']} ���, 5 ��� �� ���� �{$rec['bank_id']}, ������ �� {$rec['add_info']}, �����  \"{$rec['target_login']}\".";
                    $delo_type[459]="\"{$rec['owner_login']}\" ��������/������� Silver account �� {$rec['sum_ekr']} ���, ������ �� {$rec['add_info']}, �����  \"{$rec['target_login']}\".";

                    $delo_type[359]="\"{$rec['owner_login']}\" ��������/������� Gold account �� {$rec['sum_ekr']} ���, 5 ��� �� ���� �{$rec['bank_id']}, ������ �� {$rec['add_info']}, �����  \"{$rec['target_login']}\".";
                    $delo_type[559]="\"{$rec['owner_login']}\" ��������/������� Gold account �� {$rec['sum_ekr']} ���, ������ �� {$rec['add_info']}, �����  \"{$rec['target_login']}\".";

                    $delo_type[358]="\"{$rec['owner_login']}\" ��������/������� Platinum account �� {$rec['sum_ekr']} ���, 5 ��� �� ���� �{$rec['bank_id']}, ������ �� {$rec['add_info']}, �����  \"{$rec['target_login']}\".";
                    $delo_type[558]="\"{$rec['owner_login']}\" ��������/������� Platinum account �� {$rec['sum_ekr']} ���, ������ �� {$rec['add_info']}, �����  \"{$rec['target_login']}\".";

                    $delo_type[310]="\"{$rec['owner_login']}\" �������� {$rec['sum_ekr']} ���. �� ������ ����� �.{$rec['bank_id']} � ����� �� ������ ������������� ������, ����� ����� �{$rec['add_info']}";
                    $delo_type[2283]="\"{$rec['owner_login']}\" �������� {$rec['sum_ekr']} ���. �� ������ ����� �.{$rec['bank_id']} � ����� �� ������ ������������� ������. {$rec['add_info']}";
                    //������ ��������� �����
                    $delo_type[70]="\"{$rec['owner_login']}\" �������� {$rec['sum_ekr']} ���. �� ������ ����� �{$rec['bank_id']} � �����, �� ������������� ������: \"��������� ����������\". (������� �� �����:{$rec['add_info']} ���.) ";
                    $delo_type[71]="\"{$rec['owner_login']}\" �������� {$rec['sum_ekr']} ���. �� ������ ����� �{$rec['bank_id']} � �����, �� ������������� ������: \"���������\". (������� �� �����:{$rec['add_info']} ���.) ";
                    $delo_type[72]="\"{$rec['owner_login']}\" �������� {$rec['sum_ekr']} ���. �� ������ ����� �{$rec['bank_id']} � �����, �� ������������� ������: \"�������� ���������\". (������� �� �����:{$rec['add_info']} ���.) ";
                    $delo_type[73]="\"{$rec['owner_login']}\" �������� {$rec['sum_ekr']} ���. �� ������ ����� �{$rec['bank_id']} � �����, �� ������������� ������: \"������� �����\". (������� �� �����:{$rec['add_info']} ���.) ";
                    $delo_type[74]="\"{$rec['owner_login']}\" �������� {$rec['sum_ekr']} ���. �� ������ ����� �{$rec['bank_id']} � �����, �� ������������� ������: \"�������� 30 ���.\". (������� �� �����:{$rec['add_info']} ���.) ";
                    $delo_type[75]="\"{$rec['owner_login']}\" �������� {$rec['sum_ekr']} ���. �� ������ ����� �{$rec['bank_id']} � �����, �� ������������� ������: \"���������� �����\". (������� �� �����:{$rec['add_info']} ���.) ";
                    $delo_type[76]="\"{$rec['owner_login']}\" �������� {$rec['sum_ekr']} ���. �� ������ ����� �{$rec['bank_id']} � �����, �� ������������� ������: \"����� �� ���\". (������� �� �����:{$rec['add_info']} ���.) ";
                    $delo_type[77]="\"{$rec['owner_login']}\" �������� {$rec['sum_ekr']} ���. �� ������ ����� �{$rec['bank_id']} � �����, �� ������������� ������: \"�������������� ������� +180\". (������� �� �����:{$rec['add_info']} ���.) ";
                    $delo_type[196]="\"{$rec['owner_login']}\" ���������� ������� \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��. �� {$rec['sum_ekr']} e��.";
                    $delo_type[198]="\"{$rec['owner_login']}\" ����������� ������� \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��. �� {$rec['sum_kr']} ��.";
                    $delo_type[1107]="\"{$rec['owner_login']}\" �������� {$rec['sum_ekr']} ���. �  \"{$rec['target_login']}\", �� ����� �{$rec['bank_id']}.";

                }
            }
            //����
            {
                //�������
                {
                    $delo_type[28]="\"{$rec['owner_login']}\" ������� {$rec['sum_ekr']} ���. �� {$rec['sum_rep']} ��������� �� ����� ����� �.{$rec['bank_id']} � �����.";
                    $delo_type[2828]="\"{$rec['owner_login']}\" ����� �� {$rec['sum_ekr']} ���. {$rec['sum_rep']} ��������� ����� ������.";
                    $delo_type[182]="\"{$rec['owner_login']}\" ������� {$rec['sum_rep']} ���. �� ���������� ������ \"{$rec['add_info']}\".";
                    $delo_type[183]="\"{$rec['owner_login']}\" ������� {$rec['sum_rep']} ���. ������ � �������.";
                    $delo_type[1184]="\"{$rec['owner_login']}\" ������� ������� {$rec['item_name']} �� ������ � �������.";
                    $delo_type[203]="\"{$rec['owner_login']}\" ������� {$rec['sum_rep']} ��������� �� ������ � ������� �� ������";
                    $delo_type[250]="\"{$rec['owner_login']}\" ������� {$rec['sum_rep']} ��������� �� ���������� ����� �� ������";
                    $delo_type[204]="\"{$rec['owner_login']}\" ������� {$rec['sum_rep']} ��������� �� �������� � ������� �� ������";
                    $delo_type[251]="\"{$rec['owner_login']}\" ������� {$rec['sum_rep']} ��������� �� ������ ���������";
                    $delo_type[254]="\"{$rec['owner_login']}\" ������� {$rec['sum_rep']} ��������� �� ���������� ������";
                    $delo_type[260]="\"{$rec['owner_login']}\" ������� {$rec['sum_rep']} ��������� �� ����� �������� � ����";
                    $delo_type[2260]="\"{$rec['owner_login']}\" ������� {$rec['sum_rep']} ��������� �� �����  {$rec['item_name']}  � �����";
                    $delo_type[360]="\"{$rec['owner_login']}\" ������� {$rec['sum_rep']} ��������� �� ����� � �������� ���������";
                    $delo_type[361]="\"{$rec['owner_login']}\" ������� {$rec['sum_rep']} ��������� �� ����� ��������� � ��� �����";
                    $delo_type[384]="\"{$rec['owner_login']}\" �������� {$rec['sum_rep']} ��������� �� ����� ��������� � ��� �����";
                    $delo_type[381]="\"{$rec['owner_login']}\" - {$rec['add_info']}.";
                    $delo_type[382]="\"{$rec['owner_login']}\" ������� {$rec['sum_rep']} ��������� ".(($rec['sum_kr']>0)?" � {$rec['sum_kr']} ��. ":"")." - {$rec['add_info']}.";
                    $delo_type[383]="\"{$rec['owner_login']}\" - {$rec['add_info']}.";
                    $delo_type[385]="\"{$rec['owner_login']}\" ������� {$rec['sum_rep']} ��������� (������� ������� � ����) �� ������� {$rec['item_name']}.";
                    $delo_type[371]="\"{$rec['owner_login']}\" ������� {$rec['sum_rep']} ��������� �� ����� \"{$rec['target_login']}\".";
                    $delo_type[392]="\"{$rec['owner_login']}\" ������� {$rec['add_info']} ������� ����� �� ����� \"{$rec['target_login']}\".";

                    //��� ��� � ������....  ������ ������
                    {
                        $delo_type[3]="\"{$rec['owner_login']}\" �������: \"{$rec['item_name']}\" � \"{$rec['sum_rep']}\" ��������� �� ������ �� ��������� � \"��������� �������\".";
                        $delo_type[4]="\"{$rec['owner_login']}\" �������: ".self::if_have(" �� �������:",$rec['sum_kr']," ��.")." ".self::if_have(" � �������:",$rec['item_name']," � ")."  ".self::if_have("",$rec['sum_rep']," ��������� ")." �� ��������� � \"��������� ���������\".";
                        $delo_type[5]="\"{$rec['owner_login']}\" �������: \"{$rec['item_name']}\" � \"{$rec['sum_rep']}\" ��������� �� ������ �� ��������� � \"��������� ���������\".";
                    }
                }
                //��������
                {

                    $delo_type[5001]="������ {$rec['sum_kr']} ��. � ������� �����, � ���� �����.";
                    $delo_type[5002]="������ {$rec['sum_kr']} ��. � ����������� ����� � {$rec['bank_id']}, � ���� �����.";
                    $delo_type[5003]="������ {$rec['sum_ekr']} ���. � ����������� ����� � {$rec['bank_id']}, � ���� �����.";
                    $delo_type[5004]="�������� {$rec['sum_kr']} ��. ����� �� ������� ����� ���������.";
                    $delo_type[5005]="����� ���������� {$rec['item_name']}({$rec['item_id']}), � ���� �����.";
                    $delo_type[5006]="�������� {$rec['sum_ekr']} ���. ����� (��� �� ���� {$rec['bank_id']}) �� ������� ����� ������������.";
                    $delo_type[5007]="�������� {$rec['sum_kr']} ��. ����� (��) �� ������� ����� ������������.";
                    $delo_type[5008]="������� ������� {$rec['item_name']}, �� ����� {$rec['sum_ekr']} ���. ����� �� ������� ����� ������������.";
                    $delo_type[5020]="�������� {$rec['sum_ekr']} ��� � ������� {$rec['add_info']}, � ���� �����.";
                    $delo_type[386]="\"{$rec['owner_login']}\" �������� {$rec['sum_rep']} ���������  �� {$rec['add_info']} ��� ��������� {$rec['item_name']}.";
                    $delo_type[387]="\"{$rec['owner_login']}\" �������� {$rec['sum_rep']} ���������  �� {$rec['add_info']} ��� ��������� {$rec['item_name']}.";
                    $delo_type[395]="\"{$rec['owner_login']}\" �������� {$rec['sum_rep']} ��������� ���������� ����.";

                }
            }


            //������
            {
                if ($rec['type'] == 215) { $t = explode("/",$rec['add_info']); $delo_type[215]="\"{$rec['owner_login']}\" ������� �� ������ \"{$rec['item_name']}\" {$rec['sum_kr']} ��. ������ ������ �� ".$t[0]." ����"; }
                if ($rec['type'] == 216) { $t = explode("/",$rec['add_info']); $delo_type[216]="\"{$rec['owner_login']}\" �������� �� ��������� ������: \"{$rec['item_name']}\" ������ �� ".$t[0]." ���� �� ".$rec['sum_kr']." ��."; }
                if ($rec['type'] == 217) { $t = explode("/",$rec['add_info']); $delo_type[217]="\"{$rec['owner_login']}\" ������� �� ��������� ������: \"{$rec['item_name']}\" {$rec['sum_kr']} ��. ������ �� ".$t[0]." ����"; }
            }
            //���������
            {

            }
        }


//��������
        {
            //�����
            {
                $delo_type[1]="\"{$rec['owner_login']}\" ����� �����: \"{$rec['item_name']}\" (x{$rec['item_count']}) [{$rec['item_dur']}/{$rec['item_maxdur']}] �� ".self::if_have(" ",$rec['sum_kr']," ��.")."  ".self::if_have(" ",$rec['sum_ekr']," ���.")."  ".self::if_have(" (� ������� �����:",$rec['item_arsenal'],")");
                $delo_type[401]="\"{$rec['owner_login']}\" ����� �����: \"{$rec['item_name']}\" (x{$rec['item_count']}) [{$rec['item_dur']}/{$rec['item_maxdur']}] �� ".self::if_have(" ",$rec['sum_kr']," ��.")."  ".self::if_have(" ",$rec['sum_ekr']," ���.")."  ".self::if_have(" (� ������� �����:",$rec['item_arsenal'],")");
                $delo_type[2]="\"{$rec['owner_login']}\" ����� �����: \"{$rec['item_name']}\" (x{$rec['item_count']}) [{$rec['item_dur']}/{$rec['item_maxdur']}] �� {$rec['sum_rep']} ��.".self::if_have(" (� ������� �����:",$rec['item_arsenal'],")");
                $delo_type[40]="\"{$rec['owner_login']}\" �����  �������:\"{$rec['item_name']}\" �� {$rec['sum_kr']} �� � \"{$rec['target_login']}\"";
                $delo_type[54]="\"{$rec['owner_login']}\" ����� \"{$rec['item_name']}\" �� {$rec['sum_ekr']} ���, ����� ������ \"{$rec['target_login']}\".";
                $delo_type[354]="\"{$rec['owner_login']}\" ����� \"{$rec['item_name']}\" �� ".self::if_have(" ",$rec['sum_ekr']," ���.")." ".self::if_have(" ",$rec['sum_rep']," ���.").".";

                $delo_type[82]="\"{$rec['owner_login']}\" ����� \"{$rec['item_name']}\" �� {$rec['sum_ekr']} ���, ����� ������ \"{$rec['target_login']}\" � ������� ����� \"{$rec['add_info']}\" ���. �� ���� �{$rec['bank_id']}.";
                $delo_type[8282]="\"{$rec['owner_login']}\" ������� \"{$rec['item_name']}\" �� ���������� ������ ��  ��������";
                $delo_type[122]="\"{$rec['owner_login']}\" ����� �������:\"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��. �� ����������� �� {$rec['sum_kr']} ��.";
                $delo_type[172]="\"{$rec['owner_login']}\" ����� �����: \"{$rec['item_name']}\" (x{$rec['item_count']}) [{$rec['item_dur']}/{$rec['item_maxdur']}] �� {$rec['sum_rep']} ���.";
                $delo_type[272]="\"{$rec['owner_login']}\" ����� �����: \"{$rec['item_name']}\" (x{$rec['item_count']}) [{$rec['item_dur']}/{$rec['item_maxdur']}] �� {$rec['sum_kr']} ��.".self::if_have(" (� ������� �����:",$rec['item_arsenal'],")");
                $delo_type[372]="\"{$rec['owner_login']}\" ������� ������ ��������: \"{$rec['item_name']}\" (x{$rec['item_count']}) [{$rec['item_dur']}/{$rec['item_maxdur']}] �� {$rec['sum_rep']} ���. {$rec['add_info']} ";
                $delo_type[373]="\"{$rec['owner_login']}\" ����� ���� ����� � ��: \"{$rec['item_name']}\" (x{$rec['item_count']}) [{$rec['item_dur']}/{$rec['item_maxdur']}] �� {$rec['sum_ekr']} ���.";
                $delo_type[374]="\"{$rec['owner_login']}\"  �������� �� ������� ���� : \"{$rec['item_name']}\" (x{$rec['item_count']}) [{$rec['item_dur']}/{$rec['item_maxdur']}] �� {$rec['sum_rep']} ���. {$rec['add_info']} ";
                $delo_type[375]="\"{$rec['owner_login']}\"  �������� �� ������� ������ ���� : \"{$rec['item_name']}\" (x{$rec['item_count']}) [{$rec['item_dur']}/{$rec['item_maxdur']}] �� {$rec['sum_rep']} ���. {$rec['add_info']} ";
                $delo_type[376]="\"{$rec['owner_login']}\" ������� ������ �������� ��������: \"{$rec['item_name']}\" (x{$rec['item_count']}) [{$rec['item_dur']}/{$rec['item_maxdur']}] �� ����� {$rec['sum_rep']} ���. {$rec['add_info']} ";
                $delo_type[377]="\"{$rec['owner_login']}\" �������  ������ �������� {$rec['add_info']} �� �����: \"{$rec['item_name']}\" (x{$rec['item_count']}) [{$rec['item_dur']}/{$rec['item_maxdur']}] ";

                $delo_type[378]="\"{$rec['owner_login']}\" �������  �������� {$rec['add_info']} �� �����: \"{$rec['item_name']}\" (x{$rec['item_count']}) [{$rec['item_dur']}/{$rec['item_maxdur']}] �� {$rec['sum_ekr']} ���(���������).";
                $delo_type[1378]="\"{$rec['owner_login']}\" �������  �������� {$rec['add_info']} �� �����: \"{$rec['item_name']}\" (x{$rec['item_count']}) [{$rec['item_dur']}/{$rec['item_maxdur']}] �� {$rec['sum_ekr']} ��� �� ����� �{$rec['bank_id']}.";
                $delo_type[379]="\"{$rec['owner_login']}\" �����  �������� \"{$rec['item_name']}\" (x{$rec['item_count']}) [{$rec['item_dur']}/{$rec['item_maxdur']}] �� ����� � ������������ ����� �� {$rec['sum_ekr']} ���(���������).";
                $delo_type[1379]="\"{$rec['owner_login']}\" �����  �������� \"{$rec['item_name']}\" (x{$rec['item_count']}) [{$rec['item_dur']}/{$rec['item_maxdur']}] �� ����� � ������������ ����� �� {$rec['sum_ekr']} ��� .";
                $delo_type[380]="\"{$rec['owner_login']}\" ������� ������� �������� \"{$rec['item_name']}\" (x{$rec['item_count']}) [{$rec['item_dur']}/{$rec['item_maxdur']}] ��������� � ������.";
                $delo_type[390]="\"{$rec['owner_login']}\" ������� ������ �������� \"{$rec['item_name']}\" (x{$rec['item_count']}) [{$rec['item_dur']}/{$rec['item_maxdur']}] ��� ������.";


            }
            //�������/��������
            {
                $delo_type[454]="\"{$rec['owner_login']}\" ������� \"{$rec['item_name']}\" �� {$rec['sum_ekr']} ���, �� \"{$rec['target_login']}\".";
                $delo_type[452]="\"{$rec['owner_login']}\" ������� ������ �� {$rec['sum_ekr']} ���, �� \"{$rec['target_login']}\".";
                $delo_type[455]="\"{$rec['owner_login']}\" ������� \"{$rec['item_name']}\" , �� \"{$rec['target_login']}\".";
                $delo_type[403]="\"{$rec['owner_login']}\" ���������� ���� �������:\"{$rec['item_name']}\".";
                $delo_type[404]="\"{$rec['owner_login']}\" ������� � ������� �������:\"{$rec['item_name']}\" �� \"{$rec['target_login']}\" �� ��������.";
                $delo_type[6060]="\"{$rec['owner_login']}\" ������� � ������� �������:\"{$rec['item_name']}\" �� \"{$rec['target_login']}\", ����������� \"�������� �� ������ �������\".";
                $delo_type[410]="\"{$rec['owner_login']}\" ������� � ������� ����������� ������� �� \"{$rec['target_login']}\".";
                $delo_type[14]="\"{$rec['owner_login']}\" ������� � ������� �������:\"{$rec['item_name']}\" �� \"{$rec['target_login']}\" (����� � ��������� ).";
                $delo_type[21]="\"{$rec['owner_login']}\" ������ �� �������� ��� ������ �� ����� \"{$rec['item_arsenal']}\"  ������� \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}]";
                $delo_type[22]="\"{$rec['owner_login']}\" ������ ����� ������� ��� ������ �� ����� \"{$rec['item_arsenal']}\"  ������� \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}]";
                $delo_type[23]="� \"{$rec['owner_login']}\" ��� ����� �������:\"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}], �������������� \"{$rec['target_login']}\" ";
                $delo_type[56]="\"{$rec['owner_login']}\" ������� � ����� \"{$rec['item_name']}\" �� {$rec['sum_ekr']} ���, �� ������������� ������.";
                $delo_type[60]="\"{$rec['owner_login']}\" ������� � ��� \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��.";
                $delo_type[61]="\"{$rec['owner_login']}\" ������ �� ������� \"{$rec['item_arsenal']}\" ���� �������: \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��.";
                $delo_type[62]="\"{$rec['owner_login']}\" ���� �� �������� \"{$rec['item_arsenal']}\" �������: \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��. ������ �� {$rec['add_info']};";
                $delo_type[63]="\"{$rec['owner_login']}\" ����� ����� ������� \"{$rec['item_arsenal']}\" �������: \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��. � ��������� {$rec['add_info']};";
                $delo_type[64]="\" � {$rec['owner_login']}\" ��� ����� ����� ������� \"{$rec['item_arsenal']}\" �������: \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��. ���������� {$rec['add_info']};";
                $delo_type[88]="\"{$rec['owner_login']}\" ������� �� �������� �������: \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��.";
                $delo_type[288]="\"{$rec['owner_login']}\" ������� � ����� �������: \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��. ��� ���������� 4�� ������.";
                $delo_type[99]="\"{$rec['owner_login']}\" ������� �������:\"{$rec['item_name']}\" (x{$rec['item_count']}) ��. ".($rec['item_count']==1?"(".$rec['item_id'].")":"")." �� ��������� \"{$rec['target_login']}\"";
                $delo_type[169]="\"{$rec['owner_login']}\" ������ ������� �������:\"{$rec['item_name']}\" (x{$rec['item_count']}) ��. �� \"{$rec['target_login']}\"";

                $delo_type[419]="\"{$rec['owner_login']}\" ������� �� ����� {$rec['add_info']}, �������: \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��. .";
                $delo_type[420]="\"{$rec['owner_login']}\" ������� �� ����� {$rec['add_info']}, ������ �������: \"{$rec['item_name']}\"  {$rec['item_count']}��. .";

                $delo_type[1419]="\"{$rec['owner_login']}\" ������� �� {$rec['add_info']}, �������: \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��. .";
                $delo_type[1420]="\"{$rec['owner_login']}\" ������� �� {$rec['add_info']}, ������ �������: \"{$rec['item_name']}\"  {$rec['item_count']}��. .";


                $delo_type[421]="\"{$rec['owner_login']}\" ������� �� {$rec['add_info']}, �������: \"{$rec['item_name']}\"  {$rec['item_count']}��.";

                $delo_type[98]="\"{$rec['owner_login']}\" ������� � ������� �������:\"{$rec['item_name']}\" (x{$rec['item_count']}) ��. �� ��������� \"{$rec['target_login']}\"";
                $delo_type[140]="\"{$rec['owner_login']}\" ����� �����: \"{$rec['item_name']}\" (x{$rec['item_count']}) [{$rec['item_dur']}/{$rec['item_maxdur']}] �� {$rec['sum_ekr']} e��.";
                $delo_type[1140]="\"{$rec['owner_login']}\" ����� �����: \"{$rec['item_name']}\" (x{$rec['item_count']}) [{$rec['item_dur']}/{$rec['item_maxdur']}] �� {$rec['sum_ekr']} e��. �� ����� �{$rec['bank_id']}   ";
                $delo_type[393]="\"{$rec['owner_login']}\" ������� �������:\"{$rec['item_name']}\" (x{$rec['item_count']}) ��. �� ����� \"{$rec['target_login']}\"";



                $delo_type[180]="\"{$rec['owner_login']}\" ������� �������:\"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��. �� ���������� ������ \"{$rec['add_info']}\".";
                //   $delo_type[183]="\"{$rec['owner_login']}\" ������� �������:\"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��. �� ���������� ������ \"{$rec['add_info']}\".";
                $delo_type[185]="\"{$rec['owner_login']}\" ������� �������:\"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��. � �������.";
                $delo_type[1185]="\"{$rec['owner_login']}\" ������� �������:\"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��. � ���������� �������.";
                $delo_type[205]="\"{$rec['owner_login']}\" ����� {$rec['item_name']} �� ������� �� ����� ������� �� ������";
                $delo_type[206]="\"{$rec['owner_login']}\" ������ ����� {$rec['item_name']} � ��������� ��������.";
                $delo_type[1206]="\"{$rec['owner_login']}\" ������ ������� {$rec['item_name']} � ��������� ��������.";
                $delo_type[202]="\"{$rec['owner_login']}\" ������� {$rec['item_name']} �� ������ � ������� �� ������";
                $delo_type[209]="\"{$rec['owner_login']}\" ������� ������� �� ���������� ��������: \"{$rec['item_name']}\" �� ��������� \"{$rec['target_login']}\"";
                $delo_type[253]="\"{$rec['owner_login']}\" ������� ��������� �������: \"{$rec['item_name']}\" �� \"{$rec['target_login']}\"";
                $delo_type[255]="\"{$rec['owner_login']}\" ������� ������� � ������� �� �����: \"{$rec['item_name']}\" �� \"{$rec['target_login']}\"";
                $delo_type[264]="\"{$rec['owner_login']}\" ������� ������� \"{$rec['item_name']}\" ��� �������.";

                $delo_type[266]="\"{$rec['owner_login']}\" ����� ������ �� �������.";
                $delo_type[267]="� \"{$rec['owner_login']}\" ������ ������ �� �������.";
                $delo_type[280]="\"{$rec['owner_login']}\" ������� ������ (�����) �� ����� {$rec['sum_ekr']} ���. �� ������������� ������";
                $delo_type[1280]="\"{$rec['owner_login']}\" ������� ������� �� ����� {$rec['sum_ekr']} ���. �� ������������� ������ �� ���������� ���� �{$rec['bank_id']} ";
                $delo_type[283]="\"{$rec['owner_login']}\" ������� ������ (�������) �� ����� {$rec['sum_ekr']} ���. �� ������������� ������";
                $delo_type[281]="\"{$rec['owner_login']}\" �������� ������� �� ������� ������ ��������";
                $delo_type[1281]="\"{$rec['owner_login']}\" ��������  {$rec['sum_ekr']} ���. �� ������� ������ �������� �� ����� �{$rec['bank_id']}  ";
                $delo_type[282]="\"{$rec['owner_login']}\" �������� ������� �� ������ ����� ������������� ������";
                $delo_type[2282]="\"{$rec['owner_login']}\" �������� {$rec['sum_ekr']} ���.  �� ������ ����� ������������� ������ �� ����� �{$rec['bank_id']}  ";
                $delo_type[284]="\"{$rec['owner_login']}\" �������� ������� �� ������� �������� ��������";
                $delo_type[1284]="\"{$rec['owner_login']}\" ��������  {$rec['sum_ekr']} ���.  �� ������� �������� ��������  �� ����� �{$rec['bank_id']}  ";
                $delo_type[285]="\"{$rec['owner_login']}\" �������� ������� �� ������� ������� ��� �������.";
                $delo_type[388]="\"{$rec['owner_login']}\" �������� ������������ �� ������ ������������� ������";
                $delo_type[389]="\"{$rec['owner_login']}\" ������� ���������� (�������) �� ������������� ������";

                $delo_type[306]="\"{$rec['owner_login']}\" ������� ��� ������ ������� \"{$rec['item_name']}\" � �������� ����������";
            }
            //������
            {
                $delo_type[34]="\"{$rec['owner_login']}\" ������ � ������� �����: \"{$rec['item_name']}\" (x{$rec['item_count']}) [{$rec['item_dur']}/{$rec['item_maxdur']}] �� ". ($rec['sum_kr']>0?$rec['sum_kr']." ��.":"").($rec['sum_ekr']>0?$rec['sum_ekr']." ���.":"").($rec['bank_id']>0?" ����� ����� �:".$rec['bank_id']:"");
                $delo_type[41]="\"{$rec['owner_login']}\" ������ �������:\"{$rec['item_name']}\" �� {$rec['sum_kr']} ��, ��������� \"{$rec['target_login']}\" (��������:{$rec['sum_kom']} ��.)";
                $delo_type[123]="\"{$rec['owner_login']}\" ������ ����� ����������� �������:\"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��. �� {$rec['sum_kr']} ��. �������� ��������� {$rec['sum_kom']}��.";
            }
            //������, �������, �������, ���� (���������)
            {
                $delo_type[66]="\" � {$rec['owner_login']}\" ��� ����� ������� ����� \"{$rec['item_arsenal']}\": \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��. ���������� {$rec['add_info']};";

                $delo_type[39]="\"{$rec['owner_login']}\" ������� �������:\"{$rec['item_name']}\" (x{$rec['item_count']}) ��. ".($rec['item_count']==1?"(".$rec['item_id'].")":"")." ��������� \"{$rec['target_login']}\" ";
                $delo_type[168]="\"{$rec['owner_login']}\" ������ ������� �������:\"{$rec['item_name']}\" (x{$rec['item_count']}) ��. ".($rec['item_count']==1?"(".$rec['item_id'].")":"")." ��������� \"{$rec['target_login']}\"";

                $delo_type[6061]="\"{$rec['owner_login']}\" ����������� �������:\"{$rec['item_name']}\" � \"{$rec['target_login']}\" (��������).";

                $delo_type[38]="\"{$rec['owner_login']}\" ������� �������:\"{$rec['item_name']}\" (x{$rec['item_count']}) ��.  ��������� \"{$rec['target_login']}\" ";
                $delo_type[65]="\"{$rec['owner_login']}\" ���� � ������� \"{$rec['item_arsenal']}\" ���� �������: \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��.";
                $delo_type[67]="\"{$rec['owner_login']}\" ������ � ������� \"{$rec['item_arsenal']}\" �������: \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��.";
                $delo_type[86]="\"{$rec['owner_login']}\" ������� � ������� �������: \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��.";
                $delo_type[89]="\"{$rec['owner_login']}\" ������ ����������� �������: \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��. �������.";
                $delo_type[120]="\"{$rec['owner_login']}\" ���� �������:\"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��. � ������������ ������� �� {$rec['sum_kr']} ��.";
                $delo_type[20]="\"{$rec['owner_login']}\" ������ � ������� ��� ������ �� ����� \"{$rec['item_arsenal']}\"  ������� \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}]";
                $delo_type[186]="���������� ���� ������ ��������:\"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}].";
                $delo_type[187]="������� \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��. ��������� � \"{$rec['target_login']}\".";
                $delo_type[188]="\"{$rec['owner_login']}\" ������ ������� ����� ������� ��� ������ �� ����� \"{$rec['item_arsenal']}\" ������� \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}]";
                $delo_type[189]="��������� ������� \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] ����� ������� ��� ������ �� ����� \"{$rec['item_arsenal']}\".";
                $delo_type[207]="\"{$rec['owner_login']}\" ������� ������� �� ���������� ��������: \"{$rec['item_name']}\" ��������� \"{$rec['add_info']}\" � ��������� ��������, �������� {$rec['sum_kr']} ��.";
                $delo_type[208]="\"{$rec['owner_login']}\" ������� ������� �� ���������� ��������: \"{$rec['item_name']}\" ��������� \"{$rec['target_login']}\"";
                $delo_type[405]="\"{$rec['owner_login']}\" ������� ����������� ������� �� ���������� ��������: \"{$rec['item_name']}\" ��������� \"{$rec['target_login']}\"";
                $delo_type[302]="\"{$rec['owner_login']}\" ���� � ����� ����� \"{$rec['add_info']}\"   \"{$rec['item_name']}\" ";
                $delo_type[256]="\"{$rec['owner_login']}\" ������� ��������� �������: \"{$rec['item_name']}\" � \"{$rec['target_login']}\"";
                $delo_type[265]="\"{$rec['owner_login']}\" ������� �������� \"{$rec['item_name']}\" �� �������";
                $delo_type[301]="� \"{$rec['owner_login']}\" ������� \"{$rec['item_name']}\" ��� ����� � ��������� ���������� �����";

                $delo_type[305]="\"{$rec['owner_login']}\" ������� ������� \"{$rec['item_name']}\" � �������� ����������";

                $delo_type[340]="\"{$rec['owner_login']}\" ���� �� �������  � ����� ����� \"{$rec['add_info']}\"  \"{$rec['item_name']}\" ";

                $delo_type[411]="� \"{$rec['owner_login']}\" ���� ������� \"{$rec['item_name']}\" (".$rec['item_id'].") � ��������� ����������";
                $delo_type[412]="� \"{$rec['owner_login']}\" ������� ������� \"{$rec['item_name']}\" (".$rec['item_id'].") �� ��������� ���������";
                $delo_type[413]="� \"{$rec['owner_login']}\" �������� �����������: \"���������� ���������� - 5 ���\" � \"���������� ���������� - 10 ���\" �� ��������� ��������� ��� ������ ������ �����������";

                $delo_type[414]="� \"{$rec['owner_login']}\" ���� ������ �� ����� \"{$rec['sum_ekr']}\" (".$rec['item_id'].") ������ �� ����� �������.".$rec['add_info'];
                $delo_type[415]="� \"{$rec['owner_login']}\" ����� �� ����� ������� �� ����� \"{$rec['sum_ekr']}\". ������� �����:".$rec['item_id'].".".$rec['add_info'];

            }
            //������, ������ (���� ��� �������)
            {

                $delo_type[344]="\"{$rec['owner_login']}\" ������� ������ \"{$rec['item_name']}\" ��� �������.";

                $delo_type[341]="\"{$rec['owner_login']}\" ������� ������� ������ \"{$rec['item_name']}\", ��� ������ ������ � ����� �����  \"{$rec['add_info']}\"  ";
                $delo_type[121]="\"{$rec['owner_login']}\" ������ �������:\"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��. �� ������������� ��������, �������� �� �������� {$rec['sum_kom']} ��.";
                $delo_type[173]="\"{$rec['owner_login']}\" ������ �������� {$rec['add_info']}: \"{$rec['item_name']}\" (x{$rec['item_count']}) [{$rec['item_dur']}/{$rec['item_maxdur']}].";
                $delo_type[174]="\"{$rec['owner_login']}\" ������ ������� {$rec['add_info']}: \"{$rec['item_name']}\" (x{$rec['item_count']}) [{$rec['item_dur']}/{$rec['item_maxdur']}].";
                $delo_type[300]="\"{$rec['owner_login']}\" ������ ������� � ������� {$rec['add_info']}: \"{$rec['item_name']}\" (x{$rec['item_count']}) [{$rec['item_dur']}/{$rec['item_maxdur']}].";
            }

            {//������ �������� � ����������
                $delo_type[195]="\"{$rec['owner_login']}\" ������� ������� �������� \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��.";
                $delo_type[19]="\"{$rec['owner_login']}\" �������� ������� \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}]";
                $delo_type[35]=" � \"{$rec['owner_login']}\" ������� \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] ������ � ������ ���������� � ����������.";

                $delo_type[32]="\"{$rec['owner_login']}\" ������ ����������� �������:\"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}]";
                $delo_type[33]="\"{$rec['owner_login']}\" �������� ����������� �������:\"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}]";
                $delo_type[78]="\"{$rec['owner_login']}\" �������� ��������� ������� �������:\"{$rec['item_name']}\".";
                $delo_type[80]="\"{$rec['owner_login']}\" ������� ������ \"{$rec['item_incmagic']}\" �� \"{$rec['add_info']}\" � \"{$rec['item_name']}\".".self::if_have(" (������� �����:",$rec['item_arsenal'],")");
                $delo_type[81]="\"{$rec['owner_login']}\" ����������� ������ \"{$rec['add_info']}\" � \"{$rec['item_name']}\".".self::if_have(" (������� �����:",$rec['item_arsenal'],")");
                $delo_type[176]="\"{$rec['owner_login']}\" ��������� �������� ������� \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��. ".($rec['add_info']!=''?$rec['add_info']:'').".";
                $delo_type[177]="\"{$rec['owner_login']}\" �������� ������� \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��. �� {$rec['sum_kr']} ��.";
                $delo_type[178]="\"{$rec['owner_login']}\" ��������� ������������� ������� \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��.";
                $delo_type[179]="\"{$rec['owner_login']}\" ������������� ������� \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��. �� {$rec['sum_kr']} ��.";
                $delo_type[1179]="\"{$rec['owner_login']}\" ���������  \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��. �������  {$rec['add_info']} ";
                $delo_type[1180]="\"{$rec['owner_login']}\" ������� (  \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��. �������  {$rec['add_info']} ";
                $delo_type[313]="\"{$rec['owner_login']}\" ������ �������� ���������� ����� � �����";
                $delo_type[314]="\"{$rec['owner_login']}\" ������� ��� ������ �������  \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��.";
                $delo_type[1314]="\"{$rec['owner_login']}\" ������� ��� ������ �������  \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��., ������� {$rec['sum_ekr']} ���. �� ����� � {$rec['bank_id']}   ";
                $delo_type[1315]="\"{$rec['owner_login']}\" ������� ��� ���������� ������ �������  \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��., ������� {$rec['sum_ekr']} ���. �� ����� � {$rec['bank_id']} � {$rec['sum_kr']} ��.";
                $delo_type[315]="\"{$rec['owner_login']}\" {$rec['add_info']} �� �������  \"{$rec['item_name']}\" [{$rec['item_dur']}/{$rec['item_maxdur']}] {$rec['item_count']}��. ��������� {$rec['target_login']}.";
            }
            //������
            { 	$delo_type[210]="\"{$rec['owner_login']}\" ������ �� ��������: \"{$rec['item_name']}\" �� \"{$rec['sum_kr']}\" ��. ".$rec['add_info'];
                $delo_type[211]="\"{$rec['owner_login']}\" ���� � �������: \"{$rec['item_name']}\" �� \"{$rec['sum_kr']}\" ��. �� ".$rec['add_info']." ����";
                if ($rec['type'] == 212) {  $t = explode("/",$rec['add_info']); $delo_type[212]="\"{$rec['owner_login']}\" ���� � �������� �����: \"{$rec['item_name']}\" ������ �� ".$t[0]." ���� �� ".$t[1]." ��. � ����� (����� 1 ��. ������)"; }
                $delo_type[213]="\"{$rec['owner_login']}\" ������ �� �������� �����: \"{$rec['item_name']}\""; 	if ($rec['type'] == 214) {  $t = explode("/",$rec['add_info']); $delo_type[214]="\"{$rec['owner_login']}\" �������� �� ������: \"{$rec['item_name']}\" ������ �� ".$t[0]." ���� �� ".$rec['sum_kr']." ��."; }
                $delo_type[218]="\"{$rec['owner_login']}\" ������ � �������� ����� \"{$rec['item_name']}\" �� ��������� ����� ������";
                $delo_type[219]="\"{$rec['owner_login']}\" ���������� ���� �� �������� �����: \"{$rec['item_name']}\" ������� ����. ����.";

            }
        }

        //�������
        {
            $delo_type[220]="\"{$rec['owner_login']}\" ������ ���� \"{$rec['item_name']}\" �� �������� � ������� ����� {$rec['item_arsenal']}";
            $delo_type[221]="\"{$rec['owner_login']}\" ������ ���� \"{$rec['item_name']}\" �� ��������";
            if ($rec['type'] == 222) { $t = explode("/",$rec['add_info']); $delo_type[222]="\"{$rec['owner_login']}\" �������� ���� �� �������� �� �������: \"{$rec['item_name']}\". ������ �� ".$t[0]." ���� � ��������� ���������� ".$t[1]." ��. �� ����� {$rec['item_arsenal']} (����� 1 �� ������ �� �����)"; }
            if ($rec['type'] == 223) { $t = explode("/",$rec['add_info']); $delo_type[223]="\"{$rec['owner_login']}\" �������� ���� �� �������: \"{$rec['item_name']}\". ������ �� ".$t[0]." ���� � ��������� ���������� ".$t[1]." ��. (����� 1 �� ������)"; }
            $delo_type[224]="\"{$rec['owner_login']}\" ������ �� �������� ���� \"{$rec['item_name']}\", ������� {$rec['sum_kr']} ��., ��������: {$rec['sum_kom']}. ������ ����� � ����� ����� {$rec['item_arsenal']}";
            $delo_type[225]="\"{$rec['owner_login']}\" ������ �� �������� ���� \"{$rec['item_name']}\", ������� {$rec['sum_kr']} ��., ��������: {$rec['sum_kom']}.";
            $delo_type[226]="\"{$rec['owner_login']}\" ������� �� �������� � ������� ����� \"{$rec['item_arsenal']}\" ���� \"{$rec['item_name']}\" �� {$rec['sum_kr']} ��.";
            $delo_type[227]="\"{$rec['owner_login']}\" ������� ���� �� �������� \"{$rec['item_name']}\" �� {$rec['sum_kr']} ��.";
            $delo_type[228]="\"{$rec['owner_login']}\" ��������� ���� �� �������� \"{$rec['item_name']}\" � ������� ����� {$rec['item_arsenal']}";
            $delo_type[229]="\"{$rec['owner_login']}\" ��������� ���� �� �������� \"{$rec['item_name']}\"";
            $delo_type[230]="\"{$rec['owner_login']}\" ������� ������� ������ � �������� �� \"{$rec['item_name']}\"";
            $delo_type[231]="\"{$rec['owner_login']}\" ������ ������ �� �������� �� \"{$rec['item_name']}\"";
            $delo_type[232]="\"{$rec['owner_login']}\" ������ ���� ������ �� �������� �� \"{$rec['item_name']}\"";
            $delo_type[233]="\"{$rec['owner_login']}\" �������� �� ����������� �����";
            $delo_type[234]="\"{$rec['owner_login']}\" �������� �� ���������� ����������� � �����";
            $delo_type[235]="\"{$rec['owner_login']}\" �������� �� ������ �� ����������";
            $delo_type[236]="\"{$rec['owner_login']}\" �������� �� ������� �� ����� {$rec['sum_kr']} ��";

            $delo_type[332]="\"{$rec['owner_login']}\" ������ ���� ������ {$rec['sum_rep']} ���., �� �������� �� \"{$rec['item_name']}\""; // �� ����
            $delo_type[352]="\"{$rec['owner_login']}\" ������ ���� ������ ��������� �� ����� {$rec['sum_ekr']} ���, �� �������� �� \"{$rec['item_name']}\"";

            $delo_type[331]="\"{$rec['owner_login']}\" ������ ������ {$rec['sum_rep']} ���., �� �������� �� \"{$rec['item_name']}\""; //�� ����		
            $delo_type[351]="\"{$rec['owner_login']}\" ������ ������  ��������� �� ����� {$rec['sum_ekr']} ���, �� �������� �� \"{$rec['item_name']}\"";

            $delo_type[330]="\"{$rec['owner_login']}\" ������� ������� ������ {$rec['sum_rep']} ���.,  � �������� �� \"{$rec['item_name']}\"";	// �� ����	
            $delo_type[350]="\"{$rec['owner_login']}\" ������� ������� ������ ��������� �� ����� {$rec['sum_ekr']} ���,  � �������� �� \"{$rec['item_name']}\"";

            $delo_type[333]="\"{$rec['owner_login']}\" ������� ����� ��� \"{$rec['item_name']}\" �� �������� �� {$rec['sum_rep']} ���."; //�� ����				

            $delo_type[334]="\"{$rec['owner_login']}\" ������� �� �������� \"{$rec['item_name']}\" �� {$rec['sum_rep']} ���."; //�� ����
            $delo_type[353]="\"{$rec['owner_login']}\" ������� �� �������� \"{$rec['item_name']}\", �� {$rec['sum_ekr']} ��� ���������.";

        }

        $delo_type[237]="\"{$rec['owner_login']}\" �������� {$rec['sum_kom']} �� {$rec['add_info']}";
        $delo_type[0]="\"{$rec['owner_login']}\", �������� �� ����������!";
        $delo_type[79]="\"{$rec['owner_login']}\" ������� {$rec['add_info']} ���������� �� ����� ������������ ����� \"{$rec['target_login']}\".";

        $delo_type[270]="\"{$rec['owner_login']}\" ������� ���������� ����� � \"{$rec['add_info']}\".";
        $delo_type[271]="\"{$rec['owner_login']}\" �������� ���������� ����� � \"{$rec['add_info']}\".";


        $out=$delo_type[$rec['type']];
// �����
        if ($al[perevodi]>=5 && $add_info_off==2)
        {
            if($al[item_hist]==1) //������ �� ������� ��������, ���� �� 1.9 � ���� + ������ ($access[perevodi_deep]>5)
            {
                if($rec['item_id'] !='')
                {
                    $it=explode(',',$rec['item_id']);
                    for($j=0;$j<count($it);$j++)
                    {
                        $it[$j]="<a href='http://capitalcity.oldbk.com/perevod/perevod.php?sh=3&item_hist=".$it[$j]."' target=_blank>".$it[$j]."</a> ";
                    }
                    $rec['item_id']=implode(',',$it);
                }
            }

            //��������� �����
            $rec_date=date("d-m-Y H:i:s",$rec['sdate']);
            $out= $rec['type']. ' '. $rec_date.": ".$out;

            $rec=self::login_fix_for_delo($rec);
            //������� ��� ����
            $out.=" (".
                self::if_have("�������� �:",$rec['target_login']).
                self::if_have(", �����:",$rec['sum_kr']," ��.").
                self::if_have(", �����:",$rec['sum_ekr']," ���.").
                self::if_have(", ��������:",$rec['sum_kom']).
                self::if_have(", ����� �����:",$rec['bank_id']).
                self::if_have(", ����������� ������� id:",$rec['aitem_id']).
                self::if_have(", ��������� ��������:",$rec['item_cost']).
                self::if_have(", id:",$rec['item_id']).
                self::if_have(", ups:",$rec['item_ups']).
                ($rec['item_unic'] > 0 ? ", <font color=red>����: ".$rec['item_unic']."</font>" : "").
                self::if_have(", ��������:",$rec['item_incmagic']).
                self::if_have(", ����:",$rec['item_incmagic_count']).
                self::if_have(", ������� �����:",$rec['item_arsenal']).
                self::if_have(", ��� ���:",$rec['battle']).
                self::if_have(", ������ ��:",$rec['owner_balans_do']," /").
                self::if_have(" ������ �����:",$rec['owner_balans_posle']).
                self::if_have(", ���. ��:",$rec['owner_rep_do']," /").
                self::if_have(" ���. �����:",$rec['owner_rep_posle']).
                self::if_have(" ��� ����:",$rec['add_info'])."   )";
            $out=str_replace("(,","(",$out);
            $out=str_replace(",,",",",$out);
        }
        else
        {
            //�������
            $rec_date=date("d-m-Y H:i:s",$rec['sdate']);
            $out=$rec_date.": ".$out;
        }
        return $out;
    }



    public static function if_have($str,$val,$str2="")
    {
        if (($val!='') AND ($val!='0'))
        {

            if ($str!='')
            {
                return $str.$val.$str2;
            }
            else
            {
                return $val.$str2;
            }
        }
        else if ($val==0)
        {
            return "";
        }
        else return "".$str2;
    }
}