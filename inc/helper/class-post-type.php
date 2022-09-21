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

class Post_Type {
	/**
	 * Post Type
	 *
	 * @return false|string
	 * @global \WP_Query
	 */
	public static function get_post_type() {
		global $wp_query;
		$post_type = get_post_type();
		if ( ! $post_type ) {
			if ( isset( $wp_query->query['post_type'] ) ) {
				$post_type = $wp_query->query['post_type'];
			}
		}

		return $post_type;
	}
}
