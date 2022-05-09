<?php

require '../vendor/autoload.php';

use Annon\DbManager\DbFactory;

$config = [
    'host' => '127.0.0.1',
    'dbname' => 'yadmin',
    'user' => 'yadmin',
    'password' => 'yadmin',
    'port' => 4040,
    'charset' => 'utf8mb4',
];

$db     = DbFactory::getInstance("mysqli")->getDb($config);
$find   = $db->find("select * from `yd_log` limit 1");
$select = $db->select("select * from `yd_log`");
$insert = $db->insert(sprintf(
    "insert into `yd_log` (`type`, `data`, `sql`, `time`) values ('%s', '%s', '%s', '%s')",
    "info",
    "session close",
    "db test",
    date("Y-m-d H:i:s")
));
$update = $db->update(sprintf(
    "update `yd_log` set `type` = '%s' where `type` = '%s'",
    "warning",
    "info"
));
$delete = $db->delete(sprintf(
    "delete from `yd_log` where `data` = '%s'",
    "session close"
));

echo "<pre>";
var_dump($find, $db->affected_rows(), $select, $db->num_rows(), $insert, $update, $delete);
