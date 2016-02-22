<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Mappers
{
    /**
     * @covers Ganked\Frontend\Mappers\CounterStrikeUserMapper
     * @uses \Ganked\Frontend\DataObjects\CounterStrike\User
     * @uses \Ganked\Library\Helpers\DomHelper
     */
    class CounterStrikeUserMapperTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var CounterStrikeUserMapper
         */
        private $mapper;

        protected function setUp()
        {
            $this->mapper = new CounterStrikeUserMapper;
        }

        public function testMapWorks()
        {
            $steamInfo = [
                'steamid' => 123,
                'personaname' => 'bro',
                'avatarmedium' => 'test.jpg',
                'personastate' => 0,
                'avatarfull' => 'foo',
                'lastlogoff' => '1449964501',
                'playerstats' => ['stats' => [], 'achievements' => []]
            ];

            $this->assertInstanceOf(
                \Ganked\Frontend\DataObjects\CounterStrike\User::class,
                $this->mapper->map($steamInfo)
            );
        }
    }
}
