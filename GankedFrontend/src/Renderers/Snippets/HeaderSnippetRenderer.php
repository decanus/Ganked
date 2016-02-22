<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Renderers
{

    use Ganked\Library\Backends\DomBackend;
    use Ganked\Library\DataObjects\Accounts\AnonymousAccount;
    use Ganked\Library\DataObjects\Accounts\RegisteredAccount;

    class HeaderSnippetRenderer extends AbstractSnippetRenderer
    {
        /**
         * @var DomBackend
         */
        private $domBackend;

        /**
         * @param DomBackend $domBackend
         */
        public function __construct(DomBackend $domBackend)
        {
            $this->domBackend = $domBackend;
        }

        protected function doRender()
        {
            $model = $this->getModel();
            $account = $model->getAccount();
            $template = $this->getTemplate();

            $exploded = $model->getRequestUri()->getExplodedPath();

            if (isset($exploded[0]) && $exploded[0] === 'games' && isset($exploded[1]) && !isset($exploded[2])) {
                $headers = $template->getElementsByTagName('header');
                $landingHeader = $headers->item(1);

                $landingHeader->insertBefore($headers->item(0), $landingHeader->firstChild);
            }

            if ($account instanceof AnonymousAccount) {
                return;
            }

            $dropdown = $template->getElementById('userDropdown');
            $dropdown->setAttribute('class', 'user user-dropdown');

            $avatar = $dropdown->appendChild($template->createElement('div'));
            $avatar->setAttribute('class', 'avatar-box avatar');

            $img = $avatar->appendChild($template->createElement('img'));
            $img->setAttribute('class', 'image');
            $img->setAttribute('src', '//cdn.ganked.net/images/lol/champion/icon/Rammus.png');

            $dropdownElement = $dropdown->appendChild($template->createElement('div'));
            $dropdownElement->setAttribute('class', 'dropdown');
            $dropdownElement->setAttribute('hidden', '');

            $content = $dropdownElement->appendChild($template->createElement('div'));
            $content->setAttribute('class', 'content');

            /**
             * @var $account RegisteredAccount
             */
            $name = $content->appendChild($template->createElement('h2', $account->getUsername()));
            $name->setAttribute('class', '_noMargin');

            $email = $content->appendChild($template->createElement('span', $account->getEmail()));
            $email->setAttribute('class', '_grey');

            $nav = $content->appendChild($template->createElement('nav'));
            $nav->setAttribute('class', 'nav');

            $list = $nav->appendChild($template->createElement('ul'));

            $profile = $template->createElement('li');
            $profileLink = $template->createElement('a', 'Profile');
            $profileLink->setAttribute('href', '/profile/' . $account->getUsername());
            $profile->appendChild($profileLink);
            $list->appendChild($profile);

            $accountElement = $template->createElement('li');
            $accountLink = $template->createElement('a', 'Account');
            $accountLink->setAttribute('href', '/account');
            $accountElement->appendChild($accountLink);
            $list->appendChild($accountElement);

            $signOut = $template->createElement('li');
            $form = $signOut->appendChild($template->createElement('form'));
            $form->setAttribute('action', '//post.ganked.net/action/logout');
            $form->setAttribute('method', 'post');
            $link = $form->appendChild($template->createElement('button', 'Sign Out'));
            $link->setAttribute('class', 'plain-button');
            $link->setAttribute('type', 'submit');
            $token = $form->appendChild($template->createElement('input'));
            $token->setAttribute('type', 'hidden');
            $token->setAttribute('name', 'token');

            $list->appendChild($signOut);
        }
    }
}
