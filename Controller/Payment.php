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

use \OxidEsales\Eshop\Core\Request;
use \OxidEsales\Eshop\Core\Registry;

class Payment extends Payment_parent
{
    public function getEmosCode(&$aEmos)
    {
        $oRequest = Registry::getRequest();
        if ($oRequest->getRequestParameter('new_user')) {
            $iError = $oRequest->getRequestParameter('newslettererror');
            $iSuccess = $oRequest->getRequestParameter('success');
            $oUser = $this->getUser();

            if ($iError && $iError < 0) {
                $sHashedId = md5($oUser ? $oUser->getId() : 'NULL');
                $aEmos['register'] = array(array($sHashedId, abs($iError)));
            }

            if ($iSuccess && $iSuccess > 0 && $oUser) {
                $aEmos['register'] = array(array($this->getUser()->getId(), abs($iError)));
            }
        }

        if ($this->getIsOrderStep()) {
            $aEmos['content'] = 'Shopping/Checkout/PaymentOptions';
            $aEmos['orderProcess'] = '3_PaymentOptions';
        }

        return $aEmos;
    }
}