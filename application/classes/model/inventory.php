<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
<<<<<<< HEAD
 * @author     Lewis Delicata
 * @copyright  (c) 2010 Lewis Delicata
 * @license    http://modulargaming.com/projects/modulargaming/wiki/License
=======
 * @author     Lewis
 * @copyright  (c) 2010 Lewis
 * @license    BSD
>>>>>>> cf9e2217b11a817628b6deedf923d26ceaa3847c
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
