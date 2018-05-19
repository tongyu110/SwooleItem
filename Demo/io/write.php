<?php

define('__ROOT__', realpath('.'));

$file_name = __ROOT__.'/1.log';

$_size = filesize($file_name)/2;

swoole_async_read($file_name,function($filename,$content){
    echo $filename."\n";
    echo $content."\n";
},$size = 8192,$offset = $_size);


//swoole_async_readfile($file_name, function($filename,$content){
//    echo $filename."\n";
//    echo $content."\n";
//    echo "-- swoole_async_readfile -- \n";
//});

echo "start \n";
