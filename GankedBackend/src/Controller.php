<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend
{
    class Controller
    {
        /**
         * @var Bootstrapper
         */
        private $bootstrapper;

        /**
         * @param Bootstrapper $bootstrapper
         */
        public function __construct(Bootstrapper $bootstrapper)
        {
            $this->bootstrapper = $bootstrapper;
        }

        public function run()
        {
            $request = $this->bootstrapper->getRequest();
            $this->bootstrapper->getFactory()->createTaskLocator()->locate($request)->run($request);
        }
    }
}
