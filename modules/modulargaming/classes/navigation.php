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
		
		$data = Jelly::select('navigation')
			->where('group', '=', $group)
			->execute();
		
		
		return View::factory($view)
			->set('data', $data);
		
	}
	
}