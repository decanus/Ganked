<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton
{

    use Ganked\Skeleton\Exceptions\MapException;

    class Map
    {
        /**
         * @var array
         */
        private $data = [];

        /**
         * @param string $key
         *
         * @return bool
         */
        public function has($key)
        {
            return isset($this->data[$key]);
        }

        /**
         * @param string $key
         *
         * @return string
         * @throws MapException
         */
        public function get($key)
        {
            if (!$this->has($key)) {
                throw new MapException('Key "' . $key . '" not found');
            }

            return $this->data[$key];
        }

        /**
         * @param string $key
         * @param string $value
         *
         * @throws MapException
         */
        public function set($key, $value)
        {
            if ($this->has($key)) {
                throw new MapException('Key "' . $key . '" already exists');
            }

            $this->data[$key] = $value;
        }

        /**
         * @param string $key
         */
        public function remove($key)
        {
            unset($this->data[$key]);
        }

        /**
         * @return \ArrayIterator
         */
        public function getIterator()
        {
            return new \ArrayIterator($this->data);
        }
    }
}
