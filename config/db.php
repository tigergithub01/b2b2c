<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=b2b2c_wedding',
    'username' => 'b2b',
    'password' => 'b2b_tu_2016',
    'charset' => 'utf8',
	'tablePrefix' => 't_',
		
	'enableSchemaCache' => false,
	
	// Duration of schema cache.
	'schemaCacheDuration' => 3600,
	
	// Name of the cache component used to store schema information
	'schemaCache' => 'cache',
];
