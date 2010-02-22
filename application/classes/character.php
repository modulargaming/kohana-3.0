<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    Modular Gaming
 * @author     Copy112
 * @copyright  (c) 2010 Copy112
 * @license    http://copy112.com/mg/license
 */

class Character {
	
	protected $char;
	
	protected $max_alignment = '9999';
	
	public function __construct( $char = NULL )
	{
		$this->char = $char;
	}
	
	
	public function get_alignments()
	{
		
		$alignments = Sprig::factory( 'alignment' )->load(  NULL, NULL );
		
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
			
			if ( $ali <= $v->min && $ali >= $v->max )
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
	
}