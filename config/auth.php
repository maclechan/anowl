<?php
return [
    'driver' => 'eloquent',
    'model' => App\Models\Back\AdminUsers::class,
    'table' => 'admin_users',
    'password' => [
        'email'  => 'emails.password',
        'table'  => 'password_resets',
        'expire' => 60,
    ],

];
