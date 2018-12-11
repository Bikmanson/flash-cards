<?php

use yii\filters\AccessControl;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
  'id' => 'basic',
  'language' => 'ru',
  'basePath' => dirname(__DIR__),
  'bootstrap' => ['log'],
  'aliases' => [
    '@bower' => '@vendor/bower-asset',
    '@npm' => '@vendor/npm-asset',
    '@modules' => dirname(__DIR__) . '/modules'
  ],
  'name' => yii::t('app', 'Flash Cards'),
  'modules' => [
    'lang' => [
      'class' => modules\lang\Module::class,
    ],
    'i18n' => [
      'translations' => [
        '*' => [
          'class' => 'yii\i18n\PhpMessageSource',
        ],
      ],
    ],
  ],
  'components' => [
    'request' => [
      // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
      'cookieValidationKey' => '7~B/Vfsyb<b79AGm4\g)~j2,d^R_~$',
    ],
    'cache' => [
      'class' => 'yii\caching\FileCache',
    ],
    'user' => [
      'identityClass' => 'app\models\Player',
      'enableAutoLogin' => true,
    ],
    'errorHandler' => [
      'errorAction' => 'site/error',
    ],
    'mailer' => [
      'class' => 'yii\swiftmailer\Mailer',
      // send all mails to a file by default. You have to set
      // 'useFileTransport' to false and configure a transport
      // for the mailer to send real emails.
      'useFileTransport' => true,
    ],
    'log' => [
      'traceLevel' => YII_DEBUG ? 3 : 0,
      'targets' => [
        [
          'class' => 'yii\log\FileTarget',
          'levels' => ['error', 'warning'],
        ],
      ],
    ],
    'db' => $db,

    'urlManager' => [
      'enablePrettyUrl' => true,
      'showScriptName' => false,
      'rules' => [
      ],
    ],

  ],
  'as access' => [
    'class' => AccessControl::class,
    'rules' => [
      [
        'allow' => true,
        'roles' => ['?'],
        'controllers' => ['site'],
        'actions' => ['login', 'sign-up', 'about', 'contact']
      ],
      [
        'allow' => true,
        'roles' => ['@']
      ],
      [
        'allow' => false,
        'roles' => ['?']
      ]
    ]
  ],
  'params' => $params,
];

if (YII_ENV_DEV) {
  // configuration adjustments for 'dev' environment
  $config['bootstrap'][] = 'debug';
  $config['modules']['debug'] = [
    'class' => 'yii\debug\Module',
    // uncomment the following to add your IP if you are not connecting from localhost.
    //'allowedIPs' => ['127.0.0.1', '::1'],
  ];

  $config['bootstrap'][] = 'gii';
  $config['modules']['gii'] = [
    'class' => 'yii\gii\Module',
    'generators' => [
      'langCrud' => [
        'class' => '\modules\lang\gii\generators\langCrud\Generator',
        'templates' => [
          'default' => '@modules/lang/gii/generators/langCrud/default',
        ]
      ],
      'langModel' => [
        'class' => '\modules\lang\gii\generators\langModel\Generator',
        'templates' => [
          'default' => '@modules/lang/gii/generators/langModel/default',
        ]
      ],
    ]
    // uncomment the following to add your IP if you are not connecting from localhost.
    //'allowedIPs' => ['127.0.0.1', '::1'],
  ];
}

return $config;
