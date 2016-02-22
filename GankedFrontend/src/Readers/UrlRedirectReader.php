<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Readers
{

    use Ganked\Library\Backends\FileBackend;

    class UrlRedirectReader
    {
        /**
         * @var FileBackend
         */
        private $fileBackend;

        /**
         * @var array
         */
        private $redirects;

        /**
         * @param FileBackend $fileBackend
         */
        public function __construct(FileBackend $fileBackend)
        {
            $this->fileBackend = $fileBackend;
        }

        /**
         * @param string $path
         *
         * @return bool
         */
        public function hasPermanentUrlRedirect($path)
        {
            $this->load();
            return isset($this->redirects[$path]);
        }

        /**
         * @param string $path
         *
         * @return string
         * @throws \OutOfBoundsException
         */
        public function getPermanentUrlRedirect($path)
        {
            if ($this->hasPermanentUrlRedirect($path)) {
                return $this->redirects[$path];
            }

            throw new \OutOfBoundsException('Redirect for path "' . $path . '" not found');
        }

        private function load()
        {
            if ($this->redirects !== null) {
                return;
            }

            $this->redirects = json_decode($this->fileBackend->load(__DIR__ . '/../../data/urlRewrites.json'), true);
        }
    }
}
