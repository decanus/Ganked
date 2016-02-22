<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Commands
{

    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;

    /**
     * @covers Ganked\Frontend\Commands\SaveDefaultLeagueOfLegendsRegionInSessionCommand
     */
    class SaveDefaultLeagueOfLegendsRegionInSessionCommandTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $sessionData = $this->getMockBuilder(\Ganked\Skeleton\Session\SessionData::class)
                ->disableOriginalConstructor()
                ->getMock();

            $command = new SaveDefaultLeagueOfLegendsRegionInSessionCommand($sessionData);

            $region = new Region('euw');
            $sessionData->expects($this->once())->method('hasDefaultLeagueOfLegendsRegion')->will($this->returnValue(true));
            $sessionData->expects($this->once())->method('removeDefaultLeagueOfLegendsRegion');
            $sessionData->expects($this->once())->method('setDefaultLeagueOfLegendsRegion')->with($region);

            $command->execute($region);
        }
    }
}
