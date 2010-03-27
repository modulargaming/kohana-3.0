<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Untold Nation
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    May not be used without full permission from the Author (Oscar Hinton).
 */

class Modulargaming_Controller_PM extends Controller_Frontend {

	public $title = 'PM';

	public function before()
	{
		parent::before();
		
		$this->sidebar = View::factory('pm/sidebar');
		
	}
	
	public function action_index()
	{
		$this->template->content = View::factory('pm/index')
			->set( 'sidebar', $this->sidebar );
	}
	
	public function action_new()
	{
		
		$this->template->content = View::factory('pm/new')
			->set( 'sidebar', $this->sidebar );
		
	}

} // End PM
