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

	const BLOCK_CATEGORY = 'ooo';
	const BLOCK_CATEGORY_LAYOUT = 'oooLayout';
	const BLOCK_CATEGORY_TEMPLATE = 'oooTemplate';

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'register_block_styles' ] );
		add_action( 'init', [ $this, 'register_block_patterns' ], 9 );
		add_action( 'init', [ $this, 'register_blocks' ] );
		add_action( 'after_setup_theme', [ $this, 'enqueue_theme_block_styles' ] );
		add_filter( 'block_categories_all', [ $this, 'add_block_categories' ] );
		add_filter( 'block_type_metadata', [ $this, 'block_type_metadata' ] );
		add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_block_editor_assets' ], 11 );
	}

	/**
	 * ブロック登録.
	 *
	 * @return void
	 */
	public function register_blocks() {
		// Odangoブロック.
		$this->register_block_types( get_template_directory() . '/build/blocks/library' );
		// フックで追加.
		$blocks_dir_path = apply_filters( 'ooo_block_blocks_dir_path', [] );
		// 子テーマ.
		if ( is_child_theme() ) {
			$blocks_dir_path[] = get_stylesheet_directory() . '/build/blocks/library';
		}
		if ( is_array( $blocks_dir_path ) && ! empty( $blocks_dir_path ) ) {
			$blocks_dir_path = array_values( array_unique( $blocks_dir_path ) );
			foreach ( $blocks_dir_path as $path ) {
				$this->register_block_types( $path );
			}
		}
	}

	public function register_block_types( $blocks_dir_path ) {
		if ( ! file_exists( $blocks_dir_path ) ) {
			return;
		}
		foreach ( glob( "${blocks_dir_path}/*", GLOB_ONLYDIR ) as $dir_path ) {
			$args       = [];
			$block_name = basename( $dir_path );
			$file       = $dir_path . '/index.php';
			if ( file_exists( $file ) ) {
				require $file;
			}
			// Dynamic Block.
			$dynamic_block_file_name = 'class-render-' . $block_name;
			$dynamic_block_file_path = $dir_path . '/' . $dynamic_block_file_name . '.php';
			if ( file_exists( $dynamic_block_file_path ) ) {
				require $dynamic_block_file_path;
				$args['render_callback'] = apply_filters(
					'ooo_block_dynamic_block_render_callback__' . strtolower( $block_name ),
					'\ooo\Render_' . ucfirst( strtolower( $block_name ) ) . '::render',
				);
			}
			// Register Block.
			register_block_type( $dir_path, $args );
		}
	}

	/**
	 * 子テーマ利用時のScript,CSS読み込み調整
	 *
	 * @param array $metadata Meta Data.
	 *
	 * @return array
	 */
	public function block_type_metadata( $metadata ) {
		// odango 利用であれば調整の必要なし.
		if ( ! is_child_theme() ) {
			return $metadata;
		}
		if ( ! isset( $metadata['name'] ) || empty( $metadata['name'] ) ) {
			return $metadata;
		}
		if ( 0 !== strpos( $metadata['name'], 'ooo/' ) ) {
			return $metadata;
		}

		if ( ! empty( $metadata['editorScript'] ) ) {
			$metadata['editorScript'] = Block_Registry::register_block_script_handle(
				$metadata,
				'editorScript'
			);
		}

		if ( ! empty( $metadata['script'] ) ) {
			$metadata['script'] = Block_Registry::register_block_script_handle(
				$metadata,
				'script'
			);
		}

		if ( ! empty( $metadata['viewScript'] ) ) {
			$metadata['viewScript'] = Block_Registry::register_block_script_handle(
				$metadata,
				'viewScript'
			);
		}

		if ( ! empty( $metadata['editorStyle'] ) ) {
			$metadata['editorStyle'] = Block_Registry::register_block_style_handle(
				$metadata,
				'editorStyle'
			);
		}

		if ( ! empty( $metadata['style'] ) ) {
			$metadata['style'] = Block_Registry::register_block_style_handle(
				$metadata,
				'style'
			);
		}

		return $metadata;
	}

	/**
	 * ブロックカテゴリー追加
	 *
	 * @param array $categories Categories.
	 *
	 * @return array
	 */
	public function add_block_categories( $categories ) {
		$categories[] = [
			'slug'  => self::BLOCK_CATEGORY,
			'title' => __( '[ooo]odango', 'odango' ),
		];
		$categories[] = [
			'slug'  => self::BLOCK_CATEGORY_LAYOUT,
			'title' => __( '[ooo]odango レイアウト', 'odango' ),
		];
		$categories[] = [
			'slug'  => self::BLOCK_CATEGORY_TEMPLATE,
			'title' => __( '[ooo]odango テンプレート用', 'odango' ),
		];

		return $categories;
	}

	/**
	 * Enqueue Block Styles
	 *
	 * @return void
	 */
	public function enqueue_theme_block_styles() {

		$this->enqueue_block_styles(
			get_template_directory() . '/assets/css/block-styles',
		);
		// 子テーマも検索.
		if ( is_child_theme() ) {
			$dir_path = apply_filters(
				'ooo_block_styles_dir_path',
				get_stylesheet_directory() . '/assets/css/block-styles'
			);
			$this->enqueue_block_styles( $dir_path, true );
		}
	}


	private function enqueue_block_styles( $dir, $is_child = false ) {
		foreach ( glob( "${dir}/*", GLOB_ONLYDIR ) as $dir_path ) {
			$block        = $this->parse_block_name( basename( $dir_path ) );
			$block_name   = $block['namespace'] . '/' . $block['name'];
			$style_handle = "odango-$block_name";
			if ( $is_child ) {
				$style_handle .= '-child';
			}
			$theme_css_path = $dir_path . '/' . $block['name'] . '.css';
			$style_src      = Path::replace_template_path_to_uri( $theme_css_path, $is_child );

			wp_enqueue_block_style(
				$block_name,
				[
					'handle' => $style_handle,
					'src'    => $style_src,
					'path'   => $theme_css_path,
				]
			);
			// インラインスタイルは必ず読み込み.
			if ( false !== strpos( $block['name'], 'inline-style' ) ) {
				wp_enqueue_style(
					$style_handle,
					$style_src,
					[],
					filemtime( $theme_css_path )
				);
				wp_style_add_data( $style_handle, 'path', $theme_css_path );
			}
		}
	}


	private function parse_block_name( $name ) {
		$block_name = explode( '__', $name );
		$namespace  = 'core';
		if ( isset( $block_name[1] ) && ! empty( $block_name[1] ) ) {
			$namespace     = $block_name[0];
			$block_name[0] = '';
		}
		$block_name = implode( '__', array_filter( $block_name ) );

		return [
			'namespace' => $namespace,
			'name'      => $block_name,
		];
	}

	public function enqueue_block_editor_assets() {
		wp_enqueue_style(
			'ooo-editor-style',
			get_template_directory_uri() . '/assets/css/odango-editor.css',
			[],
			filemtime( get_template_directory() . '/assets/css/odango-editor.css' )
		);
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
