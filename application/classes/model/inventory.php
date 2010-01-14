<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Lewis Delicata
 * @copyright  (c) 2010 Lewis Delicata
 * @license    http://modulargaming.com/projects/modulargaming/wiki/License
 */
class Model_Inventory extends Sprig {
	protected $_table='user_items';
	protected function _init()
	{
		$this->_fields += array(
			'id' => new Sprig_Field_Auto,
			'item_id' => new Sprig_Field_BelongsTo(array(
                'model' => 'Item',
			)),
			'user_id' => new Sprig_Field_BelongsTo(array(
                'model' => 'User',
			)),
			'amount' => new Sprig_Field_Integer(),
		);
	}	
}
?>
