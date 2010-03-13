<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Lewis & Copy112
 * @copyright  (c) 2010 Lewis & Copy112
 * @license    http://copy112.com/mg/license
 */


class Model_Item extends Jelly_Model {
	
	
	public static function initialize(Jelly_Meta $meta)
	{
		
		$meta->fields += array(
			'id' => new Field_Primary,
			'name' => new Field_String,
			'description' => new Field_Text,
		);
		
	}
	
	protected function _init()
	{
		$this->_fields += array(
			'id'    => new Sprig_Field_Auto,
			'name'  => new Sprig_Field_Char(),
			'class' => new Sprig_Field_Char(),
			'image' => new Sprig_Field_Image(array(
				'directory' => 'assets/images/monsters/',
			)),
			'description' => new Sprig_Field_Char(),
		);
	}	
	
}
