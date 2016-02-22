<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Routers
{

    use Ganked\Skeleton\Controllers\AbstractPageController;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Models\JsonErrorPageModel;

    class JsonErrorRouter extends AbstractRouter
    {

        /**
         * @param AbstractRequest $request
         *
         * @return AbstractPageController
         */
        public function route(AbstractRequest $request)
        {
            $uri = $request->getUri();

            $model = new JsonErrorPageModel($uri);
            switch ($uri->getPath()) {
                case '/500':
                    $model->setResponseCode(500);
                    $model->setContent(['Internal Server Error']);
                    break;
                default:
                    $model->setResponseCode(404);
                    $model->setContent(['Not Found Error']);
            }

            return $this->getFactory()->createJsonErrorPageController($model);
        }
    }
}