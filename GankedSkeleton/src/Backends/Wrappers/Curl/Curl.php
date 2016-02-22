<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Backends\Wrappers
{

    use Ganked\Library\ValueObjects\Uri;

    /**
     * @deprecated Use curl in library
     */
    class Curl
    {

        /**
         * @var array
         */
        private $configuration = [];

        /**
         * @param Uri   $uri
         * @param array $data
         * @param array $configuration
         *
         * @return Curl
         */
        public function post(Uri $uri, $data = [], $configuration = [])
        {
            $configuration[CURLOPT_URL] = (string) $uri;
            $configuration[CURLOPT_POST] = count($data);
            $configuration[CURLOPT_POSTFIELDS] = http_build_query($data);

            $this->setConfiguration($configuration);

            return $this;
        }

        /**
         * @param Uri   $uri
         * @param array $data
         * @param array $configuration
         *
         * @return Curl
         */
        public function get(Uri $uri, $data = [], $configuration = [])
        {
            $query = '';
            if (!empty($data)) {
                $query = '?' . http_build_query($data);
            }

            $configuration[CURLOPT_URL] = (string) $uri . $query;

            $this->setConfiguration($configuration);
            return $this;
        }

        /**
         * @param array $configuration
         */
        private function setConfiguration(array $configuration)
        {
            if (!isset($configuration[CURLOPT_CONNECTTIMEOUT])) {
                $this->configuration[CURLOPT_CONNECTTIMEOUT] = 30;
            }

            if (!isset($configuration[CURLOPT_TIMEOUT])) {
                $this->configuration[CURLOPT_TIMEOUT] = 30;
            }

            if (!isset($configuration[CURLOPT_SSL_VERIFYPEER])) {
                $this->configuration[CURLOPT_SSL_VERIFYPEER] = 0;
            }

            if (!isset($configuration[CURLOPT_SSL_VERIFYHOST])) {
                $this->configuration[CURLOPT_SSL_VERIFYHOST] = 0;
            }

            if (!isset($configuration[CURLOPT_FRESH_CONNECT])) {
                $this->configuration[CURLOPT_FRESH_CONNECT] = 1;
            }

            if (!isset($configuration[CURLOPT_RETURNTRANSFER])) {
                $this->configuration[CURLOPT_RETURNTRANSFER] = 1;
            }

            if (!isset($configuration[CURLOPT_FORBID_REUSE])) {
                $this->configuration[CURLOPT_FORBID_REUSE] = 1;
            }

            if (!empty($configuration)) {
                foreach ($configuration as $key => $value) {
                    $this->configuration[$key] = $value;
                }
            }

            $this->configuration[CURLOPT_HEADER] = false;
        }

        /**
         * @return CurlResponse
         * @throws \RuntimeException
         */
        public function execute()
        {
            $response = new CurlResponse();

            $handle = curl_init();

            curl_setopt_array($handle, $this->configuration);
            $result = curl_exec($handle);
            
            if (curl_errno($handle)) {
                $error = curl_error($handle);
                $errorNumber = curl_errno($handle);
                curl_close($handle);
                throw new \RuntimeException($error, $errorNumber);
            }

            $response->setHttpStatus(curl_getinfo($handle, CURLINFO_HTTP_CODE));
            $response->setContentType(curl_getinfo($handle, CURLINFO_CONTENT_TYPE));
            curl_close($handle);

            $response->setBody($result);

            $this->configuration = [];

            return $response;
        }
    }
}
