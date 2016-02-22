<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\Curl
{

    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Library\ValueObjects\Uri;

    class Response
    {
        /**
         * @var int
         */
        private $responseCode;

        /**
         * @var string
         */
        private $body;

        /**
         * @var Uri
         */
        private $uri;

        /**
         * @param int $code
         */
        public function setResponseCode($code)
        {
            $this->responseCode = $code;
        }

        /**
         * @return int
         */
        public function getResponseCode()
        {
            return $this->responseCode;
        }

        /**
         * @param string $body
         */
        public function setResponseBody($body)
        {
            $this->body = $body;
        }

        /**
         * @return string
         */
        public function getRawResponseBody()
        {
            return $this->body;
        }

        /**
         * @return mixed
         */
        public function getDecodedJsonResponse()
        {
            return json_decode($this->getRawResponseBody(), true);
        }

        /**
         * @return DomHelper
         */
        public function getResponseAsDomHelper()
        {
            return new DomHelper($this->getRawResponseBody());
        }

        /**
         * @param Uri $uri
         */
        public function setUri(Uri $uri)
        {
            $this->uri = $uri;
        }

        /**
         * @return Uri
         */
        public function getUri()
        {
            return $this->uri;
        }
   
    }
}
