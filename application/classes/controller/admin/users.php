<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://copy112.com/mg/license
 */

class Controller_Admin_Users extends Controller_Backend {
	
	public $title = 'Admin - Users';
	private $users_per_page = 10;

	public function before()
	{
		//$this->request->action = 'index';
		parent::before();
	}
	
	
	public function action_index($page = 1)
	{
		// Check if the user got permission to view all users
		if ( !$this->a2->allowed('admin', 'users_view'))
			$this->request->redirect('');
		
		// Make sure page is numeric, if not it might be a hacking attempt
		if ( ! is_numeric($page))
			die( 'Not numeric' );
		
		// Count the ammount of users
		$t_users = Jelly::select('user')->count();
		
		// Get the offset based on page and the ammount of users we display.
		$offset = ($page-1) * $this->users_per_page;
		
		// Load the users
		$users = Jelly::select('user')
			->offset($offset)
			->limit($this->users_per_page)
			->execute();
		
		$pag_data = array
		(
			'current_page'   => array('source' => 'route', 'key' => 'id'),
			'total_items'    => $t_users,
			'items_per_page' => $this->users_per_page,
		);
		$pagination = Pagination::factory($pag_data)->render();
		
		$this->template->content = View::factory('admin/users/index')
			->set('t_users', $t_users)
			->set('users', $users)
			->set('pagination', $pagination);
		
	}
	
	public function action_add()
	{
		// Check if the user got permission to add new users
		if ( !$this->a2->allowed( 'admin', 'users_add' ) )
			$this->request->redirect('');		
		
		$sprig = Sprig::factory('user');
		
		// Check if we have a post request
		$post = Validate::factory($_POST)
			->filter(TRUE, 'trim')
			->rules('username', $sprig->field('username')->rules)
			->rules('email', $sprig->field('email')->rules)
			->rule('password', 'min_length', array(6))
			->rule('password', 'max_length', array(20))
			->rule('password_confirm', 'matches', array('password'))
			->rule('role', 'not_empty');
		
		$this->errors = array();
		
		if ( $post->check() )
		{
			
			// Assign the validated data to the sprig object
			$sprig->values( $post->as_array());
			
			// Hash the password
			$sprig->password = $this->a1->hash_password( $post['password'] );
			try
			{
				// Create the new user
				$sprig->create();
				
				// Redirect the user to the login page
				$this->request->redirect( 'admin/users' );
			}
			catch (Validate_Exception $e)
			{
				// Get the errors using the Validate::errors() method
				$this->errors = $e->array->errors('register');
			}
			
		}
		else
		{
			$this->errors = $post->errors('register');
		}
		
		$t = Kohana::config('a2');
		$t = $t['roles'];
		
		$roles = array();
		
		foreach ( $t as $k => $v ){
			$roles[$k] = $k;
		}
		
		$this->template->content = View::factory('admin/users/add')
			->set( 'errors', $this->errors     )
			->set( 'post',   $post->as_array() )
			->set( 'roles',  $roles            );
			
	}
	
	public function action_edit( $id = '' )
	{
		// Check if the user got permission to edit users
		if ( !$this->a2->allowed( 'admin', 'users_edit' ) )
			$this->request->redirect( '' );
		
		if ( !is_numeric( $id ) ) {
			die('Error, not integer');
		}
		
		$sprig = Sprig::factory( 'user', array( 'id' => $id ) )->load();
		
		// Check if no post request was made, and load the user
		if ( $_POST == array() )
		{
			$post = $sprig;
		}
		else
		{
			
			// Check if we have a post request
			$post = Validate::factory( $_POST )
				->filter( TRUE, 'trim' )
				->rules( 'username',         $sprig->field('username')->rules )
				->rules( 'email',            $sprig->field('email')->rules    )
				->rule ( 'password',         'max_length', array( 20 )        )
				->rule ( 'password_confirm', 'matches', array('password')     )
				->rule ( 'role',             'not_empty'                      );
			
			$this->errors = array();
			
			if ( $post->check() )
			{
				
				// Assign the validated data to the sprig object
				$sprig->values( $post->as_array());
				
				// Hash the password
				if ( $post['password'] != '' )
				{
					$sprig->password = $this->a1->hash_password( $post['password'] );
				}
				
				try
				{
					// Create the new user
					$sprig->update();
					
					// Redirect the user to the login page
					$this->request->redirect( 'admin/users' );
				}
				catch (Validate_Exception $e)
				{
					// Get the errors using the Validate::errors() method
					$this->errors = $e->array->errors('register');
				}
				
			}
			else
			{
				$this->errors = $post->errors('register');
			}
			
		}
		
		$t = Kohana::config('a2');
		$t = $t['roles'];
		
		$roles = array();
		
		foreach ( $t as $k => $v ){
			$roles[$k] = $k;
		}
		
		$this->template->content = View::factory('admin/users/edit')
			//->set( 'errors', $this->errors     )
			->set( 'post',   $post->as_array() )
			->set( 'roles',  $roles            );
		
	}
	
	public function action_delete( $id = '' )
	{
		
		
		
	}

} // End Admin_Users
