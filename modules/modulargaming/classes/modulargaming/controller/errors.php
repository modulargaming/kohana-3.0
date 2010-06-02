<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @category   Controllers
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://www.modulargaming.com/license
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
