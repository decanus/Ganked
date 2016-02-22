<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Renderers
{

    use Ganked\Frontend\Queries\FetchUserFavouriteSummonersQuery;
    use Ganked\Library\DataObjects\Accounts\RegisteredAccount;
    use Ganked\Library\DataPool\DataPoolReader;
    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Library\Logging\LoggerAware;
    use Ganked\Library\Logging\LogProvider;
    use Ganked\Skeleton\Queries\FetchAccountFromSessionQuery;

    class RecentSummonersRenderer implements LoggerAware
    {
        /**
         * @trait
         */
        use LogProvider;

        /**
         * @var DataPoolReader
         */
        private $dataPoolReader;

        /**
         * @var SummonerSnippetRenderer
         */
        private $summonerSnippetRenderer;

        /**
         * @var FetchAccountFromSessionQuery
         */
        private $fetchAccountFromSessionQuery;

        /**
         * @var FetchUserFavouriteSummonersQuery
         */
        private $fetchUserFavouriteSummonersQuery;

        /**
         * @param DataPoolReader                   $dataPoolReader
         * @param SummonerSnippetRenderer          $summonerSnippetRenderer
         * @param FetchAccountFromSessionQuery     $fetchAccountFromSessionQuery
         * @param FetchUserFavouriteSummonersQuery $fetchUserFavouriteSummonersQuery
         */
        public function __construct(
            DataPoolReader $dataPoolReader,
            SummonerSnippetRenderer $summonerSnippetRenderer,
            FetchAccountFromSessionQuery $fetchAccountFromSessionQuery,
            FetchUserFavouriteSummonersQuery $fetchUserFavouriteSummonersQuery
        )
        {
            $this->dataPoolReader = $dataPoolReader;
            $this->summonerSnippetRenderer = $summonerSnippetRenderer;
            $this->fetchAccountFromSessionQuery = $fetchAccountFromSessionQuery;
            $this->fetchUserFavouriteSummonersQuery = $fetchUserFavouriteSummonersQuery;
        }

        /**
         * @return DomHelper
         */
        public function render()
        {
            $div = new DomHelper('<section class="page-wrap -padding"/>');

            $title = 'Recent Summoners';

            try {

                $summoners = $this->dataPoolReader->getRecentSummonersList();
                $account = $this->fetchAccountFromSessionQuery->execute();
                if ($account instanceof RegisteredAccount) {
                    $response = $this->fetchUserFavouriteSummonersQuery->execute($account->getId());

                    $responseBody = $response->getDecodedJsonResponse();
                    if ($response->getResponseCode() !== 404 && isset($responseBody) && !empty($responseBody['data'])) {
                        $summoners = $responseBody['data'];
                        $title = 'Favourites';
                    }
                }

                $div->firstChild->appendChild($div->createElement('h2', $title));
                $container = $div->createElement('div');
                $container->setAttribute('id', 'recentSummoners-container');
                $container->setAttribute('class', 'page-section');
                $div->firstChild->appendChild($container);

                $grid = $div->createElement('div');
                $grid->setAttribute('class', 'grid-wrapper -gap -type-a');
                $container->appendChild($grid);

                $appended = 0;
                foreach ($summoners as $summoner) {
                    if ($appended === 4) {
                        break;
                    }

                    if (!is_array($summoner)) {
                        $summoner = json_decode($summoner, true);
                    }

                    if (!isset($summoner['name'])) {
                        continue;
                    }

                    $summonerSnippet = $this->summonerSnippetRenderer->render($summoner);
                    $summonerSnippet->documentElement->setAttribute('class', 'item -quarter -flex');

                    $div->importAndAppendChild($grid, $summonerSnippet->firstChild);
                    $appended++;
                }

            } catch (\Exception $e) {
                $this->logCriticalException($e);
            }

            return $div;
        }
    }
}
