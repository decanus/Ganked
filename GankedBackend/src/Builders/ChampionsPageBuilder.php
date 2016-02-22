<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Builders
{

    use Ganked\Backend\StaticPages\StaticPage;
    use Ganked\Library\Backends\DomBackend;
    use Ganked\Library\Backends\FileBackend;
    use Ganked\Library\DataPool\DataPoolReader;
    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Library\ValueObjects\MetaTags;
    use Ganked\Skeleton\Transformations\SnippetTransformation;

    class ChampionsPageBuilder
    {
        /**
         * @var FileBackend
         */
        private $fileBackend;

        /**
         * @var DomHelper
         */
        private $template;

        /**
         * @var DomBackend
         */
        private $domBackend;

        /**
         * @var DataPoolReader
         */
        private $dataPoolReader;

        /**
         * @var SnippetTransformation
         */
        private $snippet;

        /**
         * @param FileBackend    $fileBackend
         * @param DomBackend     $domBackend
         * @param DataPoolReader $dataPoolReader
         */
        public function __construct(
            FileBackend $fileBackend,
            DomBackend $domBackend,
            DataPoolReader $dataPoolReader,
            SnippetTransformation $snippet
        )
        {
            $this->fileBackend = $fileBackend;
            $this->domBackend = $domBackend;
            $this->dataPoolReader = $dataPoolReader;
            $this->snippet = $snippet;
        }

        /**
         * @return StaticPage
         * @throws \Exception
         */
        public function build()
        {
            $champions = $this->dataPoolReader->getAllChampions();

            $this->template = $this->domBackend->getDomFromXML('pages://template.xhtml');
            $this->snippet->setTemplate($this->template);

            $this->snippet->replaceElementWithId('main', new DomHelper('<main id="main" class="page-wrap -padding"></main>'));
            $this->snippet->appendToMain($this->domBackend->getDomFromXML(__DIR__ . '/../../data/templates/champions/header.xhtml'));

            $metaTags = new MetaTags;
            $metaTags->setDescription('Ganked.net overview of all League of Legends champions');
            $metaTags->setTitle('Champions');

            /**
             * @var $championBoxes DomHelper[]
             */
            $championBoxes = [];

            /**
             * @var $champion array
             */
            foreach ($champions as $champion) {
                $champion = json_decode($champion, true);
                $championBoxes[$champion['name']] = $this->renderChampion($champion);
            }

            ksort($championBoxes);

            $grid = new DomHelper('<div class="grid-wrapper -gap -type-a"></div>');

            foreach ($championBoxes as $championBox) {
                $grid->importAndAppendChild($grid->firstChild, $championBox->firstChild);
            }

            $this->snippet->appendToMain($grid);

            return new StaticPage('/games/lol/champions', $metaTags, $this->template);
        }

        /**
         * @param array $champion
         *
         * @return DomHelper
         */
        private function renderChampion(array $champion)
        {
            $championDom = $this->domBackend->getDomFromXML(__DIR__ . '/../../data/templates/champions/champion.xhtml');

            $championDom->query('/div/a/p')->item(0)->nodeValue = $champion['title'];
            $championDom->query('/div/a/h3')->item(0)->nodeValue = $champion['name'];

            $link = $championDom->query('/div/a')->item(0);
            $link->setAttribute('href', '/games/lol/champions/' . strtolower($champion['key']));
            $link->setAttribute('title', $champion['name']);


            $sources = $championDom->query('/div/a/picture/source');
            $sources->item(0)->setAttribute('srcset', '//cdn.ganked.net/images/lol/champion/splash/thumbnail/small/' . $champion['key'] . '_0.jpg');
            $sources->item(1)->setAttribute('srcset', '//cdn.ganked.net/images/lol/champion/splash/thumbnail/medium/' . $champion['key'] . '_0.jpg');

            $championDom->query('/div/a/picture/img')->item(0)->setAttribute('src', '//cdn.ganked.net/images/lol/champion/splash/thumbnail/large/' . $champion['key'] . '_0.jpg');

            return $championDom;
        }
    }
}
