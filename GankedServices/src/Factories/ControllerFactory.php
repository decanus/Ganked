<?php
 /**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Services\Factories
{

    use Ganked\Skeleton\Http\Response\JsonResponse;

    class ControllerFactory extends \Ganked\Skeleton\Factories\ControllerFactory
    {
        /**
         * @param \Ganked\Services\Models\ServiceModel $model
         *
         * @return \Ganked\Services\Controllers\SlackController
         */
        public function createSlackController(\Ganked\Services\Models\ServiceModel $model)
        {
            return new \Ganked\Services\Controllers\SlackController(
                new JsonResponse(),
                $model,
                $this->getMasterFactory()->createSlackBackend()
            );
        }

        /**
         * @param \Ganked\Services\Models\ServiceModel $model
         *
         * @return \Ganked\Services\Controllers\ServiceClientController
         */
        public function createTwitchServiceClientController(\Ganked\Services\Models\ServiceModel $model)
        {
            return new \Ganked\Services\Controllers\ServiceClientController(
                new JsonResponse(),
                $model,
                $this->getMasterFactory()->createTwitchServiceClient()
            );
        }

        /**
         * @param \Ganked\Services\Models\ServiceModel $model
         *
         * @return \Ganked\Services\Controllers\ServiceClientController
         */
        public function createLoLServiceClientController(\Ganked\Services\Models\ServiceModel $model)
        {
            return new \Ganked\Services\Controllers\ServiceClientController(
                new JsonResponse(),
                $model,
                $this->getMasterFactory()->createLoLServiceClient()
            );
        }

        /**
         * @param \Ganked\Services\Models\ServiceModel $model
         *
         * @return \Ganked\Services\Controllers\ServiceClientController
         */
        public function createAccountServiceClientController(\Ganked\Services\Models\ServiceModel $model)
        {
            return new \Ganked\Services\Controllers\ServiceClientController(
                new JsonResponse(),
                $model,
                $this->getMasterFactory()->createAccountServiceClient()
            );
        }

        /**
         * @param \Ganked\Services\Models\ServiceModel $model
         *
         * @return \Ganked\Services\Controllers\ServiceClientController
         */
        public function createCounterStrikeServiceClientController(\Ganked\Services\Models\ServiceModel $model)
        {
            return new \Ganked\Services\Controllers\ServiceClientController(
                new JsonResponse(),
                $model,
                $this->getMasterFactory()->createCounterStrikeServiceClient()
            );
        }

        /**
         * @param \Ganked\Services\Models\ServiceModel $model
         *
         * @return \Ganked\Services\Controllers\ServiceClientController
         */
        public function createDotaServiceClientController(\Ganked\Services\Models\ServiceModel $model)
        {
            return new \Ganked\Services\Controllers\ServiceClientController(
                new JsonResponse(),
                $model,
                $this->getMasterFactory()->createDotaServiceClient()
            );
        }

        /**
         * @param \Ganked\Services\Models\ServiceModel $model
         *
         * @return \Ganked\Services\Controllers\ServiceClientController
         */
        public function createSteamServiceClientController(\Ganked\Services\Models\ServiceModel $model)
        {
            return new \Ganked\Services\Controllers\ServiceClientController(
                new JsonResponse(),
                $model,
                $this->getMasterFactory()->createSteamServiceClient()
            );
        }
    }

}
