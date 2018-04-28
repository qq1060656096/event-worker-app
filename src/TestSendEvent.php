<?php

switch (true) {
    // 参数错误
    case empty($argv[1]):
        throw new \Exception('The event name cannot be empty.');
        break;
    // 请传入引入composer autoload.php
    case empty($argv[4]):
        $composerAutoload = 'vendor/autoload.php';
        if (!file_exists($composerAutoload)) {
            $errorMsg = sprintf("the boot file is found.(boot-file: %s)", $composerAutoload);
            throw new Exception($errorMsg);
        }
        break;
    default:
        $composerAutoload = $argv[4];
        break;
}
$times      = !isset($argv[2]) ? 10 : intval($argv[2]);
$times      = max($times, 0);
$sleepTime  = !isset($argv[3]) ? 10 : intval($argv[3]);
$sleepTime  = max($sleepTime, 0);
$eventName  = $argv[1];

require $composerAutoload;
$nowDate = date('Y-m-d H:i:s');
echo <<<str
send test event
eventKey: {$eventName} 
time: {$nowDate}
run demo start: 
# 运行10次间隔1秒q
php src/TestSendEvent.php BUY_PRODUCT 10 1 vendor/autoload.php
# 一直运行间隔1秒
php src/TestSendEvent.php BUY_PRODUCT 0 1 vendor/autoload.php
# 一直运行不间隔
php src/TestSendEvent.php BUY_PRODUCT 0 1 vendor/autoload.php
run demo end:
str;
$i = 0;
while (true) {
    if ($i > $times && $times != 0) {
        break;
    }
    $sendData = [
        'i' => $i,
        'eventName' => $eventName,
        'times' =>$times,
        'sleepTime' => $sleepTime
    ];
    echo "$i \n";
    print_r($sendData);
    //发送事件
    \Zwei\EventWork\EventSend::send($eventName, $sendData);
    $sleepTime > 0 ? sleep($sleepTime) : null;
    $i ++;
}