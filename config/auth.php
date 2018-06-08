<?php

return [
    //身份验证默认设置
    'defaults' => [
       /* 'guard' => 'web',
        'passwords' => 'users',*/

        'guard' => 'extman',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | 身份验证保护
    |--------------------------------------------------------------------------
    | Guard 定义了用户在每个请求中如何实现认证 (存储用户认证信息[和Session交互 api是token])
    | 默认使用了extman,使用的是sessoind存储、Eloquent用户提供器
    |
    | 所有身份验证驱动程序都有一个用户提供器.为每个应用 可单独使用某个身份验证保护
    | 支持: "session", "token"
    |
    */

    'guards' => [
        'extman' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | 用户提供器
    |--------------------------------------------------------------------------
    | Provider 定义了如何从持久化存储中获取用户信息 (存取数据[与数据库交互])
    |
    | 支持: "database", "eloquent"
    |
    */

    'providers' => [
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Role\AdminUsers::class,
        ],

        'users' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings based on the specific user types.
    |
    | The expire time is the number of minutes that the reset token should be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
        ],
    ],

];
