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
## 如何监听事件
```sh
php lib/EventWorkerRun.php demo_module vendor/autoload.php
```


## 运行计划任务
```sh
php lib/CronRun.php demo_cron vendor/autoload.php
```

# 单元测试使用

> --bootstrap 在测试前先运行一个 "bootstrap" PHP 文件
- --bootstrap引导测试: phpunit --bootstrap vendor/autoload.php tests/
- --bootstrap引导测试: phpunit --bootstrap tests/TestInit.php tests/