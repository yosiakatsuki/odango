<?php
/**
 * Functions and definitions
 *
 * @package odango
 */
defined( 'ABSPATH' ) || die();

/**
 * The theme version.
 *
 * @since 1.0.0
 */
define( 'ODANGO_VERSION', wp_get_theme()->get( 'Version' ) );

/**
 * Enqueue the CSS files.
 *
 * @since 1.0.0
 *
 * @return void
 */
function odango_styles() {

}
add_action( 'wp_enqueue_scripts', 'odango_styles' );


require_once __DIR__ . '/inc/load.php';
