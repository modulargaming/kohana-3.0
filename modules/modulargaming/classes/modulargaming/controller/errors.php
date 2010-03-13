<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Untold Nation
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    May not be used without full permission from the Author (Oscar Hinton).
 */

class Modulargaming_Controller_Errors extends Controller_Frontend {

	public $title = 'Error';

	public function action_index()
	{
		$this->template->content = View::factory('index');
	}
	
	public function action_404()
	{
		$this->request->status = 404;
		$this->template->content = View::factory('errors/404');
	}

} // End Errors
