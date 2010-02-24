<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2010 Copy112
 * @license    http://copy112.com/mg/license
 */

class Controller_Inventory extends Controller_Frontend {
	
	public $protected = TRUE;
	public $title = 'Inventory';
	
	public function action_index()
	{
		$items = Model_User::get_items( $this->user->id );
		
		$this->template->content = View::factory( 'inventory/index' )
			->set( 'items', $items );
		
	}
	
	public function action_view()
	{
		
		
		
	}
	
} // End Inventory