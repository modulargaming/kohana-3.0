<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://modulargaming.com/license
 */

class Modulargaming_Model_Battle extends Jelly_Model {
	
	
	public static function initialize(Jelly_Meta $meta)
	{
		
		$meta->fields += array(
			'id' => new Field_Primary,
			'character' => new Field_BelongsTo,
			'monster' => new Field_BelongsTo,
			
			'hp' => new Field_Integer,
		);
		
	}
	
}
