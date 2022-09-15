<?php
/**
 * Blocks
 *
 * @package odango
 * @author  yosiakatsuki
 * @license GPL-2.0+
 */

namespace ooo;

use ooo\helper\Path;

defined( 'ABSPATH' ) || die();

class Blocks {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'register_block_styles' ] );
		add_action( 'init', [ $this, 'register_block_patterns' ], 9 );
		add_action( 'after_setup_theme', [ $this, 'enqueue_theme_block_styles' ] );
	}

	/**
	 * Enqueue Block Styles
	 *
	 * @return void
	 */
	public function enqueue_theme_block_styles() {

		$this->enqueue_block_styles(
			get_template_directory() . '/assets/css/core-blocks',
			'core'
		);
		// 子テーマも検索.
		if ( is_child_theme() ) {
			$this->enqueue_block_styles(
				get_stylesheet_directory() . '/assets/css/core-blocks',
				'core',
				true
			);
		}
	}


	private function enqueue_block_styles( $dir, $namespace, $is_child = false ) {
		foreach ( glob( "${dir}/*", GLOB_ONLYDIR ) as $dir_path ) {
			$block_name     = $namespace . '/' . basename( $dir_path );
			$theme_css_path = $dir_path . '/' . basename( $dir_path ) . '.css';
			wp_enqueue_block_style(
				$block_name,
				[
					'handle' => "odango-$block_name",
					'src'    => Path::replace_template_path_to_uri( $theme_css_path, $is_child ),
					'path'   => $theme_css_path,
				]
			);
		}
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
			[ 'label' => esc_html__( 'Images', 'odango' ) ]
		);
	}
}

new Blocks();
