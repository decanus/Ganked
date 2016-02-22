<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Http\Request
{

    use Ganked\Library\ValueObjects\UploadedFile;

    class PostRequest extends AbstractRequest
    {
        /**
         * @var array
         */
        private $files;

        /**
         * @param array $parameters
         * @param array $server
         * @param array $cookies
         * @param array $files
         */
        public function __construct($parameters = [], $server = [], $cookies = [], $files = [])
        {
            parent::__construct($parameters, $server, $cookies);
            $this->files = $files;
        }

        /**
         * @return bool
         */
        public function hasFiles()
        {
            return !empty($this->files);
        }

        /**
         * @return array
         */
        public function getFiles()
        {
            return $this->files;
        }

        /**
         * @param string $name
         *
         * @return bool
         */
        public function hasFile($name)
        {
            return isset($this->files[$name]) && $this->files[$name]['error'] === 0;
        }

        /**
         * @param string $name
         *
         * @return UploadedFile
         * @throws \InvalidArgumentException
         */
        public function getFile($name)
        {
            if (!$this->hasFile($name)) {
                throw new \InvalidArgumentException('File "' . $name . '" does not exist');
            }

            return new UploadedFile($this->files[$name]);
        }

        /**
         * @return array
         * @throws \Exception
         */
        public function getFileNames()
        {
            if (!$this->hasFiles()) {
                throw new \Exception('Request has no files');
            }

            return array_keys($this->getFiles());
        }

    }
}
