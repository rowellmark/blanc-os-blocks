<?php
/**
 * Plugin Name:       Blancstudio Blocks
 * Description:       Example block scaffolded with Create Block tool.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       blancstudio-blocks
 *
 * @package CreateBlock
 */

namespace BlancStudio\GutenbergBlocks;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (!defined('ABSPATH')) {
	header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
	exit;
}

define('BLANCSTUDIO_BLOCKS_VERSION', '0.1.0');
define('BLANCSTUDIO_BLOCKS_URL', plugin_dir_url(__FILE__));
define('BLANCSTUDIO_BLOCKS_PATH', plugin_dir_path(__FILE__));
define('BLANCSTUDIO_BLOCKS_INC_URL', BLANCSTUDIO_BLOCKS_URL . 'assets/');

/**
 * Loads PSR-4-style plugin classes.
 */
function classloader($class)
{
	static $ns_offset;
	if (strpos($class, __NAMESPACE__ . '\\') === 0) {
		if ($ns_offset === NULL) {
			$ns_offset = strlen(__NAMESPACE__) + 1;
		}
		include __DIR__ . '/config/' . strtr(substr($class, $ns_offset), '\\', '/') . '.php';
	}
}
spl_autoload_register(__NAMESPACE__ . '\classloader');

add_action('plugins_loaded', __NAMESPACE__ . '\Config::loadTextDomain');
add_action('init', __NAMESPACE__ . '\Config::perInit', 0);
add_action('init', __NAMESPACE__ . '\Config::init', 20);
//add_action('admin_init', __NAMESPACE__ . '\Admin::init');