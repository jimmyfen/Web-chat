<?php
namespace App\Utility;

use App\Config;

class Message
{
	protected static $command = [ 'MESSAGE', 'ADD_USER', 'CHANGE_NAME', 'USER_LIST', 'INIT', 'DELETE_USER', 'IMAGE', 'IMOJI' ];

	static function build($message)
	{
		$message = json_decode($message, true);

		if ( !is_array($message) || !isset($message['command']) || !isset($message['content']) ) {
			return null;
		}

		if ( !is_string($message['content']) && !is_numeric($message['content']) ) {
			return null;
		}

		if ( !in_array($message['command'], Static::$command) ) {
			$message['command'] = 'MESSAGE';
		}

		if ( $message['command'] === 'MESSAGE' ) {
			$message['content'] = htmlspecialchars($message['content']);
		}

		if ( $message['command'] === 'IMOJI' ) {
			$content = intval($message['content']);
			if ( $content < 0 || $content > 17 ) {
				$message['content'] = htmlspecialchars($message['content']);
			} else {
				$message['content'] = '<img src="http://chat.fzhang.cn/statics/emoji/' . $message['content'] . '.png" />';
			}
		}

		if ( $message['command'] === 'IMAGE' ) {
			if ( !strpos($message['content'], ',') || !base64_decode(substr($message['content'], strpos($message['content'], ',') + 1, -4)) ) {
				$message['content'] = htmlspecialchars($message['content']);
			}
		}

		return [ 'command' => $message['command'], 'content' => $message['content'], 'time' => date('Y-m-d H:i:s') ];
	}
}