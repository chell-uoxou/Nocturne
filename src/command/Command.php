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


    public function setSystemStatusMessage($value = "")
    {
        global $system_status_text;
        $system_status_text = $value;
    }

    public function quote($text)
    {
        $commandArray = array();
        $spaced = false;
        $tokenBegin = 0;
        $spacedBegin = 0;
        $cuated = false;
        $ignoreSpace = false;
        $text = trim($text) . " []";
        for ($i = 0; $i < strlen($text); $i++) {
            if (substr($text, $i, 1) == "\"") {//走査文字列に"がきたぞ
                if ($cuated == false) {
                    $cuatedBegin = $i;
                    $cuated = true;
                    $ignoreSpace = true;
                } else {
                    $cuated = false;//もう"には囲まれてないぞ！
                    $ignoreSpace = false;//スペース無視すんなよ！
                }
            }
            if (substr($text, $i, 1) == " ") {
                if ($spaced == false) { //すなはちスペースの一回目である
                    $spacedBegin = $i;//スペースはじめのインデックス
                }
                $spaced = true;
                if ($ignoreSpace == true) {  // スペース無視していいかな？
                    $spaced = false;  // このスペースは無視だ！
                }
            } else {
                if ($spaced == true) {  //さっきまですぺーすだったよ！
                    // 	com1.add(command.substring(tokenbegin,spacedbegin));//トークン始まりからスペース始まりまでをListにぶっこむ
                    $addstr = substr($text, $tokenBegin, $spacedBegin - $tokenBegin);
                    $addstr = ltrim($addstr, '"');
                    $addstr = rtrim($addstr, '"');
                    array_push($commandArray, $addstr);
                    $tokenBegin = $i;//ここからトークンがはじまるぞ！
                }
                $spaced = false;//すぺーすではないぞ！
            }
        }
        $text = implode(" ",$commandArray);
        return $text;
    }
}