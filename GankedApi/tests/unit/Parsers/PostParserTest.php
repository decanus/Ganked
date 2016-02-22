<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Parsers
{

    /**
     * @covers Ganked\API\Parsers\PostParser
     */
    class PostParserTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $parser = new PostParser;

            $this->assertSame(
                [
                    'text' => '@yolo #sweg @oö #uü o@u oö@u http://www.ganked.net',
                    'entities' => [
                        'hashtags' => [
                            ['text' => 'sweg', 'offset' => [6, 11]],
                            ['text' => 'uü', 'offset' => [16, 19]],
                        ],
                        'mentions' => [
                            ['text' => 'oö', 'offset' => [12, 15]]
                        ],
                        'urls' => [
                            ['text' => 'http://www.ganked.net', 'offset' => [29, 50]]
                        ]
                    ]
                ],
                $parser->parse('@yolo #sweg @oö #uü o@u oö@u http://www.ganked.net')
            );
        }
    }
}
