<?php
namespace Zwei\EventWorkerApp\Cron;

/**
 * 测试计划任务
 *
 * Class DemoCron
 * @package Zwei\EventWorkerApp\Cron
 */
class DemoCron
{

    /**
     * 运行计划任务
     *
     */
    public function run()
    {
        echo "\nstart cron date:" . date('Y-m-d H:i:s');
        echo "\nstart cron : demo_cron\n";
        for ($i = 1; $i < 11; $i++) {
            echo "$i\n";
            usleep(500000);
        }
        echo "\nend cron : demo_cron\n";
    }
}