<?php
 /**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Factories
{

    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Skeleton\Models\JsonErrorPageModel;

    /**
     * @covers Ganked\Skeleton\Factories\ControllerFactory
     * @covers Ganked\Skeleton\Factories\AbstractFactory
     * @covers Ganked\Skeleton\Factories\MasterFactory
     * @uses Ganked\Skeleton\Factories\BackendFactory
     * @uses Ganked\Skeleton\Factories\SessionFactory
     * @uses Ganked\Skeleton\Factories\QueryFactory
     * @uses \Ganked\Skeleton\Controllers\JsonErrorPageController
     * @uses \Ganked\Skeleton\Controllers\AbstractPageController
     * @uses \Ganked\Skeleton\Session\Session
     * @uses \Ganked\Skeleton\Session\SessionDataPool
     * @uses \Ganked\Skeleton\Queries\FetchSessionCookieQuery
     * @uses Ganked\Skeleton\Factories\CommandFactory
     */
    class ControllerFactoryTest extends GenericFactoryTestHelper
    {

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createJsonErrorPageController', \Ganked\Skeleton\Controllers\JsonErrorPageController::class, [new JsonErrorPageModel(new Uri('ganked.net'))]]
            ];
        }
    }
}
