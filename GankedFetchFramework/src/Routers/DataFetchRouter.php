<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Fetch\Routers
{

    use Ganked\Skeleton\Controllers\AbstractPageController;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Routers\AbstractRouter;

    class DataFetchRouter extends AbstractRouter
    {
        /**
         * @param AbstractRequest $request
         *
         * @return AbstractPageController
         */
        public function route(AbstractRequest $request)
        {
            $uri = $request->getUri();

            switch ($uri->getPath()) {
                case '/fetch/getStream':
                    return $this->getFactory()->createLandingPageStreamController();
                case '/fetch/match':
                    return $this->getFactory()->createFetchMatchController();
            }
        }
    }
}
