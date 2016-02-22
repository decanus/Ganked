<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\Logging\Loggers
{

    use Ganked\Library\Logging\Logs\LogInterface;
    use Ganked\Skeleton\Gateways\SlackGateway;

    class SlackLogger extends AbstractLogger
    {
        /**
         * @var SlackGateway
         */
        private $gateway;

        /**
         * @param SlackGateway $gateway
         */
        public function __construct(SlackGateway $gateway)
        {
            $this->gateway = $gateway;
        }

        /**
         * @return array
         */
        protected function getTypes()
        {
            return [
                \Ganked\Library\Logging\Logs\EmergencyExceptionLog::class
            ];
        }

        /**
         * @param LogInterface $log
         */
        public function log(LogInterface $log)
        {
            $logData = $log->getLog();
            $this->gateway->sendMessage(
                'C06CVAT08',
                'Level: ' . $logData['level'] . PHP_EOL . 'Message: ' . $logData['message'] . PHP_EOL . 'Trace: ' . $logData['trace']
            );
        }
    }
}
