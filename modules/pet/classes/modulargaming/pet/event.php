<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Class to hook into events.
 *
 * @package    Modular Gaming
 * @author     Curtis Delicata
 * @copyright  (c) 2010 Curtis Delicata
 * @license    http://www.modulargaming.com/license
 */

class Modulargaming_Pet_Event {
	
	/**
	 * Hook into before function.
	 */
	public static function before()
	{
		$t = Event::$data;
		
		// If load_pet is set and is TRUE, load the pet
		if (isset($t->load_pet) AND $t->load_pet) {
			Pet_Event::load_pet($t);
		}
		
		// If pet is loaded, and pet is required, make sure we got a pet.
		if (isset($t->load_pet) AND $t->load_pet AND isset($t->require_pet) AND $t->require_pet )
		{
			if ( ! $t->pet->loaded())
			{
				Request::instance()->redirect('pet/create');
			}
		}
	}
	
	/**
	 * Loads a pet, and assigns it to a variable.
	 * @param $t
	 */
	public static function load_pet($t)
	{
		if ($t->user && ! isset($t->pet))
		{
			$t->pet = Jelly::select('pet')
				->where('user', '=', $t->user->id)
				->load();
		}
	}
	
	
	/**
	 * Hook into the dasboard display system, and assign the pet stats view.
	 */
	public static function dashboard()
	{
		$t = Event::$data;
	
		Pet_Event::load_pet($t);
	
		$t->left[] = View::factory('pet/dashboard/status')
			->set('user_pet', $t->pet)
			->set('pet', new Pet($t->pet));

		$t->sidebar_left[] = View::factory('pet/dashboard/sidebar');
	}
	

	public static function sidebar_right()
	{
		$s = Event::$data;
		
		if ( ! $s->user)
		{
			return false;
		}

		Pet_Event::load_pet($s);
		
		$s->sidebar_right[] = View::factory('pet/sidebar')
				->set('user_pet', $s->pet)
				->set('pet', new Pet($s->pet));


	}
}
