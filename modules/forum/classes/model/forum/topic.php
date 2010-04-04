<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Curtis Delicata
 * @copyright  (c) 2010 Curtis Delicata
 * @license    BSD - http://www.modulargaming.com/license
 */

class Model_Forum_Topic extends Jelly_Model {
	
	public static function initialize(Jelly_Meta $meta)
	{
		

		$meta->fields += array(
			'id' => new Field_Primary,
			'category' => new Field_BelongsTo(array(
				'column'  => 'category_id',
				'foreign' => 'forum_category.id',
			)),
			
			'title' => new Field_String,
			'status' => new Field_String,

			'user' => new Field_BelongsTo,
			
			'created' => new Field_Timestamp(array(

				'empty'  => TRUE,

				'auto_now_create' => true,

			)),
			'posts' => new Field_Integer,
			
                );

        }

}

