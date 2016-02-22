<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Backends\Streams
{
    abstract class AbstractStreamWrapper
    {
        /**
         * @var string
         */
        protected static $protocol;

        /**
         * @var string
         */
        protected static $base;

        /**
         * @var
         */
        private $filePointer;

        /**
         * @param string $path
         */
        public static function setUp($path)
        {
            static::$base = $path;
            stream_register_wrapper(static::$protocol, get_called_class());
        }

        public static function tearDown()
        {
            stream_wrapper_unregister(static::$protocol);
        }

        /**
         * @param string $path
         *
         * @return string
         */
        private function buildPath($path)
        {
            $uri = parse_url($path);
            $filePath = static::$base;

            if (isset($uri['host'])) {
                $filePath .= '/' . $uri['host'];
            }

            if (isset($uri['path'])) {
                $filePath .= $uri['path'];
            }

            return $filePath;
        }

        /**
         * @param string $path
         * @param $flags
         *
         * @return array|bool
         */
        public function url_stat($path, $flags)
        {
            $uri = $this->buildPath($path);

            if (!file_exists($uri)) {
                return false;
            }

            return stat($uri);
        }

        /**
         * @param $count
         *
         * @return string
         */
        public function stream_read($count)
        {
            return fread($this->filePointer, $count);
        }

        /**
         * @return bool
         */
        public function stream_eof()
        {
            return feof($this->filePointer);
        }

        /**
         * @param $path
         * @param $mode
         * @param $options
         * @param $opened_path
         *
         * @return bool
         */
        public function stream_open($path, $mode, $options, &$opened_path)
        {
            $this->filePointer = fopen($this->buildPath($path), $mode, $options);
            return $this->filePointer !== false;
        }

    }
}
