<?php
/**
 * Created by PhpStorm.
 * User: 20150176
 * Date: 2017/09/30
 * Time: 15:32
 */


namespace nocturne {

    define("SRC_PATH", __DIR__);

    date_default_timezone_set("Asia/Tokyo");

    require_once('Loader.php');
    require_once('System.php');
    $loader = new Loader( SRC_PATH, true ,array());
    $loader->includeFiles();
    $system = new System();
    $system->init();
    $system->standByInput();
}