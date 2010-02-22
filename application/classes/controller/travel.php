<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2010 Copy112
 * @license    http://copy112.com/mg/license
 */

class Controller_Travel extends Controller_Frontend {
	
	public $protected = true;
	public $title = 'Travel';

	public function action_index()
	{
		
		$zones = Sprig::factory( 'zone' )->load( NULL, NULL );
		
		$this->template->content = View::factory('travel/index')
			->set( 'zones', $zones );
	}
	
	
	public function action_view( $id )
	{
		
		if ( !is_numeric( $id ) ) {
			die('Error, not integer');
		}
		
		$zone = Sprig::factory( 'zone', array( 'id' => $id ) )->load();
		
		$this->template->content = View::factory('travel/view')
			->set( 'zone', $zone );
		
	}
	
	public function action_travel( $id )
	{
		
		if ( !is_numeric( $id ) ) {
			die('Error, not integer');
		}
		
		$zone = Sprig::factory( 'zone', array( 'id' => $id ) )->load();
	
		
		$character = $this->user->character;
		
		$character->load();
		
		// Make sure the character got enough of engery
		if ( $character->energy < $zone->energy )
			die( 'need more energy' );
		
		// Set the new zone, and energy
		$character->zone = $zone->id;
		$character->energy = $character->energy - $zone->energy;
		$character->update();
		
		$this->request->redirect( 'character' );
		
	}

} // End Travel