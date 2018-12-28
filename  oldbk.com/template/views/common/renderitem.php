<?php
use \components\Helper\TimeHelper;

?>
    <tr>
        <td align="center" valign="top"  width="150">
            <div style="padding: 20px;">
                <img src="https://i.oldbk.com/i/sh/<?= $Item->item->img ?>">
            </div>
        </td>
        <td align="left">
            <h3>
                <?= $Item->item->name; ?> <img src="https://i.oldbk.com/i/align_<?= $Item->item->nalign == 1 ? '1.5' : $Item->item->nalign ?>.gif"> (���: <?= $Item->item->massa ?>)
                <?php if($Item->isArt()): ?>
                    <IMG SRC="https://i.oldbk.com/i/artefact.gif" WIDTH="18" HEIGHT="16" BORDER=0 TITLE="��������" alt="��������">
                <?php endif; ?>
                <?php if($Item->isUnlim()): ?>
                    <IMG SRC="https://i.oldbk.com/i/noobs.png" WIDTH="14" HEIGHT="8" BORDER=0 TITLE="��� ���� ������ ����� ������ � ���.��������" alt="��� ���� ������ ����� ������ � ���.��������">
                <?php endif; ?>
            </h3>
            <?php if(($gold_price = $Item->getGold()) > 0): ?>
                <b>����: <?= $gold_price ?> </b><img src=https://i.oldbk.com/i/icon/coin_icon.png> &nbsp; &nbsp;
            <?php elseif($Item->item->repcost > 0): ?>
                <b>����: <?= $Item->item->repcost ?> ���.</b> &nbsp; &nbsp;
            <?php elseif($Item->item->ecost > 0): ?>
                <b>����: <?= $Item->item->ecost ?> ���.</b> &nbsp; &nbsp;
            <?php elseif($Item->item->cost > 0): ?>
                <b>����: <?= $Item->item->cost ?> ��.</b> &nbsp; &nbsp;
            <?php endif; ?>

	    <?php if ($Item->item->id == 501) { ?>
		<br><span style='background-color:white;'>��� ������������ �����</span>
	    <?php } ?>
	    <?php if (strlen($Item->item->letter) && $Item->item->letter != "0") { ?>
		<br><div style='width:90%;border: 1px solid;padding: 4px;border-style: inset;border-width: 2px;'><?=$Item->item->letter?></div>
	    <?php } ?>


            <div>
                ������������� : <?= $Item->item->duration ?>/<?= $Item->item->maxdur ?>
            </div>
            <?php if($Item->item->needident): ?>
                <font color=maroon><B>�������� �������� �� ����������������</B></font><BR>
            <?php else: ?>
            <?php endif; ?>


	    <?php 
		// ��������� ��
		if ($Item->item->gmeshok || $Item->item->gsila || $Item->item->mfkrit || $Item->item->mfakrit || $Item->item->mfuvorot || $Item->item->mfauvorot || $Item->item->glovk || $Item->item->ghp || $Item->item->ginta || $Item->item->gintel || $Item->item->gnoj || $Item->item->gtopor || $Item->item->gdubina || $Item->item->gmech || $Item->item->gfire || $Item->item->gwater || $Item->item->gair || $Item->item->gearth || $Item->item->gearth || $Item->item->glight || $Item->item->ggray || $Item->item->gdark || $Item->item->minu || $Item->item->maxu || $Item->item->bron1 || $Item->item->bron2 || $Item->item->bron3 || $Item->item->bron4 || $Item->item->craftbonus || $Item->item->craftspeedup || (isset($Item->item->mfchance) && $Item->item->mfchance > 0)) { ?>
		<br><b>��������� ��:</b><br>
	    <?php } ?>

	    <?php if ($Item->item->minu) { ?>
		����������� ��������� �����������: <?= $Item->item->minu ?></b><br>
	    <?php } ?>
	    <?php if ($Item->item->maxu) { ?>
		������������ ��������� �����������: <?= $Item->item->maxu ?></b><br>
	    <?php } ?>
	    <?php if ($Item->item->craftbonus) { ?>
		����� ����������: <?= $Item->item->craftbonus ?><br>
	    <?php } ?>
	    <?php if ($Item->item->craftspeedup) { ?>
		��������� ����� ������������ ��: <?= $Item->item->craftspeedup ?>%<br>
	    <?php } ?>

	    <?php if (isset($Item->item->mfchance) && $Item->item->mfchance > 0) { ?>
		���� �����������: <?= $Item->item->mfchance ?>%<br>
	    <?php } ?>

	    <?php if ($Item->item->gsila) { ?>
		����: <?= $Item->item->gsila ?><br>
	    <?php } ?>
	    <?php if ($Item->item->glovk) { ?>
		��������: <?= $Item->item->glovk ?><br>
	    <?php } ?>
	    <?php if ($Item->item->ginta) { ?>
		��������: <?= $Item->item->ginta ?><br>
	    <?php } ?>
	    <?php if ($Item->item->gintel) { ?>
		���������: <?= $Item->item->gintel ?><br>
	    <?php } ?>
	    <?php if ($Item->item->gmp) { ?>
		��������: <?= $Item->item->gmp ?><br>
	    <?php } ?>
	    <?php if ($Item->item->ghp) { ?>
		������� �����: <?= $Item->item->ghp ?><br>
	    <?php } ?>


	    <?php if ($Item->item->mfkrit) { ?>
		��. ����������� ������: <?= $Item->item->mfkrit ?>%<br>
	    <?php } ?>
	    <?php if ($Item->item->mfakrit) { ?>
		��. ������ ����. ������: <?= $Item->item->mfakrit ?>%<br>
	    <?php } ?>
	    <?php if ($Item->item->mfuvorot) { ?>
		��. ������������: <?= $Item->item->mfuvorot ?>%<br>
	    <?php } ?>
	    <?php if ($Item->item->mfauvorot) { ?>
		��. ������ ������������: <?= $Item->item->mfauvorot ?>%<br>
	    <?php } ?>


	    <?php if ($Item->item->gnoj) { ?>
		���������� �������� ������ � ���������: <?= $Item->item->gnoj ?><br>
	    <?php } ?>
	    <?php if ($Item->item->gtopor) { ?>
		���������� �������� �������� � ��������: <?= $Item->item->gtopor ?><br>
	    <?php } ?>
	    <?php if ($Item->item->gdubina) { ?>
		���������� �������� �������� � ��������: <?= $Item->item->gdubina ?><br>
	    <?php } ?>
	    <?php if ($Item->item->gmech) { ?>
		���������� �������� ������: <?= $Item->item->gmech ?><br>
	    <?php } ?>


	    <?php if ($Item->item->gfire) { ?>
		���������� �������� ������� ����: <?= $Item->item->gfire ?><br>
	    <?php } ?>
	    <?php if ($Item->item->gwater) { ?>
		���������� �������� ������� ����: <?= $Item->item->gwater ?><br>
	    <?php } ?>
	    <?php if ($Item->item->gair) { ?>
		���������� �������� ������� �������: <?= $Item->item->gair ?><br>
	    <?php } ?>
	    <?php if ($Item->item->gearth) { ?>
		���������� �������� ������� �����: <?= $Item->item->gearth ?><br>
	    <?php } ?>



	    <?php if ($Item->item->glight) { ?>
		���������� �������� ������ �����: <?= $Item->item->glight ?><br>
	    <?php } ?>
	    <?php if ($Item->item->ggray) { ?>
		���������� �������� ����� ������: <?= $Item->item->ggray ?><br>
	    <?php } ?>
	    <?php if ($Item->item->gdark) { ?>
		 ���������� �������� ������ ����: <?= $Item->item->gdark ?><br>
	    <?php } ?>


	    <?php if ($Item->item->bron1) { ?>
		 ����� ������: <?= $Item->item->bron1 ?><br>
	    <?php } ?>
	    <?php if ($Item->item->bron2) { ?>
		 ����� �������: <?= $Item->item->bron2 ?><br>
	    <?php } ?>
	    <?php if ($Item->item->bron3) { ?>
		 ����� �����: <?= $Item->item->bron3 ?><br>
	    <?php } ?>
	    <?php if ($Item->item->bron4) { ?>
		 ����� ���: <?= $Item->item->bron4 ?><br>
	    <?php } ?>


	    <?php if ($Item->item->stbonus) { ?>
		��������� ����������: <b><?= $Item->item->stbonus ?></b><br>
	    <?php } ?>

	    <?php if ($Item->item->mfbonus) { ?>
		��������� ���������� ��: <b><?= $Item->item->mfbonus ?></b><br>
	    <?php } ?>

	    <?php 
		// ��������� �����������
		if ((is_object($Item->incmagic) && $Item->incmagic->nlevel > 0) || $Item->item->nsex || $Item->item->nsila || $Item->item->nlovk || $Item->item->ninta || $Item->item->nvinos || $Item->item->nlevel || $Item->item->nintel || $Item->item->nmudra || $Item->item->nnoj || $Item->item->ntopor || $Item->item->ndubina || $Item->item->nmech || $Item->item->nfire || $Item->item->nwater || $Item->item->nair || $Item->item->nearth || $Item->item->nlight || $Item->item->ngray || $Item->item->ndark || $Item->item->nclass ) { ?>
		<br><b>��������� �����������:</b><BR>
	    <?php } ?>


	    <?php if ($Item->item->nclass) { ?>
		����� ���������: <b><?
			if ($Item->item->nclass == 1) echo '���������';
			if ($Item->item->nclass == 2) echo '��������';
			if ($Item->item->nclass == 3) echo '����';
			if ($Item->item->nclass == 4) echo '�����';
		?></b><br>
	    <?php } ?>


	    <?php if ($Item->item->nsila) { ?>
		����: <?= $Item->item->nsila ?><br>
	    <?php } ?>
	    <?php if ($Item->item->nlovk) { ?>
		��������: <?= $Item->item->nlovk ?><br>
	    <?php } ?>
	    <?php if ($Item->item->ninta) { ?>
		��������: <?= $Item->item->ninta ?><br>
	    <?php } ?>
	    <?php if ($Item->item->nintel) { ?>
		���������: <?= $Item->item->nintel ?><br>
	    <?php } ?>
	    <?php if ($Item->item->nvinos) { ?>
		������������: <?= $Item->item->nvinos ?><br>
	    <?php } ?>

	    <?php if ($Item->item->nlevel > 0 || (is_object($Item->incmagic) && $Item->incmagic->nlevel > 0)) { ?>
		�������: <?php
		$nlevel = $Item->item->nlevel;
		if (is_object($Item->incmagic) && $Item->incmagic->nlevel > $nlevel) {
			$nlevel = $Item->incmagic->nlevel;
		}
		echo $nlevel;
		?><br>
	    <?php } ?>
	    <?php if ($Item->item->nmudra) { ?>
		��������: <?= $Item->item->nmudra ?><br>
	    <?php } ?>


	    <?php if ($Item->item->nnoj) { ?>
		���������� �������� ������ � ���������: <?= $Item->item->nnoj ?><br>
	    <?php } ?>
	    <?php if ($Item->item->ntopor) { ?>
		���������� �������� �������� � ��������: <?= $Item->item->ntopor ?><br>
	    <?php } ?>
	    <?php if ($Item->item->ndubina) { ?>
		���������� �������� �������� � ��������: <?= $Item->item->ndubina ?><br>
	    <?php } ?>
	    <?php if ($Item->item->nmech) { ?>
		���������� �������� ������: <?= $Item->item->nmech ?><br>
	    <?php } ?>


	    <?php if ($Item->item->nfire) { ?>
		���������� �������� ������� ����: <?= $Item->item->nfire ?><br>
	    <?php } ?>
	    <?php if ($Item->item->nwater) { ?>
		���������� �������� ������� ����: <?= $Item->item->nwater ?><br>
	    <?php } ?>
	    <?php if ($Item->item->nair) { ?>
		���������� �������� ������� �������: <?= $Item->item->nair ?><br>
	    <?php } ?>
	    <?php if ($Item->item->nearth) { ?>
		���������� �������� ������� �����: <?= $Item->item->nearth ?><br>
	    <?php } ?>



	    <?php if ($Item->item->nlight) { ?>
		���������� �������� ������ �����: <?= $Item->item->nlight ?><br>
	    <?php } ?>
	    <?php if ($Item->item->ngray) { ?>
		���������� �������� ����� ������: <?= $Item->item->ngray ?><br>
	    <?php } ?>
	    <?php if ($Item->item->ndark) { ?>
		 ���������� �������� ������ ����: <?= $Item->item->ndark ?><br>
	    <?php } ?>

	    <?php if ($Item->item->nsex == 1) { ?>
		���: �������<br>
	    <?php } ?>
	    <?php if ($Item->item->nsex == 2) { ?>
		���: �������<br>
	    <?php } ?>

	    <?php if (is_object($Item->magic) && $Item->magic->id == 8888) { ?>
		�������, ������, ����������� ����������<br>
	    <?php } ?>

	    <?php
		// �����������
		if (
			(is_object($Item->magic) && strlen($Item->magic->name) && ($Item->magic->us_type > 0 || $Item->magic->target_type > 0)) ||
			(is_object($Item->magic) && strlen($Item->magic->img) && $Item->item->type == 12 && $Item->item->dategoden == 0) ||
			((is_object($Item->magic) && $Item->item->type == 12) && (!strlen($Item->magic->img) || $Item->item->dategoden > 0)) ||
			!$Item->item->isrep ||
			$Item->item->goden ||
			$Item->item->notsell
		) {
	    ?>
		<br><b>�����������:</b><br>
	    <?php 
		  }
            ?>

	    <?php if ($Item->item->goden) { ?>
		���� ��������: <b><?= $Item->item->goden ?> ��.</b><br>
	    <?php } ?>


	    <?php if ($Item->item->id >= 946 && $Item->item->id <= 957) { ?>
		<small><font color=red>���������� ������������ ������ ����� 4-� ��������� �������, � ��� ����� �� ����� ������ ������</font></small><br>
	    <?php } ?>

	    <?php if ((is_object($Item->magic) && $Item->item->type == 12) && (!strlen($Item->magic->img) || $Item->item->dategoden > 0)) { ?>
		�� ����� ������������ � ����<BR>
	    <?php } ?>

	    <?php if (is_object($Item->magic) && $Item->magic->id == 8888) { ?>
		����� ���� ����������� ������ �� ���� �������<br>
	    <?php } ?>

	    <?php if (is_object($Item->magic) && strlen($Item->magic->name) && $Item->magic->us_type == 2) { ?>
		����� ������������ ������ ��� ���<br>
	    <?php } ?>

	    <?php if (is_object($Item->magic) && strlen($Item->magic->name) && $Item->magic->us_type == 1) { ?>
		����� ������������ ������ � ���<br>
	    <?php } ?>

	    <?php if (is_object($Item->magic) && strlen($Item->magic->name) && $Item->magic->target_type == 1) { ?>
		����� ������������ ������ �� ����<br>
	    <?php } ?>


	    <?php if (!$Item->item->isrep && !($Item->item->id >= 946 && $Item->item->id <= 957)) { ?>
		<font color=maroon>������� �� �������� �������</font><BR>
	    <?php } ?>

	    <?php if ($Item->item->id >= 946 && $Item->item->id <= 957) { ?>
		<font color=maroon>������� �� �������� �����������</font><BR>
		<font color=maroon>������� �� �������� ���������</font><BR>
	    <?php } ?>

	    <?php if ($Item->item->notsell) { ?>
		<font color=maroon>������� �� �������� ������� � ���. �������</font><BR>
	    <?php } ?>

	    <?php
		// ��������
		if (
			$Item->item->id == 30012 ||
			(is_object($Item->magic) && strlen($Item->magic->name) && $Item->item->type == 50) ||
			$Item->item->rareitem > 0 ||
			$Item->item->type == 27 ||
			$Item->item->type == 28 ||
			(is_object($Item->magic) && strlen($Item->magic->name) && $Item->item->type != 50) ||
			(is_object($Item->magic) && $Item->magic->chanse) ||
                        (is_object($Item->magic) && $Item->magic->time) ||
			is_object($Item->incmagic)
		) {
	    ?>
		<br><b>��������:</b><br>
	    <?php 
		  }
            ?>


	    <?php if (is_object($Item->magic) && strlen($Item->magic->name) && $Item->item->type == 50) {
			if (strlen($Item->magic->name >=4) && stripos(substr($Item->magic->name,0,-4),'<br>') !== false) { ?>
				<?=$Item->magic->name ?>
		  <?php } else { ?>
				� <?=$Item->magic->name ?><BR>
		  <?php } ?>
	    <?php } ?>


	    <?php if ($Item->item->id == 30012) { ?>
		� ��� ���� ����������� ���� �������� ������<br>
	    <?php } ?>

 
	    <?php if (is_object($Item->magic) && strlen($Item->magic->name) && $Item->item->type != 50) { ?>
		<font color=maroon>�������� ��������:</font> <?=$Item->magic->name ?><br>
	    <?php } ?>	    

	    <?php if (is_object($Item->incmagic)) { ?>
		�������� �������� <img src="https://i.oldbk.com/i/magic/<?=$Item->incmagic->img?>" title="<?=$Item->incmagic->name?>"> 0/<?=$Item->item->includemagicmax?> ��.<BR>
		���������� �����������: <?=$Item->item->includemagicuses?><br>
	    <?php } ?>	

	    <?php if (is_object($Item->magic) && $Item->magic->chanse) { ?>
		����������� ������������: <?= $Item->magic->chanse ?>%</b><br>
	    <?php } ?>

	    <?php if (is_object($Item->incmagic) && $Item->incmagic->chanse) { ?>
		����������� ������������: <?= $Item->incmagic->chanse ?>%</b><br>
	    <?php } ?>

	    <?php if (is_object($Item->magic) && $Item->magic->time) { ?>
		����������������� �������� �����: <b><?= TimeHelper::prettyTime(null,time()+($Item->magic->time*60)) ?></b><br>
	    <?php } ?>
	    <?php if (is_object($Item->incmagic) && $Item->incmagic->time) { ?>
		����������������� �������� �����: <b><?= TimeHelper::prettyTime(null,time()+($Item->incmagic->time*60)) ?></b><br>
	    <?php } ?>

            <?php if($Item->item->type == 27): ?>
                ����� ��������� �� �����<br>
            <?php elseif($Item->item->type == 28): ?>
                ����� ��������� ��� �����<br>
            <?php endif; ?>

	    <?php if ($Item->item->rareitem == 10) { ?>
		<font color="#676565"><b>������� �������</b></font><BR>
	    <?php } ?>
	    <?php if ($Item->item->rareitem == 1) { ?>
		<font color="#34a122"><b>������ �������</b></font><BR>
	    <?php } ?>
	    <?php if ($Item->item->rareitem == 2) { ?>
		<font color="#2145ad"><b>������� �������</b></font><BR>
	    <?php } ?>
	    <?php if ($Item->item->rareitem == 3) { ?>
		<font color="#760c90"><b>����������� �������</b></font><BR>
	    <?php } ?>



	    <?php if ($Item->item->ab_mf > 0 || $Item->item->ab_bron || $Item->item->ab_uron || ($Item->item->id >= 55510301 && $Item->item->id <= 55510401) || ($Item->item->id >= 410027 && $Item->item->id <= 410028) || $Item->item->type == 30 || (is_object($Item->magic) && $Item->magic->id && $Item->get_rkm_bonus_by_magic($Item->magic->id))) { ?>
		<br><b>��������:</b><br>
		    <?php if ($Item->item->ab_mf > 0) { ?>
			������������� ��.: +<?=$Item->item->ab_mf?>%<br>
		    <?php } ?>
		    <?php if ($Item->item->ab_bron > 0) { ?>
			�����: +<?=$Item->item->ab_bron?>%<br>
		    <?php } ?>
		    <?php if ($Item->item->ab_uron > 0) { ?>
			�����: +<?=$Item->item->ab_uron?>%<br>
		    <?php } ?>
		    <?php
			$bonus = $Item->getElkaBuketBonus();
			if ($bonus > 0) { ?>
				������� �����: +<?=$bonus?>%<br>
		  <?php } ?>

		    <?php if ($Item->item->id == 55510351) { ?>
			�����: +10%<br>
		    <?php } ?>

		    <?php if ($Item->item->id == 55510352) { ?>
			�����: +30%<br>
			���������� ���������: +20%<br>
		    <?php } ?>


		    <?php if ($Item->item->id == 410027) { ?>
			�����: +10%<br>
			���������� ���������: +10%<br>
		    <?php } ?>
		    <?php if ($Item->item->id == 410028) { ?>
			�����: +30%<br>
			���������� ���������: +20%<br>
		    <?php } ?>

		<?php if ($Item->item->type == 30) { 
				$ab = $Item->getEmptyRune();
				if ($ab['ab_mf'] > 0) {
					echo "������������� ��.: 0%<br>";
				}
				if ($ab['ab_bron'] > 0) {
					echo "�����: 0%<br>";
				}
				if ($ab['ab_uron'] > 0) {
					echo "�����: 0%<br>";
				}
		      } ?>


			<?php
			if (is_object($Item->magic) && $Item->magic->id && $Item->get_rkm_bonus_by_magic($Item->magic->id)) { ?>
				������� ����� �� ���. �����: +<?=$Item->get_rkm_bonus_by_magic($Item->magic->id)?>%<br>
			<?php			
			}
			?>
	    <?php } ?>
	    <div>&nbsp;</div>
        </td>
    </tr>
