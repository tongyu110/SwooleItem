<?php

/**
 * Description of mysql
 * @author xpc
 */
class AysMysql {

    private $dbConfig = [];
    private $dbSource = '';

    public function __construct() {

        $this->dbSource = new Swoole\Mysql;
        $this->dbConfig = [
            'host' => 'localhost',
            'port' => 3306,
            'user' => 'root',
            'password' => '',
            'database' => 'db_0013fr',
            'charset' => 'utf8', //指定字符集
            'timeout' => 2, // 可选：连接超时时间（非查询超时时间），默认为SW_MYSQL_CONNECT_TIMEOUT（1.0）  
        ];
    }

    public function execute($sql) {

        $this->dbSource->connect($this->dbConfig, function ($db, $r) use ($sql) {
            if ($r === false) {
                var_dump($db->connect_errno, $db->connect_error);
                die;
            }
            $db->query($sql, function(swoole_mysql $db, $r) {
                if ($r === false) {
                    var_dump($db->error, $db->errno);
                } elseif ($r === true) {
                    var_dump($db->affected_rows, $db->insert_id);
                }
                var_dump($r);
                $db->close();
            });
        });
    }

}

$db = new AysMysql();
$db->execute('show tables;');
