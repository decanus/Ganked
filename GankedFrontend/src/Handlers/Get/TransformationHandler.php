<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Handlers\Get
{

    use Ganked\Frontend\Renderers\AbstractPageRenderer;
    use Ganked\Skeleton\Handlers\TransformationHandlerInterface;
    use Ganked\Skeleton\Models\AbstractModel;

    class TransformationHandler implements TransformationHandlerInterface
    {
        /**
         * @var AbstractPageRenderer
         */
        private $renderer;

        /**
         * @param AbstractPageRenderer $renderer
         */
        public function __construct(AbstractPageRenderer $renderer)
        {
            $this->renderer = $renderer;
        }

        /**
         * @param AbstractModel $model
         *
         * @return string
         */
        public function execute(AbstractModel $model)
        {
            return $this->renderer->render($model);
        }
    }
}
