<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Curtis Delicata
 * @copyright  (c) 2010 Curtis Delicata
 * @license    http://www.modulargaming.com/license
 */

class Modulargaming_Pet {
	
	protected $pet;
	
	protected $max_alignment = '9999';
	
	public function __construct( $pet = NULL )
	{
		$this->pet = $pet;
	}
	
	public function get_races()
	{
		
		$races = Jelly::select( 'pet_race' )
			->execute( );
		
		return $races;
		
	}

	public function get_colours()
	{
		
		$colours = Jelly::select( 'pet_colour' )
			->execute( );
		
		return $colours;
		
	}


	public function get_alignments()
	{
		
		$alignments = Jelly::select( 'alignment' )
			->execute( );
		
		return $alignments;
		
	}
	
	
	public function percent_alignment( $ali )
	{
		return round( $ali / 100 );
	}
	
	public function alignment( $ali = NULL )
	{
		if ( !isset ( $ali ) )
			$ali = $this->pet->alignment;
			
		if ( !is_numeric( $ali ) )
			die( 'Not numeric' );
		
		$ali = $this->percent_alignment( $ali );
		
		foreach ( $this->get_alignments() as $k => $v )
		{
			
				if ( $ali >= $v->min && $ali <= $v->max )
				return $v->name;
				
		}
		
		return $ali;
		
	}
	
	public function max_hp( $pet )
	{
		
	}
	
	public function percent_hp( $hp = NULL, $maxhp = NULL ) {
		
		if ( !isset ( $hp ) )
			$hp = $this->pet->hp;
		
		if ( !isset ( $maxhp ) )
			$maxhp = $this->pet->max_hp;
		
		return round( ( $hp / $maxhp ) * 100 );
		
	}

	public function percent_energy( $energy = NULL, $maxenergy = NULL ) {
		
		if ( !isset ( $energy ) )
			$energy = $this->pet->energy;
		
		if ( !isset ( $maxenergy ) )
			$maxenergy = $this->pet->max_energy;
		
		return round( ( $energy / $maxenergy ) * 100 );
		
	}

	public function percent_xp( $xp = NULL, $maxxp = NULL ) {
		
		if ( !isset ( $xp ) )
			$xp = $this->pet->xp;
		
		if ( !isset ( $maxxp ) )
			$maxxp = $this->pet->max_xp;
		
		return round( ( $xp / $maxxp ) * 100 );
		
	}
	
}
