<?php

use YuriOliveira\Validation\Validate;

require_once(__DIR__ . '/vendor/autoload.php');

$validate = new Validate(['email' => 'yuri_oli@hotmail.com']);

$validate->validate([
    'email' => ['c.content']
]);