<?php

echo 'shell start';

define('__ROOT__', realpath('.'));

$http = new swoole_http_server("127.0.0.1", 9501);
$http->set([
    'worker_num'=>4,
    'max_request'=>50
]);

$http->on('request', function ($request, $response) {
    //var_dump($request->get, $request->post);
    echo '111';    
    include __ROOT__.'/test.php';
    
    $response->header("Content-Type", "text/html; charset=utf-8");
    $response->end(getTplContent());
});
$http->start();

function getTplContent() {
    return false;
    $file = __ROOT__ . '/Template/index.html';
    $content = file_get_contents($file);
    return $content;
}
