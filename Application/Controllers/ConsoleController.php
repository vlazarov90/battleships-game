<?php
/**
 * Created by PhpStorm.
 * User: veso
 * Date: 8/6/2016
 * Time: 12:45
 */

namespace Application\Controllers;


use Application\Models\Board;

class ConsoleController extends MainController
{
    protected $newLine = PHP_EOL;

    public function index()
    {
        $stdin = fopen('php://stdin', 'r');

        /** @var  $board Board */
        $board = $this->createBoard();

        echo $this->getBoard($board);
        $this->handleInput($stdin, $board);


        while (($board->getShipsCount() !== 0)) {
            $this->handleInput($stdin, $board);
        }

        echo "Well done! You completed the game in {$board->getShots()} shots";
    }

    /**
     * Handle console input
     * @param $stdin
     * @param Board $board
     */
    private function handleInput($stdin, Board $board)
    {
        echo "Enter coordinates (row, col), e.g. A5 or enter show to see your progress: ";
        $input = trim(fgets($stdin));

        if ($input === parent::SHOW) {
           echo $this->getBoard($board, $show = true);
        } else {
           echo $this->shoot($input, $board).PHP_EOL;
            echo $this->getBoard($board);
        }
    }
}