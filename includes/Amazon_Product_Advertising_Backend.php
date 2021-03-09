<?php

require_once __DIR__ . '/Amazon_Product_Advertising_Options.php';
require_once __DIR__ . '/Amazon_Product_Advertising_PostMeta.php';

/**
 * @package Amazon_Product_Advertising
 */
class Amazon_Product_Advertising_Backend
{
    /**
     * init
     */
    public static function init()
    {
        // メニューを追加します。
        add_action('admin_menu', array('Amazon_Product_Advertising_Options', 'addAdminMenu'));
        // ページの初期化を行います。
        add_action('admin_init', array('Amazon_Product_Advertising_Options', 'addAdminPage'));
        // 記事メタ情報を追加します
        add_action('add_meta_boxes', array('Amazon_Product_Advertising_PostMeta', 'addMetaBox'));
        // 記事メタ情報の値を保存します。
        add_action('save_post_post', array('Amazon_Product_Advertising_PostMeta', 'saveMetaBox'));
    }
}
