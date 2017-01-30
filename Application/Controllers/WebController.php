<?php
/**
 * Created by PhpStorm.
 * User: veso
 * Date: 8/6/2016
 * Time: 12:44
 */

namespace Application\Controllers;

use Application\Models\Board;
use Libs\Request;
use Libs\Session;
use Libs\View;

class WebController extends MainController
{
    const BOARD = 'board';
    const SHOOT = 'shoot';

    protected $newLine = "<br/>";

    public function index()
    {
        /** @var  $board Board */
        $board = Session::read(self::BOARD) ?: $this->createBoard();

        $input = Request::getPostParam(self::SHOOT);

        $view = new View();

        $view->message = $this->shoot($input, $board);

        Session::write(self::BOARD, $board);

        $view->setTitle("Battle Ships");

        if($board->getShipsCount() === 0){
            $view->shots = $board->getShots();
            Session::destroy();

            echo $view->render('end');
        }else{
            if($input === parent::SHOW){
                $view->board = $this->getBoard($board, $show = true);
            }else{
                $view->board = $this->getBoard($board);
            }

            echo $view->render("index");
        }

    }

}