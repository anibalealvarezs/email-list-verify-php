<?php

namespace EmailListVerifyPHP;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\TooManyRedirectsException;
use GuzzleHttp\Psr7\Message;
use GuzzleHttp\Psr7\Query;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Utils;
use stdClass;

trait ApiTrait
{
    protected Client $client;
    protected Configuration $config;
    protected HeaderSelector $headerSelector;

    public function __construct(Configuration $config = null)
    {
        $this->client = new Client([
            'defaults' => [
                'timeout' => 120.0
            ]
        ]);
        $this->headerSelector = new HeaderSelector();
        $this->config = $config ?: new Configuration();
    }

    public function getConfig(): Configuration
    {
        return $this->config;
    }

    protected function createHttpClientOption(): array
    {
        $options = [];
        if ($this->config->getDebug()) {
            $options[RequestOptions::DEBUG] = fopen($this->config->getDebugFile(), 'a');
            if (!$options[RequestOptions::DEBUG]) {
                throw new RuntimeException('Failed to open the debug file: ' . $this->config->getDebugFile());
            }
        }

        if ($this->config->getTimeout()) {
            $options[RequestOptions::TIMEOUT] = $this->config->getTimeout();
        }

        return $options;
    }

    /**
     * @throws GuzzleException
     */
    protected function performRequest($request): mixed
    {
        try {
            $options = $this->createHttpClientOption();
            $response = $this->client->send($request, $options);

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    $response->getBody()
                );
            }

            return json_decode($response->getBody()->getContents());

        } catch (ApiException $e) {
            return $e->getMessage();
        } catch (ClientException | ServerException | TooManyRedirectsException $e) {
            return Message::toString($e->getResponse());
        } catch (ConnectException $e) {
            return Message::toString($e->getRequest());
        }
    }

    protected function setHeaders($headerParams): array
    {
        $headers = $this->headerSelector->selectHeaders(
            ['text/html'],
            ['application/json']
        );

        return array_merge($headerParams, $headers);
    }

    protected function encodeBodyWhenJSON($httpBody, $headers)
    {
        if($headers['Content-Type'] === 'application/json') {
            if ($httpBody instanceof stdClass) {
                $httpBody = Utils::jsonEncode($httpBody);
            }
            if (is_array($httpBody)) {
                $httpBody = Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($httpBody));
            }
        }
        return $httpBody;
    }

    protected function checkRequiredParameter($parameter)
    {
        if ($parameter === null || (is_array($parameter) && count($parameter) === 0)) {
            throw new InvalidArgumentException(
                'Missing the required parameter $parameter when calling '
            );
        }
    }

    protected function queryAndRequestGet($queryParams, $resourcePath, $headers, $httpBody): Request
    {
        $query = Query::build($queryParams);
        return new Request(
            'GET',
            $this->config->getHost() . $resourcePath . ($query ? "?$query" : ''),
            $headers,
            $httpBody
        );
    }

    protected function queryAndRequestPost($queryParams, $resourcePath, $headers, $httpBody): Request
    {
        $query = Query::build($queryParams);
        return new Request(
            'POST',
            $this->config->getHost() . $resourcePath . ($query ? "?$query" : ''),
            $headers,
            $httpBody
        );
    }

    protected function queryAndRequestDelete($queryParams, $resourcePath, $headers, $httpBody): Request
    {
        $query = Query::build($queryParams);
        return new Request(
            'DELETE',
            $this->config->getHost() . $resourcePath . ($query ? "?$query" : ''),
            $headers,
            $httpBody
        );
    }

    protected function queryAndRequestPatch($queryParams, $resourcePath, $headers, $httpBody): Request
    {
        $query = Query::build($queryParams);
        return new Request(
            'PATCH',
            $this->config->getHost() . $resourcePath . ($query ? "?$query" : ''),
            $headers,
            $httpBody
        );
    }

    protected function queryAndRequestPut($queryParams, $resourcePath, $headers, $httpBody): Request
    {
        $query = Query::build($queryParams);
        return new Request(
            'PUT',
            $this->config->getHost() . $resourcePath . ($query ? "?$query" : ''),
            $headers,
            $httpBody
        );
    }

    protected function serializeParam(&$queryParams, $param, $key)
    {
        if ($param != null) {
            $queryParams[$key] = ObjectSerializer::toQueryValue($param);
        }
    }

    protected function pathParam(&$resourcePath, $key, $param)
    {
        $resourcePath = str_replace(
            '{' . $key . '}',
            ObjectSerializer::toPathValue($param),
            $resourcePath
        );
    }
}
