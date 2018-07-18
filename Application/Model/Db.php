<?php
namespace App\Model;

use App\Config;
use \MysqliDb;

class Db
{
	protected $connection = [];
	protected $conf = [];

	public function __construct(string $name = 'MAIN_DB')
	{
		if ( !isset($this->connection[$name]) ) {
			$this->conf[$name] = Config::getInstance()->getConf($name);
			$this->connect($name);
		}
	}

	private function connect(string $name = 'MAIN_DB') : void
	{
		$this->connection[$name] = new \MysqliDb($this->conf[$name]['HOST'], $this->conf[$name]['USER'], $this->conf[$name]['PASSWORD'], $this->conf[$name]['DB_NAME'], $this->conf[$name]['PORT']);
	}

	public function getConnect(string $name = 'MAIN_DB') : ?MysqliDb
	{
		if ( isset($this->connection[$name]) ) {
			$this->checkConnect($name);
			$this->connection[$name]->setPrefix($this->conf[$name]['PREFIX']);
			return $this->connection[$name];
		}

		return null;
	}

	private function checkConnect(string $name = 'MAIN_DB') : void
	{
		if ( !$this->connection[$name]->query('select 1+1') ) {
			$this->connect($name);
		}
	}
}