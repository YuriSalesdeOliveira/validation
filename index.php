<?php
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
use YuriOliveira\Validation\Validate;

require_once(__DIR__ . '/vendor/autoload.php');

$validate = new Validate(['email' => 'aasdfasdf']);

$validate->validate([
    'email' => ['email', 'c_filled', 'max:5']
]);

print_r($validate->errors());