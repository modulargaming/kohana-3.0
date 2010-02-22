<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2010 Copy112
 * @license    http://copy112.com/mg/license
 */

class Controller_Welcome extends Controller_Frontend {
	
	public $title = 'Welcome';
	
	public function action_index()
	{
		
		if ( $this->user ) {
			$this->request->redirect( 'dashboard' );
		}
		
		$this->template->content = View::factory('index');
	}

} // End Welcome
