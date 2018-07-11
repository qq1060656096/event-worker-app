消费者win进程管理(Windows 服务)
=========================
> 这里一个简单示例，如果不清楚supervisor安装使用，请网上搜索

1步 创建服务
-------------------------
> php src/EventWorkerRun.php demo_module 1>> logs/demo_module.log 2>>logs/demo_module.error.log
```sh
sc create [service name] [binPath= ] <option1> <option2>.
```

```sh
sc create demo_module binPath="php src/EventWorkerRun.php demo_module 1>> logs/demo_module.log 2>>logs/demo_module.error.log" displayname= "demo_moduleService"
```


2步 Supervisor配置
-------------------------
> 发送"BUY_PRODUCT"事件

```sh
# 安装服务
php-event-service.bat demo_module install
# 删除服务
php-event-service.bat demo_module remove
# 开发服务
php-event-service.bat demo_module start
# 停止服务
php-event-service.bat demo_module stop
```
