<?php
/**
 * Created by PhpStorm.
 * User: 20150176
 * Date: 2017/09/30
 * Time: 17:10
 */
namespace nocturne\display\output;

use nocturne\display\Display;

class Console extends Display
{
    public static function AddLine($strings){
       echo $strings;
    }
}