<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
// @codeCoverageIgnoreStart

namespace Ganked\Library\Logging\Logs
{
    class EmergencyExceptionLog implements LogInterface
    {
        /**
         * @var \Exception
         */
        private $exception;

        /**
         * @param \Exception $exception
         */
        public function __construct(\Exception $exception)
        {
            $this->exception = $exception;
        }

        /**
         * @return array
         */
        public function getLog()
        {
            return [
                'level' => 'emergency',
                'code' => $this->exception->getCode(),
                'message' => $this->exception->getMessage(),
                'trace' => $this->exception->getTraceAsString(),
            ];
        }

        /**
         * @return string
         */
        public function getMessage()
        {
            return $this->exception->getMessage();
        }
    }
}
// @codeCoverageIgnoreEnd

