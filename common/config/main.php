<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',

   // 'modules' =>[
   //   'redactor' =>[
   //       'uploadDir' => '@frontend//web/uploads',
   //       'uploadUrl' =>  'http://www.yfc.com/uploads',
   //   ]
   // ],

    'components' => [
    // 'user' => [
    //         'identityClass' => 'app\models\User',
    //         'enableAutoLogin' => true,
    //     ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@runtime/cache2',
        ],
    ],
];
