<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Handlers
{
    use Ganked\API\Models\ApiModel;

    class ResponseHandler extends AbstractResponseHandler
    {

        /**
         * @param ApiModel $model
         *
         * @return array
         */
        protected function handleResponse(ApiModel $model)
        {
            return $this->handleObject($model->getData(), $model->getObjectType());
        }
    }
}
