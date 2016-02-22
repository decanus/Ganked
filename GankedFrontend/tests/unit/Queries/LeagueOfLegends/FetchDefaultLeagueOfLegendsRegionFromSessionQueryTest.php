<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Queries
{

    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;

    /**
     * @covers Ganked\Frontend\Queries\FetchDefaultLeagueOfLegendsRegionFromSessionQuery
     */
    class FetchDefaultLeagueOfLegendsRegionFromSessionQueryTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $sessionData = $this->getMockBuilder(\Ganked\Skeleton\Session\SessionData::class)
                ->disableOriginalConstructor()
                ->getMock();

            $query = new FetchDefaultLeagueOfLegendsRegionFromSessionQuery($sessionData);

            $region = new Region('euw');
            $sessionData->expects($this->once())->method('getDefaultLeagueOfLegendsRegion')->will($this->returnValue($region));

            $this->assertSame($region, $query->execute());
        }
    }
}
