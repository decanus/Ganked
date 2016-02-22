<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Fetch\Handlers\DataFetch
{

    use Ganked\Skeleton\Http\Request\AbstractRequest;

    interface DataFetchHandlerInterface
    {
        /**
         * @param AbstractRequest $request
         *
         * @return array
         */
        public function execute(AbstractRequest $request);
    }
}
