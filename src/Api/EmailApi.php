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

class EmailApi
{
    use ApiTrait;

    const END_POINT = '/verifyEmail';

    public function checkEmail($email)
    {
        return $this->checkEmailWithHttpInfo($email);
    }

    public function checkEmailWithHttpInfo($email)
    {
        $request = $this->checkEmailRequest($email);

        return $this->performRequest($request);
    }

    protected function checkEmailRequest($email): Request
    {
        // verify the required parameter 'list_id' is set
        $this->checkRequiredParameter($email);

        $secret = $this->apiKey;

        $resourcePath = self::END_POINT;
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';

        $this->serializeParam($queryParams, $secret, 'secret');
        $this->serializeParam($queryParams, $email, 'email');

        // body params
        $headers = $this->setHeaders($headerParams);

        return $this->queryAndRequestGet($queryParams, $resourcePath, $headers, $httpBody);
    }
}
