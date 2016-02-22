<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\Curl
{

    use Ganked\Library\ValueObjects\Uri;

    /**
     * @codeCoverageIgnore
     */
    class CurlHandler
    {

        /**
         * @param string $method
         * @param Uri    $uri
         * @param array  $params
         *
         * @return Response
         * @throws \RuntimeException
         */
        public function sendRequest($method, Uri $uri, array $params = [])
        {
            $handle = $this->prepareRequest($method, $uri, $params);
            $result = curl_exec($handle);

            if (curl_errno($handle)) {
                $error = curl_error($handle);
                $errorNumber = curl_errno($handle);
                curl_close($handle);
                throw new \RuntimeException($error, $errorNumber);
            }

            return $this->buildResponse($result, $handle);
        }

        /**
         * @param string $method
         * @param Uri    $uri
         * @param array  $params
         *
         * @return resource
         */
        private function prepareRequest($method, Uri $uri, array $params = [])
        {
            $handle = curl_init();

            if ($method === 'DELETE') {
                curl_setopt($handle, CURLOPT_CUSTOMREQUEST, $method);
            }

            if ($method !== 'POST' && $method !== 'PATCH' && !empty($params)) {
                $uri = (string) $uri . '?' . http_build_query($params);
            }

            if ($method === 'POST' || $method === 'PATCH') {
                curl_setopt($handle, CURLOPT_POST, 1);
                curl_setopt($handle, CURLOPT_POSTFIELDS, $params);
            }

            curl_setopt($handle, CURLOPT_URL, (string) $uri);
            curl_setopt($handle, CURLOPT_HEADER, false);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 150);

            return $handle;
        }

        /**
         * @param string   $result
         * @param resource $handle
         *
         * @return Response
         */
        private function buildResponse($result, $handle)
        {
            $response = new Response;

            $response->setResponseCode(curl_getinfo($handle, CURLINFO_HTTP_CODE));
            $response->setUri(new Uri(curl_getinfo($handle, CURLINFO_EFFECTIVE_URL)));

            curl_close($handle);
            $response->setResponseBody($result);
            return $response;
        }
    }
}
