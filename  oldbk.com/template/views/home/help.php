<?php
$help = <<<HTML
<br><br>� <b>�����</b> ���� ����������� ���������, ������� ����� ������� ��� <b>������ �� ����</b> � �������� �� ������, ���������� ������� ��������.<br />
                    ����� ��������� ����� � ���������� ������ <img class="img-responsive" src="http://i.oldbk.com/i/support/support.gif" border="0" /><strong style="color:#800000;">�������� �� ������� ��������!</strong>.<br /><br />
                    ��� ���� �������� �� ��������� �������, ���� �� �������, ���������� <b>"������"</b>:<br /><br />

                    <p style="text-align:center;"><img class="img-responsive"  alt="" src=http://i.oldbk.com/i/images/help11.jpg border=0></p><br /><br />
                    <b>��� ������</b> ���� ��� ���� ������� � �������, � ��� ����� ������������ ������ ��� ��������� ������ �� �������� ��������.
                    �� ������ ���������� � ���� ��� � ����� ������� (�� �����������) ��������� � �������� ������ ��� �����.<br /><br />
                    �� ������ ������ � ��� ������� � �������� ���������, � ���������� �������, � �������� ����, � ������ �������, � ��� �����.
                    �������� - ��� ������� �����������, ��� ������ �� ��������, ��� ����� ���������� ����, � ������ ������ ����� �������� � ����, "��� ������ ����...".<br /><br />

                    ���� �� <img src="http://i.oldbk.com/i/support/support.gif" border="0" /> <strong style="color:#800000;">����������</strong>, ����������� � �������, ����������� ������� ��� ��� ��������� � ���� ���������� � ����� ��������. <br /><br />

                    ������ <strong style="color:#800000;">����������</strong> ������ ����� ���������� � ������ ����, ����� �� ������� <img src=http://i.oldbk.com/i/chat/ch6_active.jpg border=0>: <br><br>
                    <p style="text-align:center;"><img class="img-responsive" alt="" src=http://i.oldbk.com/i/images/help2.jpg border=0></p><br><br>

                    � <img src="http://i.oldbk.com/i/support/support.gif" border="0" /> <strong style="color:#800000;">�����������</strong>, �����, ����� �������� � �������, ����� ����������� ��� ��� � ������ ����. ������, ������� <b>� �������</b> �������� ������ � <strong style="color:#800000;">�����������</strong>, ������������ <b>� ����� ������</b>. �������� � ������ ������ �� ������� ���� ��������� ���������.
                    <br><br>
                    �� �������� ����� � ����������� ������� �������� ���������� � ����� <img src="http://i.oldbk.com/i/align_2.4.gif"><img alt="radminion" title="radminion" src="http://i.oldbk.com/i/klan/radminion.gif"> <B>radminion</B>

HTML;

//render_news('������ �� ����', $help);
?>

<div class="kp-news-item box po-re sh-10">
    <div class="kp-backgr-news po-ab">
        <div class="kp-bk-full im-10 po-ab"></div>
        <div class="kp-bk-top im-11 m-im-100 po-ab"></div>
        <div class="kp-bk-bot im-12 m-im-100 po-ab"></div>
    </div>
    <div class="po-re">
        <div class="kp-news-title po-re">
            <div class="kp-backgr-news-title po-ab">
                <div class="kp-bk-full-tt im-15 po-ab"></div>
                <div class="kp-bk-left-tt im-16 po-ab"></div>
                <div class="kp-bk-right-tt im-17 po-ab"></div>
            </div>
            <div class="oh po-re kp-main-tittle">
                <i class="fa fa-newspaper-o fl po-re" aria-hidden="true"></i>
                <div class="kp-title-news-name fl"><h3>������ �� ����</h3></div>
<!--                <div class="kp-title-news-date po-re fr"><h3>--><?//=\Carbon\Carbon::parse($item['cdate'])->toDateString()?><!--</h3></div>-->
            </div>
        </div>
        <div class="kp-news-content">
            <?= $help;?>
        </div>
    </div>
</div>
