<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\API\Exceptions
{

    use Ganked\Skeleton\Http\StatusCodes\StatusCodeInterface;

    class ApiException extends \Exception
    {
        /**
         * @var StatusCodeInterface
         */
        private $statusCode;

        /**
         * @param string              $message
         * @param int                 $code
         * @param \Exception|null     $previous
         * @param StatusCodeInterface $statusCode
         */
        public function __construct($message = '', $code = 0, \Exception $previous = null, StatusCodeInterface $statusCode)
        {
            parent::__construct($message, $code, $previous);
            $this->statusCode = $statusCode;
        }

        /**
         * @return StatusCodeInterface
         */
        public function getStatusCode()
        {
            return $this->statusCode;
        }
    }
}
