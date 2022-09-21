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

class Boolean {
	/**
	 * 真偽変換.
	 *
	 * @param mixed $value Value.
	 *
	 * @return bool
	 */
	public static function toBool( $value ) {
		if ( true === $value || 'true' === $value || 1 === $value || '1' === $value ) {
			return true;
		}

		return false;
	}
}
