<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @subpackage Core
 * @author     Curtis Delicata
 * @copyright  (c) 2010 Curtis Delicata
 * @license    http://www.modulargaming.com/license
 */

class Modulargaming_Controller_Profile extends Controller_Frontend {

	public $title = 'Profile';
	public $protected = true;

	/**
	 * Display the users profile.
	 */
	public function action_view($id)
	{
		
		$profile = Jelly::select('user')
			->where('id', '=', $id)
			->load();
		
                if ($profile->loaded())
                {
                        $this->title = 'Profile - '.$profile->username;
			$this->template->content = View::factory('profile/index')
			->set('profile', $profile);

                }
                else
                {
                        Message::set(Message::ERROR, 'Username does not exist');
			$this->template->content = View::factory('profile/error');

                }


	}
	

} // End Profile
