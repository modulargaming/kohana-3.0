<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Lewis
 * @copyright  (c) 2010 Lewis
 * @license    BSD
 */


class Model_Item extends Sprig {
	
	protected function _init()
	{
		$this->_fields += array(
			'id' => new Sprig_Field_Auto,
			'name' => new Sprig_Field_Char(),
			'class' => new Sprig_Field_Char(),
			'image' => new Sprig_Field_Char(),
			'description' => new Sprig_Field_Char(),
		);
	}	
	
}
