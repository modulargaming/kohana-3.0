<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Curtis Delicata
 * @copyright  (c) 2010 Curtis Delicata
 * @license    BSD - http://www.modulargaming.com/projects/modulargaming/wiki/License
 */

class Model_Forum_Topic extends Jelly_Model {
	
	public static function initialize(Jelly_Meta $meta)
	{
		
		// $meta->load_with = array('forum_posts');
		
		$meta->fields += array(
			'id' => new Field_Primary,
			'group_id' => new Field_BelongsTo,
			
			'title' => new Field_String,
			'content' => new Field_String,
			'status' => new Field_String,

			'created' => new Field_Integer,
			'posts' => new Field_Integer,
			
			))
		);
	}
}
