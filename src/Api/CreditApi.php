<?php

/**
 * ListsApi
 * PHP version 8.1
 *
 * @category Class
 * @package  EmailListVerifyPHP
 * @author   Aníbal Álvarez
 * @link     https://github.com/anibalealvarezs/publica-php
 */

/**
 * FromDoppler API
 *
 * OpenAPI spec version: 0.0.1
 * Contact: anibalealvarezs@gmail.com
 */

namespace EmailListVerifyPHP\Api;

use GuzzleHttp\Psr7\Request;
use EmailListVerifyPHP\ApiTrait;

class CreditApi
{
    use ApiTrait;

    const END_POINT = '/getCredit';

    public function checkCredit()
    {
        return $this->checkCreditWithHttpInfo();
    }

    public function checkCreditWithHttpInfo()
    {
        $request = $this->checkCreditRequest();

        return $this->performRequest($request);
    }

    protected function checkCreditRequest(): Request
    {
        $secret = $this->apiKey;

        $resourcePath = self::END_POINT;
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';

        $this->serializeParam($queryParams, $secret, 'secret');

        // body params
        $headers = $this->setHeaders($headerParams);

        return $this->queryAndRequestGet($queryParams, $resourcePath, $headers, $httpBody);
    }
}
