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
use \OxidEsales\Eshop\Core\Session;

class User extends User_parent
{
    public function getEmosCode(&$aEmos)
    {
        $oRequest = Registry::getRequest();
        $oSession = Registry::getSession();
        $sOption = $oRequest->getRequestParameter('option');
        $sOption = (isset($sOption)) ? $sOption : $oSession->getVariable('option');

        $sUserAction = 'Shopping/Checkout/AccountData';
        $sOrderStep = '2_AccountData';
        switch ($sOption) {
            case 1:
                $sUserAction = 'Shopping/Checkout/AccountData/Guest';
                if ($this->getIsOrderStep()) {
                    $sOrderStep = $sOrderStep . '/Guest';
                }
                break;
            case 2:
                $sUserAction = 'Shopping/Checkout/AccountData/Customer';
                if ($this->getIsOrderStep()) {
                    $sOrderStep = $sOrderStep . '/Customer';
                }
                break;
            case 3:
                $sUserAction = 'Shopping/Checkout/AccountData/NewCustomer';
                if ($this->getIsOrderStep()) {
                    $sOrderStep = $sOrderStep . '/NewCustomer';
                }
                break;
        }

        if ($this->getFncName() === 'login_noredirect') {
            $oUser = $this->getUser();
            $aEmos['login'] = array(
                array(
                    md5($oRequest->getRequestParameter('lgn_usr')),($oUser ? '0' : '1')
                )
            );
        }

        $aEmos['content'] = $sUserAction;
        $aEmos['orderProcess '] = $sOrderStep;

        return $aEmos;
    }
}