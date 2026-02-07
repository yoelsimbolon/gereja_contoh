<?php
/**
 * core/logger.php
 * Sistem activity log
 */

require_once __DIR__ . "/helper.php";

function activityLog($action, $description = '')
{
    $logFile = __DIR__ . '/../logs/activity.log';

    $user = isLogin() ? user() : null;

    $time = date('Y-m-d H:i:s');
    $ip   = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';

    $log = "[{$time}] ";
    $log .= "IP: {$ip} | ";

    if ($user) {
        $log .= "User: {$user['name']} ({$user['role']}) | ";
    } else {
        $log .= "User: GUEST | ";
    }

    $log .= "Action: {$action}";

    if (!empty($description)) {
        $log .= " | {$description}";
    }

    $log .= PHP_EOL;

    file_put_contents($logFile, $log, FILE_APPEND);
}
