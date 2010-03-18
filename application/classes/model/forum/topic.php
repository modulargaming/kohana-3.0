<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2010 Copy112
 * @license    http://copy112.com/mg/license
 */

class Model_Forum_Topic extends Jelly_Model {
	
	public static function initialize(Jelly_Meta $meta)
	{
		
		// $meta->load_with = array('forum_posts');
		
		$meta->fields += array(
			'id' => new Field_Primary,
			'user' => new Field_BelongsTo,
			
			'group_id' => new Field_BelongsTo,
			
			'title' => new Field_String,
			'content' => new Field_String,

			'created' => new Field_Integer,
			'posts' => new Field_Integer,
			
			
			'locked' => new Field_Enum(array(
				'choices' => array('Y' => 'Y', 'Y' => 'Y'),
			)),
			
		);
	}
