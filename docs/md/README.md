开发文档
===============================

入门
----
* **已定稿** [关于(Intro)](INTRO.md)
* **已定稿** [安装(Install)](INSTALL.md)
* **已定稿** [应用结构(Application)](APPLICATION-STRUCT.md)
* **已定稿** [事件(Event)](EVENT.md)
* **已定稿** [事件消费者(Event Module)](EVENT-MODULE.md)
* **已定稿** [计划任务(Cron)](CRON.md)
* **撰写完成** [消费者linux进程管理(Linux Supervisor)](PROCESS-LINUX.md)
* **撰写完成** [消费者win进程管理(Windows 服务)](PROCESS-WIN.md)


## 运行发送测试事件
```sh
php src/TestSendEvent.php 事件名 运行次数(0一直运行) 间隔多少秒 vendor/autoload.php php src/TestSendEvent.php 事件名 运行次数(0一直运行) 间隔多少秒
php src/TestSendEvent.php BUY_PRODUCT 0 1 # 一直运行不间隔
php src/TestSendEvent.php BUY_PRODUCT 0 1 vendor/autoload.php # 一直运行不间隔
```
