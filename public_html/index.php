<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../private_html/vendor/autoload.php';
require __DIR__ . '/../private_html/vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../private_html/config/web.php';

(new yii\web\Application($config))->run();
