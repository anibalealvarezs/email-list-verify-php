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

class FileApi
{
    use ApiTrait;

    const END_POINT = '/getApiFileInfo';

    public function checkFile($id)
    {
        return $this->checkFileWithHttpInfo($id);
    }

    public function checkFileWithHttpInfo($id)
    {
        $request = $this->checkFileRequest($id);

        return $this->performRequest($request);
    }

    protected function checkFileRequest($id): Request
    {
        // verify the required parameter 'list_id' is set
        $this->checkRequiredParameter($id);

        $secret = $this->apiKey;

        $resourcePath = self::END_POINT;
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';

        $this->serializeParam($queryParams, $secret, 'secret');
        $this->serializeParam($queryParams, $id, 'id');

        // body params
        $headers = $this->setHeaders($headerParams);

        return $this->queryAndRequestGet($queryParams, $resourcePath, $headers, $httpBody);
    }
}
