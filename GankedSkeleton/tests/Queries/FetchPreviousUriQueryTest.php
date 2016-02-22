<?php
 /**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Queries
{

    use Ganked\Library\ValueObjects\Uri;

    /**
     * @covers Ganked\Skeleton\Queries\FetchPreviousUriQuery
     */
    class FetchPreviousUriQueryTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var FetchPreviousUriQuery
         */
        private $query;
        private $data;
        private $uri;

        protected function setUp()
        {
            $this->data = $this->getMockBuilder(\Ganked\Skeleton\Session\SessionData::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->uri = new Uri('ganked.test');

            $this->query = new FetchPreviousUriQuery($this->data);
        }

        public function testUriCanBeRetrievedIfIsStored()
        {
            $this->data
                ->expects($this->once())
                ->method('hasPreviousUri')
                ->will($this->returnValue(true));

            $this->data
                ->expects($this->once())
                ->method('getPreviousUri')
                ->will($this->returnValue('ganked.test'));

            $this->assertSame('ganked.test', $this->query->execute($this->uri));
        }

        public function testUriCanBeRetrievedWhenNoneIsSet()
        {
            $this->data
                ->expects($this->once())
                ->method('hasPreviousUri')
                ->will($this->returnValue(false));

            $this->assertSame((string) $this->uri, $this->query->execute($this->uri));
        }
    }
}
