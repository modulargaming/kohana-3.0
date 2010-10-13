<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Curtis Delicata
 * @copyright  (c) 2010 Curtis Delicata
 * @license    BSD - http://www.modulargaming.com/license
 */

class Model_Group extends Jelly_Model {
	
	public static function initialize(Jelly_Meta $meta)
	{
		

		$meta->fields += array(
			'id' => new Field_Primary,
			
			'name' => new Field_String,
			'description' => new Field_String,
			'status' => new Field_String,

			'user' => new Field_BelongsTo,
			
			'created' => new Field_Timestamp(array(

				'empty'  => TRUE,

				'auto_now_create' => true,

			)),
			
                );

        }

}

