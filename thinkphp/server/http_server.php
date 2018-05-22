<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 18/2/28
 * Time: 上午1:39
 */
$http = new swoole_http_server("0.0.0.0", 8811);

$http->set(
    [
        'worker_num'=>4,
        'max_request'=>50,
        'enable_static_handler' => true,
        'document_root' => "/home/Dev/SwooleItem/thinkphp/public/static",
    ]
);

$http->on('WorkerStart',function($serv, $worker_id){
    
    define('APP_PATH', __DIR__ . '/../application/');
    require __DIR__ . '/../thinkphp/base.php';
});

$http->on('request', function($request, $response) {
    $response->cookie("singwa", "xsssss", time() + 1800);
    $response->end("sss". json_encode($request->get));
});

$http->start();

// topthink/think-swoole
