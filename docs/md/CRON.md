计划任务(Cron)
=========================
> 我们来创建一个示例计划任务"demo_cron"

1步 创建计划任务调用类
-------------------------
> 在项目根目录下"src/Cron"新增类"DemoCron",用于监听事件"BUY_PRODUCT"
> "src/Cron/DemoCron.php"文件内容如下
```php
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
```

2步 配置"demo_cron"计划任务
-------------------------
> 在项目根目录下"config/event-worker.conf.yml"中
```yml
# 计划任务列表
crons:
  demo_cron: # cron 计划任务名字唯一
    class: "\\Zwei\\EventWork\\Tests\\Demo\\DemoCron" # 调用类
    callback_func: "run" # 调用方法
```

3步 运行计划任务
> 运行"demo_cron"计划任务，在项目根目录下运行命令：php src/CronRun.php demo_cron
> 运行模块命令
```sh
php src/CronRun.php 计划任务名
php src/CronRun.php 计划任务名 vendor/autoload.php
```
