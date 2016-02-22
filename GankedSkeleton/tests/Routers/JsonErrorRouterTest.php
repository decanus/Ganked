<?php
 /**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Routers
{

    /**
     * @covers Ganked\Skeleton\Routers\JsonErrorRouter
     * @covers Ganked\Skeleton\Routers\AbstractRouter
     * @uses \Ganked\Skeleton\Controllers\JsonErrorPageController
     * @uses \Ganked\Skeleton\Controllers\AbstractPageController
     * @uses \Ganked\Skeleton\Models\JsonErrorPageModel
     * @uses \Ganked\Skeleton\Factories\BackendFactory
     * @uses \Ganked\Skeleton\Factories\QueryFactory
     * @uses \Ganked\Skeleton\Factories\AbstractFactory
     * @uses \Ganked\Skeleton\Factories\MasterFactory
     * @uses \Ganked\Skeleton\Factories\ControllerFactory
     * @uses \Ganked\Skeleton\Factories\SessionFactory
     * @uses \Ganked\Skeleton\Models\AbstractModel
     * @uses \Ganked\Skeleton\Models\AbstractPageModel
     * @uses \Ganked\Skeleton\Session\Session
     * @uses \Ganked\Skeleton\Session\SessionDataPool
     * @uses \Ganked\Skeleton\Queries\FetchSessionCookieQuery
     */
    class JsonErrorRouterTest extends GenericRouterTestHelper
    {
        protected function setUp()
        {
            parent::setUp();
            $this->router = new JsonErrorRouter($this->masterFactory);
        }

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['/500', \Ganked\Skeleton\Controllers\JsonErrorPageController::class],
                ['/3', \Ganked\Skeleton\Controllers\JsonErrorPageController::class],
            ];
        }
    }
}