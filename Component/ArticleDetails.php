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

namespace WeaItSolutions\Oxid\WeaTracker\Component;


use WeaItSolutions\Oxid\WeaTracker\Model\EmosItem;

class ArticleDetails extends ArticleDetails_parent
{
    /**
     * Returns the main emos code.
     *
     * @param $aEmos
     * @return mixed
     */
    public function getEmosCode(&$aEmos)
    {
        $aEmos['content'] = $this->getProduct()->getEmosContent();
        $aEmos['ec_Event'] = [$this->getEmosEvent('view')];

        return $aEmos;
    }

    /**
     * Prepare and return the emos event.
     *
     * @return mixed
     */
    protected function getEmosEvent($sType = 'view')
    {
        return $this->getProduct()->getEmosItem()->toEmosArray($sType);
    }
}