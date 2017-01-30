<?php
/**
 * Created by PhpStorm.
 * User: veso
 * Date: 8/6/2016
 * Time: 13:43
 */

namespace Application\Models;


class Board
{
    private $x;
    private $y;
    private $ships = [];
    private $board;
    private $shots = 0;
    private $shipsCount;

    const SHIP = "ship";
    const STATE = "state";
    const STATE_OPEN = 0;
    const STATE_MISSED = 1;
    const STATE_HIT = 2;
    const STATE_SUNKED = 3;

    /**
     * Assemble board
     * @return $this
     */
    public function init()
    {
        $this->assembleBoard();
        $this->placeShips();
        $this->shipsCount = count($this->ships);

        return $this;
    }

    /**
     * Get array with positions
     * @return array
     */
    public function getBoardPositions()
    {
        return $this->board;
    }

    /**
     * @param Ship $ship
     */
    public function addShip(Ship $ship)
    {
        $this->ships[] = $ship;
    }

    /**
     * @return int
     */
    public function getShipsCount()
    {
        return $this->shipsCount;
    }

    /**
     * Perform a shoot and return if is successful
     * @param $position
     * @return int
     */
    public function shoot($position)
    {
        $positions = $this->parseInput($position);

        $y = $positions['y'];
        $x = $positions['x'];

        /** @var  $ship Ship */
        $ship = $this->board[$y][$x][self::SHIP];

        if ($ship) {
            $this->board[$y][$x][self::STATE] = self::STATE_HIT;
            $ship->hit();

            if ($ship->isSunked()) {
                $this->shipsCount--;
                $this->board[$y][$x][self::STATE] = self::STATE_SUNKED;
            }

        } else {
            $this->board[$y][$x][self::STATE] = self::STATE_MISSED;
        }

        $this->shots++;

        return $this->board[$y][$x][self::STATE];
    }

    /**
     * Set board height
     * @param string $end
     * @throws \Exception
     */
    public function setHeight($end = "J")
    {
        if (!preg_match("/^[a-zA-Z]$/", $end)) {
            throw new \Exception("Invalid parameter");
        }

        $this->y = range("A", strtoupper($end));
    }

    /**
     * Set board width
     * @param int $end
     * @throws \Exception
     */
    public function setWidth($end = 10)
    {
        if (!is_int($end) || ($end < 1)) {
            throw new \Exception("Invalid parameter");
        }

        $this->x = range(1, $end);
    }

    /**
     * Create array with positions
     */
    private function assembleBoard()
    {
        foreach ($this->y as $y) {
            foreach ($this->x as $x) {
                $this->board[$y][$x][self::STATE] = self::STATE_OPEN;
                $this->board[$y][$x][self::SHIP] = null;
            }
        }
    }

    /**
     * Place ships on the board
     */
    private function placeShips()
    {
        foreach ($this->ships as $ship) {
            /** @var $ship Ship */
            $this->placeShip($ship);
        }
    }

    /**
     * Determinate position of a ship
     * @param Ship $ship
     */
    private function placeShip(Ship $ship)
    {
        $xLength = count($this->x);
        $yLength = count($this->y) - 1;
        $usedPositions = [];

        if ($ship->getAlign() === Ship::HORIZONTAL) {
            $x = mt_rand(1, $xLength - $ship->getLength());
            $y = mt_rand(0, $yLength);

            $limit = $x + $ship->getLength();
            for ($x; $x < $limit; $x++) {
                $usedPositions[$this->y[$y]][$x] = 0;
            }
        } else {
            $y = mt_rand(0, $yLength - $ship->getLength());
            $x = mt_rand(1, $xLength);

            $limit = $y + $ship->getLength();
            for ($y; $y < $limit; $y++) {
                $usedPositions[$this->y[$y]][$x] = 0;
            }
        }

        if ($this->checkIfPositionIsAvailable($usedPositions)) {
            foreach ($usedPositions as $y => $v) {
                foreach ($v as $x => $value) {
                    $this->board[$y][$x][self::SHIP] = $ship;
                }
            }
        } else {
            $this->placeShip($ship);
        }
    }

    /**
     * Check if position is available
     * @param $usedPositions
     * @return bool
     */
    private function checkIfPositionIsAvailable($usedPositions)
    {
        foreach ($usedPositions as $y => $v) {
            foreach ($v as $x => $value) {
                if ($this->board[$y][$x][self::SHIP]) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Get current position state
     * @param $position
     * @return int
     */
    public function getStateByPosition($position)
    {
        $positions = $this->parseInput($position);

        return $this->board[$positions['y']][$positions['x']][self::STATE];
    }

    /**
     * Get ship by position
     * @param $position
     * @return mixed
     */
    public function getShipByPosition($position)
    {
        $positions = $this->parseInput($position);

        return $this->board[$positions['y']][$positions['x']][self::SHIP];
    }

    /**
     * Get performed shots
     * @return int
     */
    public function getShots()
    {
        return $this->shots;
    }

    /**
     * Parse input to coordinates
     * @param $position
     * @return array
     */
    private function parseInput($position)
    {
        $pieces = preg_split('/(?<=[a-z])(?=[0-9]+)/i', $position);

        $y = strtoupper($pieces[0]);
        $x = $pieces[1];

        return array("x" => $x, "y" => $y);
    }

    /**
     * Check if position is valid
     * @param $position
     * @return bool
     */
    public function validatePosition($position)
    {
        $pieces = preg_split('/(?<=[a-z])(?=[0-9]+)/i', $position);

        if (count($pieces) !== 2) {
            return false;
        }

        $y = strtoupper($pieces[0]);
        $x = $pieces[1];

        if (!in_array($y, $this->y)) {
            return false;
        }

        if (!in_array($x, $this->x)) {
            return false;
        }

        return true;
    }
}