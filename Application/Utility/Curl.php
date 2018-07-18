<?php
namespace App\Utility;

class Curl
{
	static function get($url, array $params = [])
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		if ( isset($params['headers']) ) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $params['headers']);
		}
		$output = curl_exec($ch);
		curl_close($ch);

		if ( $output ) {
			return $output;
		}

		return null;
	}

	static function post($url, $data, array $params = [])
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		if ( isset($params['headers']) ) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $params['headers']);
		}
		$output = curl_exec($ch);
		curl_close($ch);

		if ( $output ) {
			return $output;
		}

		return null;
	}
}