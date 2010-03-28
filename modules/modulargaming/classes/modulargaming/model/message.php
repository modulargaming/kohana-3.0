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
		
		$meta->fields += array(
			'id' => new Field_Primary,
			'to' => new Field_BelongsTo('to',array(
				'model' => 'user',
			)),
			'from' => new Field_BelongsTo('from',array(
				'model' => 'user',
			)),
			'status' => new Field_String,
			'title' => new Field_String,
			'message' => new Field_Text,
		);
		
	}
	
}