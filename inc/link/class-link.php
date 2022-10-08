<?php
/**
 * Link
 *
 * @package odango
 * @author  yosiakatsuki
 * @license GPL-2.0+
 */

namespace ooo;

defined( 'ABSPATH' ) || die();

class Link {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_shortcode(
			'ooo_home_url',
			[ $this, 'get_home_url' ]
		);
		add_shortcode(
			'ooo_template_directory_uri',
			[ $this, 'get_template_directory_uri' ]
		);
		add_shortcode(
			'ooo_stylesheet_directory_uri',
			[ $this, 'get_stylesheet_directory_uri' ]
		);
	}

	/**
	 * ホームURL取得
	 *
	 * @param array $args Attributes
	 *
	 * @return string
	 */
	public function get_home_url( $args ) {
		$args = shortcode_atts(
			[ 'path' => '/' ],
			$args
		);

		return home_url( $args['path'] );
	}

	/**
	 * テーマディレクトリURL取得
	 *
	 * @return string
	 */
	public function get_template_directory_uri() {
		return get_template_directory_uri();
	}

	/**
	 * 子テーマディレクトリURL取得
	 *
	 * @return string
	 */
	public function get_stylesheet_directory_uri() {
		return get_stylesheet_directory_uri();
	}
}

new Link();
