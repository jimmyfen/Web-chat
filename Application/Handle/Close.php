<?php
namespace App\Handle;

use App\Table\Fd;
use App\Utility\Log;

class Close extends Common
{
	public static function hook($server, $fd)
	{
		Static::checkConnect($server);

		$fds = Fd::hGet();

		if ( isset($fds[$fd]) ) {
			unset($fds[$fd]);
		}

		Fd::hSet($fds);
	}
}