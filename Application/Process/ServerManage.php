<?php
namespace App\Process;

use App\Config;

class ServerManage
{
	protected $server;
	protected static $manager;

	public function __construct(array $options)
	{
		$conf = Config::getInstance()->getConf('MAIN_SERVER');
		if ( isset($options['d']) ) {
			$conf['SETTING']['daemonize'] = 1;
		}
		$this->server = new Server($conf);
	}

	public static function getInstance(array $options) : ServerManage
	{
		if ( !isset(Static::$manager) ) {
			Static::$manager = new self($options);
		}

		return Static::$manager;
	}

	public function start()
	{
		echo "\e[31mserver start at " . date('Y-m-d H:i:s') . ".\e[0m\n";
		$this->server->getServer()->start();
	}
}