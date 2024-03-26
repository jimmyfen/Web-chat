<?php
namespace App\Handle;

use App\Table\Fd;
use App\Utility\Log;

class Close extends Common
{
	public static function hook($server, $fd)
	{
		// Static::checkConnect($server);

		$fds = Fd::hGet();

		if ( isset($fds[$fd]) ) {
			$name = $fds[$fd]['name'];
			unset($fds[$fd]);
		}

		foreach ($server->connections as $_fd) {
			if ($fd !== $_fd) {
				$server->push($_fd, json_encode([ 'command' => 'DELETE_USER', 'content' => [ 'fd' => $fd, 'name' => $name ] ], JSON_UNESCAPED_UNICODE));
			}
		}

		Fd::hSet($fds);
	}
}