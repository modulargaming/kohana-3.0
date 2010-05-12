<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Class to hook into events.
 *
 * @package    Modular Gaming
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://www.modulargaming.com/license
 */

class Modulargaming_Character_Event {
	
	/**
	 * Hook into before function.
	 */
	public static function before()
	{
		$t = Event::$data;
		
		// If load_character is set and is TRUE, load the character
		if (isset($t->load_character) AND $t->load_character) {
			Character_Event::load_character($t);
		}
		
		// If character is loaded, and character is required, make sure we got a character.
		if (isset($t->load_character) AND $t->load_character AND isset($t->require_character) AND $t->require_character )
		{
			if ( ! $t->character->loaded())
			{
				Request::instance()->redirect('character/create');
			}
		}
	}
	
	/**
	 * Loads a character, and assigns it to a variable.
	 * @param $t
	 */
	public static function load_character($t)
	{
		if ($t->user && ! isset($t->character))
		{
			$t->character = Jelly::select('character')
				->where('user', '=', $t->user->id)
				->load();
		}
	}
	
	
	/**
	 * Hook into the dasboard display system, and assign the character stats view.
	 */
	public static function dashboard()
	{
		$t = Event::$data;
	
		Character_Event::load_character($t);
	
		$t->left = View::factory('character/dashboard/status')
			->set('character', $t->character)
			->set('char', new Character($t->character));

		$t->sidebar_left[] = View::factory('character/dashboard/sidebar');

	}
	

	public static function sidebar_right()
	{
		$s = Event::$data;
		
		if ( ! $s->user)
		{
			return false;
		}

		Character_Event::load_character($s);
		
		$s->sidebar_right[] = View::factory('character/sidebar')
				->set('character', $s->character)
				->set('char', new Character($s->character));


	}
}
