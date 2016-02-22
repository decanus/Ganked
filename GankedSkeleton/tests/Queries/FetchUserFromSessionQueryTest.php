<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Queries
{
    /**
     * @covers Ganked\Skeleton\Queries\FetchUserFromSessionQuery
     */
    class FetchUserFromSessionQueryTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $sessionData = $this->getMockBuilder(\Ganked\Skeleton\Session\SessionData::class)
                ->disableOriginalConstructor()
                ->getMock();
            $query = new FetchUserFromSessionQuery($sessionData);

            $sessionData->expects($this->once())->method('getUser');
            $query->execute();
        }
    }
}
