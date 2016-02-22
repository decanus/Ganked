<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Handlers
{

    use Ganked\Frontend\Commands\SaveDefaultLeagueOfLegendsRegionInSessionCommand;
    use Ganked\Frontend\Models\LeagueOfLegendsSearchPageModel;
    use Ganked\Frontend\Queries\FetchSummonerForRegionByNameQuery;
    use Ganked\Frontend\Queries\FetchSummonersByNameQuery;
    use Ganked\Frontend\Queries\FetchUserFavouriteSummonersQuery;
    use Ganked\Library\DataObjects\Accounts\RegisteredAccount;
    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;
    use Ganked\Library\ValueObjects\LeagueOfLegends\SummonerName;
    use Ganked\Skeleton\Http\Redirect\RedirectToPath;
    use Ganked\Skeleton\Http\StatusCodes\MovedTemporarily;

    class LeagueOfLegendsSearchHandler extends AbstractSearchHandler
    {
        /**
         * @var FetchSummonersByNameQuery
         */
        private $fetchSummonersByNameQuery;

        /**
         * @var FetchSummonerForRegionByNameQuery
         */
        private $fetchSummonerForRegionByNameQuery;

        /**
         * @var SaveDefaultLeagueOfLegendsRegionInSessionCommand
         */
        private $saveDefaultLeagueOfLegendsRegionInSessionCommand;

        /**
         * @var FetchUserFavouriteSummonersQuery
         */
        private $fetchUserFavouriteSummonersQuery;

        /**
         * @param FetchSummonersByNameQuery                        $fetchSummonersByNameQuery
         * @param FetchSummonerForRegionByNameQuery                $fetchSummonerForRegionByName
         * @param SaveDefaultLeagueOfLegendsRegionInSessionCommand $saveDefaultLeagueOfLegendsRegionInSessionCommand
         * @param FetchUserFavouriteSummonersQuery                 $fetchUserFavouriteSummonersQuery
         */
        public function __construct(
            FetchSummonersByNameQuery $fetchSummonersByNameQuery,
            FetchSummonerForRegionByNameQuery $fetchSummonerForRegionByName,
            SaveDefaultLeagueOfLegendsRegionInSessionCommand $saveDefaultLeagueOfLegendsRegionInSessionCommand,
            FetchUserFavouriteSummonersQuery $fetchUserFavouriteSummonersQuery
        )
        {
            $this->fetchSummonersByNameQuery = $fetchSummonersByNameQuery;
            $this->fetchSummonerForRegionByNameQuery = $fetchSummonerForRegionByName;
            $this->saveDefaultLeagueOfLegendsRegionInSessionCommand = $saveDefaultLeagueOfLegendsRegionInSessionCommand;
            $this->fetchUserFavouriteSummonersQuery = $fetchUserFavouriteSummonersQuery;
        }

        protected function doRun()
        {
            /**
             * @var $model LeagueOfLegendsSearchPageModel
             */
            $model = $this->getModel();
            $uri = $model->getRequestUri();

            if (!$uri->hasParameter('name') || $uri->getParameter('name') === '') {
                return;
            }

            $name = $uri->getParameter('name');

            $names = explode(',', $name);
            if (end($names) === '') {
                unset($names[key($names)]);
            }

            $region = 'all';
            if ($uri->hasParameter('region')) {
                $region = $uri->getParameter('region');
            }

            if (count($names) > 1) {

                if ($region === 'all') {
                    $region = 'euw';
                }

                $model->setRedirect(new RedirectToPath($uri, new MovedTemporarily, '/games/lol/search/multi?' . http_build_query(['names' => implode(',', $names), 'region' => $region])));
                return;
            }

            $account = $model->getAccount();
            if ($account instanceof RegisteredAccount) {
                $favourites = $this->fetchUserFavouriteSummonersQuery->execute($account->getId());
                $body = $favourites->getDecodedJsonResponse();
                if ($favourites->getResponseCode() === 200 && isset($body['data'])) {
                    $model->setFavouriteSummoners($body['data']);
                }
            }

            try {
                $name = new SummonerName($name);
            } catch (\Exception $e) {
                $model->setSearchResult([]);
                return;
            }

            if ($region === 'all') {
                $model->setSearchResult(json_decode($this->fetchSummonersByNameQuery->execute((string) $name)->getBody(), true));
                return;
            }

            try {
                $region = new Region($region);
            } catch (\Exception $e) {
                $model->setSearchResult([]);
                return;
            }

            $this->saveDefaultLeagueOfLegendsRegionInSessionCommand->execute($region);
            $summoner = json_decode($this->fetchSummonerForRegionByNameQuery->execute((string) $region, (string) $name)->getBody(), true);

            if (!empty($summoner)) {
                $model->setRedirect(new RedirectToPath($uri, new MovedTemporarily, '/games/lol/summoners/' . $region . '/' . str_replace(' ', '', $name)));
            }

            $model->setSearchResult([]);

        }
    }
}
