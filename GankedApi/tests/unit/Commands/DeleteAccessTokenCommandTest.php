<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Commands
{
    use Ganked\Library\ValueObjects\Token;

    /**
     * @covers Ganked\API\Commands\DeleteAccessTokenCommand
     */
    class DeleteAccessTokenCommandTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $redisBackend = $this->getMockBuilder(\Ganked\Library\DataPool\RedisBackend::class)
                ->disableOriginalConstructor()
                ->getMock();

            $command = new DeleteAccessTokenCommand($redisBackend);

            $token = new Token;

            $redisBackend->expects($this->once())->method('hDel')->with('accessToken', (string) $token);
            $command->execute($token);
        }
    }
}
