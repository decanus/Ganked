<?php
/**
* Copyright (c) Ganked 2015
* All rights reserved.
*/
namespace Ganked\Post\Handlers
{

    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Models\AbstractModel;

    interface HandlerInterface
    {
        /**
         * @param AbstractModel   $model
         * @param AbstractRequest $request
         *
         * @return array
         */
        public function execute(AbstractModel $model, AbstractRequest $request);
    }
}
