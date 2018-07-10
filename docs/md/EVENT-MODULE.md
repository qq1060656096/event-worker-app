事件模块即事件消费模块(Event Module)
=========================
> 我们来创建一个示例模块"demo_module"

1步 创建事件消费模块示例类"DemoCustomer"
-------------------------
> 在项目根目录下"src/Customer"新增类"DemoCustomer",用于监听事件"BUY_PRODUCT"
> "src/Customer/DemoCustomer.php"文件内容如下
```php
<?php
namespace Zwei\EventWorkerApp\Customer;

/**
 * 测试消费者
 * Class DemoCustomer
 * @package Zwei\EventWorkerApp\Customer
 */
class DemoCustomer
{
    /**
     * 监听事件方法
     *
     * @param string $evenKey 事件
     * @param mixed $data 事件数据
     * @param array $eventRaw 事件原始数据
     * @return bool true 成功,否者失败
     */
    public function run($evenKey, $data, $eventRaw)
    {
        print_r($eventRaw);
        return true;
    }
}
```

2步 配置"demo_module"模块
-------------------------
> 在项目根目录下"config/event-worker.conf.yml"中
```yml
# 模块列表
modules:
  demo_module: # docker 模块
    class: "\\Zwei\\EventWorkerApp\\Customer\\DemoCustomer" # 调用类
    callback_func: run # 调用方法
    listen_events: # 监听事件列表
      - BUY_PRODUCT
```

3步 运行模块
> 运行"demo_module"模块，在项目根目录下运行命令：php src/EventWorkerRun.php demo_module
> 运行模块命令
```sh
php src/EventWorkerRun.php 模块名
php src/EventWorkerRun.php 模块名 vendor/autoload.php
```
