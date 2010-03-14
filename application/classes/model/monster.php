<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2010 Copy112
 * @license    http://copy112.com/mg/license
 */

class Model_Monster extends Jelly_Model {
	
	public static function initialize(Jelly_Meta $meta)
	{
		
		$meta->fields += array(
			'id' => new Field_Primary,
			'name' => new Field_String,
			'max_hp'  => new Field_Integer(),
			'defence' => new Field_integer(),
			
			'min_dmg' => new Field_Integer(),
			'max_dmg' => new Field_Integer(),
			'money'   => new Field_Integer(),
			'xp'      => new Field_Integer(),
			
			'image'   => new Field_String(array(
				'path' => 'assets/images/monsters/',
			)),
			
		);
		
	}

}