<?php
/**
 * Created by PhpStorm.
 * User: 20150176
 * Date: 2017/09/30
 * Time: 15:33
 */

namespace nocturne\command\defaults;


use nocturne\command\Command;

class defaults_echo extends Command
{
    function onCommand($executor){
        $message = implode(" ",$executor->getArgs());
        $this->getLogger()->info($message);
    }
}