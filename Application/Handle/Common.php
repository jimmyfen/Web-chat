<?php
namespace App\Handle;

use App\Config;
use App\Table\Fd;

class Common
{
	protected $fd;

	public static function checkConnect($server, $fd = 0)
	{
		$conf = Config::getInstance()->getConf('REDIS_SERVER');
		Fd::connect($conf['SERVICE_KEY']);

		$allFd = Fd::hGet();
		$allFd = $allFd ? $allFd : [];
		$connections = Static::IteratorToArray($server->connections, $fd);

		foreach ( $allFd as $k => $v ) {
			if ( !in_array($k, $connections) ) {
				unset($allFd[$k]);
			}
		}

		Fd::hSet($allFd);
	}

	public static function IteratorToArray($connections, $fd)
	{
		$result = [];
		foreach ( $connections as $_fd ) {
			if ( $fd !== $_fd ) {
				$result[] = $_fd;
			}
		}
		return $result;
	}
}