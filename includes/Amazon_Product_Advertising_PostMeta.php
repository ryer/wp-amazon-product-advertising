<?php

/**
 * @package Amazon_Product_Advertising
 */
class Amazon_Product_Advertising_PostMeta
{
    const AMAZON_SEARCH_PARAMS = 'amazon_search_params';

    public static function getTheAmazonSearchParams()
    {
        return get_post_meta(get_the_ID(), self::AMAZON_SEARCH_PARAMS, true);
    }

    /**
     * Amazon search params
     */
    public static function add_amazon_search_params()
    {
        $value = get_post_meta(get_the_ID(), self::AMAZON_SEARCH_PARAMS, true);
        ?>
        <label>
            <input type="text"
                   size="60"
                   name="<?php echo self::AMAZON_SEARCH_PARAMS ?>"
                   value="<?php echo htmlspecialchars($value, ENT_QUOTES) ?>"
            >
        </label>
        <?php
    }

    /**
     * @noinspection PhpUnused
     */
    public static function addMetaBox()
    {
        add_meta_box(self::AMAZON_SEARCH_PARAMS, 'Amazon search params', array(__CLASS__, 'add_amazon_search_params'), 'post', 'normal');
    }

    /**
     * @param int $post_id
     * @noinspection PhpUnused
     */
    public static function saveMetaBox($post_id)
    {
        $value = isset($_POST[self::AMAZON_SEARCH_PARAMS]) ? $_POST[self::AMAZON_SEARCH_PARAMS] : null;

        if ($value) {
            update_post_meta($post_id, self::AMAZON_SEARCH_PARAMS, $value);
        } else {
            delete_post_meta($post_id, self::AMAZON_SEARCH_PARAMS);
        }
    }
}
