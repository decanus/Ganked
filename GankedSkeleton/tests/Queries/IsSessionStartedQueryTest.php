<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Queries
{
    /**
     * @covers Ganked\Skeleton\Queries\IsSessionStartedQuery
     */
    class IsSessionStartedQueryTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $session = $this->getMockBuilder(\Ganked\Skeleton\Session\Session::class)
                ->disableOriginalConstructor()
                ->getMock();
            $query = new IsSessionStartedQuery($session);

            $session->expects($this->once())->method('isSessionStarted');
            $query->execute();
        }
    }
}
