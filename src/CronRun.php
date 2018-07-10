<?php

switch (true) {
    // 参数错误
    case empty($argv[1]):
        throw new \Exception('The cron name cannot be empty.');
        break;
    // 请传入引入composer autoload.php
    case empty($argv[2]):
        $composerAutoload = 'vendor/autoload.php';
        if (!file_exists($composerAutoload)) {
            $errorMsg = sprintf("the boot file is found.(boot-file: %s)", $composerAutoload);
            throw new Exception($errorMsg);
        }
        list($name, $composerAutoload) = [$argv[1], $composerAutoload];
        break;
    default:
        list($name, $composerAutoload) = [$argv[1], $argv[2]];
        break;
}
require $composerAutoload;

\Zwei\EventWork\Cron::run($name);