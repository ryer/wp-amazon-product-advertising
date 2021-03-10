<?php

require_once __DIR__ . '/apaAwsV4.php';

/**
 * @package Amazon_Product_Advertising
 * @see https://webservices.amazon.co.jp/paapi5/scratchpad/index.html
 */
class apaPAAPI
{
    public function searchItems(array $params)
    {
        $payload =
            "{" .
            ' "PartnerType": "Associates",' .
            ' "Keywords": "' . $params['keywords'] . '",' .
            ' "PartnerTag": "' . $params['associate_tag'] . '",' .
            ' "Marketplace": "' . $params['market_place'] . '",' .
            ' "Resources": [' .
            '   "Images.Primary.Medium",' .
            '   "Offers.Summaries.LowestPrice",' .
            '   "ItemInfo.Title"' .
            ' ]';
        if (isset($params['search_index'])) {
            $payload .= ',"SearchIndex":"' . $params['search_index'] . '"';
        }
        if (isset($params['browse_node_id'])) {
            $payload .= ',"BrowseNodeId":"' . $params['browse_node_id'] . '"';
        }
        $payload .= "}";

        $host = $params['host'];
        $uriPath = "/paapi5/searchitems";

        $awsv4 = new apaAwsV4($params['access_key'], $params['secret_key']);
        $awsv4->setRegionName($params['region']);
        $awsv4->setServiceName('ProductAdvertisingAPI');
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

        $responseJson = @stream_get_contents($fp);
        if ($responseJson === false) {
            error_log("searchItem error: failed to stream_get_contents");
            return null;
        }

        $resp = json_decode($responseJson, true);
        if (!isset($resp['SearchResult'])) {
            error_log("searchItem panic: missing SearchResult");
            return null;
        }

        return $resp;
    }
}
