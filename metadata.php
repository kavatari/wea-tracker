<?php
/**
 * This file is part of WEA IT-Solutions wea-tracker module.
 *
 * WEA IT-Solutions wea-tracker module is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * WEA IT-Solutions wea-tracker module is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with WEA IT-Solutions wea-tracker module.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @link http://www.wea-it.com
 * @copyright (C) WEA IT-Solutions 2018
 */

// Metadata version.
$sMetadataVersion = '2.0';

$aModule = array(
    'id' => 'wea_tracker',
    'title' => 'Oxid Tracker by WEA IT-Solutions',
    'description' => array(
        'de' => file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . '/translations/de/description.html'),
        'en' => file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . '/translations/en/description.html'),
    ),
    'thumbnail' => 'wea-it-solutions.png',
    'version' => '1.0',
    'author' => 'WEA IT-Solutions',
    'url' => 'http://www.wea-it.com/',
    'email' => 'info@wea-it.com',
    'extend' => array(
        \OxidEsales\Eshop\Core\UtilsView::class => WeaItSolutions\Oxid\WeaTracker\Core\UtilsView::class,
        \OxidEsales\Eshop\Application\Component\Widget\ArticleDetails::class => WeaItSolutions\Oxid\WeaTracker\Component\ArticleDetails::class,
        \OxidEsales\Eshop\Application\Controller\SearchController::class => WeaItSolutions\Oxid\WeaTracker\Controller\Search::class,
        \OxidEsales\Eshop\Application\Controller\PaymentController::class => WeaItSolutions\Oxid\WeaTracker\Controller\Payment::class,
        \OxidEsales\Eshop\Application\Controller\UserController::class => WeaItSolutions\Oxid\WeaTracker\Controller\User::class,
        \OxidEsales\Eshop\Application\Controller\RegisterController::class => WeaItSolutions\Oxid\WeaTracker\Controller\Register::class,
        \OxidEsales\Eshop\Application\Controller\StartController::class => WeaItSolutions\Oxid\WeaTracker\Controller\Start::class,
        \OxidEsales\Eshop\Application\Controller\ArticleListController::class => WeaItSolutions\Oxid\WeaTracker\Controller\ArticleList::class,
        \OxidEsales\Eshop\Application\Controller\AccountController::class => WeaItSolutions\Oxid\WeaTracker\Controller\Account::class,
        \OxidEsales\Eshop\Application\Controller\ContentController::class => WeaItSolutions\Oxid\WeaTracker\Controller\Content::class,
        \OxidEsales\Eshop\Application\Controller\ManufacturerListController::class => WeaItSolutions\Oxid\WeaTracker\Controller\ManufacturerList::class,
        \OxidEsales\Eshop\Application\Controller\ContactController::class => WeaItSolutions\Oxid\WeaTracker\Controller\Contact::class,
        \OxidEsales\Eshop\Application\Controller\NewsletterController::class => WeaItSolutions\Oxid\WeaTracker\Controller\Newsletter::class,
        \OxidEsales\Eshop\Application\Controller\OrderController::class => WeaItSolutions\Oxid\WeaTracker\Controller\Order::class,
        \OxidEsales\Eshop\Application\Controller\ThankYouController::class => WeaItSolutions\Oxid\WeaTracker\Controller\ThankYou::class,
        \OxidEsales\Eshop\Application\Model\Article::class => WeaItSolutions\Oxid\WeaTracker\Model\Article::class,
        \OxidEsales\Eshop\Application\Component\BasketComponent::class => WeaItSolutions\Oxid\WeaTracker\Component\Basket::class,
        \OxidEsales\Eshop\Application\Controller\BasketController::class => WeaItSolutions\Oxid\WeaTracker\Controller\Basket::class,
        \OxidEsales\Eshop\Application\Controller\AccountNoticeListController::class => WeaItSolutions\Oxid\WeaTracker\Controller\AccountNoticeList::class,
        \OxidEsales\Eshop\Application\Controller\AccountWishlistController::class => WeaItSolutions\Oxid\WeaTracker\Controller\AccountWishlist::class,
        \OxidEsales\Eshop\Application\Controller\AccountOrderController::class => WeaItSolutions\Oxid\WeaTracker\Controller\AccountOrder::class,
        \OxidEsales\Eshop\Application\Controller\AccountUserController::class => WeaItSolutions\Oxid\WeaTracker\Controller\AccountUser::class,
        \OxidEsales\Eshop\Application\Controller\AccountNewsletterController::class => WeaItSolutions\Oxid\WeaTracker\Controller\AccountNewsletter::class,
        \OxidEsales\Eshop\Application\Controller\AccountPasswordController::class => WeaItSolutions\Oxid\WeaTracker\Controller\AccountPassword::class,
    ),
    'controllers' => array(),
    // Events.
    'events' => array(
        'onDeactivate' => \WeaItSolutions\Oxid\WeaTracker\Core\ModuleEvents::onDeactivate(),
    ),
    'templates' => array(),
    'blocks' => array(
        array(
            'template' => 'widget/product/details.tpl',
            'block' => 'wea_tracker',
            'file' => 'views/block/wea_tracker.tpl',
        ),
        array(
            'template' => 'page/account/forgotpwd.tpl',
            'block' => 'wea_tracker',
            'file' => 'views/block/wea_tracker.tpl',
        ),
        array(
            'template' => 'page/account/login.tpl',
            'block' => 'wea_tracker',
            'file' => 'views/block/wea_tracker.tpl',
        ),
        array(
            'template' => 'page/account/newsletter.tpl',
            'block' => 'wea_tracker',
            'file' => 'views/block/wea_tracker.tpl',
        ),
        array(
            'template' => 'page/account/noticelist.tpl',
            'block' => 'wea_tracker',
            'file' => 'views/block/wea_tracker.tpl',
        ),
        array(
            'template' => 'page/account/order.tpl',
            'block' => 'wea_tracker',
            'file' => 'views/block/wea_tracker.tpl',
        ),
        array(
            'template' => 'page/account/password.tpl',
            'block' => 'wea_tracker',
            'file' => 'views/block/wea_tracker.tpl',
        ),
        array(
            'template' => 'page/account/register_success.tpl',
            'block' => 'wea_tracker',
            'file' => 'views/block/wea_tracker.tpl',
        ),
        array(
            'template' => 'page/account/user.tpl',
            'block' => 'wea_tracker',
            'file' => 'views/block/wea_tracker.tpl',
        ),
        array(
            'template' => 'page/account/wishlist.tpl',
            'block' => 'wea_tracker',
            'file' => 'views/block/wea_tracker.tpl',
        ),
        array(
            'template' => 'page/checkout/basket.tpl',
            'block' => 'wea_tracker',
            'file' => 'views/block/wea_tracker.tpl',
        ),
        array(
            'template' => 'page/checkout/order.tpl',
            'block' => 'wea_tracker',
            'file' => 'views/block/wea_tracker.tpl',
        ),
        array(
            'template' => 'page/checkout/payment.tpl',
            'block' => 'wea_tracker',
            'file' => 'views/block/wea_tracker.tpl',
        ),
        array(
            'template' => 'page/checkout/thankyou.tpl',
            'block' => 'wea_tracker',
            'file' => 'views/block/wea_tracker.tpl',
        ),
        array(
            'template' => 'page/checkout/user.tpl',
            'block' => 'wea_tracker',
            'file' => 'views/block/wea_tracker.tpl',
        ),
        array(
            'template' => 'page/info/content.tpl',
            'block' => 'wea_tracker',
            'file' => 'views/block/wea_tracker.tpl',
        ),
        array(
            'template' => 'page/info/newsletter.tpl',
            'block' => 'wea_tracker',
            'file' => 'views/block/wea_tracker.tpl',
        ),
        array(
            'template' => 'page/list/list.tpl',
            'block' => 'wea_tracker',
            'file' => 'views/block/wea_tracker.tpl',
        ),
        array(
            'template' => 'page/search/search.tpl',
            'block' => 'wea_tracker',
            'file' => 'views/block/wea_tracker.tpl',
        ),
        array(
            'template' => 'page/shop/start.tpl',
            'block' => 'wea_tracker',
            'file' => 'views/block/wea_tracker.tpl',
        ),
        array(
            'template' => 'page/wishlist/wishlist.tpl',
            'block' => 'wea_tracker',
            'file' => 'views/block/wea_tracker.tpl',
        ),
        array(
            'template' => 'page/account/dashboard.tpl',
            'block' => 'wea_tracker',
            'file' => 'views/block/wea_tracker.tpl',
        ),
    ),
    // Module settings.
    'settings' => array(
        array(
            'group' => 'wea_tracker_general',
            'name' => 'wea_tracker_general_opt',
            'type' => 'select',
            'value' => '0',
            'constrains' => '0|1|2'
        ),
        array(
            'group' => 'wea_tracker_general',
            'name' => 'wea_tracker_general_artnum',
            'type' => 'select',
            'value' => '0',
            'constrains' => '0|1'
        ),
        array(
            'group' => 'wea_tracker_emos',
            'name' => 'wea_tracker_emos_active',
            'type' => 'bool',
        ),
        array(
            'group' => 'wea_tracker_emos',
            'name' => 'wea_tracker_emos_file',
            'type' => 'str',
            'value' => 'emos.js'
        ),
        array(
            'group' => 'wea_tracker_gtag',
            'name' => 'wea_tracker_gtag_active',
            'type' => 'bool',
        ),
        array(
            'group' => 'wea_tracker_gtag',
            'name' => 'wea_tracker_gtag_analytics',
            'type' => 'str',
        ),
        array(
            'group' => 'wea_tracker_gtag',
            'name' => 'wea_tracker_gtag_anonymizeip',
            'type' => 'bool',
        ),
    ),
);