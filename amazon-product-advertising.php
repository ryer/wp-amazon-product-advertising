<?php

/**
 * Plugin Name:     Amazon Product Advertising
 * Plugin URI:      https://ryer.jp
 * Description:     Amazon Product Advertising
 * Author:          ryer
 * Author URI:      https://ryer.jp
 * Text Domain:     amazon-product-advertising
 * Domain Path:     /languages
 * Version:         1.1.0
 *
 * @package         Amazon_Product_Advertising
 */


// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

if (is_admin()) {
    require_once __DIR__ . '/includes/apaBackend.php';
    apaBackend::init();
} else {
    require_once __DIR__ . '/includes/apaFrontend.php';
    apaFrontend::init();
}
