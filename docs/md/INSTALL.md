安装(Install)
=========================

1步 通过Composer安装
-------------------------
> 通过 Composer 安装
如果还没有安装 Composer，你可以按 [getcomposer.org](https://getcomposer.org/) 中的方法安装


2步 安装event-worker-app
-------------------------
> composer create-project zwei/event-worker-app 安装路径 安装版本

```sh
composer create-project zwei/event-worker-app event-worker-app 2.*
```

3步 数据配置请修改"bao-loan.yml"文件
-------------------------

> 增加一下内容:
```yml
# 数据库配置
DB_HOST: "localhost" # 主机
DB_PORT: 3306 # 端口
DB_USER: "root" # 用户名
DB_PASS: "root" # 密码
DB_NAME: "demo" # 数据库名
DB_TABLE_PREFIX: "" # 表前缀
DB_CHARSET: "utf8" # 设置字符编码,空字符串不设置
DB_SQLLOG: false # 是否启用sql调试
```

4步 将以下sql导入到数据库中
-------------------------

```sql
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
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COMMENT='事件模块执行记录';
```