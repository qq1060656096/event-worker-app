<?php
namespace Wei\EventWorkSimple\Cron;

use Wei\EventWork\CronInterface;

/**
 * 测试计划任务
 *
 * Class DemoCron
 * @package Wei\EventWorkSimple\Cron
 */
class DemoCron implements CronInterface
{

    /**
     * 运行计划任务
     * @param string $cronName 计划任务名字
     */
    public function run($cronName)
    {
        echo "\nstart cron date:" . date('Y-m-d H:i:s');
        echo "\nstart cron : $cronName\n";
        for ($i = 1; $i < 11; $i++) {
            echo "$i\n";
            usleep(500000);
        }
        echo "\nend cron : $cronName\n";
    }
}