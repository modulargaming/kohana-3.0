<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Controller for providing the base of backend controllers.
 *
 * @package    Modular Gaming
 * @subpackage Core
 * @author     Oscar Hinton
 * @copyright  (c) 2010 Oscar Hinton
 * @license    http://www.modulargaming.com/license
 */

abstract class Modulargaming_Controller_Backend extends Controller_Base {
	
	public $template = 'admin/template';
	
	public $errors = array();
	
	public $protected = TRUE; // Require user to login.
	
	public function before()
	{
		
		parent::before();
		
		Asset::add('assets/css/admin.css', 'css');
		
		Asset::add('assets/js/jquery.js', 'js'); // jQuery
		Asset::add('assets/js/jquery-ui.js', 'js'); // jQuery UI
		Asset::add('assets/js/jquery.scrollTo.js', 'js'); // jQuery scrollTo
		Asset::add('assets/js/jquery.localscroll.js', 'js'); // jQuery localscroll
		Asset::add('assets/js/jquery.validate.js', 'js'); // Form Validation
		Asset::add('assets/js/admin/main.js', 'js');
		
		
		$this->template->latest_version = $this->latest_version();
		$this->template->news = $this->get_news();
		
		/*
		if ($this->auto_render === TRUE && !Request::$is_ajax )
		{
			
			// Load the template
			$this->template = View::factory($this->template)
				->bind('js',  $this->js)
				->bind('css', $this->css)
				->set('latest_version', $this->latest_version())
				->set('news', $this->get_news());
			
			$this->template->errors = array();
		}*/
		
	}
	
	/**
	 * Compare the current version with the latest avaible.
	 */
	public function latest_version()
	{
		
		$latest = Kohana::cache('mg_latest_version');
		
		// If we can't retrive it from cache, grab it from the url defined in Modulargaming class.
		if ( ! $latest)
		{
			$latest = Remote::get(Modulargaming::VERSION_URL);
			
			// Cache it.
			Kohana::cache('mg_latest_version', $latest, Modulargaming::VERSION_CACHE_TIME);
		}
		
		// Return the latest avaible version.
		return $latest;
		
	}
	
	/**
	 * Grab news from Modular gaming site.
	 */
	public function get_news()
	{
		
		$news = Kohana::cache('mg_news');
		
		// If we can't retrive it from cache, grab it from modulargaming.com
		if ( ! $news)
		{
			$news = Feed::parse('http://modulargaming.com/rss.xml', 2);
			
			// Cache it.
			Kohana::cache('mg_news', $news, Modulargaming::VERSION_CACHE_TIME);
		}
		
		return $news;
		
	}
	
} // End Backend
