<?php
/**
 * ACF Keep My Data
 *
 * @wordpress-plugin
 * Plugin Name:   ACF Keep My Data
 * Plugin URI:    https://github.com/slipnox/acf-keep-my-data.git
 * Description:   This plugin enables you to retain the previously saved values in your posts after renaming the custom field names.
 * Version:       0.1
 * Author:        Abrahan Silverio
 */

namespace ACFKMD;

defined( 'ABSPATH' ) || exit;

require_once plugin_dir_path( __FILE__ ) . 'inc/AcfManager.php';
require_once plugin_dir_path( __FILE__ ) . 'inc/DbManager.php';

use ACFKMD\Managers\AcfManager;

if ( is_admin() ) {
	AcfManager::init();
}


