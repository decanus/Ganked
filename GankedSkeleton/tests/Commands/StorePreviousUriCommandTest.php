<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Commands
{

    use Ganked\Library\ValueObjects\Uri;

    /**
     * @covers Ganked\Skeleton\Commands\StorePreviousUriCommand
     */
    class StorePreviousUriCommandTest extends \PHPUnit_Framework_TestCase
    {
        public function testUriCanBeStored()
        {
            $data = $this->getMockBuilder(\Ganked\Skeleton\Session\SessionData::class)
                ->disableOriginalConstructor()
                ->getMock();

            $uri = new Uri('ganked.test');

            $command = new StorePreviousUriCommand($data);

            $data->expects($this->once())->method('hasPreviousUri')->will($this->returnValue(true));
            $data->expects($this->once())->method('removePreviousUri');
            $data->expects($this->once())->method('setPreviousUri')->with($uri);

            $command->execute($uri);
        }
    }
}
