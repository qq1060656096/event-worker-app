<?php

$demo = '[demo:php lib/DemoSendEvent.php demo_event 10 1]';

switch (true) {
    // 参数错误
    case empty($argv[1]):
        throw new \Exception('事件key不能未空'.$demo);
        break;
    default:
        $composerAutoload = 'vendor/autoload.php';
        if (!file_exists($composerAutoload)) {
            throw new Exception('引导文件不能为空(composer "vendor/autoload.php")'.$demo);
        }

        $times      = !isset($argv[2]) ? 10 : intval($argv[2]);
        $times      = max($times, 0);

        $sleepTime  = !isset($argv[3]) ? 10 : intval($argv[3]);
        $sleepTime  = max($sleepTime, 0);
        $eventKey   = $argv[1];
        break;
}

require $composerAutoload;


$nowDate = date('Y-m-d H:i:s');
echo <<<str

send test event
eventKey: $eventKey 
time: {$nowDate}

run demo start: 
# 运行10次间隔1秒
php lib/DemoSendEvent.php demo_event 10 1

# 一直运行间隔1秒
php lib/DemoSendEvent.php demo_event 0 1

# 一直运行不间隔
php lib/DemoSendEvent.php demo_event 0 1
run demo end:

str;


$i = 0;
while (true) {
    if ($i > $times && $times != 0) {
        break;
    }

    $sendData = [
        'i' => $i,
        'eventKey' => $eventKey,
        'times' =>$times,
        'sleepTime' => $sleepTime
    ];
    echo "$i \n";
    //发送产品购买事件
    \Wei\EventWork\EventSend::send($eventKey, $sendData);
    $sleepTime > 0 ? sleep($sleepTime) : null;
    $i ++;
}
