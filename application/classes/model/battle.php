<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2010 Copy112
 * @license    http://copy112.com/mg/license
 */

class Model_Battle extends Sprig {
	
	protected function _init()
	{
		$this->_fields += array(
			'id' => new Sprig_Field_Auto,
			'character' => new Sprig_Field_BelongsTo(array(
                'model' => 'Character',
			)),
			'monster' => new Sprig_Field_BelongsTo(array(
                'model' => 'Monster',
			)),
			
			'hp' => new Sprig_Field_Integer(array(
				'empty'  => TRUE,
				'rules' => array(
				 	'numeric' => array(),
				 )
			)),
			
		);
	}	
	
}