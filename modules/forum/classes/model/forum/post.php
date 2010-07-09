<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Curtis Delicata
 * @copyright  (c) 2010 Curtis Delicata
 * @license    BSD - http://www.modulargaming.com/license
 */

class Model_Forum_Post extends Jelly_AACL {
	
	public static function initialize(Jelly_Meta $meta)
	{
		
		$meta->load_with = array('user');		
		
		$meta->fields += array(
			'id' => new Field_Primary,
			'topic' => new Field_BelongsTo(array(
				'column'  => 'topic_id',
				'foreign' => 'forum_topic.id',
			)),
			'user' => new Field_BelongsTo,
			'title' => new Field_String,
			'content' => new Field_String,
			'created' => new Field_Timestamp(array(
				'empty'  => TRUE,
				'auto_now_create' => true,
			)),			
		);
			
	}
	
	public function acl_conditions(Model_User $user = NULL, $condition = NULL)
	{
	    if (is_null($user) OR is_null($condition))
		{
			// Return condition definition(s)
			// Here we only have one condition but we could have many
			return array(
				'is_author' => 'user is post author',
			);
		}
		else
		{
			// Condition logic goes here. Complex condition logic could be implemented in another method and called here.
			switch ($condition)
			{
				case 'is_author':
					// Return TRUE if the post author matches the passed user id
					return ($this->user->id === $user->id);

				default:
					// Condition doesn't exist therefore fails
					return FALSE;
			}
		}
	}

}
