<?php defined('SYSPATH') or die('No direct script access.');

class Form extends Kohana_Form {
	
	/**
	 * Generates an opening HTML form tag.
	 *
	 * @param   string  form action
	 * @param   array   html attributes
	 * @return  string
	 */
	public static function open($action = NULL, array $attributes = NULL)
	{
		if ($action === NULL)
		{
			// Use the current URI
			$action = Request::instance()->uri;
		}

		if ($action === '')
		{
			// Use only the base URI
			$action = Kohana::$base_url;
		}
		elseif (strpos($action, '://') === FALSE)
		{
			// Make the URI absolute
			$action = URL::site($action);
		}

		// Add the form action to the attributes
		$attributes['action'] = $action;

		// Only accept the default character set
		$attributes['accept-charset'] = Kohana::$charset;

		if ( ! isset($attributes['method']))
		{
			// Use POST method
			$attributes['method'] = 'post';
		}
		
		// CRSF Protection
		$token = '<input type="hidden" name="_token" value="" />';

		return '<form'.HTML::attributes($attributes).'>'.$token;
	}
	
	
}
