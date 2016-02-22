<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Handlers\Redirect
{

    /**
     * @covers Ganked\Post\Handlers\Redirect\ResendVerificationMailRedirectHandler
     * @covers Ganked\Post\Handlers\Redirect\AbstractRedirectHandler
     * @covers Ganked\Post\Handlers\AbstractHandler
     */
    class ResendVerificationMailRedirectHandlerTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $mail = $this->getMockBuilder(\Ganked\Post\Mails\VerifyMail::class)
                ->disableOriginalConstructor()
                ->getMock();

            $fetchAccountQuery = $this->getMockBuilder(\Ganked\Skeleton\Queries\FetchAccountQuery::class)
                ->disableOriginalConstructor()
                ->getMock();

            $request = $this->getMockBuilder(\Ganked\Skeleton\Http\Request\PostRequest::class)
                ->disableOriginalConstructor()
                ->getMock();

            $model = $this->getMockBuilder(\Ganked\Post\Models\JsonModel::class)
                ->disableOriginalConstructor()
                ->getMock();

            $handler = new ResendVerificationMailRedirectHandler(true, $fetchAccountQuery, $mail);

            $data = [
                'data' => [
                    'attributes' => [
                        'hash' => 'hash',
                        'email' => 'email',
                        'username' => 'firstName'
                    ]
                ]
            ];

            $request
                ->expects($this->once())
                ->method('getParameter')
                ->with('email')
                ->will($this->returnValue('test@ganked.net'));
            $fetchAccountQuery->expects($this->once())->method('execute')->will($this->returnValue($data));

            $mail->expects($this->once())->method('setHash')->with('hash');
            $mail
                ->expects($this->once())
                ->method('setRecipient')
                ->with(['email' => 'email', 'name' => 'firstName']);

            $model->expects($this->once())->method('setRedirectUri');

            $handler->execute($model, $request);
        }
    }
}
