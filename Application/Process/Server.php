<?php
namespace App\Process;

use App\Handle\Open;
use App\Handle\Message;
use App\Handle\Close;
use App\Utility\Log;

class Server
{
	protected $server;

	public function __construct($conf)
	{
		$this->server = new \swoole_websocket_server($conf['HOST'], $conf['PORT']);
		$this->server->set($conf['SETTING']);

		$this->server->on('open', function($server, $request){
			Log::consoleBegin();
			Open::hook($server, $request);
			Log::consoleEnd();
		});

		$this->server->on('message', function($server, $frame){
			Log::consoleBegin();
			Message::hook($server, $frame);
			Log::consoleEnd('message');
		});

		$this->server->on('close', function($server, $fd){
			Log::consoleBegin();
			Close::hook($server, $fd);
			Log::consoleEnd('close');
		});
	}

	public function getServer()
	{
		return $this->server;
	}
}