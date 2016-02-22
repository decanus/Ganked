<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\DataObjects\CounterStrike
{
    class User
    {
        /**
         * @var string
         */
        private $id;

        /**
         * @var string
         */
        private $name;

        /**
         * @var array
         */
        private $stats;

        /**
         * @var array
         */
        private $achievements;

        /**
         * @var string
         */
        private $image;

        /**
         * @var \DateTime
         */
        private $lastLogOff;

        /**
         * @var string
         */
        private $status;

        /**
         * @var string
         */
        private $currentGameId;

        /**
         * @param string $id
         * @param string $name
         */
        public function __construct($id, $name)
        {
            $this->id = $id;
            $this->name = $name;
        }

        /**
         * @return string
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * @return string
         */
        public function getName()
        {
            return $this->name;
        }

        /**
         * @param array $achievements
         */
        public function setAchievements(array $achievements)
        {
            $this->achievements = $achievements;
        }

        /**
         * @return array
         */
        public function getAchievements()
        {
            return $this->achievements;
        }

        /**
         * @param array $stats
         */
        public function setStats(array $stats)
        {
            $this->stats = $stats;
        }

        /**
         * @return array
         */
        public function getStats()
        {
            return $this->stats;
        }

        /**
         * @param string $image
         */
        public function setImage($image)
        {
            $this->image = $image;
        }

        /**
         * @return string
         */
        public function getImage()
        {
            return $this->image;
        }

        /**
         * @param \DateTime $lastLogOff
         */
        public function setLastLogOff(\DateTime $lastLogOff)
        {
            $this->lastLogOff = $lastLogOff;
        }

        /**
         * @return \DateTime
         */
        public function getLastLogOff()
        {
            return $this->lastLogOff;
        }

        /**
         * @param string $status
         */
        public function setStatus($status)
        {
            $this->status = $status;
        }

        /**
         * @return string
         */
        public function getStatus()
        {
            return $this->status;
        }

        /**
         * @param string $currentGameId
         */
        public function setCurrentGameId($currentGameId)
        {
            $this->currentGameId = $currentGameId;
        }

        /**
         * @return string
         */
        public function getCurrentGameId()
        {
            return $this->currentGameId;
        }
    }
}
