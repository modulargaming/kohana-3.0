<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://copy112.com/mg/license
 */

class Model_Character extends Jelly_Model {
	
	public static function initialize(Jelly_Meta $meta)
	{
		
		$meta->load_with = array('zone');
		
		$meta->fields += array(
			'id' => new Field_Primary,
			'user' => new Field_BelongsTo,
			'race' => new Field_BelongsTo(array(
                                'column'  => 'race_id',
                                'foreign' => 'character_race.id',

			)),
			'class'   => new Field_BelongsTo(array(
                                'column'  => 'class_id',
                                'foreign' => 'character_class.id',

			)),
			'name' => new Field_String,
			'gender' => new Field_Enum(array(
				'choices' => array('male' => 'Male', 'female' => 'Female'),
			)),
			'alignment' => new Field_Integer,
			'hp'     => new Field_Integer,
			'max_hp' => new Field_Integer,
			'strength' => new Field_Integer,
			'defence' => new Field_Integer,
			'agility' => new Field_Integer,
			'money'  => new Field_Integer,
			'level' => new Field_Integer,
			'xp' => new Field_Integer,
			'energy' => new Field_Integer,
			'max_energy' => new Field_Integer,
			'zone'   => new Field_BelongsTo,
			'battle' => new Field_HasOne,
		);
	}
	
}
