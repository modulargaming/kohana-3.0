<?php defined('SYSPATH') or die('No direct script access.');

/**

 * 

 *

 * @package    Modular Gaming

 * @author     Lewis

 * @copyright  (c) 2010 Lewis

 * @license    BSD

 */


class Model_Inventory extends Sprig {

	protected $_table='user_items';

	protected function _init()

	{

		$this->_fields += array(

			'id' => new Sprig_Field_Auto,

			'item_id' => new Sprig_Field_Integer(),

			'user_id' => new Sprig_Field_Integer(),

			'amount' => new Sprig_Field_Integer(),

		);

	}	

	

}

?>
