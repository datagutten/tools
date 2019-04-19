<?php
/**
 * Created by PhpStorm.
 * User: abi
 * Date: 19.04.2019
 * Time: 10:08
 */
spl_autoload_register(function ($class_name) {
    $valid_classes = array('color', 'dependcheck', 'FileNotFoundException');
    if(array_search($class_name, $valid_classes)!==false) {
        /** @noinspection PhpIncludeInspection */
        include __DIR__ . '/' . $class_name . '.php';
    }
});
