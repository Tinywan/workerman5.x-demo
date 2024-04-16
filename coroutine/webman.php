<?php

function http()
{
    $http = new \Workerman\Http\Client();
    $count = 50;
    $result = [];
    $startTime = microtime(true);
    echo ' [x] 开始时间' . $startTime . PHP_EOL;
    while ($count--) {
        $http->get('https://www.baidu.com/', function ($response) use ($startTime, $count, &$result) {
            echo ' [x] ' . sprintf('第%d个 | 耗时%s秒 ', $count, microtime(true) - $startTime) . PHP_EOL;
            $result[$count] = sprintf('第%d个 | 耗时%s秒 | 状态码%d', $count, microtime(true) - $startTime, $response->getStatusCode());
            if (50 === count($result)) {
                echo ' [x] 请求完成，总耗时' . (microtime(true) - $startTime) . PHP_EOL;
            }
        }, function ($exception) {
            echo ' [x] 请求异常' . $exception . PHP_EOL;
        });

    }
    $endTime = microtime(true);
    echo ' [x] 结束时间' . $endTime . PHP_EOL;
    return json($result);
}