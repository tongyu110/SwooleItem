<?php

echo 'shell start';
define('__ROOT__', realpath('.'));
include __ROOT__.'/test.php';

$http = new swoole_http_server("127.0.0.1", 9501);
$http->set([
    'worker_num'=>4,
    'max_request'=>50
]);

$http->on('WorkerStart', function ($serv, $worker_id){
    echo "WorkerStart \n";
});

$http->on('request', function ($request, $response) {
    getTest();
    include __ROOT__.'/test_request.php';
    $response->header("Content-Type", "text/html; charset=utf-8");
    $response->end(getTplContent());
});

$http->on('Receive',function($server, $fd, $from_id, $data) {
   echo "tick start \n";
   $server->tick(1000, function() use ($server, $fd) {
        echo $fd . "\n";
    });
   echo "tick end \n";
});

$http->start();

function getTplContent() {
    return "hello Swoole test \n";
}
