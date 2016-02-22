<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Bootstrapper
{

    use Ganked\Skeleton\Factories\MasterFactory;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Routers\AbstractRouter;

    abstract class AbstractBootstrapper
    {
        /**
         * @var MasterFactory
         */
        private $factory;

        /**
         * @var AbstractRequest
         */
        private $request;

        public function __construct()
        {
            $this->request = $this->buildRequest();
            $this->buildSession();
            $this->factory = $this->buildFactory();
            $this->bootstrap();
        }

        /**
         * @return MasterFactory
         */
        abstract protected function buildFactory();

        abstract protected function bootstrap();

        abstract protected function buildSession();

        /**
         * @return AbstractRequest
         */
        abstract protected function buildRequest();

        /**
         * @return AbstractRequest
         */
        public function getRequest()
        {
            return $this->request;
        }

        /**
         * @return MasterFactory
         */
        protected function getFactory()
        {
            return $this->factory;
        }

        /**
         * @return AbstractRouter
         */
        abstract public function getRouter();
    }
}
