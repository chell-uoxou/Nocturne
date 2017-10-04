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

    const TYPE_INFO = 100;

    private $sender;
    private $receiver;

    public function __construct($sender)
    {
        $this->sender = $sender;
        $this->receiver = Display::CONSOLE;
    }

    public function info($message)
    {
        $this->setMessageType = self::TYPE_INFO;
        Console::AddLine($this->formatPrefix("[%H:%i:%s] [#type_info] ") . $message . PHP_EOL);
    }

    public function formatPrefix($format){
        $search =   array(
            "%d","%D","%j","%l","%F","%M","%n","%t","%Y","%A","%B","%g","%G","%h","%H","%i","%s","%v","%e","%c",
            "#type_info"
            );
        $replace =  array_merge(explode("!",date('d!D!j!l!F!M!n!t!Y!A!B!g!G!h!H!i!s!v!e!c')),
            array($this->getTypeName(self::TYPE_INFO)));
        return str_replace($search,$replace,$format);
    }

    public function getTypeName($type)
    {
        switch ($type) {
            case self::TYPE_INFO:
                return "INFO";
                break;
            default:
                return false;
                break;
        }
    }
}