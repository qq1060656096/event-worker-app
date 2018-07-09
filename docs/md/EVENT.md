事件(Event)
=========================

1步 配置新的事件"BUY_PRODUCT"
-------------------------
> 在项目根目录下"config/event-worker.conf.yml"中
```yml
# 事件列表
events:
  BUY_PRODUCT: 1 # demo事件
```


2步 发送事件
-------------------------
> 发送"BUY_PRODUCT"事件

```php
<?php
// 事件内容
$sendData = [
    'productId' => 1,// 购买产品id
    'quantity' => 10,// 购买数量
    'couponId' => 0,// 优惠券id
    'uid' => 10,//购买用户
]; 
// 用户购买产品
\Zwei\EventWork\EventSend::send('BUY_PRODUCT', $data);
```
