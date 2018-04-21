<?php

//创建Server对象，监听 127.0.0.1:9501端口
$serv = new swoole_server("127.0.0.1", 9501); 

$serv->set([
    'worker_num'=>8,        // worker 进程数 ， CPU 核的 1-4 倍
    'max_request'=>128,     // 每个进程处理的最大用于数
]);

//监听连接进入事件
/**
 * $fd 可以说是客户端一个连接的标识 , $fd 是自增的形式
 * $reactor_id 线程id
 */
$serv->on('connect', function ($serv, $fd , $reactor_id) {  
    echo "Client: {$reactor_id} - Connect.\n";
});

//监听数据接收事件
/**
 * $from_id  = $reactor_id 线程id
 */
$serv->on('receive', function ($serv, $fd, $from_id, $data) {
    $serv->send($fd, "Server: {$fd}  -  {$from_id}".$data);
});

//监听连接关闭事件
$serv->on('close', function ($serv, $fd) {
    echo "Client: Close.\n";
});

//启动服务器
$serv->start(); 

// netstat -anp | grep 9501
// telnet 127.0.0.1 9501
