<?php
/**
 * Created by PhpStorm.
 * User: veso
 * Date: 8/6/2016
 * Time: 12:46
 */

namespace Application\Models;


abstract class Ship
{
    const VERTICAL = 0;
    const HORIZONTAL = 1;

    private $sunk = false;
    private $health;
    private $align;

    public function __construct()
    {
        $this->health = $this->length;
        $this->align = mt_rand(0, 1);
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return int
     */
    public function getAlign()
    {
        return $this->align;
    }

    /**
     * @return int
     */
    public function hit()
    {
        $this->health--;

        if($this->health === 0){
            $this->sunk = true;
        }

        return $this->health;
    }

    /**
     * @return bool
     */
    public function isSunked()
    {
        return $this->sunk;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}