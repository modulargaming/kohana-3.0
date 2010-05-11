<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Curtis Delicata
 * @copyright  (c) 2010 Curtis Delicata
 * @license    http://modulargaming.com/license
 */

class Modulargaming_Controller_Pet extends Controller_Frontend {
	
	
	public $protected = TRUE;
	public $load_pet = TRUE;
	public $title = 'Pet';
	public $heal_cost = 2;
	public $train_cost = 2;
	public $skills = array('strength','defence','agility');
	
	public function action_index()
	{
		// Check if the user has a pet already.
		if ( !$this->pet->loaded() )
			$this->request->redirect( 'pet/create' );
		
		$this->request->redirect( 'dashboard' );
		
	}
	
	public function action_heal()
	{
		// Check if the user has a pet already.
		if ( !$this->pet->loaded() )
			$this->request->redirect( 'pet/create' );
		
		$pet = $this->pet;
		
		// Initialize the pet class, and set the players pet as the default.
		$user_pet = new Pet( $pet );
		
		$post = Validate::factory($_POST)
			->filter(TRUE,'trim')
			->rule( 'amount', 'not_empty' )
			->rule( 'amount', 'digit' )
			->callback( 'amount', array( $this, 'can_heal' ));
		
		if ($post->check())
		{
			
			try
			{
				
				$pet->hp = $pet->hp + $post['amount'];
				$pet->money = $pet->money - ( $post['amount'] * $this->heal_cost );
				
				$pet->save();
				$this->request->redirect( 'pet' );
				
				
			}
			catch (Validate_Exception $e)
			{
				
				// Get the errors using the Validate::errors() method
				$this->errors = $e->array->errors('register');
			}
			
		}
		else
		{
			$this->errors = $post->errors('pet/create');
		}
		
		if ( !empty($this->errors) )
			Message::set( Message::ERROR, $this->errors );
		
		$this->template->content = View::factory('pet/heal')
			->set( 'pet', $pet )
			->set( 'user_pet', $user_pet )
			->set( 'post', $post );
		
	}

	public function action_train($skill = NULL)
	{

		// Check if the user has a pet already.
		if ( !$this->pet->loaded() )
			$this->request->redirect( 'pet/create' );
		
		$pet = $this->pet;
		
		// Initialize the pet class, and set the players pet as the default.
		$user_pet = new Pet( $pet );
		

		if ($skill != NULL)

		{

		if (!in_array($skill, $this->skills))
		{
		                Message::set( Message::ERROR, 'Invalid skill' );
				$this->request->redirect('pet/train' );

		}

		if ($pet->energy < $this->train_cost)
		{
		                Message::set( Message::ERROR, 'Not enough energy' );
				$this->request->redirect('pet/train' );

		}

		else
		{

			
			try
			{
				$pet->$skill = $pet->$skill+1;
				$pet->energy = $pet->energy - $this->train_cost;
				
				$pet->save();
//				$this->request->redirect( 'pet/train' );
				
				
			}
			catch (Validate_Exception $e)
			{
				
				// Get the errors using the Validate::errors() method
				$this->errors = $e->array->errors('register');
			}
			
		}

}		
		if ( !empty($this->errors) )
			Message::set( Message::ERROR, $this->errors );
		
		$this->template->content = View::factory('pet/train')
			->set( 'pet', $pet )
			->set( 'user_pet', $user_pet )
			->set( 'skills', $this->skills );
		
	}
	
	public function action_create()
	{
		
		// Check if the user has a pet already.
		if ( $this->pet->loaded() )
			$this->request->redirect( 'pet/create' );
				
		$pet = Jelly::factory('pet');
		
		$post = Validate::factory($_POST)
			->filter(TRUE,'trim')
			->rule('name', 'not_empty')
			->rule('name', 'min_length', array(3))
			->rule('name', 'max_length', array(20))
			->rule('gender', 'not_empty')
			->rule('race', 'not_empty')
			->rule('colour', 'not_empty')
			->callback('colour', array($this, 'valid_colour'))
			->callback('race', array($this, 'valid_race'));
		
		if ($post->check())
		{
			
			try
			{
				
				$values = array(
					'name' => $post['name'],
					'gender' => $post['gender'],
					'race' => $post['race'],
					'colour' => $post['colour'],
					'user' => $this->user->id,
					'money' => 1000,
					'hp' => 100,
					'max_hp' => 100,
					'strength' => 10,
					'defence' => 10,
					'agility' => 10,
					'level' => 1,
					'xp' => 0,
					'max_xp' => 100,
					'energy' => 100,
					'max_energy' => 100,
					'alignment' => 5000,
					'zone' => 1,
				);
				
				$pet->set($values);
				
				$pet->save();
				
				$this->MG->add_history( 'Created the pet: ' . $post['name'] );
				
				$this->request->redirect( 'pet' );
				
			}
			catch (Validate_Exception $e)
			{
				
				// Get the errors using the Validate::errors() method
				$this->errors = $e->array->errors('register');
			}
			
		}
		else
		{
			$this->errors = $post->errors('pet/create');
		}
		
		// Get the races the user can choose from.
		$races = $this->getRaces();

		$colours = $this->getColours();
		
		$this->template->content = View::factory('pet/create')
			->set( 'post', $post )
			->set( 'races', $races )
			->set( 'colours', $colours );

	}
	
	// Function to verify if it is a valid race and that the player can use it.
	function valid_race( $form, $field )
	{
		
		$race = Jelly::select( 'pet_race' )
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
		$races = Jelly::select( 'pet_race' )->execute();
		
		$t = array();
		
		foreach ($races as $v)
		{
			$t[$v->id] = $v->name;
		}
		
		return $t;
	}
	
	// Function to verify if it is a valid colour and that the player can use it.
	function valid_colour( $form, $field )
	{
		
		$colour = Jelly::select( 'pet_colour' )
			->where( 'id', '=', $form[$field] )
			->load();
		
		if ( $colour->loaded() )
		{
			return true;
		}
		
		$form->error($field, 'colour_not_valid');

	}
	
	// Retrieve all races from the database and assign them to an array
	function getColours()
	{
		$colours = Jelly::select( 'pet_colour' )->execute();
		
		$t = array();
		
		foreach ($colours as $v)
		{
			$t[$v->id] = $v->name;
		}
		
		return $t;
	}
	
	
	function can_heal( $form, $field )
	{
		
		$amount = $form[$field];
		
		if ( $amount * $this->heal_cost > $this->pet->money )
			$form->error($field, 'not_enough_money');
		
		if ( $amount >= ( $this->pet->max_hp - $this->pet->hp ) )
			$form[$field] = $this->pet->max_hp - $this->pet->hp;
		
	}

	function can_train( $form, $field )
	{
		
		$amount = $form[$field];
		
		if ( $amount * $this->heal_cost > $this->pet->energy )
			$form->error($field, 'not_enough_energy');
		
	}
	
} // End pet
