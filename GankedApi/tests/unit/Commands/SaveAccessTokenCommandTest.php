<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Commands
{
    use Ganked\Library\ValueObjects\Token;

    /**
     * @covers Ganked\API\Commands\SaveAccessTokenCommand
     */
    class SaveAccessTokenCommandTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $redisBackend = $this->getMockBuilder(\Ganked\Library\DataPool\RedisBackend::class)
                ->disableOriginalConstructor()
                ->getMock();

            $command = new SaveAccessTokenCommand($redisBackend);

            $token = new Token;
            $user = '1234';

            $redisBackend->expects($this->once())->method('hSet')->with('accessToken', (string) $token, $user);
            $command->execute($token, $user);
        }
    }
}
