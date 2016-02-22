<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Queries
{

    /**
     * @covers Ganked\Skeleton\Queries\GetDomFromFileQuery
     * @uses Ganked\Library\Helpers\DomHelper
     */
    class GetDomFromFileQueryTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var GetDomFromFileQuery
         */
        private $query;

        private $backend;

        protected function setUp()
        {
            $this->backend = $this->getMockBuilder(\Ganked\Library\Backends\FileBackend::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->query = new GetDomFromFileQuery($this->backend);
        }

        public function testExecuteWorks()
        {
            $this->backend
                ->expects($this->once())
                ->method('load')
                ->will($this->returnValue('<div>test</div>'));

            $this->assertSame(
                $this->query->execute('/path/to/file')->firstChild->nodeValue,
                'test'
            );

        }
    }
}
