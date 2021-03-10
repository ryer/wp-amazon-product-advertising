<?php

require_once __DIR__ . '/apaOptions.php';
require_once __DIR__ . '/apaPostMeta.php';

/**
 * @package Amazon_Product_Advertising
 */
class apaBackend
{
    public static function init()
    {
        add_action('admin_menu', ['apaOptions', 'addAdminMenu']);
        add_action('admin_init', ['apaOptions', 'addAdminPage']);
        add_action('add_meta_boxes', ['apaPostMeta', 'addMetaBox']);
        add_action('save_post_post', ['apaPostMeta', 'saveMetaBox']);
    }
}
