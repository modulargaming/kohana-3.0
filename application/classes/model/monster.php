<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2010 Copy112
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
			
			'min_dmg' => new Sprig_Field_Integer(),
			'max_dmg' => new Sprig_Field_Integer(),
			'money'   => new Sprig_Field_Integer(),
			'xp'      => new Sprig_Field_Integer(),
			'image'   => new Sprig_Field_Image(array(
				'directory' => 'assets/images/monsters/',
			)),
		);
	}	
	
}