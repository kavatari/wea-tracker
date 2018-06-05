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

namespace WeaItSolutions\Oxid\WeaTracker\Model;

use \OxidEsales\Eshop\Core\Registry;
use \OxidEsales\Eshop\Core\Config;

class Article extends Article_parent
{
    // Cache the product path here.
    private $sProductPath = null;

    /**
     * Converts current product into econda emos item.
     *
     * @param int $iQuantity
     * @return object
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseErrorException
     */
    public function getEmosItem($iQuantity = 1)
    {
        /* @var EmosItem */
        $oEmosItem = oxNew(\WeaItSolutions\Oxid\WeaTracker\Model\EmosItem::class);
        $oEmosItem->sProductId = $this->getTrackingProductNumber();

        $oEmosItem->sProductName = $this->getTrackingProductNumber();

        $oCur = $this->getConfig()->getActShopCurrencyObject();
        $oEmosItem->dPrice = $this->getPrice()->getBruttoPrice() * (1 / $oCur->rate);
        $oEmosItem->sGroup = $this->getEmosContent();
        $oEmosItem->iQuantity = $iQuantity;
        $oEmosItem->sVariant1 = $this->getVendor() ? $this->getVendor()->getTitle() : "NULL";
        $oEmosItem->sVariant2 = $this->getManufacturer() ? $this->getManufacturer()->getTitle() : "NULL";
        $oEmosItem->sVariant3 = $this->getId();

        return $oEmosItem;
    }

    public function getGoogleItem($iQuantity = 1)
    {
        $oCur = $this->getConfig()->getActShopCurrencyObject();
        /* @var $oGoogleItem GoogleItem */
        $oGoogleItem = oxNew(\WeaItSolutions\Oxid\WeaTracker\Model\GoogleItem::class);
        $oGoogleItem->id = $this->getTrackingProductNumber();
        $oGoogleItem->name = $this->getTrackingProductName();
        $oGoogleItem->category = $this->getEmosContent();
        $oGoogleItem->price = $this->getPrice()->getBruttoPrice() * (1 / $oCur->rate);
        $oGoogleItem->quantity = $iQuantity;

        return $oGoogleItem;
    }

    protected function getTrackingProductName()
    {
        $sTitle = $this->oxarticles__oxtitle->value;
        if ($this->oxarticles__oxvarselect->value) {
            $sTitle .= " " . $this->oxarticles__oxvarselect->value;
        }

        return $sTitle;
    }

    /**
     * Returns the preferred product tracking id.
     *
     * @return string
     */
    protected function getTrackingProductNumber()
    {
        $sProductNumber = '';
        $oConfig = Registry::getConfig();
        $iCol = 0;
        if ($iTmpCol = $oConfig->getConfigParam('wea_tracker_general_artnum')) {
            $iCol = $iTmpCol;
        }

        if ($iCol == 1) {
            $sProductNumber = (isset($this->oxarticles__oxartnum->value) && $this->oxarticles__oxartnum->value) ? $this->oxarticles__oxartnum->value : $this->getId();
        } else {
            $sProductNumber = $this->getId();
        }

        return $sProductNumber;
    }

    /**
     * Returns the main category path to this product.
     *
     * @return null|string
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseErrorException
     */
    public function getEmosContent()
    {
        if ($this->sProductPath === null) {
            $oProduct = $this;
            $sTitle = $oProduct->oxarticles__oxtitle->value;
            if ($oProduct->oxarticles__oxvarselect->value) {
                $sTitle .= " " . $oProduct->oxarticles__oxvarselect->value;
            }
            /* @var $oCategory Category */
            $oCategory = $oProduct->getCategory();

            $sCatPath = '';
            $sTable = $oCategory->getViewName();
            $oDb = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
            $sQ = "select {$sTable}.oxtitle as oxtitle from {$sTable}
                       where {$sTable}.oxleft <= " . $oDb->quote($oCategory->oxcategories__oxleft->value) . " and
                             {$sTable}.oxright >= " . $oDb->quote($oCategory->oxcategories__oxright->value) . " and
                             {$sTable}.oxrootid = " . $oDb->quote($oCategory->oxcategories__oxrootid->value) . "
                       order by {$sTable}.oxleft";

            $oRs = $oDb->select($sQ);
            if ($oRs != false && $oRs->count() > 0) {
                while (!$oRs->EOF) {
                    if ($sCatPath) {
                        $sCatPath .= '/';
                    }
                    $sCatPath .= strip_tags($oRs->fields['oxtitle']);
                    $oRs->fetchRow();
                }
            }

            $this->sProductPath = 'Shopping/' . $sCatPath . '/' . $sTitle;
        }

        return $this->sProductPath;
    }
}