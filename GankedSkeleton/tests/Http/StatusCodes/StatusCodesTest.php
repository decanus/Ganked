<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Http\StatusCodes
{

    class StatusCodesTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @param StatusCodeInterface $statusCode
         * @param string              $toString
         * @param string              $headerString
         *
         * @dataProvider dataProvider
         */
        public function testStatusCodesReturnExpectedValue(StatusCodeInterface $statusCode, $toString, $headerString)
        {
            $this->assertSame($toString, (string) $statusCode);
            $this->assertSame($headerString, $statusCode->getHeaderString());
        }

        /**
         * @return array
         */
        public function dataProvider()
        {
            return [
                [new BadRequest, '400', 'Status: 400 Bad Request'],
                [new Conflict, '409', 'Status: 409 Conflict'],
                [new InternalServerError, '500', 'Status: 500 Internal server error'],
                [new MovedPermanently, '301', 'Status: 301 Moved Permanently'],
                [new MovedTemporarily, '302', 'Status: 302 Moved Temporarily'],
                [new NotFound, '404', 'Status: 404 Not Found'],
                [new Unauthorized, '401', 'Status: 401 Unauthorized'],
            ];
        }


    }
}
