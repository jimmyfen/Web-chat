<?php
namespace App\Utility;

class Log
{
	CONST USER_MESSAGE_TEMPLATE = '用户发送消息: [openid:{$openid}], [uniacid: {$uniacid}], [msgtype: {$msgtype}], [content: {$content}]';
	CONST USER_MESSAGE_SEND_TEMPLATE = '推送给在线客服: [account: {$account}]';
	CONST USER_MESSAGE_NO_KF_ONLINE_TEMPLATE = '无客服在线, 保存为未读消息';
	CONST KF_LOGIN_TEMPLATE = '客服登陆: [uniacid: {$uniacid}], [account: {$account}]';
	CONST KF_LOGINED_TEMPLATE = '客服登陆, 但账号已登陆: [uniacid: {$uniacid}], [account: {$account}]';
	CONST KF_MESSAGE_TEMPLATE = '客服发送消息,推送给用户: [uniacid: {$uniacid}], [account: {$account}], [openid: {$openid}], [msgtype: {$msgtype}], [content: {$content}]';
	CONST KF_LOGOUT_TEMPLATE = '客服退出: [uniacid: {$uniacid}], [account: {$account}]';
	CONST UNKOWN_CLIENT_CONNECT = '未知用户连接, 已断开连接: [ip: {$ip}]';
	CONST UNREAD_MESSAGE_TEMPLATE = '向客服发送未读消息: [openid: {$openid}], [uniacid: {$uniacid}], [account: {$account}], [msgtype: {$msgtype}], [content: {$content}]';
	CONST UNKOWN_MESSAGE_TEMPLATE = '收到未知消息: [content: {$content}]';
	CONST ERROR_MINIPROGRAMPAGE_MESSAGE_TEMPLATE = '收到错误格式小程序卡片消息：[account: {$account}], [content: {$content}]';
	CONST KEYWORDS_ANSWER_TEMPLATE = '匹配到关键字回复: [keywords: {$keywords}] [answer: {$answer}]';
	CONST FORCE_LOGOUT_TEMPLATE = '后台强制下线客服: [uniacid: {$uniacid}] [account: {$account}]';

	static function write(array $data, $template = '')
	{
		$file = ROOT_PATH . '/Logs/' . date('Ym') . '.log';
		file_put_contents($file, '[' . date('Y-m-d H:i:s') . ']  ' . preg_replace_callback('/\{\$(\w+)\}/', function ($matches) use ($data) {
			return $data[$matches[1]];
		}, $template) . "\r\n", FILE_APPEND);
	}

	static function consoleBegin()
	{
		ob_start();
	}

	static function consoleEnd($type = 'open')
	{
		$file = ROOT_PATH . '/Logs/console.log';
		$contents = ob_get_contents();
		ob_end_clean();

		file_put_contents($file, '[' . date('Y-m-d H:i:s') . '] [' . $type . '] ' . $contents . "\r\n", FILE_APPEND);
	}
}