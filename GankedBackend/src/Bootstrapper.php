<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

// @codeCoverageIgnoreStart
namespace Ganked\Backend
{

    use Ganked\Backend\Backends\Stream\PagesStreamWrapper;
    use Ganked\Skeleton\Bootstrapper\AbstractBootstrapper;
    use Ganked\Skeleton\Configuration;
    use Ganked\Skeleton\ErrorHandlers\DevelopmentErrorHandler;
    use Ganked\Skeleton\Factories\MasterFactory;
    use Ganked\Skeleton\Routers\AbstractRouter;

    class Bootstrapper extends AbstractBootstrapper
    {
        /**
         * @var array
         */
        private $parameters;

        /**
         * @var Configuration
         */
        private $configuration;

        /**
         * @var Request
         */
        private $request;

        /**
         * @param array $parameters
         */
        public function __construct($parameters)
        {
            $this->parameters = $parameters;
            (new DevelopmentErrorHandler())->register();

            parent::__construct();
        }

        /**
         * @return MasterFactory
         * @throws \Exception
         */
        protected function buildFactory()
        {
            $factory = new MasterFactory($this->getConfiguration());
            $factory->addFactory(new \Ganked\Backend\Factories\BuilderFactory);
            $factory->addFactory(new \Ganked\Skeleton\Factories\ApplicationFactory);
            $factory->addFactory(new \Ganked\Backend\Factories\TaskFactory);
            $factory->addFactory(new \Ganked\Backend\Factories\LocatorFactory);
            $factory->addFactory(new \Ganked\Backend\Factories\BackendFactory);
            $factory->addFactory(new \Ganked\Backend\Factories\RendererFactory);
            $factory->addFactory(new \Ganked\Backend\Factories\MapperFactory);
            $factory->addFactory(new \Ganked\Backend\Factories\WriterFactory);
            $factory->addFactory(new \Ganked\Skeleton\Factories\LoggerFactory);
            $factory->addFactory(new \Ganked\Skeleton\Factories\TransformationFactory);
            $factory->addFactory(new \Ganked\Skeleton\Factories\GatewayFactory);

            return $factory;
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

        protected function bootstrap()
        {
            $this->request = $this->buildRequest();
            $this->registerStreams();
        }

        private function registerStreams()
        {
            PagesStreamWrapper::setUp(__DIR__ . '/../../GankedTemplates/templates/');
        }

        /**
         * @return Request
         * @throws \InvalidArgumentException
         */
        protected function buildRequest()
        {
            if (!isset($this->parameters[1])) {
                throw new \InvalidArgumentException('Please enter a task');
            }

            $request = new Request($this->parameters);
            return $request;
        }

        /**
         * @return MasterFactory
         */
        public function getFactory()
        {
            return parent::getFactory();
        }

        /**
         * @return Request
         */
        public function getRequest()
        {
            return $this->request;
        }

        /**
         * @return AbstractRouter
         */
        public function getRouter()
        {
        }

        protected function buildSession()
        {
        }
    }
}
// @codeCoverageIgnoreEnd
