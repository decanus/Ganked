<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

 
namespace Ganked\Fetch\Mappers
{
    /**
     * @covers Ganked\Fetch\Mappers\LandingPageStreamMapper
     */
    class LandingPageStreamMapperTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var LandingPageStreamMapper
         */
        private $renderer;

        protected function setUp()
        {
            $this->renderer = new LandingPageStreamMapper;
        }

        public function testRenderWorksWhenStreamsAreEmpty()
        {
            $this->assertSame(['streams' => null], $this->renderer->map([]));
        }

        public function testRendererWorksWhenBannerIsEmpty()
        {
            $input = [
                'streams' => [
                    [
                        'channel' => [
                            'display_name' => 'first',
                            'name'=> 'firstBro'
                        ],
                        'preview' => ['medium' => 'firstBro.png', 'large' => 'firstBroLarge.png']
                    ]
                ]
            ];

            $expected = [
                'streams' => [
                    [
                        'name' => 'firstBro',
                        'display_name' => 'first',
                        'preview' => 'firstBro.png',
                        'banner' => 'firstBroLarge.png',
                        'src' => 'http://www.twitch.tv/firstBro/embed'
                    ]
                ]
            ];

            $this->assertEquals($expected, $this->renderer->map($input));
        }

        public function testRenderWorks()
        {
            $streams = [
                'streams' => [
                    [
                        'channel' => [
                            'display_name' => 'first',
                            'name' => 'firstBro',
                            'video_banner' => 'bro_banner.png'
                        ],
                        'preview' => ['medium' => 'firstBro.png']
                    ],
                    [
                        'channel' => [
                            'display_name' => 'test',
                            'name' => 'tester',
                            'video_banner' => 'tester_banner.jpg'
                        ],
                        'preview' => ['medium' => 'tester.png']
                    ],
                    []
                ]
            ];

            $expected = [
                'streams' => [
                    [
                        'name' => 'firstBro',
                        'display_name' => 'first',
                        'preview' => 'firstBro.png',
                        'banner' => 'bro_banner.png',
                        'src' => 'http://www.twitch.tv/firstBro/embed'
                    ],
                    [
                        'name' => 'tester',
                        'display_name' => 'test',
                        'preview' => 'tester.png',
                        'banner' => 'tester_banner.jpg',
                        'src' => 'http://www.twitch.tv/tester/embed'
                    ]
                ]
            ];

            $this->assertEquals($expected, $this->renderer->map($streams));
        }
    }
}
