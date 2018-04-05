<?php

switch (true) {
    // 参数错误
    case empty($argv[1]):
        throw new \Exception('The module name cannot be empty.');
        break;
    // 请传入引入composer autoload.php
    case empty($argv[2]):
        $composerAutoload = $argv[2];
        $errorMsg = sprintf("the boot file is found.(boot-file: %s)", $composerAutoload);
        throw new Exception($errorMsg);
        break;
    default:
        list($moduleName, $composerAutoload) = [$argv[1], $argv[2]];
        break;
}
require $composerAutoload;

\Zwei\EventWork\EventWorker::run($moduleName);