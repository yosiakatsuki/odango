<?php
/**
 * Load
 *
 * @package odango
 * @author  yosiakatsuki
 * @license GPL-2.0+
 */

namespace ooo;

defined( 'ABSPATH' ) || die();

class Init {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'after_setup_theme', [ $this, 'setup' ] );
	}

	/**
	 * Setup Theme.
	 *
	 * @return void
	 */
	public function setup() {
		add_theme_support( 'wp-block-styles' );
		add_editor_style( './assets/css/odango-editor.css' );
	}
}

new Init();
