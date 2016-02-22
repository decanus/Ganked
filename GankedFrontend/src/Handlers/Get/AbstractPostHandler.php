<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Handlers\Get
{

    use Ganked\Skeleton\Commands\WriteSessionCommand;
    use Ganked\Skeleton\Handlers\PostHandlerInterface;
    use Ganked\Skeleton\Models\AbstractModel;

    abstract class AbstractPostHandler implements PostHandlerInterface
    {
        /**
         * @var WriteSessionCommand
         */
        private $writeSessionCommand;

        /**
         * @var AbstractModel
         */
        private $model;

        /**
         * @param WriteSessionCommand $writeSessionCommand
         */
        public function __construct(WriteSessionCommand $writeSessionCommand)
        {
            $this->writeSessionCommand = $writeSessionCommand;
        }

        /**
         * @param AbstractModel $model
         */
        public function execute(AbstractModel $model)
        {
            $this->model = $model;
            $this->writeSessionCommand->execute();
            $this->doExecute();
        }

        abstract protected function doExecute();
    }
}
