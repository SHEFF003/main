<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 19.11.2015
 */

namespace components\models;
use components\Component\VarDumper;
use components\models\_base\BaseModal;

/**
 * Class Chat
 * @package components\Model
 *
 * @property int $owner
 * @property int $hunterlevel
 * @property int $hunterexp
 * @property int $woodmanlevel
 * @property int $woodmanexp
 * @property int $minerlevel
 * @property int $minerexp
 * @property int $farmerlevel
 * @property int $farmerexp
 * @property int $herbalistlevel
 * @property int $herbalistexp
 * @property int $cooklevel
 * @property int $cookexp
 * @property int $smithlevel
 * @property int $smithexp
 * @property int $armorerlevel
 * @property int $armorerexp
 * @property int $armorsmithlevel
 * @property int $armorsmithexp
 * @property int $tailorlevel
 * @property int $tailorexp
 * @property int $jewelerlevel
 * @property int $jewelerexp
 * @property int $alchemistlevel
 * @property int $alchemistexp
 * @property int $magelevel
 * @property int $mageexp
 * @property int $carpenterlevel
 * @property int $carpenterexp
 * @property int $prospectorlevel
 * @property int $prospectorexp
 *
 */
class UsersCraft extends BaseModal
{
	protected $connection = 'capital';
	protected $table = 'users_craft';
	protected $primaryKey = 'owner';


	/**
	 * @param $user_id
	 * @return array
	 */
	public static function getLevelsByUser($user_id)
	{
		$profs = array();

		$UserCraft = static::find($user_id);
		if(!$UserCraft) {
			return $profs;
		}
		$UserCraft = $UserCraft->toArray();

		$Professions = CraftProf::get(['name'])->toArray();
		foreach ($Professions as $Profession) {
			$levelField = $Profession['name'].'level';
			if(array_key_exists($levelField, $UserCraft)) {
				$profs[$levelField] = $UserCraft[$levelField];
			}
		}

		return $profs;
	}

	/**
	 * @param $name
	 * @return int
	 */
	public function getLevelByName($name)
	{
		$field = strtolower($name).'level';
		if(!isset($this->attributes[$field])) {
			return 0;
		}

		return $this->attributes[$field];
	}

	/**
	 * @param $name
	 * @return int
	 */
	public function getExpByName($name)
	{
		$field = strtolower($name).'exp';
		if(!isset($this->attributes[$field])) {
			return 0;
		}

		return $this->attributes[$field];
	}

	/**
	 * @param $id
	 * @param $level
	 * @return null
	 */
	public function getBonusById($id, $level)
	{
		$bonus = null;
		switch ($id) {
			case 5:
				$bonus = sprintf('�������������� ����� �� ���: +%dHP', 20*$level);
				break;
			case 6:
				$bonus = sprintf('����� �����: %d-%d', (1*$level), (2*$level));
				break;
			case 7:
				$bonus = sprintf('����������� �����: +%s%', round((0.25*$level),2));
				break;
			case 8:
				$bonus = sprintf('�������� �����: +%s%', round((0.5*$level),2));
				break;
			case 9:
				$bonus = sprintf('��. ������ ����. ������: +%d%', round((20*$level)));
				break;
			case 10:
				$bonus = sprintf('��. ������ ��������.: +%d%', round((20*$level)));
				break;
			case 11:
				$bonus = sprintf('������ �� �����: +%s%', round((2*$level),2));
				break;
			case 12:
				$bonus = sprintf('����� ����������� �����: %d-%d', (1*$level), (2*$level));
				break;
			case 13:
				$bonus = sprintf('���� �������� ������ � ���: +%s', round((2*$level),2));
				break;
		}

		return $bonus;
	}
}