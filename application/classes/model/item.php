<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Lewis Delicata
 * @copyright  (c) 2010 Lewis Delicata
 * @license    http://modulargaming.com/projects/modulargaming/wiki/License
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
