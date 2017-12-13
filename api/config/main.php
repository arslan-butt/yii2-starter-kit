<?php
$params = array_merge(
        // require(__DIR__ . '/../../common/config/params.php'),
        //require(__DIR__ . '/../../common/config/params-local.php'),
        require(__DIR__ . '/params.php')
        //require(__DIR__ . '/params-local.php')
);

return [
    'id'         => 'runmile-api',
    'basePath'   => dirname(__DIR__),
    'bootstrap'  => ['log'],
    'modules'    => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class'    => 'api\modules\v1\Module'
        ]
    ],
    'components' => [
        'user'       => [
            'identityClass'   => 'api\modules\v1\models\ApiUserIdentity',
            'enableAutoLogin' => false,
            'loginUrl' =>'',
            'enableSession' => false,
            'as afterLogin' => 'common\behaviors\LoginTimestampBehavior'
        ],
         
        'request'    => [
            'enableCookieValidation' => false,
            'enableCsrfValidation'   => false,
            //'cookieValidationKey' => 'xxxxxxx',
            'parsers'                => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON, 
                'charset' => 'UTF-8',    
            'on beforeSend' => function ($event) 
            {
                 $response = $event->sender;
                 return $response;
            }
        ],

        'log'        => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl'     => true,
            'enableStrictParsing' => true,
            'showScriptName'      => false,
            'rules'               => require('url_rules.php'),
        ],
       'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',           
            'viewPath' => '@app/mail',
            'useFileTransport' => false,
            'transport' => [
                                'class' => 'Swift_SmtpTransport',
                                'host' => 'smtp.gmail.com',
                                'username' => 'umarzaman2010@gmail.com',
                                'password' => 'ransu@123',
                                'port' => '587',
                                'encryption' => 'tls',
                                ],
         ],
                
    ],

    
    'params'     => $params,
];