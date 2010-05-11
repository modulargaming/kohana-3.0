<?php defined('SYSPATH') or die('No direct script access.');

//-- Environment setup --------------------------------------------------------

/**
 * Set the default time zone.
 *
 * @see  http://docs.kohanaphp.com/about.configuration
 * @see  http://php.net/timezones
 */
date_default_timezone_set('Europe/London');

/**
 * Set the default locale.
 *
 * @see  http://docs.kohanaphp.com/about.configuration
 * @see  http://php.net/setlocale
 */
setlocale(LC_ALL, 'en_GB.utf-8');

/**
 * Set the environment mode.
 */
Kohana::$environment = Kohana::DEVELOPMENT;
//Kohana::$environment = Kohana::PRODUCTION;

/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://docs.kohanaphp.com/about.autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @see  http://php.net/spl_autoload_call
 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

//-- Configuration and initialization -----------------------------------------

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */
Kohana::init(array(
	'base_url' => dirname($_SERVER['SCRIPT_NAME']),
	'index_file' => '',
	'profiling' => Kohana::$environment == Kohana::DEVELOPMENT OR Kohana::$environment == Kohana::TESTING,
	'caching' => Kohana::$environment != Kohana::DEVELOPMENT AND Kohana::$environment == Kohana::TESTING,
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Kohana_Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Kohana_Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	
	// Modular Gaming modules
	'forum' => MODPATH.'forum', // Offical forum module
	'message' => MODPATH.'message', // Official messages module
	'character' => MODPATH.'character', // Official character module
	'pet' => MODPATH.'pet', // Official pet module
	
	'modulargaming' => MODPATH.'modulargaming', // Modular Gaming core
	
	// Event system
	'event' => MODPATH.'event',
	
	// Database
	'jelly'    => MODPATH.'jelly', // Jelly ORM
	'database' => MODPATH.'database', // Database access
	
	// Auth
	'a1'    => MODPATH.'A1',
	'a2'    => MODPATH.'A2',
	'acl'   => MODPATH.'ACL',
	
	// Misc modules
	'pagination' => MODPATH.'pagination', // Paging of results
	'captcha'    => MODPATH.'captcha',
	'image'      => MODPATH.'image',
));

/**
 * Setup the database config driver.
 */
Kohana::$config->attach(new Kohana_Config_Database, FALSE);

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */

Route::set('admin', 'admin(/<controller>(/<action>(/<id>)))')
	->defaults(array(
		'directory'  => 'admin',
		'controller' => 'welcome',
		'action'     => 'index',
	));
	
Route::set('shop', 'shop(/<shop>(/<action>(/<item>)))')
	->defaults(array(
		'controller' => 'shop',
		'action'     => 'index',
	));

Route::set('npc', 'npc(/<npc>(/<action>(/<method>)))')
	->defaults(array(
		'controller' => 'npc',
		'action'     => 'index',
	));

Route::set('default', '(<controller>(/<action>(/<id>)))')
	->defaults(array(
		'controller' => 'welcome',
		'action'     => 'index',
	));

/**
 * Execute the main request. A source of the URI can be passed, eg: $_SERVER['PATH_INFO'].
 * If no source is specified, the URI will be automatically detected.
 */
$request = Request::instance();

try
{
	// Attempt to execute the response
	$request->execute();
}
catch (Exception $e)
{
	
	if (Kohana::$environment == Kohana::DEVELOPMENT)
	{
		throw $e;
	}
	
	// Log the error
	Kohana::$log->add(Kohana::ERROR, Kohana::exception_text($e));
	
	$request = Request::factory('errors/404')->execute();

}

/**
* Display the request response.
*/
echo $request->send_headers()->response;
