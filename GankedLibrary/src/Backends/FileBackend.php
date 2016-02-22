<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\Backends
{
    class FileBackend 
    {
        /**
         * @param string $path
         *
         * @return string
         * @throws \Exception
         */
        public function load($path)
        {
            if (!file_exists($path)) {
                throw new \Exception('File "' . $path . '" not found');
            }

            $handle = fopen($path, 'r');
            $content = stream_get_contents($handle, filesize($path));
            fclose($handle);

            return $content;
        }

        /**
         * @param string $path
         *
         * @return bool
         */
        public function exists($path)
        {
            return file_exists($path);
        }

        // @codeCoverageIgnoreStart
        /**
         * @param $path
         *
         * @return int
         */
        public function getFileModifiedTime($path)
        {
            return filemtime($path);
        }

        /**
         * @param string $filename
         * @param string $content
         *
         * @throws \Exception
         */
        public function save($filename, $content)
        {
            if ($this->exists($filename)) {
                $this->delete($filename);
            }

            $result = file_put_contents($filename, $content);

            if ($result === false) {
                throw new \Exception('Could not save to file "' . $filename . '"');
            }
        }

        public function delete($filename)
        {
            if (!$this->exists($filename)) {
                return;
            }

            return unlink($filename);
        }

        /**
         * @param string $dirName
         * @param int    $chmod
         */
        public function makeDir($dirName, $chmod = 0755)
        {
            mkdir($dirName, $chmod, true);
        }
        // @codeCoverageIgnoreEnd
    }
}
