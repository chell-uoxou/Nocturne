<?php
/**
 * Created by PhpStorm.
 * User: 20150176
 * Date: 2017/09/30
 * Time: 17:07
 */
namespace nocturne\display;

use nocturne\display\output\Console;

class Display
{
    const CONSOLE = 0;

    public $prefix;
    private $console;

    public function init(){
        $this->console = new Console();
        $prefix = "[INFO] "; //////
    }

    public function getConsole(){
        return $this->console;
    }

}