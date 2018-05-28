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
namespace WeaItSolutions\Oxid\WeaTracker\Controller;

use \OxidEsales\Eshop\Core\Config;
use \OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Str;

class ThankYou extends ThankYou_parent
{
    public function getEmosCode(&$aEmos)
    {
        $oCur = $this->getConfig()->getActShopCurrencyObject();
        $oUser = $this->getUser();
        $oStr = Str::getStr();

        $oOrder = $this->getOrder();
        $oBasket = $this->getBasket();

        $sCountry = $oOrder->oxorder__oxbillcountry->value;
        $sZip = $oOrder->oxorder__oxbillzip->value;
        $sCity = $oOrder->oxorder__oxbillcity->value;

        $sPlace = $sCountry;
        $sPlace .= '/'.$oStr->substr($sZip, 0, 1)."/".$oStr->substr($sZip, 0, 2)."/";
        $sPlace .= '/'.$sCity;
        $sPlace .= '/'.$sZip;

        $aBilling = [
            $oOrder->oxorder__oxordernr->value,
            md5($oUser->oxuser__oxusername->value),
            $sPlace,
            $oBasket->getPrice()->getBruttoPrice() * (1 / $oCur->rate)
        ];

        $aBasket = [];
        $aBasketProducts = $oBasket->getContents();
        foreach ($aBasketProducts as $oContent) {
            /** @var \OxidEsales\Eshop\Application\Model\BasketItem $oContent */
            $sId = $oContent->getProductId();

            /** @var \OxidEsales\Eshop\Application\Model\Article $oProduct */
            $oProduct = oxNew(\OxidEsales\Eshop\Application\Model\Article::class);
            $oProduct->load($sId);

            $aBasket[] = $oProduct->getEmosItem($oContent->getAmount())->toEmosArray('buy');
        }

        $aEmos['content'] = 'Shopping/Checkout/OrderConfirmation';
        $aEmos['orderProcess'] = '5_OrderConfirmation';
        $aEmos['billing'] = [$aBilling];
        $aEmos['ec_Event'] = $aBasket;

        return $aEmos;
    }
}