<?php

/**
 * @package Amazon_Product_Advertising
 */
class Amazon_Product_Advertising_Options
{
    const PAGE_ID = 'Amazon_Product_Advertising';
    const BASIC_SECTION = 'basic_settings';

    const AWS_ACCESS_KEY_ID = 'aws_access_key_id';
    const AWS_SECRET_ACCESS_KEY_ID = 'aws_secret_access_key_id';
    const AMAZON_ASSOCIATE_TAG = 'amazin_associate_tag';

    /**
     * @noinspection PhpUnused
     */
    public static function addAdminMenu()
    {
        add_options_page(
            'Amazon Product Advertising',
            'Amazon Product Advertising',
            'manage_options',
            self::PAGE_ID,
            array(__CLASS__, 'create_admin_page')
        );
    }

    /**
     * main page
     */
    public static function create_admin_page()
    {
        ?>
        <div class="wrap">
            <h2>Amazon Product Advertising</h2>
            <!--suppress HtmlUnknownTarget -->
            <form method="post" action="options.php">
                <?php
                settings_fields(self::PAGE_ID);
                do_settings_sections(self::PAGE_ID);
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * @noinspection PhpUnused
     */
    public static function addAdminPage()
    {
        add_settings_section(
            self::BASIC_SECTION,
            'BASIC SETTINGS',
            null,
            self::PAGE_ID
        );

        // AMAZON_ASSOCIATE_TAG
        register_setting(
            self::PAGE_ID,
            self::AMAZON_ASSOCIATE_TAG,
            array(__CLASS__, 'sanitize_AMAZON_ASSOCIATE_TAG')
        );
        add_settings_field(
            self::AMAZON_ASSOCIATE_TAG,
            'AMAZON ASSOCIATE TAG',
            array(__CLASS__, 'show_input_AMAZON_ASSOCIATE_TAG'),
            self::PAGE_ID,
            self::BASIC_SECTION
        );

        // AWS_ACCESS_KEY_ID
        register_setting(
            self::PAGE_ID,
            self::AWS_ACCESS_KEY_ID,
            array(__CLASS__, 'sanitize_aws_access_key_id')
        );
        add_settings_field(
            self::AWS_ACCESS_KEY_ID,
            'AWS ACCESS KEY ID',
            array(__CLASS__, 'show_input_aws_access_key_id'),
            self::PAGE_ID,
            self::BASIC_SECTION
        );

        // AWS_SECRET_ACCESS_KEY_ID
        register_setting(
            self::PAGE_ID,
            self::AWS_SECRET_ACCESS_KEY_ID,
            array(__CLASS__, 'sanitize_aws_secret_access_key_id')
        );
        add_settings_field(
            self::AWS_SECRET_ACCESS_KEY_ID,
            'AWS SECRET ACCESS KEY ID',
            array(__CLASS__, 'show_input_aws_secret_access_key_id'),
            self::PAGE_ID,
            self::BASIC_SECTION
        );
    }

    ///////////////////////////////////////////////////////////////////////////////////////
    // AMAZON_ASSOCIATE_TAG
    ///////////////////////////////////////////////////////////////////////////////////////

    /**
     * @return string
     */
    public static function getAmazonAssociateTag()
    {
        $value = get_option(self::AMAZON_ASSOCIATE_TAG);

        return isset($value[self::AMAZON_ASSOCIATE_TAG]) ? $value[self::AMAZON_ASSOCIATE_TAG] : '';
    }

    /**
     * show input
     */
    public static function show_input_AMAZON_ASSOCIATE_TAG()
    {
        ?>
        <!--suppress HtmlFormInputWithoutLabel -->
        <input type="text"
               size="60"
               id="<?php echo self::AMAZON_ASSOCIATE_TAG ?>"
               name="<?php echo self::AMAZON_ASSOCIATE_TAG ?>[<?php echo self::AMAZON_ASSOCIATE_TAG ?>]"
               value="<?php echo htmlspecialchars(self::getAmazonAssociateTag(), ENT_QUOTES) ?>"
        >
        <p class="description">See amazon associate central.</p>
        <?php
    }

    /**
     * @param array $input
     * @return array
     * @noinspection PhpUnused
     */
    public static function sanitize_AMAZON_ASSOCIATE_TAG($input)
    {
        if (isset($input[self::AMAZON_ASSOCIATE_TAG]) and trim($input[self::AMAZON_ASSOCIATE_TAG]) !== '') {
            $input[self::AMAZON_ASSOCIATE_TAG] = sanitize_text_field($input[self::AMAZON_ASSOCIATE_TAG]);
        } else {
            add_settings_error(
                self::AMAZON_ASSOCIATE_TAG,
                self::AMAZON_ASSOCIATE_TAG,
                'Missing amazon associate tag.'
            );
            $input[self::AMAZON_ASSOCIATE_TAG] = self::getAmazonAssociateTag();
        }

        return $input;
    }

    ///////////////////////////////////////////////////////////////////////////////////////
    // AWS_ACCESS_KEY_ID
    ///////////////////////////////////////////////////////////////////////////////////////

    /**
     * @return string
     */
    public static function getAwsAccessKeyId()
    {
        $value = get_option(self::AWS_ACCESS_KEY_ID);

        return isset($value[self::AWS_ACCESS_KEY_ID]) ? $value[self::AWS_ACCESS_KEY_ID] : '';
    }

    /**
     * show input
     */
    public static function show_input_aws_access_key_id()
    {
        ?>
        <!--suppress HtmlFormInputWithoutLabel -->
        <input type="text"
               size="60"
               id="<?php echo self::AWS_ACCESS_KEY_ID ?>"
               name="<?php echo self::AWS_ACCESS_KEY_ID ?>[<?php echo self::AWS_ACCESS_KEY_ID ?>]"
               value="<?php echo htmlspecialchars(self::getAwsAccessKeyId(), ENT_QUOTES) ?>"
        >
        <p class="description">See amazon associate central.</p>
        <?php
    }

    /**
     * @param array $input
     * @return array
     * @noinspection PhpUnused
     */
    public static function sanitize_aws_access_key_id($input)
    {
        if (isset($input[self::AWS_ACCESS_KEY_ID]) and trim($input[self::AWS_ACCESS_KEY_ID]) !== '') {
            $input[self::AWS_ACCESS_KEY_ID] = sanitize_text_field($input[self::AWS_ACCESS_KEY_ID]);
        } else {
            add_settings_error(
                self::AWS_ACCESS_KEY_ID,
                self::AWS_ACCESS_KEY_ID,
                'Missing aws access key id.'
            );
            $input[self::AWS_ACCESS_KEY_ID] = self::getAwsAccessKeyId();
        }

        return $input;
    }

    ///////////////////////////////////////////////////////////////////////////////////////
    // AWS_SECRET_ACCESS_KEY_ID
    ///////////////////////////////////////////////////////////////////////////////////////

    /**
     * @return string
     */
    public static function getAwsSecretAccessKeyId()
    {
        $value = get_option(self::AWS_SECRET_ACCESS_KEY_ID);

        return isset($value[self::AWS_SECRET_ACCESS_KEY_ID]) ? $value[self::AWS_SECRET_ACCESS_KEY_ID] : '';
    }

    /**
     * show input
     */
    public static function show_input_aws_secret_access_key_id()
    {
        ?>
        <!--suppress HtmlFormInputWithoutLabel -->
        <input type="text"
               size="60"
               id="<?php echo self::AWS_SECRET_ACCESS_KEY_ID ?>"
               name="<?php echo self::AWS_SECRET_ACCESS_KEY_ID ?>[<?php echo self::AWS_SECRET_ACCESS_KEY_ID ?>]"
               value="<?php echo htmlspecialchars(self::getAwsSecretAccessKeyId(), ENT_QUOTES) ?>"
        >
        <p class="description">See amazon associate central.</p>
        <?php
    }

    /**
     * @param array $input
     * @return array
     * @noinspection PhpUnused
     */
    public static function sanitize_aws_secret_access_key_id($input)
    {
        if (isset($input[self::AWS_SECRET_ACCESS_KEY_ID]) and trim($input[self::AWS_SECRET_ACCESS_KEY_ID]) !== '') {
            $input[self::AWS_SECRET_ACCESS_KEY_ID] = sanitize_text_field($input[self::AWS_SECRET_ACCESS_KEY_ID]);
        } else {
            add_settings_error(
                self::AWS_SECRET_ACCESS_KEY_ID,
                self::AWS_SECRET_ACCESS_KEY_ID,
                'Missing aws secret access key id.'
            );
            $input[self::AWS_SECRET_ACCESS_KEY_ID] = self::getAwsSecretAccessKeyId();
        }

        return $input;
    }
}
