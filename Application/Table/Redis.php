<?php
namespace App\Table;

use \Redis as OriginRedis;

Abstract class Redis
{
	protected static $connect;
	protected static $key;

	static function connect($key)
	{
		Static::$key = $key;
		if ( !isset(Static::$connect) ) {
			Static::$connect = new OriginRedis;
			Static::$connect->pconnect('127.0.0.1', 6379);
		}
	}

	Abstract static function hGet();

	Abstract static function hSet($value);
}