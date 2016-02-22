<?php
 /**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Services
{

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
            $factory = new MasterFactory($this->getConfiguration());

            $factory->addFactory(new \Ganked\Services\Factories\ServiceClientFactory);
            $factory->addFactory(new \Ganked\Services\Factories\ControllerFactory());
            $factory->addFactory(new \Ganked\Services\Factories\BackendFactory());
            $factory->addFactory(new \Ganked\Services\Factories\RouterFactory());
            $factory->addFactory(new \Ganked\Skeleton\Factories\LoggerFactory());
            $factory->addFactory(new \Ganked\Skeleton\Factories\GatewayFactory());
            $factory->addFactory(new \Ganked\Skeleton\Factories\LoggerFactory());
            $factory->addFactory(new \Ganked\Skeleton\Factories\ApplicationFactory());

            return $factory;

        }

        /**
         * @return Router
         */
        private function buildRouter()
        {
            $router = new Router();

            $router->addRoute($this->getFactory()->createServiceRouter());
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
