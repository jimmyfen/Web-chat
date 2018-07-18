<?php
namespace App\Table;

class Uniacid extends Redis
{
	static function hGet()
	{
		return unserialize(Static::$connect->hGet(Static::$key, 'uniacid'));
	}

	static function hSet($value)
	{
		return Static::$connect->hSet(Static::$key, 'uniacid', serialize($value));
	}


}