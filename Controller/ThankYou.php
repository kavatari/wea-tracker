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
    protected $aBasketProducts = null;

    /**
     * Loads and returns an product array.
     *
     * @return array|null
     */
    protected function getBasketProducts()
    {
        if ($this->aBasketProducts === null) {
            $this->aBasketProducts = [];
            $oBasket = $this->getBasket();
            $aBasketProducts = $oBasket->getContents();
            foreach ($aBasketProducts as $oContent) {
                /** @var \OxidEsales\Eshop\Application\Model\BasketItem $oContent */
                $sId = $oContent->getProductId();

                /** @var \OxidEsales\Eshop\Application\Model\Article $oProduct */
                $oProduct = oxNew(\OxidEsales\Eshop\Application\Model\Article::class);
                $oProduct->load($sId);

                $this->aBasketProducts[] = ['product' => $oProduct, 'amount' => $oContent->getAmount()];
            }
        }

        return $this->aBasketProducts;
    }

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
        $sPlace .= '/' . $oStr->substr($sZip, 0, 1) . "/" . $oStr->substr($sZip, 0, 2) . "/";
        $sPlace .= '/' . $sCity;
        $sPlace .= '/' . $sZip;

        $aBilling = [
            $oOrder->oxorder__oxordernr->value,
            md5($oUser->oxuser__oxusername->value),
            $sPlace,
            $oBasket->getPrice()->getBruttoPrice() * (1 / $oCur->rate)
        ];

        $aBasket = [];
        foreach ($this->getBasketProducts() as $aProdData) {
            $aBasket[] = $aProdData['product']->getEmosItem($aProdData['amount'])->toEmosArray('buy');
        }

        $aEmos['content'] = 'Shopping/Checkout/OrderConfirmation';
        $aEmos['orderProcess'] = '5_OrderConfirmation';
        $aEmos['billing'] = [$aBilling];
        $aEmos['ec_Event'] = $aBasket;

        if ($this->getConfig()->getConfigParam('wea_tracker_emos_extorder')) {
            // Credit card type.
            $sCcType = 'n.a.';
            // Payment type.
            $sPaymentType = $oOrder->oxorder__oxpaymenttype->value;
            try {
                $oPayment = oxNew('oxPayment');
                if ($oPayment->load($sPaymentType)) {
                    $sPaymentType = $oPayment->oxpayments__oxdesc->value;
                }
            } catch (Exception $ex) {
            }
            // Delivery info.
            $sDelSet = ($oOrder->oxorder__oxdeltype->value && !empty($oOrder->oxorder__oxdeltype->value) ? $oOrder->oxorder__oxdeltype->value : 'n.a.');
            try {
                if ($sDelSet !== 'n.a.') {
                    $oDelivery = oxNew('oxDeliverySet');
                    if ($oDelivery->load($sDelSet)) {
                        $sDelSet = $oDelivery->oxdeliveryset__oxtitle->value;
                    }
                }
            } catch (Exception $ex) {
            }

            $fDelPrice = $oOrder->getOrderDeliveryPrice()->getPrice();
            // Customer type.
            $sUserType = 'Guest';
            if ($oUser && $oUser->hasAccount()) {
                $sUserType = 'NewCustomer';
                if ($oUser->getOrderCount() > 1) {
                    $sUserType = 'RegularCustomer';
                }
            }
            // Extended billing information.
            $aEmos['billext'] = array(array(
                $sPaymentType, $sDelSet, $fDelPrice, $sUserType, $sCcType,
            ));
        }

        return $aEmos;
    }

    public function getGoogleTagEvents(&$aGoogleTagEvents)
    {
        $oOrder = $this->getOrder();
        $oBasket = $this->getBasket();
        $oCur = $this->getConfig()->getActShopCurrencyObject();

        $aBasket = [];
        foreach ($this->getBasketProducts() as $aProdData) {
            $aBasket[] = $aProdData['product']->getGoogleItem($aProdData['amount'])->toArray();
        }

        $aGoogleTagEvents['purchase'] = [
            'transaction_id' => $oOrder->oxorder__oxordernr->value,
            'shipping' => $oOrder->oxorder__oxdelcost->value,
            'value' => $oBasket->getPrice()->getBruttoPrice() * (1 / $oCur->rate),
            'items' => $aBasket,
            'affiliation' => '',
            'tax' => $oOrder->oxorder__oxartvatprice1->value,
            'currency' => $oOrder->oxorder__oxcurrency->value
        ];

        return $aGoogleTagEvents;
    }
}