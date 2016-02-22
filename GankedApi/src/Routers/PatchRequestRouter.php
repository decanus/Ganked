<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Routers
{
    use Ganked\API\Http\Request\PatchRequest;
    use Ganked\API\Models\ApiModel;
    use Ganked\Skeleton\Controllers\AbstractPageController;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Routers\AbstractRouter;

    class PatchRequestRouter extends AbstractRouter
    {
        /**
         * @param AbstractRequest $request
         *
         * @return AbstractPageController
         */
        public function route(AbstractRequest $request)
        {
            if (!$request instanceof PatchRequest) {
                return;
            }

            $uri = $request->getUri();
            $path = $uri->getPath();

            if (preg_match('#^/users/([a-fA-f0-9]{24})$#', $path)) {
                return $this->getFactory()->createUpdateUserController(new ApiModel($uri));
            }
        }
    }
}
