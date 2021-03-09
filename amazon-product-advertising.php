<?php

/**
 * Plugin Name:     Amazon Product Advertising
 * Plugin URI:      https://ryer.jp
 * Description:     Amazon Product Advertising
 * Author:          ryer
 * Author URI:      https://ryer.jp
 * Text Domain:     amazon-product-advertising
 * Domain Path:     /languages
 * Version:         1.0.0
 *
 * @package         Amazon_Product_Advertising
 */


// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

require_once __DIR__ . '/includes/Amazon_Product_Advertising_Backend.php';
require_once __DIR__ . '/includes/Amazon_Product_Advertising_Frontend.php';
register_activation_hook(__FILE__, 'Amazon_Product_Advertising_activate');
register_deactivation_hook(__FILE__, 'Amazon_Product_Advertising_deactivate');
register_uninstall_hook(__FILE__, 'Amazon_Product_Advertising_uninstall');
add_action('init', 'Amazon_Product_Advertising_init', 2);

/**
 * Fire on init.
 */
function Amazon_Product_Advertising_init()
{
    if (is_admin()) {
        Amazon_Product_Advertising_Backend::init();
    } else {
        Amazon_Product_Advertising_Frontend::init();
    }
}

/**
 * Fire on activated.
 */
function Amazon_Product_Advertising_activate()
{
}

/**
 * Fire on deactivated.
 */
function Amazon_Product_Advertising_deactivate()
{
}

/**
 * Fire on uninstalled.
 */
function Amazon_Product_Advertising_uninstall()
{
}
