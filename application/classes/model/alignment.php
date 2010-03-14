<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2010 Copy112
 * @license    http://copy112.com/mg/license
 */

class Model_Alignment extends Jelly_Model {
	
	protected function _init()
	{
		$this->_fields += array(
			'id' => new Sprig_Field_Auto,
			'name' => new Sprig_Field_Char(),
			'min' => new Sprig_Field_Integer(),
			'max' => new Sprig_Field_Integer(),
		);
	}
	
	public static function initialize(Jelly_Meta $meta)
	{
		
		$meta->fields += array(
			'id' => new Field_Primary,
			'name' => new Field_String,
			'min' => new Field_Integer,
			'max' => new Field_Integer,
		);
		
	}
	
}