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
    
    
    if(isset($request->server)) {
        foreach($request->server as $k=>$v) {
            $_SERVER[strtoupper($k)] = $v;
        }
    }
    
    if(isset($request->header)) {
        foreach($request->header as $k=>$v) {
            $_SERVER[strtoupper($k)] = $v;
        }
    }
    
    if(isset($request->get)) {
        foreach($request->get as $k=>$v) {
            $_GET[$k] = $v;
        }
    }
    
    if(isset($request->post)) {
        foreach($request->post as $k=>$v) {
            $_POST[$k] = $v;
        }
    }
    
    ob_start();
    // 执行应用并响应
    think\Container::get('app', [APP_PATH])
    ->run()
    ->send();
    
    $re = ob_get_contents();
    ob_end_clean();
    
    $response->end($re);
});

$http->start();

// topthink/think-swoole
