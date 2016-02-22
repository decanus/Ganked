<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend
{

    use Ganked\Skeleton\Map;

    class Request
    {
        /**
         * @var Map
         */
        private $parameters;

        /**
         * @param $parameters
         */
        public function __construct($parameters)
        {
            $this->parameters = new Map;
            $this->parseParameters($parameters);
        }

        /**
         * @param array $parameters
         *
         * @throws \Ganked\Skeleton\Exceptions\MapException
         */
        private function parseParameters($parameters)
        {
            if (isset($parameters[1])) {
                $this->parameters->set('task', $parameters[1]);

                unset($parameters[0]);
                unset($parameters[1]);

                foreach ($parameters as $parameter) {
                    $key = substr($parameter, 2, (strpos($parameter, '=') - 2));
                    $value = substr($parameter, (strpos($parameter, '=') + 1));

                    $this->parameters->set($key, $value);
                }
            }
        }

        /**
         * @return Map
         */
        public function getParameters()
        {
            return $this->parameters;
        }

        /**
         * @return string
         */
        public function getTask()
        {
            return $this->parameters->get('task');
        }

        /**
         * @param string $key
         *
         * @return bool
         */
        public function hasParameter($key)
        {
            return $this->parameters->has($key);
        }

        /**
         * @param $key
         *
         * @return mixed
         * @throws \Exception
         */
        public function getParameter($key)
        {
            if (!$this->hasParameter($key)) {
                throw new \Exception('Parameter "' . $key . '" not found');
            }

            return $this->parameters->get($key);
        }
    }
}
