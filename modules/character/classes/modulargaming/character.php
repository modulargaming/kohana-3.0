<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://www.modulargaming.com/license
 */

class Modulargaming_Character {
	
	protected $char;
	
	protected $max_alignment = '9999';
	
	public function __construct( $char = NULL )
	{
		$this->char = $char;
	}
	
	public function get_classes()
	{
		
		$alignments = Jelly::select( 'character_class' )
			->execute( );
		
		return $classes;
		
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
			$ali = $this->char->alignment;
			
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
	
	public function max_hp( $char )
	{
		
	}
	
	public function percent_hp( $hp = NULL, $maxhp = NULL ) {
		
		if ( !isset ( $hp ) )
			$hp = $this->char->hp;
		
		if ( !isset ( $maxhp ) )
			$maxhp = $this->char->max_hp;
		
		return round( ( $hp / $maxhp ) * 100 );
		
	}

	public function percent_energy( $energy = NULL, $maxenergy = NULL ) {
		
		if ( !isset ( $energy ) )
			$energy = $this->char->energy;
		
		if ( !isset ( $maxenergy ) )
			$maxenergy = $this->char->max_energy;
		
		return round( ( $energy / $maxenergy ) * 100 );
		
	}
	
}
