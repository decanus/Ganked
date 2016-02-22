<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Post\Handlers\Request
{

    use Ganked\Library\DataObjects\Accounts\AnonymousAccount;
    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;
    use Ganked\Post\Commands\UnfavouriteSummonerCommand;
    use Ganked\Skeleton\Session\Session;

    class SummonerUnfavouriteHandler extends AbstractRequestHandler
    {
        /**
         * @var UnfavouriteSummonerCommand
         */
        private $unfavouriteSummonerCommand;

        /**
         * @var Region
         */
        private $region;

        /**
         * @var string
         */
        private $summonerId;

        /**
         * @param Session                    $session
         * @param UnfavouriteSummonerCommand $unfavouriteSummonerCommand
         */
        public function __construct(Session $session, UnfavouriteSummonerCommand $unfavouriteSummonerCommand)
        {
            parent::__construct($session);
            $this->unfavouriteSummonerCommand = $unfavouriteSummonerCommand;
        }

        protected function validateForm()
        {
            $this->checkCSRFToken();
            $request = $this->getRequest();

            if ($this->getSessionData()->getAccount() instanceof AnonymousAccount) {
                $this->setErrorMessage('Could not be unfavourited.');
                return;
            }

            try {
                $this->region = new Region($request->getParameter('region'));
            } catch (\Exception $e) {
                $this->setErrorMessage('Could not be unfavourited.');
                return;
            }

            try {
                $this->summonerId = $request->getParameter('summonerId');
            } catch (\Exception $e) {
                $this->setErrorMessage('Could not be unfavourited.');
                return;
            }
        }

        protected function performAction()
        {
            $userId = $this->getSessionData()->getAccount()->getId();

            try {
                $response = $this->unfavouriteSummonerCommand->execute($userId, $this->summonerId, $this->region);

                if ($response->getResponseCode() !== 200) {
                    throw new \RuntimeException('Unexpected error');
                }

            } catch (\Exception $e) {
                $this->setErrorMessage('Could not be unfavourited.');
                return;
            }
        }
    }
}
