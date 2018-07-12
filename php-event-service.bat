@echo off
rem sc文档地址
rem https://docs.microsoft.com/en-us/previous-versions/windows/it-pro/windows-server-2012-R2-and-2012/cc990290(v%3dws.11)

rem 操作类型
set op_type=%2
rem 设置服务名
set service_name=%1
rem 设置当前路径
set current_path=%~dp0

rem 设置通用变量
set service_name_prefix=php-event-
set phpRunScript=%current_path%src\EventWorkerRun.php
set phpPath=php
set phpPath=D:\phpStudy\php\php-5.6.27-nts\php.exe
set logs_path=%current_path%logs\
set log_file=%logs_path%%service_name%.log
set error_log_file=%logs_path%%service_name%.error.log

if "%op_type%" == "install" goto install
if "%op_type%" == "remove" goto remove
if "%op_type%" == "start" goto start
if "%op_type%" == "stop" goto stop
if "%op_type%" == "help" goto help

:help
echo.
echo *********************
echo PHP Event Service control usage
echo *********************
echo.
echo help    - Display this help
echo.
echo The following actions can also be accomplished by using
echo Windows Services Management Console (services.msc):
echo.
echo.
echo php-event-service [service name] [command]
echo.
echo install - Install service
echo remove  - Remove  service
echo start   - Start   service
echo stop    - Stop    service
echo.
rem 退出当前批处理
exit /B


rem **** 安装服务start ****
:install
echo .
sc config %service_name_prefix%%service_name% start= demand
@net stop %service_name_prefix%%service_name% 
sc delete %service_name_prefix%%service_name% 
echo install service...
set run_cmd=sc create %service_name_prefix%%service_name% binPath= "%phpPath% %phpRunScript% %service_name% 1>>%log_file% 2>>%error_log_file%" displayname= "%service_name_prefix%%service_name%"
set run_cmd=sc create %service_name_prefix%%service_name% binPath= "%phpPath% %phpRunScript% %service_name%" displayname= "%service_name_prefix%%service_name%"
@echo %run_cmd% 1>> %current_path%logs\rum-cmd.log
echo.
echo %current_path%logs\rum-cmd.log
echo.
%run_cmd%
echo.
net start %service_name_prefix%%service_name%
rem sc config %service_name_prefix%%service_name% start= auto
echo.
rem 退出当前批处理
exit /B
goto end
rem **** 安装服end ****

rem **** 删除服务start ****
:remove
sc config %service_name_prefix%%service_name% start= demand
net stop %service_name_prefix%%service_name% 
echo remove service
set run_cmd=sc delete %service_name_prefix%%service_name% 
@echo %run_cmd% 1>> %current_path%logs\rum-cmd.log
%run_cmd%
rem 退出当前批处理
exit /B
goto end
rem **** 删除服务end ****

rem **** 启动服务start ****
:start
sc config %service_name_prefix%%service_name% start= demand
echo start service
set run_cmd=net start %service_name_prefix%%service_name% 
@echo %run_cmd% 1>> %current_path%logs\rum-cmd.log
%run_cmd%
sc config %service_name_prefix%%service_name% start= auto
goto end
rem **** 启动服务end****

rem **** 停止服务start ****
:stop
echo stop service 
set run_cmd=net stop %service_name_prefix%%service_name% 
@echo %run_cmd% 1>> %current_path%logs\rum-cmd.log
echo.
echo %current_path%logs\rum-cmd.log
echo.
%run_cmd%
rem 退出当前批处理
exit /B
goto end
rem **** 停止服务end ****



rem 结束
:end
echo.
echo.