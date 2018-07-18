<?php
namespace App\Utility;

use App\Config;

class Message
{
	protected static $command = [ 'MESSAGE', 'ADD_USER', 'CHANGE_NAME', 'USER_LIST', 'INIT' ];

	static function build($message)
	{
		$message = json_decode($message, true);

		if ( !is_array($message) || !isset($message['command']) || !isset($message['content']) ) {
			return null;
		}

		if ( !is_string($message['content']) ) {
			return null;
		}

		if ( !in_array($message['command'], Static::$command) ) {
			$message['command'] = 'MESSAGE';
		}

		return [ 'command' => $message['command'], 'content' => htmlspecialchars($message['content']), 'time' => date('Y-m-d H:i:s') ];
	}
}