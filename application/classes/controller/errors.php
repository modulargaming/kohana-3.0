<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2009 Copy112
 * @license    http://copy112.com/mg/license
 */

class Controller_Errors extends Controller_Frontend {

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
