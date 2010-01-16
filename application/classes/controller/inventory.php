<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Lewis Delicata
 * @copyright  (c) 2010 Lewis Delicata
 * @license    http://modulargaming.com/projects/modulargaming/wiki/License
 */

class Controller_Inventory extends Controller_Frontend {
	public $protected = TRUE;
	public $title = 'Inventory';
	public function action_index()
	{
		$inventory = $this->user->inventory->as_array();
		$pag_data = array
		(
		'current_page' => array('source' => 'route', 'key' => 'id'),
		'total_items' => count($inventory),
		'items_per_page' => 20,
		);
		$pagination = Pagination::factory($pag_data)->render();
		$this->template->content = View::factory('inventory/index')
		->set( 'inventory', $inventory )
		->set( 'pagination', $pagination );
	}
} // End Inventory
