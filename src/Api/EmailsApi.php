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

class EmailsApi
{
    use ApiTrait;

    const END_POINT = '/verifyApiFile';

    public function checkEmails($filename)
    {
        return $this->checkEmailsWithHttpInfo($filename);
    }

    public function checkEmailsWithHttpInfo($filename)
    {
        $request = $this->checkEmailsRequest($filename);

        return $this->performRequest($request);
    }

    protected function checkEmailsRequest($filename): Request
    {
        // verify the required parameter 'list_id' is set
        $this->checkRequiredParameter($filename);

        $secret = $this->config->getApiKey();

        $resourcePath = self::END_POINT;
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';

        $this->serializeParam($queryParams, $secret, 'secret');
        $this->serializeParam($queryParams, $filename, 'filename');

        // body params
        $headers = $this->setHeaders($headerParams);

        return $this->queryAndRequestGet($queryParams, $resourcePath, $headers, $httpBody);
    }
}
