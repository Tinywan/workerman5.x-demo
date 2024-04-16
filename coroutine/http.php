<?php
/**
 * @desc 伪代码
 * @author Tinywan(ShaoBo Wan)
 * @date 2024/11/14 15:14
 */
declare(strict_types=1);

use Workerman\Worker;

require_once '../vendor/autoload.php';

try {
    $worker = new Worker();
    $worker->onWorkerStart = function () {
        $http = new Workerman\Http\Client();

        $response = $http->get('https://www.tinywan.com/');
        var_dump($response->getStatusCode());
        //echo $response->getBody() . PHP_EOL;

        $response = $http->post('https://www.tinywan.com/', ['key1' => 'value1', 'key2' => 'value2']);
        var_dump($response->getStatusCode());
        // echo $response->getBody() . PHP_EOL;

        $response = $http->request('https://www.tinywan.com/', [
            'method' => 'GET',
            'version' => '1.1',
            'headers' => ['Connection' => 'keep-alive'],
            'data' => ['key1' => 'value1', 'key2' => 'value2'],
        ]);
        var_dump($response->getStatusCode());
        // echo $response->getBody() . PHP_EOL;
    };
    Worker::runAll();
} catch (Throwable $throwable) {
    var_dump($throwable->getMessage());
}