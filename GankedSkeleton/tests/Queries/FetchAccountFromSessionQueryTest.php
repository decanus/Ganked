<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Queries
{

    /**
     * @covers Ganked\Skeleton\Queries\FetchAccountFromSessionQuery
     */
    class FetchAccountFromSessionQueryTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $sessionData = $this->getMockBuilder(\Ganked\Skeleton\Session\SessionData::class)
                ->disableOriginalConstructor()
                ->getMock();
            $query = new FetchAccountFromSessionQuery($sessionData);

            $account = $this->getMockBuilder(\Ganked\Library\DataObjects\Accounts\AnonymousAccount::class)
                ->disableOriginalConstructor()
                ->getMock();
            $sessionData
                ->expects($this->once())
                ->method('getAccount')
                ->will($this->returnValue($account));

            $this->assertSame($account, $query->execute());
        }
    }
}
