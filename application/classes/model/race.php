<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2010 Copy112
 * @license    http://copy112.com/mg/license
 */

class Model_Race extends Sprig {
	
	protected function _init()
	{
		$this->_fields += array(
			'id' => new Sprig_Field_Auto,
			'name' => new Sprig_Field_Char(),
		);
	}	
	
}