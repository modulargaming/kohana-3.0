<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2009 Copy112
 * @license    http://copy112.com/mg/license
 */

class Controller_Character extends Controller_Frontend {
	
	
	public $protected = TRUE;
	public $title = 'Character';
	public $heal_cost = 2;
	
	
	public function action_index()
	{
		// Load the character
		$this->user->character->load();
		
		// Check if the user has a character already.
		if ( !$this->user->character->loaded() )
			$this->request->redirect( 'character/create' );
		
		$character = $this->user->character;
		
		// Initialize the character class, and set the players character as the default.
		$char = new Character( $character );
		
		$this->template->content = View::factory('character/index')
			->set( 'character', $character )
			->set( 'char', $char );
		
	}
	
	public function action_heal()
	{
		// Load the character
		$this->user->character->load();
		
		// Check if the user has a character already.
		if ( !$this->user->character->loaded() )
			$this->request->redirect( 'character/create' );
		
		$character = $this->user->character;
		
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
				
				$character->update();
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
		
		$this->template->content = View::factory('character/heal')
			->set( 'character', $character )
			->set( 'char', $char )
			->set( 'post', $post );
		
	}
	
	public function action_create()
	{
		// Load the character
		$this->user->character->load();
		
		// Check if the user has a character already.
		if ( $this->user->character->loaded() )
			$this->request->redirect( 'character/create' );
				
		$sprig = Sprig::factory('character');
		$post = Validate::factory($_POST)
			->filter(TRUE,'trim')
			->rules( 'name',     $sprig->field('name')->rules )
			->rules( 'gender',   $sprig->field('gender')->rules )
			->callback( 'race', array( $this, 'valid_race' ));
		
		if ($post->check())
		{
			
			try
			{
				
				$sprig->values( $post->as_array() );
				$sprig->user = $this->user->id;
				
				// Default starting money
				$sprig->money = 1000;
				$sprig->hp = 100;
				$sprig->max_hp = 100;
				
				$sprig->level = 1;
				$sprig->strength = 10;
				$sprig->alignment = 5000;
				
				$sprig->create();
				
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
		
		$race = Sprig::factory( 'race', array( 'id' => $form[$field] ) )->load();
		
		if ( $race->loaded() )
		{
			return true;
		}
		
		$form->error($field, 'race_not_valid');

	}
	
	// Retrieve all races from the database and assign them to an array
	function getRaces()
	{
		$races = Sprig::factory( 'race' )->load(NULL, NULL);
		
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
		
		if ( $ammount * $this->heal_cost >= $this->user->character->money )
			$form->error($field, 'not_enought_money');
		
		if ( $ammount >= ( $this->user->character->max_hp - $this->user->character->hp ) )
			$form[$field] = $this->user->character->max_hp - $this->user->character->hp;
		
	}
	
} // End Character
