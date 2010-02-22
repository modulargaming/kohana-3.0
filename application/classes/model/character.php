<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2010 Copy112
 * @license    http://copy112.com/mg/license
 */

class Model_Character extends Sprig {
	
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