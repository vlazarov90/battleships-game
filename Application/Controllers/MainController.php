<?php
/**
 * Created by PhpStorm.
 * User: veso
 * Date: 8/6/2016
 * Time: 12:34
 */

namespace Application\Controllers;

use Application\Models\Board;
use Application\Models\BattleShip;
use Application\Models\Destroyer;

abstract class MainController
{
    const SHOW = 'show';

    protected $newLine;

    abstract public function index();

    /**
     * Create board using different options
     * @return $board Board
     */
    protected function createBoard()
    {
        $board = new Board();

        $board->setHeight("J");
        $board->setWidth(10);

        $board->addShip(new Destroyer());
        $board->addShip(new Destroyer());
        $board->addShip(new BattleShip());

        return $board->init();
    }

    /**
     * Perform a shoot
     * @param $input
     * @param Board $board
     * @return string
     */
    protected function shoot($input, Board $board)
    {
        if($input === self::SHOW){
            return "*** Ship cells remaining ***";
        }

        if (!empty($input) && !$board->validatePosition($input)) {
            return "*** Wrong input ***";
        }

        if ($board->validatePosition($input)) {
            if ($board->getStateByPosition($input) !== Board::STATE_OPEN) {
                return "*** Already selected ***";
            } else {
                $state = $board->shoot($input);

                switch ($state) {
                    case Board::STATE_MISSED:
                        return "*** Miss ***";
                        break;
                    case Board::STATE_HIT:
                        return "*** Hit ***";
                        break;
                    case Board::STATE_SUNKED:
                        return "*** {$board->getShipByPosition($input)->getName()} sunked ***";
                        break;
                }
            }
        }
    }

    /**
     * Show board
     * @param boolean $show
     * @param Board $board
     * @return string
     */
    protected function getBoard(Board $board, $show = false)
    {
        $boardPositions = $board->getBoardPositions();
        $i = 0;
        $keys = array_keys($boardPositions);
        $returnString = '  ';

        foreach ($boardPositions["A"] as $x => $value) {
            $returnString .= $x;
            $returnString .= ' ';
        }
        $returnString .= $this->newLine;

        foreach ($boardPositions as $x => $value) {
            $returnString .= $keys[$i];
            $returnString .= ' ';
            foreach ($value as $y => $v) {
                $returnString .= self::getPositionSign($v, $show);
                $returnString .= ' ';
            }
            $returnString .= $this->newLine;
            $i++;
        }

        return $returnString;
    }

    /**
     * Parse state to related sign
     * @param array $state
     * @param boolean $show
     * @return string
     */
    private static function getPositionSign($position, $show)
    {
        if($show){
           if(($position[Board::STATE] === Board::STATE_OPEN) && $position[Board::SHIP]){
               return "X";
           }else{
               return ' ';
           }
        }else{
            switch ($position[Board::STATE]) {
                case 0:
                    return ".";
                    break;
                case 1:
                    return "-";
                    break;
                default:
                    return "X";
                    break;
            }
        }
    }
}