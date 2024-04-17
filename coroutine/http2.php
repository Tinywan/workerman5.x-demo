<?php
/**
 * @desc 伪代码
 * @author Tinywan(ShaoBo Wan)
 * @date 2024/11/14 15:14
 */
declare(strict_types=1);

use Workerman\Worker;
use \Workerman\Connection\TcpConnection;

require_once '../vendor/autoload.php';

// 创建一个Worker监听2345端口，使用http协议通讯
$httpWorker = new Worker("http://0.0.0.0:8202");

// 启动8个进程对外提供服务
$httpWorker->count = 20;

// 接收到浏览器发送的数据时回复 Hello World 给浏览器
$httpWorker->onMessage = function (TcpConnection $connection) {
    $http = new \Workerman\Http\Client();
    $count = 10;
    $result = [];
    $startTime = microtime(true);
    echo ' [x] 开始时间' . $startTime . PHP_EOL;
    while ($count--) {
        $http->get('https://www.baidu.com/', function ($response) use ($startTime, $count, &$result) {
            echo ' [x] ' . sprintf('第%d个 | 耗时%s秒 ', $count, microtime(true) - $startTime) . PHP_EOL;
            $result[$count] = sprintf('第%d个 | 耗时%s秒 | 状态码%d', $count, microtime(true) - $startTime, $response->getStatusCode());
            if (10 === count($result)) {
                echo ' [x] 请求完成，总耗时' . (microtime(true) - $startTime) . PHP_EOL;
            }
        }, function ($exception) {
            echo ' [x] 请求异常' . $exception . PHP_EOL;
        });

    }
    $endTime = microtime(true);
    echo ' [x] 结束时间' . $endTime . PHP_EOL;
    $connection->send(json_encode($result));
};

// 运行worker
Worker::runAll();