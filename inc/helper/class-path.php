<?php
/**
 * Helper : Path
 *
 * @package odango
 * @author  yosiakatsuki
 * @license GPL-2.0+
 */

namespace ooo\helper;

defined( 'ABSPATH' ) || die();

class Path {
	/**
	 * テーマパスをテーマURLに変換
	 *
	 * @param string $path Path
	 *
	 * @return string
	 */
	public static function replace_template_path_to_uri( $path ) {
		return str_replace(
			get_template_directory(),
			get_template_directory_uri(),
			$path
		);
	}

	/**
	 * テーマパスをテーマURLに変換
	 *
	 * @param string $path Path
	 *
	 * @return string
	 */
	public static function replace_stylesheet_path_to_uri( $path ) {
		return str_replace(
			get_stylesheet_directory(),
			get_stylesheet_directory_uri(),
			$path
		);
	}
}
