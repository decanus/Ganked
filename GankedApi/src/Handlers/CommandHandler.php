<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Handlers
{
    use Ganked\API\Models\ApiModel;
    use Ganked\Skeleton\Http\Request\AbstractRequest;

    class CommandHandler implements CommandHandlerInterface
    {

        /**
         * @param AbstractRequest $request
         * @param ApiModel        $model
         * @codeCoverageIgnore
         */
        public function execute(AbstractRequest $request, ApiModel $model)
        {
        }
    }
}
