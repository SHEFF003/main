<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 03.03.2016
 *
 * @var int $rate_position
 * @var int $sex
 */ ?>

<?php
$message = '�� ������ � ���-100';
if($rate_position > 0 && $rate_position < 101) {
    $rate_image = 'http://i.oldbk.com/i/i/quest_0803_top%d_%s.png';
    $img_num = 1;
    if($rate_position > 10 && $rate_position < 51) {
        $img_num = 2;
    } elseif($rate_position > 50 && $rate_position < 101) {
        $img_num = 3;
    }
    $img = sprintf($rate_image, $img_num, $sex == 1 ? 'm' : 'w');
    $message = '<b>'.$rate_position.'</b> <img src="'.$img.'">';
}

$text = <<<EOT
    <table>
        <colgroup>
            <col width="120px">
            <col>
        </colgroup>
        <tr>
            <td colspan="2" align="center">
                <div style="text-align:center;margin-bottom:10px;">
                    <b>�������� ������� � ���������� �����!</b>
                </div>
            </td>
        </tr>
        <tr>
            <td align="center">
                <img src="http://i.oldbk.com/i/city/sub/vesna_cap_flowershop.png">
            </td>
            <td>
                �� ���������� � �������� ����� ������ �������� �������� ����� � ��������� � <a href="http://top.oldbk.com/?r=sgift" target="_blank">�������� ���������!</a>
                � �������, ���������� ���������� ���������� �������, ������ �������� ����� � <a href="http://top.oldbk.com/?r=ggift" target="_blank">�������� �����������������!</a>
                <br><br>
                ��� ��������� ���-100 ���� ��������� ������� ����������� ���� ������� �� �������� ���������.
                <br><br>
                ���� ����� � �������� ���������: {$message}
            </td>
        </tr>
    </table>
    <br>
    <center><a style="margin-left:15px;" href="#" onclick="$('#questdiv').hide();return false;">�������</a></center>
EOT;
?>

<?php
    echo $this->renderPartial('common/cp_popup', array('text' => $text));
?>