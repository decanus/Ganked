<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Queries
{
    use Ganked\Library\ValueObjects\Token;

    /**
     * @covers Ganked\API\Queries\FetchUserIdForAccessTokenQuery
     */
    class FetchUserIdForAccessTokenQueryTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var FetchUserIdForAccessTokenQuery
         */
        private $query;
        private $redisBackend;

        protected function setUp()
        {
            $this->redisBackend = $this->getMockBuilder(\Ganked\Library\DataPool\RedisBackend::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->query = new FetchUserIdForAccessTokenQuery($this->redisBackend);
        }

        /**
         * @expectedException \InvalidArgumentException
         */
        public function testExceptionIsThrownWhenTokenDoesNotExist()
        {
            $token = new Token;

            $this->redisBackend
                ->expects($this->once())
                ->method('hHas')
                ->with('accessToken', (string) $token)
                ->will($this->returnValue(false));

            $this->query->execute($token);
        }

        public function testExecuteReturnsExpectedValue()
        {
            $token = new Token;

            $this->redisBackend
                ->expects($this->once())
                ->method('hHas')
                ->with('accessToken', (string) $token)
                ->will($this->returnValue(true));

            $this->redisBackend
                ->expects($this->once())
                ->method('hGet')
                ->with('accessToken', (string) $token)
                ->will($this->returnValue('foobar'));

            $this->assertSame('foobar', $this->query->execute($token));
        }

    }
}
