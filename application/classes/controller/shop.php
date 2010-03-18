<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2010 Copy112
 * @license    http://copy112.com/mg/license
 */

class Controller_Shop extends Controller_Frontend {
	
	public $protected = TRUE;
	public $load_character = TRUE;
	public $require_character = TRUE;
	
	public function before()
	{
		
		parent::before();
		
		$this->add_js('assets/js/shop.js');
		
		// Assign the shop id to $shop_id
		$this->shop_id = Request::instance()->param('shop');
		
		// Make sure it's a interger and not empty
		if ( !is_numeric( $this->shop_id ) || $this->shop_id == '' ) {
			die('Error, not integer');
		}
		
		// Retrive the shop with matching id
		$this->shop = Jelly::select( 'shop' )
			->where( 'id', '=', $this->shop_id )
			->load();
		
	}
	
	public function action_index( )
	{
		
		// Set the title of the page to the shop's name
		$this->title = $this->shop->name;
		
		
		$items = Model_Shop::get_items( $this->shop->id );
		
		$this->template->content = View::factory( 'shop/index' )
			->set( 'shop', $this->shop )
			->set( 'items', $items );
		
	}
	
	public function action_view( $id2, $id )
	{
		
		if ( !is_numeric( $id ) ) {
			die('Error, not integer');
		}
		
		$item = Model_Shop::get_one_item( $this->shop->id, $id );
		
		$this->title = $item->name;
		
		$this->item = $item;
		
		$post = Validate::factory($_POST)
			->filter(TRUE,'trim')
			->rule( 'amount', 'digit' )
			->callback('amount', array($this, 'shop_got_item'));
		
		
		if ($post->check())
		{
			
			 $item2 = Model_User::get_item( $this->user->id, $id );
			 
			// User got the item in his relation table.
			if ( $item2 ) {
			 	
				DB::update('user_items')
					->set( array( 'amount' => new Database_Expression( 'amount + '  . $post['amount'] ) ) )
					->where('user_id', '=', $this->user->id)
					->and_where( 'item_id', '=', $id )
					->execute();
			
			}
			else
			{
				
				DB::insert( 'user_items', array( 'user_id', 'item_id', 'amount') )
					->values( array( $this->user->id, $id, $post['amount'] ) )
					->execute();
			}
			
			
			DB::update('shop_items')
				->set( array( 'amount' => new Database_Expression( 'amount - '  . $post['amount'] ) ) )
				->where('shop_id', '=', $this->shop_id)
				->and_where( 'item_id', '=', $id )
				->execute();
			
			$item->amount = $item->amount - $post['amount'];
			
			Message::set( Message::SUCCESS, 'You bought ' . $post['amount'] . ' ' . $item->name );
			
		}
		else
		{
			if ( $post->errors() )
				Message::set( Message::ERROR, $post->errors('shop') );
		}	
		
		$this->template->content = View::factory( 'shop/view' )
			->set( 'shop', $this->shop )
			->set( 'item', $item );
		
	}
	
	
	public function shop_got_item( Validate $array, $field )
	{
		
		$amount = $array[$field];
		$cost = $this->item->price * $amount;
		
		// Check if shop got enought items
		if ( $this->item->amount < $amount ){
			$array->error($field, 'not_enought');
			return false;
		}
		
		// Check if user can afford it
		if ( $this->character->money < $cost ){
			$array->error($field, 'expensive');
			return false;
		}
		
	}

	
}