<?php
$confidential = require(__DIR__.'/confidential.php');
$params = require(__DIR__.'/params.php');

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $confidential['db'][DB_CONNECTION],
    ],
    'params' => $params,
    /*
      'controllerMap' => [
      'fixture' => [ // Fixture generation command line.
      'class' => 'yii\faker\FixtureController',
      ],
      ],
     */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
