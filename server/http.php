<?php

echo 'shell start';
define('__ROOT__', realpath('.'));
$http = new swoole_http_server("127.0.0.1", 9501);
$http->set([
    'worker_num'=>4,
    'max_request'=>50
]);

include __ROOT__.'/test_shellstart.php';

$http->on('WorkerStart', function ($serv, $worker_id){
    include __ROOT__.'/test_WorkerStart.php';
});

$http->on('request', function ($request, $response) {
    //var_dump($request->get, $request->post);
    include __ROOT__.'/test_request.php';
    $response->header("Content-Type", "text/html; charset=utf-8");
    $response->end(getTplContent());
});
$http->start();

function getTplContent() {
    return "hello Swoole \n";
}
