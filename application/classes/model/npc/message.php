<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://copy112.com/mg/license
 */


class Model_Npc_Message extends Jelly_Model {
	
	public static function initialize(Jelly_Meta $meta)
	{
		
		$meta->fields += array(
			'id' => new Field_Primary,
			'npc' => new Field_BelongsTo,
			'title' => new Field_String,
			'message' => new Field_Text,
		);
		
	}
	
}