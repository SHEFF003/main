<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 19.11.2015
 */

namespace components\Model;

/**
 * Class Shop
 * @package components\Model
 *
 * @method $this|$this[] asModel()
 *
 * @property int $id
 * @property string $name
 * @property int $duration
 * @property int $maxdur
 * @property float $cost
 * @property float $ecost
 * @property int $count
 * @property int $avacount
 * @property int $angcount
 * @property int $nlevel
 * @property int $nsila
 * @property int $nlovk
 * @property int $ninta
 * @property int $nvinos
 * @property int $nintel
 * @property int $nmudra
 * @property int $nnoj
 * @property int $ntopor
 * @property int $ndubina
 * @property int $nmech
 * @property int $nalign
 * @property int $minu
 * @property int $maxu
 * @property int $gsila
 * @property int $glovk
 * @property int $ginta
 * @property int $ghp
 * @property int $gmp
 * @property int $mfkrit
 * @property int $mfakrit
 * @property int $mfuvorot
 * @property int $mfauvorot
 * @property int $gnoj
 * @property int $gtopor
 * @property int $gdubina
 * @property int $gmech
 * @property string $img
 * @property string $img_big
 * @property int $shshop
 * @property int $bron1
 * @property int $bron2
 * @property int $bron3
 * @property int $bron4
 * @property int $dategoden
 * @property int $magic
 * @property int $type
 * @property float $massa
 * @property int $goden
 * @property int $needident
 * @property int $nfire
 * @property int $nwater
 * @property int $nair
 * @property int $nearth
 * @property int $nlight
 * @property int $ngray
 * @property int $ndark
 * @property int $gfire
 * @property int $gwater
 * @property int $gair
 * @property int $gearth
 * @property int $glight
 * @property int $ggray
 * @property int $gdark
 * @property string $letter
 * @property int $isrep
 * @property int $razdel
 * @property int $glava
 * @property int $nsex
 * @property int $owner
 * @property string $klan
 * @property int $group
 * @property int $gmeshok
 * @property int $mfbonus
 * @property int $includemagic
 * @property int $includemagicdex
 * @property int $includemagicmax
 * @property string $includemagicname
 * @property int $includemagicuses
 * @property float $includemagiccost
 * @property float $includemagicekrcost
 * @property int $ab_mf
 * @property int $ab_bron
 * @property int $ab_uron
 * @property int $need_wins
 * @property int $artproto
 * @property int $wopen
 * @property int $charge_rep
 * @property int $is_owner
 * @property int $unikflag
 * @property int $stbonus
 * @property int $ekr_flag
 * @property int $nclass
 *
 */
class Eshop extends AbstractCapitalModel
{
    /**
     * @param string $className
     * @return Eshop
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public static function tableName()
    {
        return 'eshop';
    }

    public static function pkField()
    {
        return 'id';
    }

    public function getPk()
    {
        return $this->id;
    }

    protected function fieldMap()
    {
        return array(
            'id', 'name', 'duration', 'maxdur', 'cost', 'ecost', 'count', 'avacount', 'angcount', 'nlevel', 'nsila', 'nlovk',
            'ninta', 'nvinos', 'nintel', 'nmudra', 'nnoj', 'ntopor', 'ndubina', 'nmech', 'nalign', 'minu', 'maxu',
            'gsila', 'glovk', 'ginta', 'ghp', 'gmp', 'mfkrit', 'mfakrit', 'mfuvorot', 'mfauvorot', 'gnoj', 'gtopor',
            'gdubina', 'gmech', 'img', 'img_big', 'shshop', 'bron1', 'bron2', 'bron3', 'bron4', 'dategoden', 'magic', 'type',
            'massa', 'goden', 'needident', 'nfire', 'nwater', 'nair', 'nearth', 'nlight', 'ngray', 'ndark', 'gfire',
            'gwater', 'gair', 'gearth', 'glight', 'ggray', 'gdark', 'letter', 'isrep', 'razdel', 'glava', 'nsex',
            'owner', 'klan', 'group', 'gmeshok', 'mfbonus', 'includemagic', 'includemagicdex', 'includemagicmax',
            'includemagicname', 'includemagicuses', 'includemagiccost', 'includemagicekrcost', 'ab_mf', 'ab_bron',
            'ab_uron', 'need_wins', 'artproto', 'wopen', 'charge_rep', 'is_owner', 'unikflag', 'stbonus', 'ekr_flag','nclass'
        );
    }
}