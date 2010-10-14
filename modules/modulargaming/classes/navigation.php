<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Class for rendering navigations.
 *
 * @package    Modular Gaming
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://www.modulargaming.com/license
 */
class Navigation {
	
	protected static $data = array();
	
	/**
	 * 
	 * @param $type
	 * @return string
	 */
	public static function render($group, $view)
	{
		
		

// Logged out navigation

if ($group == 0){

$data = Kohana::cache('navigation_logged_out');

if ( ! $data)
                {

		
		$data = Jelly::select('navigation')
			->where('group', '=', $group)
			->execute();
		

                        // Cache it.
                        Kohana::cache('navigation_logged_out', $data, 3600);
                }

}

// Logged in navigation

if ($group == 1){

$data = Kohana::cache('navigation_logged_in');

if ( ! $data)
                {

		
		$data = Jelly::select('navigation')
			->where('group', '=', $group)
			->execute();
		

                        // Cache it.
                        Kohana::cache('navigation_logged_in', $data, 3600);
                }

}

// Admin navigation

if ($group == 2){

$data = Kohana::cache('navigation_admin');

if ( ! $data)
                {

		
		$data = Jelly::select('navigation')
			->where('group', '=', $group)
			->execute();
		

                        // Cache it.
                        Kohana::cache('navigation_admin', $data, 3600);
                }

}


		
		return View::factory($view)
			->set('data', $data);
		
	}
	
}
