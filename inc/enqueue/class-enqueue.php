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
	}

	/**
	 * Enqueue Styles.
	 *
	 * @return void
	 */
	public function enqueue_styles() {
		wp_enqueue_style(
			'ooo-style',
			get_stylesheet_uri(),
			[],
			ODANGO_VERSION
		);
	}
}

new Enqueue();
