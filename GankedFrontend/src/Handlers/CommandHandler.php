<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Handlers
{

    use Ganked\Skeleton\Handlers\CommandHandlerInterface;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Models\AbstractModel;

    class CommandHandler implements CommandHandlerInterface
    {

        /**
         * @param AbstractRequest $request
         * @param AbstractModel   $model
         */
        public function execute(AbstractRequest $request, AbstractModel $model)
        {
        }
    }
}
