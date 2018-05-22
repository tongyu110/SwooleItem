<?php

$http = new swoole_http_server("0.0.0.0", 9501);
$http->set([
    'worker_num'=>4,
    'max_request'=>50,
]);

$http->on('request', function ($request, $response) {
    
    $swoole_mysql = new Swoole\Coroutine\MySQL();
    $swoole_mysql->connect([
        'host' => '127.0.0.1',
        'port' => 3306,
        'user' => 'root',
        'password' => '',
        'database' => 'db_003fr',
    ]);
    $res = $swoole_mysql->query('select * from f3_rate;');
    
    $response->header("Content-Type", "text/html; charset=utf-8");
    $response->end(var_export($res));
});

$http->start();


