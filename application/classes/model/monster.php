<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2009 Copy112
 * @license    http://copy112.com/mg/license
 */

class Model_Monster extends Sprig {
	
	protected function _init()
	{
		$this->_fields += array(
			'id'      => new Sprig_Field_Auto,
			'name'    => new Sprig_Field_Char(),
			'max_hp'  => new Sprig_Field_Integer(),
			'defence' => new Sprig_Field_integer(),
			
			'min_dmg' => new Sprig_Field_integer(),
			'max_dmg' => new Sprig_Field_integer(),
			'money'   => new Sprig_Field_integer(),
			'xp'      => new Sprig_Field_integer(),
			'image'   => new Sprig_Field_image(array(
				'path' => 'assets/images/monsters/',
			)),
		);
	}	
	
}