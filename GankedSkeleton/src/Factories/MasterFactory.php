<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Factories
{

    use Ganked\Skeleton\Configuration;

    class MasterFactory
    {
        /**
         * @var array (name => AbstractFactory)
         */
        private $methods = [];

        /**
         * @var Configuration
         */
        private $configuration;

        /**
         * @param Configuration $configuration
         */
        public function __construct(Configuration $configuration)
        {
            $this->configuration = $configuration;
        }

        /**
         * @param AbstractFactory $factory
         *
         * @throws \Exception
         */
        public function addFactory(AbstractFactory $factory)
        {
            $rfc = new \ReflectionClass($factory);
            $found = false;
            foreach ($rfc->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                $name = $method->getName();
                if (strpos($name, 'create') === 0) {
                    $this->setMethod($name, $factory);
                    $found = true;
                }
            }

            if (!$found) {
                throw new \Exception('Factory "' . get_class($factory) . '" does not have any methods');
            }

            $factory->register($this);
        }

        /**
         * @param $name
         * @param $arguments
         *
         * @return mixed
         * @throws \Exception
         */
        public function __call($name, $arguments)
        {
            if (!$this->hasMethod($name)) {
                throw new \Exception('No factory found for "' . $name . '" method');
            }

            $object = call_user_func_array([$this->getMethod($name), $name], $arguments);

            if ($object instanceof \Ganked\Library\Logging\LoggerAware) {
                $object->setLogger($this->createLoggers());
            }

            return $object;
        }

        /**
         * @param $name
         *
         * @return bool
         */
        private function hasMethod($name)
        {
            return isset($this->methods[$name]);
        }

        /**
         * @param $name
         *
         * @return AbstractFactory
         */
        private function getMethod($name)
        {
            return $this->methods[$name];
        }

        /**
         * @param $name
         * @param $factory
         *
         * @throws \Exception
         */
        private function setMethod($name, AbstractFactory $factory)
        {
            $this->methods[$name] = $factory;
        }

        /**
         * @return Configuration
         */
        public function getConfiguration()
        {
            return $this->configuration;
        }
    }
}
