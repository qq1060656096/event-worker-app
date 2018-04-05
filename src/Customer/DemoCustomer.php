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
     * 监听模块事件
     * @param string $evenName 事件名
     * @param array $event 事件
     * @return bool 执行成功,执行失败
     */
    public function run($evenName, $event){
        echo 123;
        var_dump($evenName);
        print_r($event);
        return true;
    }
}
