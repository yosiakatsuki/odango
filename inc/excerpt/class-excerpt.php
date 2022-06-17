<?php
/**
 * Excerpt
 *
 * @package odango
 * @author  yosiakatsuki
 * @license GPL-2.0+
 */

namespace ooo;

defined( 'ABSPATH' ) || die();

/**
 * Class Excerpt
 */
class Excerpt {

	const MORE_STRING = '&hellip;';

	/**
	 * Constructor
	 */
	public function __construct() {
		add_filter(
			'excerpt_more',
			[ __CLASS__, 'get_excerpt_more' ]
		);
	}

	/**
	 * Get More Text
	 *
	 * @return string
	 */
	public static function get_excerpt_more() {
		return self::MORE_STRING;
	}
}

new Excerpt();
