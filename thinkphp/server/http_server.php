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

$http->on('request', function($request, $response) use ($http) {
    
    
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
    // 1. 全局变量在 swoole 中是不会注销的，包括常量
    //if(!empty($request->get)) {
    //    unset($request->get);
    //}
    
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
    try{
        // 执行应用并响应
        think\Container::get('app', [APP_PATH])
        ->run()
        ->send();
    }catch(\Exception $e) {
        //todo
    }
    
    $re = ob_get_contents();
    ob_end_clean();
    
    $response->header("Content-Type", "text/html; charset=utf-8");
    $response->end($re);
    $http->close();
    // 2. 如果没有 close ，不同地址访问都是同样的结果，因为在 Thinkphp 中会将缓存
    
});

$http->start();

// topthink/think-swoole
