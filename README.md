# event-worker-simple
event worker simple 是Event Worker的示例

## 1 安装(Install)
> 1. 克隆项目
```sh
git clone https://github.com/qq1060656096/event-worker-simple.git
```
> 2. 安装composer
> 3. 执行composer install
> 4. 配置

```sh
数据库配置文件: db.php
事件配置文件: event.conf.yml
```

> 5. 创建表

```sh
DROP TABLE IF EXISTS `event_log`;
CREATE TABLE `event_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '事件日志ID',
  `event` tinyint(4) NOT NULL COMMENT '事件ID',
  `user` varchar(32) NOT NULL DEFAULT '0' COMMENT '用户',
  `data` longtext NOT NULL COMMENT 'json数据',
  `ip` varchar(32) NOT NULL COMMENT 'ip地址',
  `created` int(11) NOT NULL COMMENT '事件事件',
  PRIMARY KEY (`id`),
  UNIQUE KEY `module_type` (`id`,`event`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COMMENT='事件日志';

-- ----------------------------
-- Records of event_log
-- ----------------------------

-- ----------------------------
-- Table structure for event_module
-- ----------------------------
DROP TABLE IF EXISTS `event_module`;
CREATE TABLE `event_module` (
  `module` tinyint(4) DEFAULT NULL COMMENT '模块',
  `event` tinyint(4) DEFAULT NULL COMMENT '事件ID',
  `last_id` int(11) NOT NULL DEFAULT '0' COMMENT '最后执行的event_log.id',
  `event_ids` longtext COMMENT '未执行的ids"逗号分隔",示例(1,2,3,4,5)',
  UNIQUE KEY `module_type` (`module`,`event`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='事件模块执行记录';
```

## 如何监听事件

### 1. 创建监听事件类

> 在lib/Customer创建监听事件类"lib/Customer/DemoCustomer.php"并创建"run()"方法,文件内容如下:

```php
<?php
namespace Zwei\EventWorkSimple\Customer;

/**
 * 测试消费者
 * Class DemoCustomer
 * @package Zwei\EventWorkSimple\Customer
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
event_lists:
  demo_event: 1 # demo事件
#  ------ 分割线 -------
# 模块列表
module_lists:
  demo_module: # docker 模块
    id: 1 # 必须唯一
    class: \Zwei\EventWorkSimple\Customer\DemoCustomer # 调用类
    callback: run # 调用方法
    listen_event_lists: # 监听事件列表
      - demo_event
```

### 3. 运行事件消费者脚本
> php src/EventWorkerRun.php 模块名
> php src/EventWorkerRun.php 模块名 vendor/autoload.php
```sh
php src/EventWorkerRun.php demo_module
php src/EventWorkerRun.php demo_module vendor/autoload.php
```

## 如何运行计划任务

### 1. 创建计划任务类

> 在src/Customer创建计划任务类"src/Cron/DemoCron.php"并创建"run()"方法,文件内容如下:

```php
<?php
namespace Zwei\EventWorkSimple\Cron;

use Zwei\EventWork\CronInterface;

/**
 * 测试计划任务
 *
 * Class DemoCron
 * @package Zwei\EventWorkSimple\Cron
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
    class: \Zwei\EventWorkSimple\Cron\DemoCron # 调用类
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