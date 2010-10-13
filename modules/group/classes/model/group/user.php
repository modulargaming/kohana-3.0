<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Curtis Delicata
 * @copyright  (c) 2010 Curtis Delicata
 * @license    BSD - http://www.modulargaming.com/license
 */

class Model_Group_User extends Jelly_Model {
	
	public static function initialize(Jelly_Meta $meta)
	{
		

		$meta->fields += array(
			'id' => new Field_Primary,

                        'group' => new Field_BelongsTo(array(
                                'column'  => 'group_id',
                                'foreign' => 'group.id',
                        )),

                        'user' => new Field_BelongsTo(array(
                                'column'  => 'user_id',
                                'foreign' => 'users.id',
                        )),

			
                );
}

}

