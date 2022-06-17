<?php
/**
 * Blocks
 *
 * @package odango
 * @author  yosiakatsuki
 * @license GPL-2.0+
 */

namespace ooo;

defined( 'ABSPATH' ) || die();

class Blocks {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'register_block_styles' ] );
		add_action( 'init', [ $this, 'register_block_patterns' ], 9 );
		add_action( 'after_setup_theme', [ $this, 'enqueue_block_style' ] );
	}

	/**
	 * Enqueue Block Styles
	 *
	 * @return void
	 */
	public function enqueue_block_style() {
//	$styled_blocks = [ 'button', 'file', 'latest-comments', 'latest-posts', 'quote', 'search' ];
//	foreach ( $styled_blocks as $block_name ) {
//		$args = array(
//			'handle' => "odango-$block_name",
//			'src'    => get_theme_file_uri( "assets/css/blocks/$block_name.min.css" ),
//			'path'   => get_theme_file_path( "assets/css/blocks/$block_name.min.css" ),
//		);
//		// Replace the "core" prefix if you are styling blocks from plugins.
//		wp_enqueue_block_style( "core/$block_name", $args );
//	}
	}

	/**
	 * ブロックのスタイル追加
	 *
	 * @return void
	 */
	public function register_block_styles() {
		register_block_style( // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.editor_blocks_register_block_style
			'core/template-part',
			[
				'name'  => 'odango-sticky',
				'label' => __( 'Sticky header', 'odango' ),
			]
		);
	}

	public function register_block_patterns() {
		/**
		 * Register an example block pattern category.
		 */
		register_block_pattern_category(
			'images',
			array( 'label' => esc_html__( 'Images', 'odango' ) )
		);
	}
}

new Blocks();
