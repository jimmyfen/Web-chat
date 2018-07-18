<?php
namespace App\Table;

class Fd extends Redis
{
	static function hGet()
	{
		return unserialize(Static::$connect->hGet(Static::$key, 'fd'));
	}

	static function hSet($value)
	{
		return Static::$connect->hSet(Static::$key, 'fd', serialize($value));
	}


}