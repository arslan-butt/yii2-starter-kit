<?php
return [
    'class'=>'yii\web\UrlManager',
    'enablePrettyUrl'=>true,
    'showScriptName'=>false,
    'rules'=> [
        [
            'class'      => 'yii\rest\UrlRule',
            'pluralize'  => false,
            'controller' => 'v1/user',
            'extraPatterns' => [
                'GET'    => 'index',
            ],
        ],
        // Api
        //['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/article', 'only' => ['index', 'view', 'options']],
       // ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/user', 'only' => ['index', 'view', 'options']],

]
];