<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2009 Copy112
 * @license    http://copy112.com/mg/license
 */

class Model_User_History extends Jelly_Model {
	
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->sorting = array('time' => 'desc');
		$meta->primary_key = 'user_id';
		$meta->fields( array(
			'user' => new Field_BelongsTo(array(
				'column' => 'user_id',
			)),
			'time' => new Field_Timestamp(array(
				'empty'  => TRUE,
				'auto_now_create' => true,
			)),
			'history' => new Field_String,
		));
	}
	
}