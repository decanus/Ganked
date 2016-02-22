<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Backend\Builders
{

    use Ganked\Backend\Renderers\BreadcrumbsRenderer;
    use Ganked\Backend\StaticPages\StaticPage;
    use Ganked\Library\Backends\DomBackend;
    use Ganked\Library\DataPool\LeagueOfLegendsDataPoolReader;
    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Library\Logging\LoggerAware;
    use Ganked\Library\Logging\LogProvider;
    use Ganked\Library\ValueObjects\MetaTags;
    use Ganked\Skeleton\Transformations\SnippetTransformation;

    class ChampionPageBuilder implements LoggerAware
    {
        /**
         * @trait
         */
        use LogProvider;

        /**
         * @var SnippetTransformation
         */
        private $snippetTransformation;

        /**
         * @var BreadcrumbsRenderer
         */
        private $breadcrumbRenderer;

        /**
         * @var DomBackend
         */
        private $domBackend;

        /**
         * @var LeagueOfLegendsDataPoolReader
         */
        private $dataPoolReader;

        /**
         * @param DomBackend                    $domBackend
         * @param SnippetTransformation         $snippetTransformation
         * @param BreadcrumbsRenderer           $breadcrumbRenderer
         * @param LeagueOfLegendsDataPoolReader $dataPoolReader
         */
        public function __construct(
            DomBackend $domBackend,
            SnippetTransformation $snippetTransformation,
            BreadcrumbsRenderer $breadcrumbRenderer,
            LeagueOfLegendsDataPoolReader $dataPoolReader
        )
        {
            $this->domBackend = $domBackend;
            $this->snippetTransformation = $snippetTransformation;
            $this->breadcrumbRenderer = $breadcrumbRenderer;
            $this->dataPoolReader = $dataPoolReader;
        }

        /**
         * @param array $champion
         *
         * @return StaticPage
         * @throws \Exception
         */
        public function build(array $champion)
        {
            $template = $this->domBackend->getDomFromXML('pages://template.xhtml');
            $this->snippetTransformation->setTemplate($template);

            $this->snippetTransformation->replaceElementWithId('main', new DomHelper('<main id="main" class="page-wrap -padding"></main>'));

            $this->snippetTransformation->appendToMain($this->renderHeader($champion));
            $this->snippetTransformation->appendToMain($this->renderChampionInfo($champion));
            $this->snippetTransformation->appendToMain($this->renderSkins($champion));
            $this->snippetTransformation->appendToMain($this->renderAbilities($champion));

            try {
                $this->snippetTransformation->appendToMain($this->renderRecommended($champion));
            } catch (\Exception $e) {
                $this->logCriticalException($e);
            }

            $this->snippetTransformation->appendToMain($this->renderBreadCrumbs($champion['name'], strtolower($champion['key'])));

            return new StaticPage(
                '/games/lol/champions/' . strtolower($champion['key']),
                $this->handleMetaTags($champion),
                $template
            );
        }

        /**
         * @param array $champion
         *
         * @return \Ganked\Library\Helpers\DomHelper
         */
        private function renderHeader(array $champion)
        {
            $header = $this->domBackend->getDomFromXML(__DIR__ . '/../../data/templates/champion/header.xhtml');

            $header->importAndAppendChild(
                $header->query('/div/header/div')->item(1),
                (new DomHelper('<h1>' . $champion['name'] . ' <small>' . $champion['title'] . '</small></h1>'))->firstChild
            );

            $avatar = $header->query('/div/header/div/img')->item(0);
            $avatar->setAttribute('alt', $champion['name']);
            $avatar->setAttribute('src', '//cdn.ganked.net/images/lol/champion/icon/' . $champion['key'] . '.png');

            $header->query('/div/header/div')->item(0)->setAttribute(
                'style',
                'background-image: url(//cdn.ganked.net/images/lol/champion/splash/' . $champion['key'] . '_0.jpg)'
            );

            return $header;
        }

        /**
         * @param array $champion
         *
         * @return DomHelper
         * @throws \Exception
         */
        private function renderChampionInfo(array $champion)
        {
            $infoDom = $this->domBackend->getDomFromXML(__DIR__ . '/../../data/templates/champion/info.xhtml');
            $info = $champion['info'];

            $lore = new DomHelper('<span>' . $this->formatRawText($champion['lore']) . '</span>');
            $infoDom->importAndAppendChild($infoDom->query('/div/div/p')->item(0), $lore->firstChild);

            $items = $infoDom->query('/div/div/div/div/div/span');

            $items->item(0)->nodeValue = $info['attack'];
            $items->item(1)->nodeValue = $info['defense'];
            $items->item(2)->nodeValue = $info['magic'];
            $items->item(3)->nodeValue = $info['difficulty'];

            return $infoDom;
        }

        /**
         * @param array $champion
         *
         * @return \Ganked\Library\Helpers\DomHelper
         * @throws \Exception
         */
        private function renderSkins(array $champion)
        {
            $dom = $this->domBackend->getDomFromXML(__DIR__ . '/../../data/templates/champion/skins.xhtml');

            foreach ($champion['skins'] as $skin) {
                $skinDom = $this->domBackend->getDomFromXML(__DIR__ . '/../../data/templates/champion/skin.xhtml');
                $skinName = ucfirst($skin['name']);

                if ($skinName === 'Default') {
                    $skinName = $champion['name'];
                }

                $image = $skinDom->query('/div/figure/img')->item(0);
                $image->setAttribute('alt', $skinName);
                $image->setAttribute(
                    'src',
                    '//cdn.ganked.net/images/lol/champion/splash/' . $champion['key'] . '_' . $skin['num'] . '.jpg'
                );

                $skinDom->query('/div/figure/figcaption')->item(0)->nodeValue = $skinName;

                $dom->importAndAppendChild($dom->query('/section/div')->item(0), $skinDom->firstChild);
            }

            return $dom;
        }

        /**
         * @param array $champion
         *
         * @return \Ganked\Library\Helpers\DomHelper
         * @throws \Exception
         */
        private function renderAbilities(array $champion)
        {
            $dom = $this->domBackend->getDomFromXML(__DIR__ . '/../../data/templates/champion/abilities.xhtml');

            foreach ($champion['spells'] as $spell) {
                try {
                    $spellDom = $this->domBackend->getDomFromXML(__DIR__ . '/../../data/templates/champion/ability.xhtml');

                    $image = $spellDom->query('//img')->item(0);
                    $image->setAttribute('src', '//cdn.ganked.net/images/lol/spell/' . $spell['image']['full']);
                    $image->setAttribute('alt', $spell['name']);

                    $spellDom->query('//h3')->item(0)->nodeValue = $spell['name'];

                    $items = $spellDom->query('/div/article/div/div/div/div/span');

                    $effectBurn = [];
                    $resource = '';

                    if (isset($spell['effectBurn'])) {
                        $effectBurn = $spell['effectBurn'];
                    }

                    if (isset($spell['resource'])) {
                        $resource = $spell['resource'];
                    }

                    if ($spell['costType'] == 'NoCost') {
                        $items->item(0)->nodeValue = 'free';
                    } else {
                        $items->item(0)->nodeValue = $this->renderTemplateString(
                            $resource,
                            ['cost' => $this->formatRange($spell['cost'])],
                            $effectBurn
                        );
                    }

                    $items->item(1)->nodeValue = ucfirst($spell['rangeBurn']);

                    $description = new DomHelper('<p class="_textLimit">' . $this->formatRawText($spell['description']) . '</p>');

                    $spellDom->importAndAppendChild(
                        $spellDom->query('/div/article/div/div')->item(1),
                        $description->firstChild
                    );

                    $dom->importAndAppendChild($dom->query('/section/div')->item(0), $spellDom->firstChild);
                } catch (\Exception $e) {
                    $this->logCriticalException($e);
                    continue;
                }
            }

            return $dom;
        }

        /**
         * @param array $champion
         *
         * @return \Ganked\Library\Helpers\DomHelper
         */
        private function renderRecommended(array $champion)
        {
            $recommendedDom = new DomHelper('<section class="page-section"><h2>Recommended Items</h2></section>');

            $mapsList = [
                1  => 'summoners-rift',
                2  => 'summoners-rift',
                4  => 'twisted-treeline',
                8  => 'crystal-scar',
                10 => 'the-twisted-treeline',
                11 => 'summoners-rift',
                12 => 'howling-abyss'
            ];

            $mapTitles = [
                'summoners-rift' => 'Summoners Rift',
                'the-twisted-treeline' => 'The Twisted Treeline',
                'howling-abyss' => 'Howling Abyss',
                'crystal-scar' => 'Crystal Scar'
            ];

            $renderedMaps = []; // Stores the map names that were already rendered

            foreach ($champion['recommended'] as $map) {
                if (!is_numeric($map['map']) || !isset($mapsList[(int) $map])) {
                    continue;
                }

                $name = $mapsList[$map['map']];

                if (isset($renderedMaps[$name])) {
                    continue;
                }

                $mapDom = $this->domBackend->getDomFromXML(__DIR__ . '/../../data/templates/champion/map.xhtml');

                $mapDom->query('/section/h3')->item(0)->nodeValue = $mapTitles[$name];
                $mapDom->query('/section/div')->item(0)->setAttribute('class', 'champion-image -' . $name);

                $appendedItems = 0;
                foreach ($map['blocks'] as $block) {
                    $blockDom = new DomHelper('<div class="item -half"><h4 /></div>');
                    $blockDom->query('/div/h4')->item(0)->nodeValue = ucfirst($block['type']);


                    foreach ($block['items'] as $item) {
                        if (!$this->dataPoolReader->hasItem($item['id'])) {
                            continue;
                        }

                        $appendedItems += 1;
                        $itemInfo = $this->dataPoolReader->getItem($item['id']);
                        $itemDom = $this->domBackend->getDomFromXML(__DIR__ . '/../../data/templates/champion/item.xhtml');

                        $image = $itemDom->getElementById('/div/div/div/img')->item(0);
                        $image->setAttribute('alt', $itemInfo['name']);
                        $image->setAttribute('src', '//cdn.ganked.net/images/lol/item/' . $itemInfo['image']['full']);

                        $itemDom->query('/div/div/p')->item(0)->nodeValue = $itemInfo['name'];

                        $blockDom->importAndAppendChild($blockDom->firstChild, $itemDom->firstChild);
                    }

                    $mapDom->importAndAppendChild($mapDom->query('/section/div')->item(1), $blockDom->firstChild);
                }

                if ($appendedItems === 0) {
                    continue;
                }

                $recommendedDom->importAndAppendChild($recommendedDom->firstChild, $mapDom->firstChild);
                $renderedMaps[$name] = 1;
            }

            if (count($renderedMaps) === 0) {
                return new DomHelper('<div />');
            }

            return $recommendedDom;
        }

        /**
         * @param string $name
         * @param string $id
         *
         * @return DomHelper
         * @throws \InvalidArgumentException
         */
        private function renderBreadcrumbs($name, $id)
        {
            $breadcrumbs = [
                ['uri' => '/games',  'name' => 'Games'],
                ['uri' => '/games/lol',  'name' => 'League of Legends'],
                ['uri' => '/games/lol/champions',  'name' => 'Champions'],
                ['uri' => '/games/lol/champions/' . $id,  'name' => $name],
            ];

            return $this->breadcrumbRenderer->render($breadcrumbs);
        }

        /**
         * @param array $champion
         *
         * @return MetaTags
         */
        private function handleMetaTags(array $champion)
        {
            $metaTags = new MetaTags;
            $metaTags->setTitle($champion['name'] . ' (' . $champion['title'] . ')');
            $metaTags->setDescription(
                'League of Legends Champion statistics for ' . $champion['name']
                . ' (' . $champion['title'] . ') updated regularly.'
            );
            $metaTags->setImage('http://cdn.ganked.net/images/lol/champion/splash/' . $champion['key'] .'_0.jpg');
            return $metaTags;
        }

        /**
         * @param array $range
         *
         * @return mixed|string
         */
        private function formatRange(array $range)
        {
            $min = min($range);
            $max = max($range);

            if ($min == $max) {
                return $min;
            }

            return $min . '-' . $max;
        }

        /**
         * @param string $template
         * @param array  $values
         * @param array  $effects
         *
         * @return string
         */
        private function renderTemplateString($template, array $values = [], array $effects = [])
        {
            $placeholders = [];

            foreach ($values as $key => $value) {
                $placeholders['{{ ' . $key . ' }}'] = $value;
            }

            foreach ($effects as $key => $value) {
                $placeholders['{{ e' . $key . ' }}'] = $value;
            }

            return strtr($template, $placeholders);
        }

        /**
         * @param string $text
         *
         * @return string
         */
        private function formatRawText($text)
        {
            return str_replace('�', '', nl2br(htmlspecialchars(strip_tags(preg_replace('/<br([ ]+\/)?>/', "\n", $text)))));
        }
    }
}
