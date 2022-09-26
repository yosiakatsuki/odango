<?php
/**
 * Inline Style.
 *
 * @package odango
 * @author  yosiakatsuki
 * @license GPL-2.0+
 */

defined( 'ABSPATH' ) || die();

/**
 * インライン装飾追加機能
 * [
 *   'name' => [
 *      'label' => '',
 *      'class' => ''
 *   ],
 *   ...
 * ]
 * 形式で配列を渡す
 * TODO: マニュアル
 */
add_action( 'enqueue_block_editor_assets', function () {
	$l10n   = [];
	$odango = apply_filters( 'ooo_block_inline_style_items__odango', [] );
	$custom = apply_filters( 'ooo_block_inline_style_items__custom', [] );
	if ( is_array( $odango ) && ! empty( $odango ) ) {
		$l10n['ooo'] = $odango;
	}
	if ( is_array( $custom ) && ! empty( $custom ) ) {
		$l10n['custom'] = $custom;
	}
	if ( empty( $l10n ) ) {
		return;
	}
	wp_localize_script(
		'ooo-inline-style-editor-script',
		'oooInlineStyles',
		$l10n
	);
} );
