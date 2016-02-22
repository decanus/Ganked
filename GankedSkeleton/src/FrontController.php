<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

// @codeCoverageIgnoreStart
namespace Ganked\Skeleton
{

    use Ganked\Skeleton\Bootstrapper\AbstractBootstrapper;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Http\Response\AbstractResponse;

    class FrontController
    {
        /**
         * @var AbstractBootstrapper
         */
        private $bootstrapper;

        /**
         * @param AbstractBootstrapper $bootstrapper
         */
        public function __construct(AbstractBootstrapper $bootstrapper)
        {
            $this->bootstrapper = $bootstrapper;
        }

        /**
         * @return AbstractResponse
         */
        public function run()
        {
            $request = $this->bootstrapper->getRequest();
            $this->theGodFunction($request);
            $controller = $this->bootstrapper->getRouter()->route($request);
            $result = $controller->execute($request);
            return $result;
        }

        /**
         * @param \Ganked\Skeleton\Http\Request\AbstractRequest $request
         */
        private function theGodFunction(AbstractRequest $request)
        {
            $userAgent = $request->getUserAgent();
            if (preg_match('/MSI/i', $userAgent) && $request->getUri()->getPath() !== '/no-ie') {
                header('Location: http://' . $request->getUri()->getHost() . '/no-ie');
                exit;
            }

            if (strpos($userAgent, 'Trident/6.0;') !== false && $request->getUri()->getPath() !== '/no-ie') {
                header('Location: http://' . $request->getUri()->getHost() . '/no-ie');
                exit;
            }

            if (strpos($userAgent, 'Trident/7.0;') !== false && $request->getUri()->getPath() !== '/no-ie') {
                header('Location: http://' . $request->getUri()->getHost() . '/no-ie');
                exit;
            }
        }
    }
}
// @codeCoverageIgnoreEnd
