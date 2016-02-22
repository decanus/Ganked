<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Queries
{
    /**
     * @covers Ganked\Frontend\Queries\HasDefaultLeagueOfLegendsRegionFromSessionQuery
     */
    class HasDefaultLeagueOfLegendsRegionFromSessionQueryTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $sessionData = $this->getMockBuilder(\Ganked\Skeleton\Session\SessionData::class)
                ->disableOriginalConstructor()
                ->getMock();

            $query = new HasDefaultLeagueOfLegendsRegionFromSessionQuery($sessionData);

            $sessionData->expects($this->once())->method('hasDefaultLeagueOfLegendsRegion')->will($this->returnValue(true));

            $this->assertTrue($query->execute());
        }
    }
}
