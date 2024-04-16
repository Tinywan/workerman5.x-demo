<?php
/**
 * @desc 伪代码
 * @author Tinywan(ShaoBo Wan)
 * @date 2024/11/14 15:14
 */
declare(strict_types=1);

use Workerman\Worker;
use \Workerman\Connection\TcpConnection;
use \Workerman\Protocols\Http\Request;

require_once '../vendor/autoload.php';

// 创建一个Worker监听2345端口，使用http协议通讯
$httpWorker = new Worker("http://0.0.0.0:8217");

// 启动8个进程对外提供服务
$httpWorker->count = 8;

// 接收到浏览器发送的数据时回复 Hello World 给浏览器
$httpWorker->onMessage = function (TcpConnection $connection, Request $request) {
    $http = new \Workerman\Http\Client();

    $count = 50;
    $result = [];
    while ($count--) {
        $startTime = microtime(true);
        echo '开始时间：' . $startTime . PHP_EOL;
        $response = $http->get('https://api-test.busionline.com/o/v1/systems/teach-website');
        $endTime = microtime(true);
        echo '结束时间：' . $endTime . PHP_EOL;
        $result[] = sprintf('第%d个 | 耗时%s秒 | 状态码%d', $count, $endTime - $startTime, $response->getStatusCode());
    }
    $connection->send(json_encode($result));
};

// 运行worker
Worker::runAll();