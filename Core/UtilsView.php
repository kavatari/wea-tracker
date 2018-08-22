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

namespace WeaItSolutions\Oxid\WeaTracker\Core;

use OxidEsales\Eshop\Core\Registry;
use WeaItSolutions\Oxid\WeaTracker\Model\WeaTracker;

class UtilsView extends UtilsView_parent
{
    /**
     * Registers a new function "wea_tracker".
     *
     * @param bool $blReload
     * @return mixed
     */
    public function getSmarty($blReload = false)
    {
        $oSmarty = parent::getSmarty($blReload);
        // New function.
        $oSmarty->register_function('wea_tracker', [\WeaItSolutions\Oxid\WeaTracker\Core\UtilsView::class, 'wea_tracker'], false);

        return $oSmarty;
    }

    /**
     *
     * @param $params
     * @param $smarty
     * @return string
     */
    public static function wea_tracker($params, &$smarty)
    {
        $oConfig = Registry::getConfig();
        if ($oConfig->getConfigParam('wea_tracker_emos_active') == true
            || $oConfig->getConfigParam('wea_tracker_gtag_active') == true) {
            /* @var WeaTracker */
            $oTracker = Registry::get(\WeaItSolutions\Oxid\WeaTracker\Model\WeaTracker::class);
            return $oTracker->getCode($params, $smarty);
        }
        return '';
    }
}
