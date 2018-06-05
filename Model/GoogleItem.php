<?php
/**
 * Created by PhpStorm.
 * User: Eugen
 * Date: 05.06.2018
 * Time: 19:28
 */

namespace WeaItSolutions\Oxid\WeaTracker\Model;


class GoogleItem
{
    public $id;
    public $name;
    public $category;
    public $price;
    public $quantity;

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category,
            'price' => $this->price,
            'quantity' => $this->quantity
        ];
    }
}