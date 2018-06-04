<?php
/**
 * Created by PhpStorm.
 * User: Eugen
 * Date: 04.06.2018
 * Time: 20:44
 */

namespace WeaItSolutions\Oxid\WeaTracker\Core;

use \OxidEsales\Eshop\Core\Registry;

class ModuleEvents
{
    /**
     * Function is called during module deactivation.
     */
    public static function onDeactivate()
    {
        // Clear smarty cache on module deactivation to avoid template errors.
        Registry::getUtils()->resetTemplateCache([
            'widget/product/details',
            'page/account/forgotpwd',
            'page/account/login',
            'page/account/newsletter',
            'page/account/noticelist',
            'page/account/order',
            'page/account/password',
            'page/account/register_success',
            'page/account/user',
            'page/account/wishlist',
            'page/checkout/basket',
            'page/checkout/order',
            'page/checkout/payment',
            'page/checkout/thankyou',
            'page/checkout/user',
            'page/info/content',
            'page/info/newsletter',
            'page/list/list',
            'page/search/search',
            'page/shop/start',
            'page/wishlist/wishlist',
            'page/account/dashboard'
        ]);
    }
}