<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */


// @codeCoverageIgnoreStart
namespace Ganked\Post
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
                $this->getConfiguration()->get('redisHost'),
                $this->getConfiguration()->get('redisPort'),
                $this->getConfiguration()->get('redisPassword')
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

        private function registerStreams()
        {
            TemplatesStreamWrapper::setUp(__DIR__ . '/../data/templates');
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

        /**
         * @return MasterFactory
         */
        protected function buildFactory()
        {
            $sessionData = $this->getSession()->getSessionData();
            $factory = new MasterFactory($this->getConfiguration());
            $factory->addFactory(new \Ganked\Post\Factories\BackendFactory);
            $factory->addFactory(new \Ganked\Post\Factories\QueryFactory($sessionData));
            $factory->addFactory(new \Ganked\Post\Factories\CommandFactory($sessionData));
            $factory->addFactory(new \Ganked\Post\Factories\ControllerFactory);
            $factory->addFactory(new \Ganked\Post\Factories\MailFactory);
            $factory->addFactory(new \Ganked\Post\Factories\RouterFactory);
            $factory->addFactory(new \Ganked\Post\Factories\HandlerFactory($sessionData));
            $factory->addFactory(new \Ganked\Skeleton\Factories\GatewayFactory);
            $factory->addFactory(new \Ganked\Skeleton\Factories\LoggerFactory);
            $factory->addFactory(new \Ganked\Skeleton\Factories\ApplicationFactory);
            $factory->addFactory($this->sessionFactory);
            return $factory;

        }

        /**
         * @return Router
         */
        private function buildRouter()
        {
            $router = new Router();
            $router->addRoute($this->getFactory()->createPostRequestRouter());
            $router->addRoute($this->getFactory()->createJsonErrorRouter());
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
