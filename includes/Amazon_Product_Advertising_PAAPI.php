<?php

require_once __DIR__ . '/Amazon_Product_Advertising_AwsV4.php';

/**
 * @package Amazon_Product_Advertising
 * @see https://webservices.amazon.co.jp/paapi5/scratchpad/index.html
 */
class Amazon_Product_Advertising_PAAPI
{
    /**
     * @param array $params
     * @return array
     */
    public static function searchItems(array $params)
    {
        $serviceName = "ProductAdvertisingAPI";
        $region = "us-west-2";
        $payload =
            "{" .
            ' "Keywords": "' . $params['keywords'] . '",' .
            ' "PartnerTag": "' . $params['associate_tag'] . '",' .
            ' "PartnerType": "Associates",' .
            ' "Marketplace": "www.amazon.co.jp",' .
            ' "Resources": [' .
            ' "Images.Primary.Small",' .
            ' "Images.Primary.Medium",' .
            ' "Images.Primary.Large",' .
            ' "Offers.Summaries.LowestPrice",' .
            ' "ItemInfo.Title",' .
            ' "ItemInfo.ByLineInfo",' .
            ' "ItemInfo.ManufactureInfo",' .
            ' "ItemInfo.ProductInfo"' .
            ' ]';
        if (isset($params['search_index'])) {
            $payload .= ',"SearchIndex":"' . $params['search_index'] . '"';
        }
        if (isset($params['browse_node_id'])) {
            $payload .= ',"BrowseNodeId":"' . $params['browse_node_id'] . '"';
        }
        $payload .= "}";
        $host = "webservices.amazon.co.jp";
        $uriPath = "/paapi5/searchitems";
        $awsv4 = new Amazon_Product_Advertising_AwsV4($params['access_key'], $params['secret_key']);
        $awsv4->setRegionName($region);
        $awsv4->setServiceName($serviceName);
        $awsv4->setPath($uriPath);
        $awsv4->setPayload($payload);
        $awsv4->setRequestMethod("POST");
        $awsv4->addHeader('content-encoding', 'amz-1.0');
        $awsv4->addHeader('content-type', 'application/json; charset=utf-8');
        $awsv4->addHeader('host', $host);
        $awsv4->addHeader('x-amz-target', 'com.amazon.paapi5.v1.ProductAdvertisingAPIv1.SearchItems');
        $headers = $awsv4->getHeaders();
        $headerString = "";
        foreach ($headers as $key => $value) {
            $headerString .= $key . ': ' . $value . "\r\n";
        }
        $params = array(
            'http' => array(
                'header' => $headerString,
                'method' => 'POST',
                'content' => $payload
            )
        );
        $stream = stream_context_create($params);

        $fp = @fopen('https://' . $host . $uriPath, 'rb', false, $stream);
        if (!$fp) {
            error_log("searchItem error: failed to fopen");
            return null;
        }

        $response = @stream_get_contents($fp);
        if ($response === false) {
            error_log("searchItem error: failed to stream_get_contents");
            return null;
        }

        $ret = json_decode($response, true);
        if (!isset($ret['SearchResult'])) {
            error_log("searchItem error: missing SearchResult");
            return null;
        }

        return $ret['SearchResult'];
    }
}
