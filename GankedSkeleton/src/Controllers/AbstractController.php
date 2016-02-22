<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Controllers
{

    use Ganked\Skeleton\Handlers\CommandHandlerInterface;
    use Ganked\Skeleton\Handlers\PostHandlerInterface;
    use Ganked\Skeleton\Handlers\PreHandlerInterface;
    use Ganked\Skeleton\Handlers\QueryHandlerInterface;
    use Ganked\Skeleton\Handlers\ResponseHandlerInterface;
    use Ganked\Skeleton\Handlers\TransformationHandlerInterface;
    use Ganked\Skeleton\Http\Request\RequestInterface;
    use Ganked\Skeleton\Http\Response\ResponseInterface;
    use Ganked\Skeleton\Models\AbstractModel;

    abstract class AbstractController implements ControllerInterface
    {

        /**
         * @var AbstractModel
         */
        private $model;

        /**
         * @var PreHandlerInterface
         */
        private $preHandler;

        /**
         * @var QueryHandlerInterface
         */
        private $queryHandler;

        /**
         * @var CommandHandlerInterface
         */
        private $commandHandler;

        /**
         * @var TransformationHandlerInterface
         */
        private $transformationHandler;

        /**
         * @var ResponseHandlerInterface
         */
        private $responseHandler;

        /**
         * @var PostHandlerInterface
         */
        private $postHandler;

        /**
         * @var ResponseInterface
         */
        private $response;

        /**
         * @param AbstractModel                  $model
         * @param PreHandlerInterface            $preHandler
         * @param QueryHandlerInterface          $queryHandler
         * @param CommandHandlerInterface        $commandHandler
         * @param TransformationHandlerInterface $transformationHandler
         * @param ResponseHandlerInterface       $responseHandler
         * @param PostHandlerInterface           $postHandler
         * @param ResponseInterface              $response
         */
        public function __construct(
            AbstractModel $model,
            PreHandlerInterface $preHandler,
            QueryHandlerInterface $queryHandler,
            CommandHandlerInterface $commandHandler,
            TransformationHandlerInterface $transformationHandler,
            ResponseHandlerInterface $responseHandler,
            PostHandlerInterface $postHandler,
            ResponseInterface $response
        )
        {
            $this->model = $model;
            $this->preHandler = $preHandler;
            $this->queryHandler = $queryHandler;
            $this->commandHandler = $commandHandler;
            $this->transformationHandler = $transformationHandler;
            $this->responseHandler = $responseHandler;
            $this->postHandler = $postHandler;
            $this->response = $response;
        }

        /**
         * @param RequestInterface $request
         *
         * @return ResponseInterface
         */
        public function execute(RequestInterface $request)
        {
            $this->preHandler->execute($request, $this->model);
            $this->queryHandler->execute($request, $this->model);
            $this->commandHandler->execute($request, $this->model);

            if (!$this->model->hasRedirect()) {
               $this->response->setBody($this->transformationHandler->execute($this->model));
            }

            $this->responseHandler->execute($this->response, $this->model);
            $this->postHandler->execute($this->model);

            return $this->response;
        }
    }
}
