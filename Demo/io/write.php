<?php

define('__ROOT__', realpath('.'));

$file_name = __ROOT__.'/1.log';
swoole_async_readfile($file_name, function($filename,$content){
    echo $filename."\n";
    echo $content."\n";
});
echo "start \n";