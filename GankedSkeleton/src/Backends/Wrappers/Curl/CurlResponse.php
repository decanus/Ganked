<?php

namespace Ganked\Skeleton\Backends\Wrappers
{
    class CurlResponse 
    {
        /**
         * @var int
         */
        private $httpStatus;

        /**
         * @var string
         */
        private $contentType;

        /**
         * @var string
         */
        private $body;

        /**
         * @param int $httpStatus
         */
        public function setHttpStatus($httpStatus)
        {
            $this->httpStatus = $httpStatus;
        }

        /**
         * @param string $body
         */
        public function setBody($body)
        {
            $this->body = $body;
        }

        /**
         * @param string $contentType
         */
        public function setContentType($contentType)
        {
            $this->contentType = $contentType;
        }

        /**
         * @return string
         */
        public function getContentType()
        {
            return $this->contentType;
        }

        /**
         * @return int
         */
        public function getHttpStatus()
        {
            return $this->httpStatus;
        }

        /**
         * @return string
         */
        public function getBody()
        {
            return $this->body;
        }
    }
}
