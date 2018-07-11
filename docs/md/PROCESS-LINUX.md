消费者linux进程管理(Linux Supervisor)
=========================
> 这里一个简单示例，如果不清楚supervisor安装使用，请网上搜索

1步 entos7 Supervisor安装
-------------------------
```sh
yum install -y supervisor
```


2步 Supervisor配置
-------------------------
> 发送"BUY_PRODUCT"事件

```sh
# 1. 使用root身份创建一个全局配置文件
echo_supervisord_conf > /etc/supervisord.conf
supervisord -c /etc/supervisord.conf
# 2. 创建目录,用于存放进程管理的配置文件 
mkdir -p /etc/supervisord/config.d
# 3. 修改配置supervisord.conf文件
vi /etc/supervisord/supervisord.conf
# 增加以下内容
[include] 
files = /etc/supervisord/config.d/*.conf
```

3步 建立常驻进程
-------------------------
> 增加常驻进程配置文件：vi php.event-worker.demo_module.conf
```sh
[program:php-event-worker-demo-module]
command=php src/EventWorkerRun.php demo_module
user=www
autostart=true
autorestart=true
startsecs=3
stdout_logfile=/usr/local/share/supervisord/php.event-worker.demo_module.log
```
4步 重新加载配置
> supervisorctl reload


5步 启动进行进程
> supervisorctl start php-event-worker-demo-module