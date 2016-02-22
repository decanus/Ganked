<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Renderers
{

    use Ganked\Frontend\Models\AccountPageModel;
    use Ganked\Library\Backends\DomBackend;
    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Skeleton\Transformations\SnippetTransformation;
    use Ganked\Skeleton\Transformations\TextTransformation;

    class AccountPageRenderer extends AbstractPageRenderer
    {
        /**
         * @var SteamOpenIdLinkRenderer
         */
        private $steamOpenIdLinkRenderer;

        /**
         * @param DomBackend              $domBackend
         * @param DomHelper               $template
         * @param SnippetTransformation   $snippetTransformation
         * @param TextTransformation      $textTransformation
         * @param GenericPageRenderer     $genericPageRenderer
         * @param SteamOpenIdLinkRenderer $steamOpenIdLinkRenderer
         */
        public function __construct(
            DomBackend $domBackend,
            DomHelper $template,
            SnippetTransformation $snippetTransformation,
            TextTransformation $textTransformation,
            GenericPageRenderer $genericPageRenderer,
            SteamOpenIdLinkRenderer $steamOpenIdLinkRenderer
        )
        {
            parent::__construct(
                $domBackend,
                $template,
                $snippetTransformation,
                $textTransformation,
                $genericPageRenderer
            );

            $this->steamOpenIdLinkRenderer = $steamOpenIdLinkRenderer;
        }

        protected function doRender()
        {
            $this->setTitle('Account');

            /**
             * @var $model AccountPageModel
             */
            $model = $this->getModel();

            $template = $this->getTemplate();
            $main = $template->getElementById('main');

            $main->appendChild($template->createElement('h1', 'Account Settings'));

            $overviewBox = $template->createElement('div');
            $overviewBox->setAttribute('class', 'generic-box -center');

            $overviewBox->appendChild($template->createTextNode('This section is still under construction'));

            $main->appendChild($overviewBox);

            $main->appendChild($this->renderSteamOverview());
        }

        /**
         * @return \DOMElement
         */
        private function renderSteamOverview()
        {
            $template = $this->getTemplate();
            $data = $this->getModel()->getAccountData();

            $overviewBox = $template->createElement('div');
            $overviewBox->setAttribute('class', 'generic-box -center');

            $overviewBox->appendChild($template->createElement('h2', 'Steam Accounts'));

            if (isset($data['attributes']['steamIds'])) {

                $list = $template->createElement('ul');

                foreach ($data['attributes']['steamIds'] as $steamAccount) {
                    $item = $template->createElement('li');
                    $link = $template->createElement('a');

                    $nameValue = $steamAccount['id'];
                    if (isset($steamAccount['name']) && $steamAccount['name'] !== '') {
                        $nameValue = $steamAccount['name'];
                    }

                    $link->appendChild($template->createTextNode($nameValue));
                    $link->setAttribute('href', 'https://steamcommunity.com/profiles/' . $steamAccount['id']);
                    $item->appendChild($link);
                    $list->appendChild($item);
                }

                $overviewBox->appendChild($list);

            } else {
                $overviewBox->appendChild($template->createTextNode('There are currently no connect steam accounts'));
            }

            $overviewBox->appendChild($template->createElement('br'));

            $button = $this->steamOpenIdLinkRenderer->render('Connect more accounts', '/connect/steam');
            $button->query('/a')->item(0)->setAttribute('class', 'link-button');
            $template->importAndAppendChild($overviewBox, $button->documentElement);

            return $overviewBox;
        }
    }
}
