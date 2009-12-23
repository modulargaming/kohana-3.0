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
	public $heal_cost = 2;
	
	
	public function action_index()
	{
		// Check if the user haven't got a character.
		if ( !$this->user->character->name )
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
		// Check if the user haven't got a character.
		if ( !$this->user->character->name )
			$this->request->redirect( 'character/create' );
		
		$character = $this->user->character;
		
		// Initialize the character class, and set the players character as the default.
		$char = new Character( $character );
		
		$post = Validate::factory($_POST)
			->filter(TRUE,'trim')
			->rule( 'ammount', 'not_empty' )
			->rule( 'ammount', 'digit' )
			->callback( 'ammount', array( $this, 'can_heal' ));
		
		if ($post->check())
		{
			
			try
			{
				
				$character->hp = $character->hp + $post['ammount'];
				$character->money = $character->money - ( $post['ammount'] * $this->heal_cost );
				
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
		// Check if the user alredy got a character
		if ( $this->user->character->name )
			$this->request->redirect( 'character' );
		
		
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
		
		// Get the races the user can chose from.
		$races = $this->getRaces();
		
		$this->template->content = View::factory('character/create')
			->set( 'post', $post )
			->set( 'races', $races );
	}
	
	// Function to verify if its a valid race and the player can use it.
	function valid_race( $form, $field )
	{
		
		$race = Sprig::factory( 'race', array( 'id' => $form[$field] ) )->load();
		
		if ( $race->loaded() )
		{
			return true;
		}
		
		$form->error($field, 'race_not_valid');

	}
	
	// Retrive all races from the database, and assign them to an array
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
		
		if ( $ammount >= ( $this->user->character->maxhp - $this->user->character->hp ) )
			$form[$field] = $this->user->character->maxhp - $this->user->character->hp;
		
	}
	
}