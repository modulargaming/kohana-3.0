<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2009 Copy112
 * @license    http://copy112.com/mg/license
 */

class Controller_Admin_Welcome extends Controller_Backend {

	public function action_index()
	{
		$this->template->content = View::factory('admin/index');
	}

} // End Welcome