<?php
/**
 * Enqueue
 *
 * @package odango
 * @author  yosiakatsuki
 * @license GPL-2.0+
 */

namespace ooo;

defined( 'ABSPATH' ) || die();

class Enqueue {
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
	}

	/**
	 * Enqueue Styles.
	 *
	 * @return void
	 */
	public function enqueue_styles() {
		wp_enqueue_style(
			'-ooo--base',
			get_template_directory_uri() . '/assets/css/odango.css',
			[],
			filemtime( get_template_directory() . '/assets/css/odango.css' )
		);
		wp_style_add_data(
			'-ooo--base',
			'path',
			get_template_directory() . '/assets/css/odango.css'
		);
		wp_enqueue_style(
			'-ooo--style',
			get_stylesheet_uri(),
			[],
			filemtime( get_theme_file_path( 'style.css' ) )
		);
		wp_style_add_data(
			'-ooo--style',
			'path',
			get_theme_file_path( 'style.css' )
		);
	}

	/**
	 * Enqueue scripts.
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_enqueue_script(
			'-ooo--scripts',
			get_template_directory_uri() . '/assets/js/odango.js',
			[],
			filemtime( get_template_directory() . '/assets/js/odango.js' )
		);
	}
}

new Enqueue();
