<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Model for the NPC's messages.
 *
 * @package    Modular Gaming
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://copy112.com/mg/license
 */


class Model_Npc extends Jelly_Model {
	
	public static function initialize(Jelly_Meta $meta)
	{
		
		$meta->fields += array(
			'id' => new Field_Primary,
			'zone' => new Field_BelongsTo,
			'name' => new Field_String,
			
			'message' => new Field_Text,
		
			'zone_id' => new Field_Integer,
		
			'messages' => new Field_HasMany(array(
				'column'  => 'npc_message',
				'foreign' => 'npc_message.npc_id',
			)),
		);
		
	}
	
}