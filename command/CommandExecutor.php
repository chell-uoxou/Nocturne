<?php
/**
 * Created by PhpStorm.
 * User: 20150176
 * Date: 2017/09/30
 * Time: 15:35
 */

namespace nocturne\command;


use nocturne\display\Logger;
use nocturne\System;

class CommandExecutor extends Command
{
    private $command;
    private $args;
    private $line;

    public function __construct($command)
    {
        $this->command = $command;

    }

    public function execute(array $args = array()){
        $this->args = $args;
        $class = '\nocturne\command\defaults\defaults_' . $this->command;
        if (is_callable("onCommand",true,$class)){
            $command = new $class;
            $command->onCommand($this);
            unset($command);
        }else{
            $this->getLogger()->info("Command \"" . $this->command . "\" not found.");
        }
    }

    public function getArgs($column = false){
        if ($column){
            if (isset($this->args[$column])){
                return $this->args[$column];
            }else{
                return false;
            }
        }else{
            return $this->args;
        }
    }

    public function getLine(){
        $line = $this->command;
        foreach ($this->args as $str) {
            $line .= " " . $str;
        }
        return $line;
    }
}