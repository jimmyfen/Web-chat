<?php
namespace App\Table;

class Message extends Redis
{
	protected static $message_key;

	static function hGet()
	{
		return unserialize(Static::$connect->hGet(Static::$key, Static::$message_key));
	}

	static function hSet($value)
	{
		return Static::$connect->hSet(Static::$key, Static::$message_key, serialize($value));
	}

	static function setMessageKey(string $key = '')
	{
		Static::$message_key = $key;
	}
}