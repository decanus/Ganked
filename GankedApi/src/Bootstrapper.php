<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

// @codeCoverageIgnoreStart
namespace Ganked\API
{
    use Ganked\API\Http\Request\DeleteRequest;
    use Ganked\API\Http\Request\PatchRequest;
    use Ganked\API\Http\Request\PutRequest;
    use Ganked\Skeleton\Bootstrapper\AbstractBootstrapper;
    use Ganked\Skeleton\Configuration;
    use Ganked\Skeleton\ErrorHandlers\DevelopmentErrorHandler;
    use Ganked\Skeleton\ErrorHandlers\ProductionErrorHandler;
    use Ganked\Skeleton\Factories\MasterFactory;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Http\Request\GetRequest;
    use Ganked\Skeleton\Http\Request\PostRequest;
    use Ganked\Skeleton\Routers\Router;

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

        protected function bootstrap()
        {
            $this->buildErrorHandler();
            $this->router = $this->buildRouter();
        }

        protected function buildSession()
        {
        }

        /**
         * @return bool
         * @throws \Exception
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
         * @throws \Exception
         */
        protected function buildFactory()
        {
            $factory = new MasterFactory($this->getConfiguration());


            $factory->addFactory(new \Ganked\API\Factories\ControllerFactory);
            $factory->addFactory(new \Ganked\Skeleton\Factories\ApplicationFactory);
            $factory->addFactory(new \Ganked\API\Factories\RouterFactory);
            $factory->addFactory(new \Ganked\API\Factories\HandlerFactory);
            $factory->addFactory(new \Ganked\API\Factories\ReaderFactory);
            $factory->addFactory(new \Ganked\API\Factories\ServiceFactory);
            $factory->addFactory(new \Ganked\API\Factories\QueryFactory);
            $factory->addFactory(new \Ganked\API\Factories\BackendFactory);
            $factory->addFactory(new \Ganked\API\Factories\CommandFactory);
            $factory->addFactory(new \Ganked\Skeleton\Factories\LoggerFactory);
            $factory->addFactory(new \Ganked\Skeleton\Factories\GatewayFactory);

            return $factory;

        }

        /**
         * @return Router
         */
        private function buildRouter()
        {
            $router = new Router();

            $router->addRoute($this->getFactory()->createGetRequestRouter());
            $router->addRoute($this->getFactory()->createPostRequestRouter());
            $router->addRoute($this->getFactory()->createDeleteRequestRouter());
            $router->addRoute($this->getFactory()->createPatchRequestRouter());

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
                case 'PUT':
                    return new PutRequest($_GET, $_SERVER, $_COOKIE);
                case 'DELETE':
                    return new DeleteRequest($_GET, $_SERVER, $_COOKIE);
                case 'PATCH':
                    return new PatchRequest(json_decode(file_get_contents('php://input'), true), $_SERVER, $_COOKIE);
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
