<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Curtis Delicata
 * @copyright  (c) 2010 Curtis Delicata
 * @license    http://modulargaming.com/license
 */

class Modulargaming_Model_Pet extends Jelly_Model {
	
	public static function initialize(Jelly_Meta $meta)
	{
		
		
		$meta->fields += array(
			'id' => new Field_Primary,
			'user' => new Field_BelongsTo,
			'race' => new Field_BelongsTo(array(
                                'column'  => 'race_id',
                                'foreign' => 'pet_race.id',

			)),
			'colour'   => new Field_BelongsTo(array(
                                'column'  => 'colour_id',
                                'foreign' => 'pet_colour.id',

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
			'level' => new Field_Integer,
			'xp' => new Field_Integer,
			'max_xp' => new Field_Integer,
			'energy' => new Field_Integer,
			'max_energy' => new Field_Integer,
			'zone'   => new Field_BelongsTo,
		);
	}
	
}
