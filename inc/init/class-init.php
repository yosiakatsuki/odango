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
		add_action( 'body_class', [ $this, 'add_theme_name' ] );
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

	public function add_theme_name( $classes ) {
		$classes[] = 'odango';

		if ( is_child_theme() ) {
			$classes[] = get_stylesheet();
		}

		return $classes;
	}
}

new Init();
