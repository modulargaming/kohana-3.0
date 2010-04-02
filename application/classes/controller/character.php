<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://copy112.com/mg/license
 */

class Controller_Character extends Controller_Frontend {
	
	
	public $protected = TRUE;
	public $load_character = TRUE;
	public $title = 'Character';
	public $heal_cost = 2;
	
	
	public function action_index()
	{
		// Check if the user has a character already.
		if ( !$this->character->loaded() )
			$this->request->redirect( 'character/create' );
		
		$this->request->redirect( 'dashboard' );
		
	}
	
	public function action_heal()
	{
		// Check if the user has a character already.
		if ( !$this->character->loaded() )
			$this->request->redirect( 'character/create' );
		
		$character = $this->character;
		
		// Initialize the character class, and set the players character as the default.
		$char = new Character( $character );
		
		$post = Validate::factory($_POST)
			->filter(TRUE,'trim')
			->rule( 'amount', 'not_empty' )
			->rule( 'amount', 'digit' )
			->callback( 'amount', array( $this, 'can_heal' ));
		
		if ($post->check())
		{
			
			try
			{
				
				$character->hp = $character->hp + $post['amount'];
				$character->money = $character->money - ( $post['amount'] * $this->heal_cost );
				
				$character->save();
				$this->request->redirect( 'character' );
				
				
			}
			catch (Validate_Exception $e)
			{
				
				// Get the errors using the Validate::errors() method
				$this->errors = $e->array->errors('register');
			}
			
		}
		else
		{
			$this->errors = $post->errors('character/create');
		}
		
		if ( !empty($this->errors) )
			Message::set( Message::ERROR, $this->errors );
		
		$this->template->content = View::factory('character/heal')
			->set( 'character', $character )
			->set( 'char', $char )
			->set( 'post', $post );
		
	}
	
	public function action_create()
	{
		
		// Check if the user has a character already.
		if ( $this->character->loaded() )
			$this->request->redirect( 'character/create' );
				
		$character = Jelly::factory('character');
		$post = Validate::factory($_POST)
			->filter(TRUE,'trim')
			->rule('name', 'not_empty')
			->rule('name', 'min_length', array(3))
			->rule('name', 'max_length', array(20))
			->rule('gender', 'not_empty')
			->rule('race', 'not_empty')
			->callback('race', array($this, 'valid_race'));
		
		if ($post->check())
		{
			
			try
			{
				
				$values = array(
					'name' => $post['name'],
					'gender' => $post['gender'],
					'race' => $post['race'],
					'user' => $this->user->id,
					'money' => 1000,
					'hp' => 100,
					'max_hp' => 100,
					'level' => 1,
					'xp' => 0,
					'energy' => 100,
					'alignment' => 5000,
					'zone' => 1,
				);
				
				$character->save();
				
				$this->MG->add_history( 'Created the character: ' . $post['name'] );
				
				$this->request->redirect( 'character' );
				
			}
			catch (Validate_Exception $e)
			{
				
				// Get the errors using the Validate::errors() method
				$this->errors = $e->array->errors('register');
			}
			
		}
		else
		{
			$this->errors = $post->errors('character/create');
		}
		
		// Get the races the user can choose from.
		$races = $this->getRaces();
		
		$this->template->content = View::factory('character/create')
			->set( 'post', $post )
			->set( 'races', $races );
	}
	
	// Function to verify if it is a valid race and that the player can use it.
	function valid_race( $form, $field )
	{
		
		$race = Jelly::select( 'race' )
			->where( 'id', '=', $form[$field] )
			->load();
		
		if ( $race->loaded() )
		{
			return true;
		}
		
		$form->error($field, 'race_not_valid');

	}
	
	// Retrieve all races from the database and assign them to an array
	function getRaces()
	{
		$races = Jelly::select( 'race' )->execute();
		
		$t = array();
		
		foreach ($races as $v)
		{
			$t[$v->id] = $v->name;
		}
		
		return $t;
	}
	
	
	function can_heal( $form, $field )
	{
		
		$ammount = $form[$field];
		
		if ( $ammount * $this->heal_cost > $this->character->money )
			$form->error($field, 'not_enought_money');
		
		if ( $ammount >= ( $this->character->max_hp - $this->character->hp ) )
			$form[$field] = $this->character->max_hp - $this->character->hp;
		
	}
	
} // End Character
