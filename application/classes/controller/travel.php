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
		
		if ( !is_numeric( $id ) )
		{

		        Message::set( Message::ERROR, 'Invalid ID' );
                        $this->request->redirect('travel');
		}
		
		if ( $id == $this->character->zone->id ) {
			Message::set( Message::ERROR, 'You cannot move to where you already are.' );
                        $this->request->redirect('travel');
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
		if ( !is_numeric( $id ) ) 

		{

                        Message::set( Message::ERROR, 'Invalid ID' );
                        $this->request->redirect('travel');
		}
		
		if ( $id == $this->character->zone->id )
		{
			Message::set( Message::ERROR, 'You cannot move to where you already are.' );
                        $this->request->redirect('travel');
		}
		
		// Load the zone
		$zone = Jelly::select('zone')
			->where( 'id', '=', $id )
			->load();
	
		
		$character = $this->character;
		
		// Make sure the character got enough of engery
		if ( $character->energy < $zone->energy )
				{
                        	Message::set( Message::ERROR, 'Not enough energy.' );
                        	$this->request->redirect('travel');
	
				}
		
		// Set the new zone, and energy
		$character->zone = $zone->id;
		$character->energy = $character->energy - $zone->energy;
		$character->save();
		
		$this->request->redirect( 'character' );
		
	}

} // End Travel
