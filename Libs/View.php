<?php
/**
 * Created by PhpStorm.
 * User: veso
 * Date: 8/6/2016
 * Time: 14:53
 */

namespace Libs;


class View
{
    private $title;

    public function __construct()
    {
        $this->header = VIEWS_DIR.DIRECTORY_SEPARATOR."header.php";
        $this->footer = VIEWS_DIR.DIRECTORY_SEPARATOR."footer.php";
    }

    /**
     * @param $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Render template
     * @param $filename
     * @return string
     */
    public function render($filename)
    {
        $fullPath = VIEWS_DIR.DIRECTORY_SEPARATOR.$filename.".php";

        ob_start();

        require_once $this->header;
        require_once $fullPath;
        require_once $this->footer;

        return ob_get_clean();
    }
}