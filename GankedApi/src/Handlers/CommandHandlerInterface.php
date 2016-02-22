<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Handlers
{
    use Ganked\API\Models\ApiModel;
    use Ganked\Skeleton\Http\Request\AbstractRequest;

    interface CommandHandlerInterface
    {
        /**
         * @param AbstractRequest $request
         * @param ApiModel        $model
         */
        public function execute(AbstractRequest $request, ApiModel $model);
    }
}
