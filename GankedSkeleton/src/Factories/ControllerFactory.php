<?php
 /**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Factories
{

    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Skeleton\Http\Response\JsonResponse;
    use Ganked\Skeleton\Models\AbstractPageModel;

    class ControllerFactory extends AbstractFactory
    {
        /**
         * @param \Ganked\Skeleton\Models\JsonErrorPageModel $model
         *
         * @return \Ganked\Skeleton\Controllers\JsonErrorPageController
         */
        public function createJsonErrorPageController(\Ganked\Skeleton\Models\JsonErrorPageModel $model)
        {
            return new \Ganked\Skeleton\Controllers\JsonErrorPageController(
                new JsonResponse,
                $model
            );
        }

        /**
         * @param string $type
         * @param Uri    $uri
         *
         * @return AbstractPageModel
         */
        protected function createModel($type, Uri $uri)
        {
            /**
             * @var $model AbstractPageModel
             */
            $model = new $type($uri);
            $model->setFetchAccountFromSessionQuery($this->getMasterFactory()->createFetchAccountFromSessionQuery());
            return $model;
        }
    }
}