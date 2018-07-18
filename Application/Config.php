<?php
namespace App;

class Config
{
	protected static $instance;
	protected $config = [];

	public function __construct()
	{
		$config_file = ROOT_PATH . '/Config.php';
		$this->config = require($config_file);
	}

	public static function getInstance()
	{
		if ( !Static::$instance ) {
			Static::$instance = new Static;
		}

		return Static::$instance;
	}

	public function setConf(array $config = [])
	{
		$this->config = array_merge($this->config, $config);
	}

	/**
	 * 获取单项配置
	 * @param  string $key [description]
	 * @return [type]      [description]
	 */
	public function getConf($key = '')
	{
		if ( $key === '' ) {
			return $this->config;
		}

		if ( isset($this->config[$key]) ) {
			return $this->config[$key];
		}

		return null;
	}
}