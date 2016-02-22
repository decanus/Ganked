<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Tasks
{

    use Ganked\Backend\Request;

    interface TaskInterface
    {
        /**
         * @param Request $request
         */
        public function run(Request $request);
    }
}
