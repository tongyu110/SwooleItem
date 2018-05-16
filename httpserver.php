<?php

        define('__ROOT__', realpath('.'));

	$http = new swoole_http_server("127.0.0.1", 9501);
        $http->on('request', function ($request, $response) {
            var_dump($request->get, $request->post);
            $response->header("Content-Type", "text/html; charset=utf-8");
            $response->end(getTplContent());
        });
        
        $http->start();

        
        function getTplContent() {
            $file = __ROOT__ . '/Template/index.html';
            $content = file_get_contents($file);
            return $content;
        }
        
?>
