<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=bdsjcotizacion',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'attributes' => [PDO::ATTR_CASE => PDO::CASE_LOWER],
    
  /*  'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=181.129.107.162;dbname=maquiladigital',
    'username' => 'desarrollo',
    'password' => 'm@quil@1119',
    'charset' => 'utf8',*/

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
