<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 03.03.2016
 */ ?>


<?php
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
                ������ ���� ��� ���� ������� ����� � <b>��������� ��������</b>, ������ ��� ����� <b>�������</b> � ����� � ������ �������.<br>
                ����� ������� ������� �� �������� 8 �����!
            </td>
        </tr>
    </table>
    <br>
    <center><a href="{$app->urlFor('quest', array('action' => 'quest8', 'get' => true))}">�������</a> <a style="margin-left:15px;" href="#" onclick="$('#questdiv').hide();return false;">�������</a></center>
EOT;
?>

<?php
echo $this->renderPartial('common/cp_popup', array('text' => $text));
?>