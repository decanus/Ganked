<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Queries
{

    use Ganked\Library\ValueObjects\Email;

    /**
     * @covers Ganked\Skeleton\Queries\FetchAccountQuery
     */
    class FetchAccountQueryTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $gateway = $this->getMockBuilder(\Ganked\Library\Gateways\GankedApiGateway::class)
                ->disableOriginalConstructor()
                ->getMock();

            $response = $this->getMockBuilder(\Ganked\Library\Curl\Response::class)
                ->disableOriginalConstructor()
                ->getMock();

            $query = new FetchAccountQuery($gateway);

            $email = new Email('foo@bar.net');
            $gateway->expects($this->once())->method('getAccount')->with((string) $email)->will($this->returnValue($response));
            $response->expects($this->once())->method('getDecodedJsonResponse')->will($this->returnValue(['foo']));

            $this->assertSame(['foo'], $query->execute($email));
        }
    }
}
