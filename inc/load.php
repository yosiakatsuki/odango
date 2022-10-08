<?php
/**
 * Load
 *
 * @package odango
 * @author  yosiakatsuki
 * @license GPL-2.0+
 */

defined( 'ABSPATH' ) || die();

/**
 * Helper
 */
require_once __DIR__ . '/helper/helper.php';
/**
 * Init
 */
require_once __DIR__ . '/init/class-init.php';
/**
 * Enqueue
 */
require_once __DIR__ . '/enqueue/class-enqueue.php';
/**
 * Block.
 */
require_once __DIR__ . '/blocks/class-blocks.php';
require_once __DIR__ . '/blocks/class-block-registry.php';
/**
 * Contents.
 */
require_once __DIR__ . '/excerpt/class-excerpt.php';
/**
 * Link
 */
require_once __DIR__ . '/link/class-link.php';
