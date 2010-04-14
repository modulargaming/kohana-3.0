<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://www.modulargaming.com/license
 */


class Modulargaming_Model_Message extends Jelly_Model {
	
	
	public static function initialize(Jelly_Meta $meta)
	{
		
		// Auto load the user who sent it (from)
		$meta->load_with = array('from');
		
		$meta->fields += array(
			'id' => new Field_Primary,
			'to' => new Field_BelongsTo(array(
				'column'  => 'to',
				'foreign' => 'user.id',
			)),
			'from' => new Field_BelongsTo(array(
				'column'  => 'from',
				'foreign' => 'user.id',
			)),
			'status' => new Field_String,
			'title' => new Field_String,
			'message' => new Field_Text,
			'created' => new Field_Timestamp(array(
				'empty'  => TRUE,
				'auto_now_create' => true,
				'pretty_format' => 'Y-m-d H:i',
			)),
			
			'to_status' => new Field_String(array(
				'default' => 'new',
			)),
			'from_status' => new Field_String(array(
				'default' => 'read',
			)),
		);
		
	}
	
}
