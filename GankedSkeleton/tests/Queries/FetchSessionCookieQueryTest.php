<?php
 /**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Queries
{
    /**
     * @covers Ganked\Skeleton\Queries\FetchSessionCookieQuery
     */
    class FetchSessionCookieQueryTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $session = $this->getMockBuilder(\Ganked\Skeleton\Session\Session::class)
                ->disableOriginalConstructor()
                ->getMock();
            $query = new FetchSessionCookieQuery($session);

            $session->expects($this->once())->method('getCookie');
            $query->execute();
        }
    }
}
