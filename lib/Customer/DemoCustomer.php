<?php
namespace Wei\EventWorkSimple\Customer;

/**
 * 测试消费者
 * Class DemoCustomer
 * @package Wei\EventWorkSimple\Customer
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