<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2010 Copy112
 * @license    http://copy112.com/mg/license
 */

class Model_Character extends Jelly_Model {
	
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields += array(
			'id' => new Field_Primary,
			'user' => new Field_BelongsTo( 'user_id' ),
			
			'race' => new Field_BelongsTo(array(
				'model' => 'race',
			)),
			
			'name' => new Field_String,
			
			'gender' => new Field_Enum(array(
				'choices' => array('male' => 'Male', 'female' => 'Female'),
			)),
			
			'alignment' => new Field_Integer,
			
			'hp' => new Field_Integer,
			'max_hp' => new Field_Integer,
			
			'money'  => new Field_Integer,
			'energy' => new Field_Integer,
		);
	}
	
	protected function _init()
	{
		$this->_fields += array(
			'id' => new Sprig_Field_Auto,
			'user' => new Sprig_Field_BelongsTo(array(
                'model' => 'User',
			)),
			'name' => new Sprig_Field_Char(array(
				'empty'  => FALSE,
				'min_length' => 3,
				'max_length' => 20,
			)),
			'gender' => new Sprig_Field_Enum(array(
				'choices' => array('male' => 'Male', 'female' => 'Female'),
				'empty'  => FALSE,
			)),
			'race' => new Sprig_Field_BelongsTo(array(
                'model' => 'race',
			)),
			'alignment' => new Sprig_Field_Integer(array(
				'empty' => TRUE,
			)),
			'hp' => new Sprig_Field_Integer(array(
				'empty'  => TRUE,
				'rules' => array(
				 	'numeric' => array(),
				 )
			)),
			'max_hp' => new Sprig_Field_Integer(array(
				'empty' => FALSE,
			)),
			'money' => new Sprig_Field_Integer(array(
				'empty' => TRUE,
				'rules' => array(
				 	'numeric' => array(),
				 )
			)),
			'level' => new Sprig_Field_Integer(),
			'xp' => new Sprig_Field_Integer(array(
				'empty' => TRUE,
				'rules' => array(
				 	'numeric' => array(),
				)
			)),
			'energy' => new Sprig_Field_Integer(),
			'battle' => new Sprig_Field_HasOne(array(
                'model' => 'Battle',
			)),
			'zone' => new Sprig_Field_BelongsTo(array(
				'model' => 'Zone',
			)),
		);
	}
	
	
}