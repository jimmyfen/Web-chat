<?php
namespace App\Table;

class Lists extends Redis
{
	static function hGet()
	{
		return unserialize(Static::$connect->hGet(Static::$key, 'list'));
	}

	static function hSet($value)
	{
		return Static::$connect->hSet(Static::$key, 'list', serialize($value));
	}


}