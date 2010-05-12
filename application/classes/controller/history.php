<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Curtis Delicata
 * @copyright  (c) 2010 Curtis Delicata
 * @license    http://modulargaming.com/license
 */

class Controller_History extends Controller_Frontend {

        public $title = 'History';
        public $protected = TRUE;

        public function action_index()
{

                // Load the users history, limit with 10
                $history = Jelly::select( 'user_history' )
                        ->where(':primary_key', '=', $this->user->id)
                        ->limit( 25 )
                        ->execute();

                $this->template->content = View::factory('history/index')
                        ->set('history', $history);

}
}
