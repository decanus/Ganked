<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Queries
{
    /**
     * @covers Ganked\Skeleton\Queries\SessionHasUserQuery
     */
    class SessionHasUserQueryTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $sessionData = $this->getMockBuilder(\Ganked\Skeleton\Session\SessionData::class)
                ->disableOriginalConstructor()
                ->getMock();
            $query = new SessionHasUserQuery($sessionData);

            $sessionData->expects($this->once())->method('hasUser');
            $query->execute();
        }
    }
}
