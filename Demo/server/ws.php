<?php

class Ws  {
    
    private $ws = null;
    
    public function __construct() {
        $this->ws = new swoole_websocket_server("0.0.0.0", 8812);
        
        $this->ws->set(
            [
                'worker_num' => 2,
                'task_worker_num' => 2,
            ]
        );
        
        $this->ws->on('open',[$this,'onOpen']);
        $this->ws->on('message',[$this,'onMessage']);
        $this->ws->on('close',[$this,'onClose']);
        $this->ws->on('task',[$this,'onTask']);
        $this->ws->on("finish", [$this, 'onFinish']);
        $this->ws->start();
    }
    
    /**
     * @param $serv
     * @param $taskId
     * @param $data
     */
    public function onFinish($serv, $taskId, $data) {
        echo "taskId:{$taskId}\n";
        echo "finish-data-sucess:{$data}\n";
    }
    
    public function onTask(swoole_server $serv,$task_id,$src_worker_id, $data) {
        print_r($data);
        // 耗时场景 10s
        sleep(10);
        return "on task finish"; // 告诉worker
    }
    
    public function onClose($ws, $fd) {
        echo "clientid:{$fd}\n";
    }
    
    public function onOpen(swoole_websocket_server $ws, swoole_http_request $req) {
        var_dump($req->fd);
        if($req->fd == 1) {
            // 每2秒执行
            swoole_timer_tick(2000, function($timer_id){
                echo "2s: timerId:{$timer_id}\n";
            });
        }
    }
    
    public function onMessage(swoole_websocket_server $ws, $frame) {
        echo "ser-push-message:{$frame->data}\n";
        // todo 10s
        $data = [
            'task' => 1,
            'fd' => $frame->fd,
        ];
        $ws->task($data);
        swoole_timer_after(5000, function() use($ws, $frame) {
            echo "5s-after\n";
            $ws->push($frame->fd, "server-time-after:");
        });
        $ws->push($frame->fd, "server-push:".date("Y-m-d H:i:s"));
    }
    
}

new Ws();


