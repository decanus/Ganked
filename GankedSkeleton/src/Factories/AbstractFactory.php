<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Factories
{
    abstract class AbstractFactory
    {
        /**
         * @var MasterFactory
         */
        private $masterFactory;

        /**
         * @param MasterFactory $masterFactory
         */
        public function register(MasterFactory $masterFactory)
        {
            $this->masterFactory = $masterFactory;
        }

        /**
         * @return MasterFactory
         */
        protected function getMasterFactory()
        {
            return $this->masterFactory;
        }
    }
}
