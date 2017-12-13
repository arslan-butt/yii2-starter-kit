<?php
return [
    //User Related API's
    [
        'class' => 'yii\rest\UrlRule',
        'pluralize' => false,
        'controller' => 'v1/user',
        'extraPatterns' => [
            'GET' => 'index',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'pluralize' => false,
        'controller' => 'v1/user',
        'extraPatterns' => [
            'POST login' => 'login',
        ],
    ],
    //Reset Password
    [
        'class' => 'yii\rest\UrlRule',
        'pluralize' => false,
        'controller' => 'v1/user',
        'extraPatterns' => [
            'PUT reset' => 'reset',
        ],
    ],
];

?>