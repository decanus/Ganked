<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Routers
{

    use Ganked\Frontend\ParameterObjects\RedirectControllerParameterObject;
    use Ganked\Frontend\Readers\UrlRedirectReader;
    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Skeleton\Controllers\AbstractPageController;
    use Ganked\Skeleton\Factories\MasterFactory;
    use Ganked\Skeleton\Http\Redirect\RedirectToPath;
    use Ganked\Skeleton\Http\Redirect\RedirectToUri;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Http\StatusCodes\MovedPermanently;
    use Ganked\Skeleton\Http\StatusCodes\MovedTemporarily;
    use Ganked\Skeleton\Routers\AbstractRouter;

    class RedirectRouter extends AbstractRouter
    {
        /**
         * @var UrlRedirectReader
         */
        private $reader;

        /**
         * @param MasterFactory     $factory
         * @param UrlRedirectReader $urlRedirectReader
         */
        public function __construct(MasterFactory $factory, UrlRedirectReader $urlRedirectReader)
        {
            parent::__construct($factory);
            $this->reader = $urlRedirectReader;
        }

        /**
         * @param AbstractRequest $request
         *
         * @return AbstractPageController
         * @throws \OutOfBoundsException
         */
        public function route(AbstractRequest $request)
        {
            $uri = $request->getUri();
            $path = $uri->getPath();

            switch ($path) {
                case '/account/verify':
                    return $this->getFactory()->createRedirectController(new RedirectControllerParameterObject($uri, new RedirectToUri(new Uri('https://post.ganked.net/action/verify' . $uri->getQuery()), new MovedTemporarily)));
                case '/account/resend-verification':
                    return $this->getFactory()->createRedirectController(new RedirectControllerParameterObject($uri, new RedirectToUri(new Uri('https://post.ganked.net/action/resend-verification' . $uri->getQuery()), new MovedTemporarily)));
            }

            if ($this->reader->hasPermanentUrlRedirect($path)) {
                return $this->getFactory()->createRedirectController(new RedirectControllerParameterObject($uri, new RedirectToPath($uri, new MovedPermanently, $this->reader->getPermanentUrlRedirect($path))));
            }
        }
    }
}
