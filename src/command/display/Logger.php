<?php
/**
 * Created by PhpStorm.
 * User: 20150176
 * Date: 2017/09/30
 * Time: 17:46
 */

namespace nocturne\display;


use nocturne\display\output\Console;
use nocturne\System;

class Logger extends System
{
    const SYSTEM = 0;

    private $sender;
    private $receiver;

    public function __construct($sender)
    {
        $this->sender = $sender;
        $this->receiver = Display::CONSOLE;
    }

    public function info($message){
        Console::AddLine($this->getDisplay()->prefix . $message);
    }
}