<?php
/**
 * Block Registry
 *
 * @package odango
 * @author  yosiakatsuki
 * @license GPL-2.0+
 */

namespace ooo;

defined( 'ABSPATH' ) || die();

class Block_Registry {

	/**
	 * ブロックスクリプト登録テーマ版.
	 *
	 * @param array  $metadata   Block metadata.
	 * @param string $field_name Field name to pick from metadata.
	 *
	 * @return string|false
	 */
	public static function register_block_script_handle( $metadata, $field_name ) {
		if ( empty( $metadata[ $field_name ] ) ) {
			return false;
		}
		$script_handle = $metadata[ $field_name ];
		$script_path   = remove_block_asset_path_prefix( $metadata[ $field_name ] );
		if ( $script_handle === $script_path ) {
			return $script_handle;
		}
		$script_handle    = generate_block_asset_handle( $metadata['name'], $field_name );
		$script_path_norm = wp_normalize_path( dirname( $metadata['file'] ) . '/' . $script_path );
		if ( ! file_exists( $script_path_norm ) ) {
			return false;
		}
		$script_is_child = 0 === strpos( $script_path_norm, get_stylesheet_directory() );
		// Script URL.
		$script_uri = helper\Path::replace_template_path_to_uri( $script_path_norm, $script_is_child );
		/**
		 * Script Assets.
		 */
		$script_asset      = [];
		$script_asset_path = wp_normalize_path(
			realpath(
				dirname( $metadata['file'] ) . '/' .
				substr_replace( $script_path, '.asset.php', - strlen( '.js' ) )
			)
		);
		if ( file_exists( $script_asset_path ) ) {
			$script_asset = require $script_asset_path;
		}
		/**
		 * Register Script.
		 */
		$script_dependencies = isset( $script_asset['dependencies'] ) ? $script_asset['dependencies'] : [];
		$result              = wp_register_script(
			$script_handle,
			$script_uri,
			$script_dependencies,
			isset( $script_asset['version'] ) ? $script_asset['version'] : false
		);
		if ( ! $result ) {
			return false;
		}
		if ( ! empty( $metadata['textdomain'] ) && in_array( 'wp-i18n', $script_dependencies, true ) ) {
			wp_set_script_translations( $script_handle, $metadata['textdomain'] );
		}

		return $script_handle;
	}

	/**
	 * ブロックススタイル登録テーマ版.
	 *
	 * @param array  $metadata   Block metadata.
	 * @param string $field_name Field name to pick from metadata.
	 *
	 * @return string|false
	 */
	public static function register_block_style_handle( $metadata, $field_name ) {
		if ( empty( $metadata[ $field_name ] ) ) {
			return false;
		}
		$style_handle = $metadata[ $field_name ];
		$style_path   = remove_block_asset_path_prefix( $metadata[ $field_name ] );
		if ( $style_handle === $style_path ) {
			return $style_handle;
		}

		$style_handle    = generate_block_asset_handle( $metadata['name'], $field_name );
		$style_path_norm = wp_normalize_path( dirname( $metadata['file'] ) . '/' . $style_path );
		$style_path_real = realpath( $style_path_norm );
		if ( ! file_exists( $style_path_real ) ) {
			return false;
		}
		$style_is_child = false !== strpos( $style_path_norm, get_stylesheet_directory() );
		// Style URL.
		$style_uri = helper\Path::replace_template_path_to_uri( $style_path_norm, $style_is_child );

		$result = wp_register_style(
			$style_handle,
			$style_uri,
			[],
			filemtime( $style_path_real )
		);
		if ( file_exists( str_replace( '.css', '-rtl.css', $style_path_real ) ) ) {
			wp_style_add_data( $style_handle, 'rtl', 'replace' );
		}
		if ( file_exists( $style_path_real ) ) {
			wp_style_add_data( $style_handle, 'path', $style_path_real );
		}

		return $result ? $style_handle : false;
	}
}
