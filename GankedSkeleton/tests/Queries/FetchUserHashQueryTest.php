<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Queries
{

    use Ganked\Library\ValueObjects\Email;

    /**
     * @covers Ganked\Skeleton\Queries\FetchUserHashQuery
     */
    class FetchUserHashQueryTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $accountGateway = $this->getMockBuilder(\Ganked\Skeleton\Gateways\AccountGateway::class)
                ->setMethods(['getUserHash'])
                ->disableOriginalConstructor()
                ->getMock();

            $response = $this->getMockBuilder(\Ganked\Skeleton\Backends\Wrappers\CurlResponse::class)
                ->disableOriginalConstructor()
                ->getMock();

            $query = new FetchUserHashQuery($accountGateway);

            $email = new Email('test@ganked.test');

            $accountGateway
                ->expects($this->once())
                ->method('getUserHash')
                ->with((string) $email)
                ->will($this->returnValue($response));

            $response
                ->expects($this->once())
                ->method('getBody')
                ->will($this->returnValue('{"hash":"yay"}'));

            $this->assertSame('yay', $query->execute($email));
        }
    }
}
