<?php defined('SYSPATH') or die('No direct script access.');

class Form extends Kohana_Form {
	
	/**
	 * Creates a form label.
	 * 
	 * @param   string  target input
	 * @param   string  label text
	 * @param   array   html attributes
	 * @return  string
	 */
	public static function label($input, $text = NULL, array $attributes = NULL)
	{
		if ($text === NULL)
		{
			// Use the input name as the text
			$text = ucwords(str_replace('_', ' ', $input));
		}
		
		// Translate the string
		$text = __($text);
		
		// Set the label target
		$attributes['for'] = $input;

		return '<label'.HTML::attributes($attributes).'>'.$text.'</label>';
	}
	
	/**
	 * Creates a submit form input.
	 *
	 * @param   string  input name
	 * @param   string  input value
	 * @param   array   html attributes
	 * @return  string
	 */
	public static function submit($name, $value, array $attributes = NULL)
	{
		$attributes['type'] = 'submit';
		
		$value = __($value);
		
		return Form::input($name, $value, $attributes);
	}
	
}
