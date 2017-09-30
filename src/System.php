<?php
/**
 * Created by PhpStorm.
 * User: 20150176
 * Date: 2017/09/30
 * Time: 16:06
 */

namespace nocturne;


use nocturne\command\Command;
use nocturne\command\CommandExecutor;
use nocturne\display\Display;
use nocturne\display\Logger;

class System
{
    private $command;
    private $display;


    public function init(){
        $this->command = new Command();
        $this->command->init();
        $this->display = new Display();
        $this->display->init();
    }

    public function getCommand(){
        return $this->command;
    }

    public function getLogger(){
        return new Logger(Logger::SYSTEM);
    }

    public function getDisplay(){
        return $this->display;
    }

    public function standByInput(){
        while(true){
            $strings = trim(fgets(STDIN));
            $arrayStrings = explode(" ",$strings);
            $command = $arrayStrings[0];
            $args = array_splice($arrayStrings,1,count($arrayStrings) - 1);
            $this->getCommand()->getExecutor($command)->execute($args);
        }
    }
}