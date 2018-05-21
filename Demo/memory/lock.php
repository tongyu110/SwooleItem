<?php

$workers = [];
for($i=1;$i<=6;$i++) {
    $process = new swoole_process(function(swoole_process $worke){
       
        $worke->write('test'.PHP_EOL);
        $pid = posix_getpid();
        $date = date('Y-m-d H:i:s',time());
        $count = 0;
        while(true) {
            $log = $pid.'-'.time().PHP_EOL;
            writeLog($log);
            $count++;

            if($count == 100) {
                break;
            }
        }

    },true);
    $pid = $process->start();
    $workers[$pid] = $process;
}

foreach($workers as $process) {
    echo $process->read();
}

swoole_process::wait();


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
    
    sleep(1);
    
    $log_filename = __DIR__."/1.log";
    swoole_async_writefile($log_filename,$content,function($filename) {
        
    },FILE_APPEND);
}
