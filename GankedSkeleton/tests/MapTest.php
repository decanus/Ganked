<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton
{

    use Ganked\Skeleton\Exceptions\MapException;

    /**
     * @covers Ganked\Skeleton\Map
     */
    class MapTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var Map
         */
        private $map;

        protected function setUp()
        {
            $this->map = new Map();
        }

        public function testHasKeyWorks()
        {
            $this->assertFalse($this->map->has('test'));
            $this->map->set('test', 'yo');
            $this->assertTrue($this->map->has('test'));
        }

        public function testGetKeyWorks()
        {
            $this->map->set('test', 'yo');
            $this->assertSame('yo', $this->map->get('test'));
        }

        public function testGetKeyThrowsExceptionWhenKeyDoesNotExist()
        {
            $this->setExpectedException(MapException::class);
            $this->map->get('test');
        }

        public function testSetKeyWorks()
        {
            $this->assertFalse($this->map->has('test'));
            $this->map->set('test', 'yo');
            $this->assertTrue($this->map->has('test'));
        }

        public function testSetKeyThrowsExceptionWhenKeyExists()
        {
            $this->map->set('test', 'yo');
            $this->setExpectedException(MapException::class);
            $this->map->set('test', 'yo');
        }

        public function testRemoveKeyWorks()
        {
            $this->map->set('test', 'yo');
            $this->assertTrue($this->map->has('test'));
            $this->map->remove('test');
            $this->assertFalse($this->map->has('test'));
        }

        public function testGetIteratorWorks()
        {
            $this->assertInstanceOf(\ArrayIterator::class, $this->map->getIterator());
        }
    }
}
