<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://www.modulargaming.com/license
 */


class Modulargaming_Model_Navigation extends Jelly_Model {
	
	
	public static function initialize(Jelly_Meta $meta)
	{
		
		$meta->sorting = array('position' => 'ASC');
		$meta->fields += array(
			'id' => new Field_Primary,
			'group' => new Field_BelongsTo(array(
				//'column'  => 'to',
				//'foreign' => 'user.id',
			)),
			'position' => new Field_Integer,
			'title' => new Field_String,
			'slug' => new Field_String,
		);
		
	}
	
}
