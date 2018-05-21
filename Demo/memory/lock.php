<?php


for($i=1;$i<=6;$i++) {
    $process = new swoole_process('handleWorkProcess',true);
    $process->start();
}

function handleWorkProcess(swoole_process $worke) {

    sleep(1);
    $worker->write('test'.PHP_EOL);

    $pid = posix_getpid();
    $date = date('Y-m-d H:i:s',time());
    $count = 0;
    while(true) {
        $log = $pid.'-'.$date;
        writeLog($log);
        $count++;
        
        if($count == 100) {
            break;
        }
    }
}

function writeLog($content) {
    $log_filename = __DIR__."/1.log";
    swoole_async_writefile($log_filename,$content,function($filename) {
        
    },FILE_APPEND);
}
