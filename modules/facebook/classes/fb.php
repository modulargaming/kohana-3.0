<?php
require_once( Kohana::find_file('vendor', 'facebook/facebook'));

class Fb extends Facebook {

	protected $config;

	/**
	 * Create new Facebook client
	 *
	 * @param  bool  $generate_session_secret
	 */
	public function __construct() {
		
		// Load config
		 $this->config = Kohana::config('facebook');

		 // Init Facebook client
		parent::__construct( $this->config['api_key'], $this->config['secret']);

	}


}
