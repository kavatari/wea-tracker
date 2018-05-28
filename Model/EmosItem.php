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


class EmosItem
{
    public $sProductId;
    public $sProductName;
    public $dPrice;
    public $sGroup;
    public $iQuantity;
    public $sVariant1;
    public $sVariant2;
    public $sVariant3;

    public function toEmosArray($sType)
    {
        return [$sType,
            $this->sProductId,
            $this->sProductName,
            $this->dPrice,
            $this->sGroup,
            $this->iQuantity,
            ($this->sVariant1 === null ? 'NULL' : $this->sVariant1),
            ($this->sVariant2 === null ? 'NULL' : $this->sVariant2),
            ($this->sVariant3 === null ? 'NULL' : $this->sVariant3)];
    }
}