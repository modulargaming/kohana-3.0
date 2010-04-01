<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://copy112.com/mg/license
 */

class Controller_Travel extends Controller_Frontend {
	
	public $protected = TRUE;
	public $load_character = TRUE;
	public $require_character = TRUE;
	
	public $title = 'Travel';
	
	/**
	 * Finds all zones and displays them throught a view.
	 */
	public function action_index()
	{
		
		$zones = Jelly::select('zone')
			->where( 'id', '!=', $this->character->zone->id )
			->execute();
		
		$this->template->content = View::factory('travel/index')
			->set( 'zones', $zones );
	}
	
	/**
	 * Displays detailed info about a specified zone
	 * 
	 * @param  integer  $id
	 */
	public function action_view( $id )
	{
		
		if ( !is_numeric( $id ) ) {
			die('Error, not integer');
		}
		
		if ( $id == $this->character->zone->id ) {
			die( 'You can\'t move to the same zone as you currently is in');
		}
		
		$zone = Jelly::select('zone')
			->where( 'id', '=', $id )
			->load();
		
		$this->template->content = View::factory('travel/view')
			->set( 'zone', $zone );
		
	}
	
	/**
	 * Moves the character to a new zone
	 * 
	 * @param  integer  $id
	 */
	public function action_travel( $id )
	{
		
		// Make sure id is an integer.
		if ( !is_numeric( $id ) ) {
			die('Error, not integer');
		}
		
		if ( $id == $this->character->zone->id ) {
			die( 'You can\'t move to the same zone as you currently is in');
		}
		
		// Load the zone
		$zone = Jelly::select('zone')
			->where( 'id', '=', $id )
			->load();
	
		
		$character = $this->character;
		
		// Make sure the character got enough of engery
		if ( $character->energy < $zone->energy )
			die( 'need more energy' );
		
		// Set the new zone, and energy
		$character->zone = $zone->id;
		$character->energy = $character->energy - $zone->energy;
		$character->save();
		
		$this->request->redirect( 'character' );
		
	}

} // End Travel