<?php defined('SYSPATH') OR die('No direct access allowed.');

Event::add('before', 'message_before');

function message_before()
{
	//echo Event::$data->title;
	//echo "hi";
}


