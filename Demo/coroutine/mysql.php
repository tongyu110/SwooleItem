<?php

$http = new swoole_http_server("0.0.0.0", 9501);
$http->set([
    'worker_num'=>4,
    'max_request'=>50,
]);

$http->on('request', function ($request, $response) {
   
    $str = '1';
    
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
    $response->end($res[0]['id'].time());
});

$http->start();

// 应用场景
// 在我们同步代码编程中，如果我们需要查询 redis 与 mysql 里的某些数据，那么它们所使用查询的时间是
// redis(1) + mysql(2) = 3

// 如果我们使用协程的话，同样的业务，那么使用的时间是
// max(redis(1),mysql(2)) = 2
// 这可主明，同小代码，异步实现，也就是并发的调用





