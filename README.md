# event-worker-simple
event worker simple 是Event Worker的示例

## 1 安装(Install)
> 1. 安装composer
> 2. 安装项目
```sh
# 安装指定的版本
composer create-project zwei/event-worker-app "2.0.0"

# 从master分支安装
composer create-project zwei/event-worker-app dev-master
```
> 3. 配置

```sh
数据库配置文件: db.php
事件配置文件: event.conf.yml
```

> 4. 创建表

```sh
DROP TABLE IF EXISTS `event_log`;
CREATE TABLE `event_log` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '事件日志ID',
  `event` int(11) NOT NULL COMMENT '事件ID',
  `user` varchar(32) NOT NULL DEFAULT '0' COMMENT '用户',
  `data` longtext NOT NULL COMMENT 'json数据',
  `ip` varchar(32) NOT NULL COMMENT 'ip地址',
  `created` int(11) NOT NULL COMMENT '事件创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `module_type` (`id`,`event`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COMMENT='事件日志';


-- ----------------------------
-- Records of event_log
-- ----------------------------

-- ----------------------------
-- Table structure for event_module
-- ----------------------------
DROP TABLE IF EXISTS `event_module_log`;
CREATE TABLE `event_module_log` (
  `mid` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `module_name` varchar(64) DEFAULT NULL COMMENT '模块',
  `event_id` tinyint(4) DEFAULT NULL COMMENT '事件ID',
  `event_log_last_id` int(11) NOT NULL DEFAULT '0' COMMENT '最后执行的event_log.id',
  `event_log_ids` longtext COMMENT 'event_log表:未执行的ids"逗号分隔",示例(1,2,3,4,5)',
  PRIMARY KEY (`mid`),
  UNIQUE KEY `unique` (`module_name`,`event_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COMMENT='事件模块执行记录';;
```

## 如何监听事件

### 1. 创建监听事件类

> 在src/Customer创建监听事件类"src/Customer/DemoCustomer.php"并创建"run()"方法,文件内容如下:

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


### 2. 增加监听配置"event.conf.yml"

```yml
# 事件列表
events:
  BUY_PRODUCT: 1 # demo事件
#  ------ 分割线 -------
# 模块列表
modules:
  demo_module: # docker 模块
    class: \Zwei\EventWorkerApp\Customer\DemoCustomer # 调用类
    callback_func: run # 调用方法
    listen_events: # 监听事件列表
      - BUY_PRODUCT
```

### 3. 运行事件消费者脚本
> php src/EventWorkerRun.php 模块名

> php src/EventWorkerRun.php 模块名 vendor/autoload.php

```sh
php src/EventWorkerRun.php demo_module
php src/EventWorkerRun.php demo_module vendor/autoload.php
```

> 4. 运行发送测试事件

php src/TestSendEvent.php 事件名 运行次数(0一直运行) 间隔多少秒 vendor/autoload.php
php src/TestSendEvent.php 事件名 运行次数(0一直运行) 间隔多少秒

```sh
php src/TestSendEvent.php BUY_PRODUCT 0 1 # 一直运行不间隔
php src/TestSendEvent.php BUY_PRODUCT 0 1 vendor/autoload.php # 一直运行不间隔
```

## 如何运行计划任务

### 1. 创建计划任务类

> 在src/Customer创建计划任务类"src/Cron/DemoCron.php"并创建"run()"方法,文件内容如下:

```php
<?php
namespace Zwei\EventWorkerApp\Cron;

use Zwei\EventWork\CronInterface;

/**
 * 测试计划任务
 *
 * Class DemoCron
 * @package Zwei\EventWorkerApp\Cron
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
```

### 2. 增加监听配置"event.conf.yml"

```yml
# 计划任务列表
cron_lists:
  demo_cron: # cron 计划任务名字唯一
    class: \Zwei\EventWorkerApp\Cron\DemoCron # 调用类
```

### 3. 运行脚本
```sh
php src/CronRun.php demo_cron vendor/autoload.php
```
### 运行发送事件测试
```sh
# 一直运行间隔1秒
php src/DemoSendEvent.php demo_event 0 1
```
# 单元测试使用

> --bootstrap 在测试前先运行一个 "bootstrap" PHP 文件
- --bootstrap引导测试: phpunit --bootstrap vendor/autoload.php tests/
- --bootstrap引导测试: phpunit --bootstrap tests/TestInit.php tests/ 