<?php

// 监听 9501 端口
$serv = new swoole_server('127.0.0.1',9501);

// 注测事件 , 客户连接事件
$serv->on('connect',function($serv, $fd) {
    echo 'Client:Connect.\n';
});

$serv->on('receive',function($serv, $fd, $from_id, $data){
    $serv->send($fd, 'Swoole: '.$data);
    $serv->close($fd);
});

$serv->start();


