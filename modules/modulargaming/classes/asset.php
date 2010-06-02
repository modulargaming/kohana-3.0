<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Class for adding and rendering assets.
 *
 * @package    Modular Gaming
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://www.modulargaming.com/license
 */
class Asset {
	
	protected static $data = array();
	
	/**
	 * Add the path into the type's array to later be loaded
	 * @param  string  $path
	 * @param  string  $type
	 * @return boolean
	 */
	public static function add($path, $type)
	{
		
		if ( ! isset(self::$data[$type]))
		{
			self::$data[$type] = array();
		}
		elseif (in_array($path, self::$data[$type], TRUE))
		{
			// The file is alredy added
			return FALSE;
		}
		
		self::$data[$type][] = $path;
		
		return TRUE;
	}
	
	/**
	 * Render the array of paths
	 * @param  string $type
	 * @return string
	 */
	public static function render($type)
	{
		
		$html = '';
		
		if ( ! isset(self::$data[$type]))
			return false;
		
		foreach (self::$data[$type] as $v)
		{
			if ($type == 'css') {
				$html .= html::style($v);
			} elseif ($type == 'js') {
				$html .= html::script($v);
			}
		}
		
		return $html;
		
	}
}