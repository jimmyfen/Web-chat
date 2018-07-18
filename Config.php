<?php

return [
	'MAIN_SERVER' => [
		'HOST' => '0.0.0.0',
		'PORT' => '9501',
		'SETTING' => [
			'max_request' => 1000,
			'worker_num' => 4,
			'pid_file' => ROOT_PATH . '/Logs/server.pid'
		]
	],
	// 连接白名单ip
	'WHITE_LIST' => [],
	// redis键设置
	'REDIS_SERVER' => [
		'SERVICE_KEY' => 'client_service',
		'MESSAGE_KEY' => 'client_message'
	],
	// 数据库设置
	'MAIN_DB' => [
		'HOST' => '127.0.0.1',
		'USER' => 'root',
		'PASSWORD' => 'root',
		'DB_NAME' => 'test',
		'PORT' => 3306,
		'PREFIX' => 't_'
	]
];