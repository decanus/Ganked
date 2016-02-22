<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Queries
{

    use Ganked\Library\ValueObjects\Email;

    /**
     * @covers Ganked\Post\Queries\IsVerifiedForBetaQuery
     */
    class IsVerifiedForBetaQueryTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $accountGateway = $this->getMockBuilder(\Ganked\Skeleton\Gateways\AccountGateway::class)
                ->setMethods(['isVerifiedForBeta'])
                ->disableOriginalConstructor()
                ->getMock();

            $response = $this->getMockBuilder(\Ganked\Skeleton\Backends\Wrappers\CurlResponse::class)
                ->disableOriginalConstructor()
                ->getMock();

            $query = new IsVerifiedForBetaQuery($accountGateway);

            $email = new Email('test@ganked.net');

            $accountGateway
                ->expects($this->once())
                ->method('isVerifiedForBeta')
                ->with((string) $email)
                ->will($this->returnValue($response));

            $response->expects($this->once())->method('getBody')->will($this->returnValue('true'));

            $this->assertSame(true, $query->execute($email));
        }
    }
}
