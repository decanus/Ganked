<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Routers
{

    use Ganked\Skeleton\Controllers\AbstractPageController;
    use Ganked\Skeleton\Http\Request\AbstractRequest;

    class Router implements RouterInterface
    {
        /**
         * @var RouterInterface[]
         */
        private $routes = [];

        /**
         * @param RouterInterface $route
         */
        public function addRoute(RouterInterface $route)
        {
            $this->routes[] = $route;
        }

        /**
         * @param AbstractRequest $request
         *
         * @return AbstractPageController
         * @throws \Exception
         */
        public function route(AbstractRequest $request)
        {
            foreach ($this->routes as $route) {
                $result = $route->route($request);

                if ($result !== null) {
                    return $result;
                }
            }

            throw new \Exception('No route found for "' . $request->getUri()->getPath() . '"');
        }
    }
}
