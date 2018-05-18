<?php

echo 'shell start';
define('__ROOT__', realpath('.'));
include __ROOT__.'/test.php';

$http = new swoole_http_server("0.0.0.0", 9501);
$http->set([
    'worker_num'=>4,
    'max_request'=>50,
    'document_root' => __ROOT__.'/../Template',
    'enable_static_handler' => true,
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


$http->start();

function getTplContent() {
    return "hello Swoole test \n";
}
