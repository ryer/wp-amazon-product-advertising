<?php

/**
 * @package Amazon_Product_Advertising
 */
class apaOptions
{
    const PAGE_ID = 'Amazon_Product_Advertising';
    const BASIC_SECTION = 'basic_settings';

    const AWS_ACCESS_KEY_ID = 'aws_access_key_id';
    const AWS_SECRET_ACCESS_KEY_ID = 'aws_secret_access_key_id';
    const AMAZON_ASSOCIATE_TAG = 'amazon_associate_tag';
    const CACHE_EXPIRES_SECONDS = 'cache_expires_seconds';
    const RENDERING_PARAMS = 'rendering_params';
    const API_PARAMS = 'api_params';

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
            array(__CLASS__, 'required_amazon_associate_tag')
        );
        add_settings_field(
            self::AMAZON_ASSOCIATE_TAG,
            'AMAZON ASSOCIATE TAG',
            array(__CLASS__, 'show_input_amazon_associate_tag'),
            self::PAGE_ID,
            self::BASIC_SECTION
        );

        // AWS_ACCESS_KEY_ID
        register_setting(
            self::PAGE_ID,
            self::AWS_ACCESS_KEY_ID,
            array(__CLASS__, 'required_aws_access_key_id')
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
            array(__CLASS__, 'required_aws_secret_access_key_id')
        );
        add_settings_field(
            self::AWS_SECRET_ACCESS_KEY_ID,
            'AWS SECRET ACCESS KEY ID',
            array(__CLASS__, 'show_input_aws_secret_access_key_id'),
            self::PAGE_ID,
            self::BASIC_SECTION
        );

        // CACHE_EXPIRES_SECONDS
        register_setting(
            self::PAGE_ID,
            self::CACHE_EXPIRES_SECONDS
        );
        add_settings_field(
            self::CACHE_EXPIRES_SECONDS,
            'CACHE EXPIRES SECONDS',
            array(__CLASS__, 'show_input_cache_expires_seconds'),
            self::PAGE_ID,
            self::BASIC_SECTION
        );

        // RENDERING_PARAMS
        register_setting(
            self::PAGE_ID,
            self::RENDERING_PARAMS
        );
        add_settings_field(
            self::RENDERING_PARAMS,
            'RENDERING PARAMS (JSON)',
            array(__CLASS__, 'show_input_rendering_params'),
            self::PAGE_ID,
            self::BASIC_SECTION
        );

        // API_PARAMS
        register_setting(
            self::PAGE_ID,
            self::API_PARAMS
        );
        add_settings_field(
            self::API_PARAMS,
            'API PARAMS (JSON)',
            array(__CLASS__, 'show_input_api_params'),
            self::PAGE_ID,
            self::BASIC_SECTION
        );
    }

    ///////////////////////////////////////////////////////////////////////////////////////
    // AMAZON_ASSOCIATE_TAG
    ///////////////////////////////////////////////////////////////////////////////////////

    public static function getAmazonAssociateTag()
    {
        return self::get(self::AMAZON_ASSOCIATE_TAG, '');
    }

    public static function show_input_amazon_associate_tag()
    {
        self::show_input_text(
            self::AMAZON_ASSOCIATE_TAG,
            self::getAmazonAssociateTag(),
            'See amazon associate central.'
        );
    }

    public static function required_amazon_associate_tag($input)
    {
        return self::required(
            $input,
            self::AMAZON_ASSOCIATE_TAG,
            self::getAmazonAssociateTag(),
            'Missing amazon associate tag.'
        );
    }

    ///////////////////////////////////////////////////////////////////////////////////////
    // AWS_ACCESS_KEY_ID
    ///////////////////////////////////////////////////////////////////////////////////////

    public static function getAwsAccessKeyId()
    {
        return self::get(self::AWS_ACCESS_KEY_ID, '');
    }

    public static function show_input_aws_access_key_id()
    {
        self::show_input_text(
            self::AWS_ACCESS_KEY_ID,
            self::getAwsAccessKeyId(),
            'See amazon associate central.'
        );
    }

    public static function required_aws_access_key_id($input)
    {
        return self::required(
            $input,
            self::AWS_ACCESS_KEY_ID,
            self::getAwsAccessKeyId(),
            'Missing aws access key id.'
        );
    }

    ///////////////////////////////////////////////////////////////////////////////////////
    // AWS_SECRET_ACCESS_KEY_ID
    ///////////////////////////////////////////////////////////////////////////////////////

    public static function getAwsSecretAccessKeyId()
    {
        return self::get(self::AWS_SECRET_ACCESS_KEY_ID, '');
    }

    public static function show_input_aws_secret_access_key_id()
    {
        self::show_input_text(
            self::AWS_SECRET_ACCESS_KEY_ID,
            self::getAwsSecretAccessKeyId(),
            'See amazon associate central.'
        );
    }

    public static function required_aws_secret_access_key_id($input)
    {
        return self::required(
            $input,
            self::AWS_SECRET_ACCESS_KEY_ID,
            self::getAwsSecretAccessKeyId(),
            'Missing aws secret access key id.'
        );
    }

    ///////////////////////////////////////////////////////////////////////////////////////
    // CACHE_EXPIRES_SECONDS
    ///////////////////////////////////////////////////////////////////////////////////////

    public static function getCacheExpiresSeconds()
    {
        return self::get(self::CACHE_EXPIRES_SECONDS, 604800); // 7days.
    }

    public static function show_input_cache_expires_seconds()
    {
        self::show_input_text(
            self::CACHE_EXPIRES_SECONDS,
            self::getCacheExpiresSeconds(),
            'Api cache for this number of seconds. Sweep to restore the default.'
        );
    }

    ///////////////////////////////////////////////////////////////////////////////////////
    // RENDERING_PARAMS
    ///////////////////////////////////////////////////////////////////////////////////////

    public static function getRenderingParams()
    {
        return json_decode(self::getRenderingParamsJson(), true);
    }

    public static function getRenderingParamsJson()
    {
        $defaults = json_encode([
            'display_limit' => 4,
            'trim_title_width' => 50
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        return self::get(self::RENDERING_PARAMS, $defaults);
    }

    public static function show_input_rendering_params()
    {
        self::show_input_textarea(
            self::RENDERING_PARAMS,
            self::getRenderingParamsJson(),
            'Parameters for rendering. Sweep to restore the default.'
        );
    }

    ///////////////////////////////////////////////////////////////////////////////////////
    // API_PARAMS
    ///////////////////////////////////////////////////////////////////////////////////////

    public static function getAPIParams()
    {
        return json_decode(self::getAPIParamsJson(), true);
    }

    public static function getAPIParamsJson()
    {
        $defaults = json_encode([
            'region' => 'us-west-2',
            'market_place' => 'www.amazon.co.jp',
            'host' => 'webservices.amazon.co.jp'
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        return self::get(self::API_PARAMS, $defaults);
    }

    public static function show_input_api_params()
    {
        self::show_input_textarea(
            self::API_PARAMS,
            self::getAPIParamsJson(),
            'Parameters for API. Sweep to restore the default.'
        );
    }

    ///////////////////////////////////////////////////////////////////////////////////////
    // BASE
    ///////////////////////////////////////////////////////////////////////////////////////

    public static function get($name, $defaults)
    {
        $value = get_option($name);

        return (isset($value[$name]) and strlen($value[$name]) !== 0) ? $value[$name] : $defaults;
    }

    public static function show_input_text($name, $currentValue, $description)
    {
        ?>
        <!--suppress HtmlFormInputWithoutLabel -->
        <input type="text"
               size="60"
               id="<?php echo $name ?>"
               name="<?php echo $name ?>[<?php echo $name ?>]"
               value="<?php echo htmlspecialchars($currentValue, ENT_QUOTES) ?>"
        >
        <p class="description"><?php echo htmlspecialchars($description, ENT_QUOTES) ?></p>
        <?php
    }

    public static function show_input_textarea($name, $currentValue, $description)
    {
        ?>
        <!--suppress HtmlFormInputWithoutLabel -->
        <textarea
                id="<?php echo $name ?>"
                name="<?php echo $name ?>[<?php echo $name ?>]"
                cols="60"
                rows="10"
        ><?php echo htmlspecialchars($currentValue, ENT_QUOTES) ?></textarea>
        <p class="description"><?php echo htmlspecialchars($description, ENT_QUOTES) ?></p>
        <?php
    }

    public static function required($input, $name, $currentValue, $message)
    {
        if (isset($input[$name]) and trim($input[$name]) !== '') {
            $input[$name] = sanitize_text_field($input[$name]);
        } else {
            add_settings_error(
                $name,
                $name,
                $message
            );
            $input[$name] = $currentValue;
        }

        return $input;
    }
}
