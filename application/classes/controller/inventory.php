<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Lewis
 * @copyright  (c) 2010 Lewis
 * @license    BSD
 */

class Controller_Inventory extends Controller_Frontend {
	public $protected = TRUE;
	// Retrieve all races from the database and assign them to an array
	public function action_index()
	{
		$items = $this->getItems();
		$inventory = $this->getUserItems();
		$this->template->content = View::factory('inventory/index')
		->set( 'inventory', $inventory )
		->set( 'items', $items );
	}

	function getUserItems()
	{
		$items = Sprig::factory('inventory', array('user_id' => $this->user->id))
		 ->load(NULL, NULL);
		$t = array();
  		$i=1;
		foreach ($items as $v)
		{
			$t[$i]['item_id'] = $v->item_id;
			$t[$i]['amount'] = $v->amount;
			$i++;
		}
 
		return $t;
	}
	function getItems()
	{
		$items = Sprig::factory( 'item' )->load(NULL, NULL);
 
		$t = array();
		foreach ($items as $v)
		{
			$t[$v->id]['name'] = $v->name;
			$t[$v->id]['class'] = $v->class;
			$t[$v->id]['image'] = $v->image;
			$t[$v->id]['description'] = $v->description;
		}
 
		return $t;
	}
} // End Inventory