<?php
namespace App\Handle;

use App\Table\Fd;
use App\Utility\Message as MessageParse;

class Message extends Common
{
	public static function hook($server, $frame, Db $db)
	{
		Static::checkConnect($server);

		$message = MessageParse::parse($frame->data);  // 解析消息

		if ( $message ) {
			if ( $message['command'] === 'MESSAGE' ) {
				$message['fd'] = $frame->fd;
				foreach ( $server->connections as $fd ) {
					if ( $fd !== $frame->fd ) {
						$server->push($fd, json_encode($message, JSON_UNESCAPED_UNICODE));
					}
				}

				return;
			}

			if ( $message['command'] === 'CHANGE_NAME' ) {
				$fd = Fd::hGet();

				if ( isset($fd[$frame->fd]) ) {
					$fd[$frame->fd] = [ 'name' => $message['content'] ];
					Fd::hSet($fd);
				}

				foreach ( $server->connections as $fd ) {
					$server->push($fd, json_encode($fd, JSON_UNESCAPED_UNICODE));
				}

				return;
			}

		}
			
		$server->push($frame->fd, 'unkown message');
		
	}

	/**
	 * 获取图片格式
	 * @param  string $content [description]
	 * @return [type]          [description]
	 */
	private static function getImageMime(string $content)
	{
		if ( strpos($content, 'png') ) {
			return '.png';
		}
		if ( strpos($content, 'gif') ) {
			return '.gif';
		}
		if ( strpos($content, 'bmp') ) {
			return '.bmp';
		}
		return '.jpg';
	}
}