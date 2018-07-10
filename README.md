# event-worker-app
Event Worker App 是Event Worker的示例

## 开发文档
[开发文档](dos/md/README.md)

# 单元测试使用

> --bootstrap 在测试前先运行一个 "bootstrap" PHP 文件
- --bootstrap引导测试: phpunit --bootstrap vendor/autoload.php tests/
- --bootstrap引导测试: phpunit --bootstrap tests/TestInit.php tests/ 