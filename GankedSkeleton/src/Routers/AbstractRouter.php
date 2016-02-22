<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Routers
{

    use Ganked\Skeleton\Factories\MasterFactory;

    abstract class AbstractRouter implements RouterInterface
    {
        /**
         * @var MasterFactory
         */
        private $factory;

        /**
         * @param MasterFactory $factory
         */
        public function __construct(MasterFactory $factory)
        {
            $this->factory = $factory;
        }

        /**
         * @return MasterFactory
         */
        protected function getFactory()
        {
            return $this->factory;
        }
    }
}
