<?php
namespace App\Handle;

use App\Table\Fd;
use App\Utility\Message as MessageParse;

class Message extends Common
{
	public static function hook($server, $frame)
	{
		Static::checkConnect($server);

		$message = MessageParse::build($frame->data);  // 解析消息

		if ( $message ) {
			if ( $message['command'] === 'MESSAGE' || $message['command'] === 'IMAGE' || $message['command'] === 'IMOJI' ) {
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
					$originName = $fd[$frame->fd]['name'];
					$fd[$frame->fd] = [ 'name' => $message['content'] ];
					Fd::hSet($fd);
				}

				foreach ( $server->connections as $_fd ) {
					if ( $_fd !== $frame->fd ) {
						$server->push($_fd, json_encode([ 'command' => 'CHANGE_NAME', 'content' =>[ 'fd' => $frame->fd, 'name' => $message['content'], 'originName' => $originName ] ], JSON_UNESCAPED_UNICODE));
					}
				}

				return;
			}

		}
			
		$server->push($frame->fd, json_encode([ 'command' => 'ERROR', 'content' => 'unkown message' ]));
		
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