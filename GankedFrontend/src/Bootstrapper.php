<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

// @codeCoverageIgnoreStart
namespace Ganked\Frontend
{

    use Ganked\Library\DataPool\RedisBackend;
    use Ganked\Skeleton\Backends\Streams\TemplatesStreamWrapper;
    use Ganked\Skeleton\Bootstrapper\AbstractBootstrapper;
    use Ganked\Skeleton\Configuration;
    use Ganked\Skeleton\ErrorHandlers\DevelopmentErrorHandler;
    use Ganked\Skeleton\ErrorHandlers\ProductionErrorHandler;
    use Ganked\Skeleton\Factories\MasterFactory;
    use Ganked\Skeleton\Factories\SessionFactory;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Http\Request\GetRequest;
    use Ganked\Skeleton\Http\Request\PostRequest;
    use Ganked\Skeleton\Routers\Router;
    use Ganked\Skeleton\Session\Session;

    class Bootstrapper extends AbstractBootstrapper
    {
        /**
         * @var Router
         */
        private $router;

        /**
         * @var Configuration
         */
        private $configuration;

        /**
         * @var Session
         */
        private $session;

        /**
         * @var SessionFactory
         */
        private $sessionFactory;

        protected function bootstrap()
        {
            $this->registerStreams();
            $this->buildErrorHandler();
            $this->router = $this->buildRouter();
        }

        protected function buildSession()
        {
            $redisBackend = new RedisBackend(
                new \Redis(),
                $this->getConfiguration()->get('session-redisHost'),
                $this->getConfiguration()->get('session-redisPort'),
                $this->getConfiguration()->get('session-redisPassword')
            );

            $this->sessionFactory = new SessionFactory($redisBackend);

            $this->session = $this->sessionFactory->createSession();
            $this->session->load($this->getRequest());
        }

        /**
         * @return Session
         */
        private function getSession()
        {
            return $this->session;
        }

        /**
         * @return bool
         */
        private function isDevelopmentMode()
        {
            return $this->configuration->get('isDevelopmentMode') == 'true';
        }

        /**
         * @return Configuration
         */
        public function getConfiguration()
        {
            if ($this->configuration === null) {
                $this->configuration = new Configuration(__DIR__ . '/../config/system.ini');
            }

            return $this->configuration;
        }

        /**
         * @return Router
         */
        public function getRouter()
        {
            return $this->router;
        }


        private function registerStreams()
        {
            TemplatesStreamWrapper::setUp(__DIR__ . '/../data/templates');
        }


        /**
         * @return MasterFactory
         * @throws \Exception
         */
        protected function buildFactory()
        {
            $factory = new MasterFactory($this->getConfiguration());

            $factory->addFactory($this->sessionFactory);
            $factory->addFactory(new \Ganked\Frontend\Factories\ControllerFactory);
            $factory->addFactory(new \Ganked\Frontend\Factories\RendererFactory);
            $factory->addFactory(new \Ganked\Frontend\Factories\RouterFactory($this->getSession()->getSessionData()));
            $factory->addFactory(new \Ganked\Frontend\Factories\ReaderFactory);
            $factory->addFactory(new \Ganked\Skeleton\Factories\BackendFactory);
            $factory->addFactory(new \Ganked\Frontend\Factories\QueryFactory($this->getSession()->getSessionData()));
            $factory->addFactory(new \Ganked\Frontend\Factories\HandlerFactory);
            $factory->addFactory(new \Ganked\Frontend\Factories\MapperFactory);
            $factory->addFactory(new \Ganked\Frontend\Factories\GatewayFactory);
            $factory->addFactory(new \Ganked\Skeleton\Factories\TransformationFactory);
            $factory->addFactory(new \Ganked\Skeleton\Factories\LoggerFactory);
            $factory->addFactory(new \Ganked\Skeleton\Factories\ApplicationFactory);
            $factory->addFactory(new \Ganked\Frontend\Factories\LocatorFactory);
            $factory->addFactory(new \Ganked\Frontend\Factories\CommandFactory($this->getSession()->getSessionData()));

            return $factory;

        }

        /**
         * @return Router
         */
        private function buildRouter()
        {
            $router = new Router();

            $router->addRoute($this->getFactory()->createSteamLoginRouter());
            $router->addRoute($this->getFactory()->createStaticPageRouter());
            $router->addRoute($this->getFactory()->createUserPageRouter());
            $router->addRoute($this->getFactory()->createRedirectRouter());
            $router->addRoute($this->getFactory()->createCounterStrikePageRouter());
            $router->addRoute($this->getFactory()->createSearchPageRouter());
            $router->addRoute($this->getFactory()->createAccountPageRouter());
            $router->addRoute($this->getFactory()->createLeagueOfLegendsPageRouter());
            $router->addRoute($this->getFactory()->createErrorPageRouter());

            return $router;
        }

        /**
         * @throws \InvalidArgumentException
         * @return AbstractRequest
         */
        protected function buildRequest()
        {
            if (!isset($_SERVER['REQUEST_METHOD'])) {
                throw new \InvalidArgumentException('Missing REQUEST_METHOD');
            }

            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    return new GetRequest($_GET, $_SERVER, $_COOKIE);
                case 'POST':
                    return new PostRequest($_POST, $_SERVER, $_COOKIE);
                default:
                    throw new \InvalidArgumentException($_SERVER['REQUEST_METHOD'] . ' request method not supported');
            }
        }

        private function buildErrorHandler()
        {

            if ($this->isDevelopmentMode()) {
                $errorHandler = new DevelopmentErrorHandler();
            } else {
                $errorHandler = new ProductionErrorHandler();
                $errorHandler->setLogger($this->getFactory()->createLoggers());
            }

            $errorHandler->register();
        }
    }
}
// @codeCoverageIgnoreEnd
