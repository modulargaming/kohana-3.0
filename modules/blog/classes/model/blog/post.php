<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2009 Copy112
 * @license    http://copy112.com/mg/license
 */

class Model_Blog_Post extends Sprig {
	
	protected function _init()
	{
		$this->_fields += array(
			'id' => new Sprig_Field_Auto,
			'title' => new Sprig_Field_Char(),
			'content' => new Sprig_Field_Text(),
			'created_on' => new Sprig_Field_Timestamp(array(
				'format'          => 'F jS',
				'auto_now_create' => TRUE,
			)),
			'author' => new Sprig_Field_BelongsTo(array(
                'model'  => 'User',
				'column' => 'author',
			)),
		);
	}

} // End Blog_Post