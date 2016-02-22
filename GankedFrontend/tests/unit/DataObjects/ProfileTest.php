<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\DataObjects
{

    use Ganked\Library\ValueObjects\Username;

    /**
     * @covers Ganked\Frontend\DataObjects\Profile
     */
    class ProfileTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var Profile
         */
        private $profile;

        protected function setUp()
        {
            $this->profile = new Profile;
        }

        public function testSetAndGetUsernameWorks()
        {
            $username = new Username('test');
            $this->profile->setUsername($username);
            $this->assertSame($username, $this->profile->getUsername());
        }

    }
}
