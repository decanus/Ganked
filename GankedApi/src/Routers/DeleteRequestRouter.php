<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Routers
{
    use Ganked\API\Http\Request\DeleteRequest;
    use Ganked\API\Models\ApiModel;
    use Ganked\Skeleton\Controllers\AbstractPageController;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Routers\AbstractRouter;

    class DeleteRequestRouter extends AbstractRouter
    {

        /**
         * @param AbstractRequest $request
         *
         * @return AbstractPageController
         */
        public function route(AbstractRequest $request)
        {
            if (!$request instanceof DeleteRequest) {
                return;
            }

            $uri = $request->getUri();
            $path = $uri->getPath();

            if (preg_match('#^/favourites/([a-fA-f0-9]{24})/summoners$#', $path)) {
                return $this->getFactory()->createUnfavouriteSummonerController(new ApiModel($uri));
            }

            switch ($path) {
                case '/token':
                    return $this->getFactory()->createDeleteTokenController(new ApiModel($uri));
                default:
                    return $this->getFactory()->createErrorController();
            }
        }
    }
}
