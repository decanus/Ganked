<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Readers
{
    use Ganked\Library\Backends\FileBackend;

    class TokenReader
    {
        /**
         * @var FileBackend
         */
        private $fileBackend;

        /**
         * @var array
         */
        private $tokens;

        /**
         * @param FileBackend $fileBackend
         */
        public function __construct(FileBackend $fileBackend)
        {
            $this->fileBackend = $fileBackend;
        }

        /**
         * @param string $token
         *
         * @return bool
         */
        public function hasToken($token)
        {
            $this->load();
            return isset($this->tokens[$token]);
        }

        private function load()
        {
            if ($this->tokens !== null) {
                return;
            }

            $this->tokens = json_decode($this->fileBackend->load(__DIR__ . '/../../data/tokens.json'), true);
        }

    }
}
