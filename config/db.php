<?php

return [
    'class' => 'yii\db\Connection',
    'emulatePrepare' => true,
    'dsn' => 'mysql:host=mysql;dbname=yii2test',
    'username' => getenv('MYSQL_USER') ?? 'root',
    'password' => getenv('MYSQL_PASSWORD') ?? '',
    'charset' => 'utf8mb4',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
