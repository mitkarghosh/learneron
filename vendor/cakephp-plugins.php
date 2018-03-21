<?php
$baseDir = dirname(dirname(__FILE__));
return [
    'plugins' => [
        'Admin' => $baseDir . '/plugins/Admin/',
        'Bake' => $baseDir . '/vendor/cakephp/bake/',
        'DebugKit' => $baseDir . '/vendor/cakephp/debug_kit/',
        'Migrations' => $baseDir . '/vendor/cakephp/migrations/',
        'Recaptcha' => $baseDir . '/vendor/cakephp-fr/recaptcha/',
        'RememberMe' => $baseDir . '/plugins/RememberMe/'
    ]
];