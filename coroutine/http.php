<?php
/**
 * @desc GovernmentController.php 描述信息
 * @author Tinywan(ShaoBo Wan)
 * @date 2023/11/14 15:14
 */
declare(strict_types=1);

use Workerman\Worker;

require_once '../vendor/autoload.php';

try {
    $worker = new Worker();
    $worker->onWorkerStart = function () {
        $http = new Workerman\Http\Client();

        for ($i = 0; $i<100;$i++) {
            $response = $http->get('https://www.tinywan.com/');
            echo '[x] [任务1]['.$i.'][状态码] '.$response->getStatusCode() .date('Y-m-d H:i:s'). PHP_EOL;
//            echo '[x] [任务1]['.$i.'][状态码] '.date('Y-m-d H:i:s'). PHP_EOL;
        }

        for ($i = 0; $i<20;$i++) {
            $response = $http->get('https://www.tinywan.com/');
            echo '[x] [任务2]['.$i.'][状态码] '.$response->getStatusCode()  .date('Y-m-d H:i:s'). PHP_EOL;
//            echo '[x] [任务2]['.$i.'][状态码] '.date('Y-m-d H:i:s'). PHP_EOL;
        }

    };
    Worker::runAll();
} catch (Throwable $throwable) {
    var_dump($throwable->getMessage());
}
