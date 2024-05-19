<?php


require __DIR__ . '/vendor/autoload.php';

const DB_SETTINGS = [
    'host' => 'db',
    'user' => 'user',
    'pass' => 'pass',
    'db_name' => 'cmp1611_pablo_vinicius_tales_renato',
    'port' => '5432',
    'drive' => 'pgsql',
];

$teste = new CMP1611_Query();

echo "<pre>";
print_r($teste);
echo "<pre>";
exit();
