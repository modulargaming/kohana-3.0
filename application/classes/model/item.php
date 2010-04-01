<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://copy112.com/mg/license
 */


class Model_Item extends Jelly_Model {
	
	
	public static function initialize(Jelly_Meta $meta)
	{
		
		$meta->fields += array(
			'id' => new Field_Primary,
			'name' => new Field_String,
			'class' => new Field_String,
			
			'image' => new Field_String(array(
				'directory' => 'assets/images/monsters/',
			)),
			
			'description' => new Field_Text,
		);
		
	}
	
}
