<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Post\Handlers\Request
{

    use Ganked\Library\DataObjects\Accounts\AnonymousAccount;
    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;
    use Ganked\Post\Commands\FavouriteSummonerCommand;
    use Ganked\Skeleton\Session\Session;

    class SummonerFavouriteHandler extends AbstractRequestHandler
    {

        /**
         * @var FavouriteSummonerCommand
         */
        private $favouriteSummonerCommand;

        /**
         * @var Region
         */
        private $region;

        /**
         * @var string
         */
        private $summonerId;

        /**
         * @param Session                  $session
         * @param FavouriteSummonerCommand $favouriteSummonerCommand
         */
        public function __construct(Session $session, FavouriteSummonerCommand $favouriteSummonerCommand)
        {
            parent::__construct($session);
            $this->favouriteSummonerCommand = $favouriteSummonerCommand;
        }

        protected function validateForm()
        {
            $this->checkCSRFToken();
            $request = $this->getRequest();

            if ($this->getSessionData()->getAccount() instanceof AnonymousAccount) {
                $this->setErrorMessage('Could not be favourited.');
                return;
            }

            try {
                $this->region = new Region($request->getParameter('region'));
            } catch (\Exception $e) {
                $this->setErrorMessage('Could not be favourited.');
                return;
            }

            try {
                $this->summonerId = $request->getParameter('summonerId');
            } catch (\Exception $e) {
                $this->setErrorMessage('Could not be favourited.');
                return;
            }
        }

        protected function performAction()
        {
            $userId = $this->getSessionData()->getAccount()->getId();

            // @todo check if is favourited?

            try {
                $response = $this->favouriteSummonerCommand->execute($userId, $this->summonerId, $this->region);

                if ($response->getResponseCode() !== 200) {
                    throw new \RuntimeException('Unexpected error');
                }

            } catch (\Exception $e) {
                $this->setErrorMessage('Could not be favourited.');
                return;
            }
        }
    }
}
