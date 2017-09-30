<?php
/**
 * Created by PhpStorm.
 * User: 20150176
 * Date: 2017/09/30
 * Time: 15:34
 */

namespace nocturne\command;

use nocturne\System;

class Command extends System
{
    public function init()
    {

    }

    public function getExecutor($command)
    {
        return new CommandExecutor($command);
    }
}