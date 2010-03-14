<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2009 Copy112
 * @license    http://copy112.com/mg/license
 */

class Model_User_Facebook extends Jelly_Model {
	
	public static function initialize(Jelly_Meta $meta)
	{
		
		$meta->table = 'user_facebook';
		$meta->load_with = array('user');
		
		$meta->fields( array(
			'facebook_id' => new Field_Primary,
			'user'        => new Field_BelongsTo,
		));
		
	}
	
}