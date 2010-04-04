<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2010 Copy112
 * @license    http://copy112.com/mg/license
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
			'time' => new Field_Timestamp(array(
				'empty'  => TRUE,
				'auto_now_create' => true,
				'pretty_format' => 'Y-m-d H:i',
			)),
		);
		
	}
	
}
