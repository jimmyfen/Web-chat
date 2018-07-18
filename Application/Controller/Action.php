<?php
namespace App\Controller;

use App\Config;
use App\Model\Db;
use App\Table\Fd;
use App\Table\Uniacid;
use App\Table\Lists;
use App\Table\Message;
use App\Utility\Message as MessageParse;

class Action
{
	public $emoji = [
		[ 'src' => '/statics/emjoy/88_thumb.gif', 'content' => '/88', 'value' => '/:bye' ],
		[ 'src' => '/statics/emjoy/angrya_thumb.gif', 'content' => '/angry', 'value' => '/::@' ],
		[ 'src' => '/statics/emjoy/bba_thumb.gif', 'content' => '/bba', 'value' => '/:,@-D' ],
		[ 'src' => '/statics/emjoy/bs_thumb.gif', 'content' => '/bs', 'value' => '/::(' ],
		[ 'src' => '/statics/emjoy/bs2_thumb.gif', 'content' => '/bs2', 'value' => '/:>-|' ],
		[ 'src' => '/statics/emjoy/bz_thumb.gif', 'content' => '/bz', 'value' => '/::X' ],
		[ 'src' => '/statics/emjoy/cj_thumb.gif', 'content' => '/cj', 'value' => '/::O' ],
		[ 'src' => '/statics/emjoy/cool_thumb.gif', 'content' => '/cool', 'value' => '/::+' ],
		[ 'src' => '/statics/emjoy/crazya_thumb.gif', 'content' => '/razya', 'value' => '/::Q' ],
		[ 'src' => '/statics/emjoy/cry.gif', 'content' => '/cry', 'value' => '/:,@!' ],
		[ 'src' => '/statics/emjoy/cza_thumb.gif', 'content' => '/cza', 'value' => '/::g' ],
		[ 'src' => '/statics/emjoy/dizzya_thumb.gif', 'content' => '/dizzya', 'value' => '/:,@@' ],
		[ 'src' => '/statics/emjoy/gza_thumb.gif', 'content' => '/gza', 'value' => '/:handclap' ],
		[ 'src' => '/statics/emjoy/h_thumb.gif', 'content' => '/cj', 'value' => '/::L' ],
		[ 'src' => '/statics/emjoy/haqianv2_thumb.gif', 'content' => '/haqianv2', 'value' => '/::-O' ],
		[ 'src' => '/statics/emjoy/heia_thumb.gif', 'content' => '/heia', 'value' => '/:,@P' ],
		[ 'src' => '/statics/emjoy/huanglianse_thumb.gif', 'content' => '/huanglianse', 'value' => '/::B' ],
		[ 'src' => '/statics/emjoy/huanglianwx_thumb.gif', 'content' => '/huanglianwx', 'value' => '/::)' ],
		[ 'src' => '/statics/emjoy/kl_thumb.gif', 'content' => '/kl', 'value' => '/:8*' ],
		[ 'src' => '/statics/emjoy/landeln_thumb.gif', 'content' => '/landeln', 'value' => '/:,@o' ],
		[ 'src' => '/statics/emjoy/laugh.gif', 'content' => '/laugh', 'value' => '/::>' ],
		[ 'src' => '/statics/emjoy/mb_thumb.gif', 'content' => '/mb', 'value' => '/:,@-D' ],
		[ 'src' => '/statics/emjoy/moren_feijie_thumb.png', 'content' => '/feijie', 'value' => '/:?' ],
		[ 'src' => '/statics/emjoy/pcmoren_huaixiao_thumb.png', 'content' => '/huaixiao', 'value' => '/:B-)' ],
		[ 'src' => '/statics/emjoy/qq_thumb.gif', 'content' => '/qq', 'value' => '/::*' ],
		[ 'src' => '/statics/emjoy/sada_thumb.gif', 'content' => '/sada', 'value' => '/::<' ],
		[ 'src' => '/statics/emjoy/sb_thumb.gif', 'content' => '/sbs', 'value' => '/::T' ],
		[ 'src' => '/statics/emjoy/shamea_thumb.gif', 'content' => '/shamea', 'value' => '/::$' ],
		[ 'src' => '/statics/emjoy/sw_thumb.gif', 'content' => '/sw', 'value' => '/::(' ],
		[ 'src' => '/statics/emjoy/sweata_thumb.gif', 'content' => '/sweata', 'value' => '/:wipe' ],
		[ 'src' => '/statics/emjoy/t_thumb.gif', 'content' => '/t', 'value' => '/::T' ],
		[ 'src' => '/statics/emjoy/tootha_thumb.gif', 'content' => '/tootha', 'value' => '/::D' ],
		[ 'src' => '/statics/emjoy/tza_thumb.gif', 'content' => '/tza', 'value' => '/:,@-D' ],
		[ 'src' => '/statics/emjoy/wabi_thumb.gif', 'content' => '/wabi', 'value' => '/:dig' ],
		[ 'src' => '/statics/emjoy/wq_thumb.gif', 'content' => '/wq', 'value' => '/:P-(' ],
		[ 'src' => '/statics/emjoy/x_thumb.gif', 'content' => '/x', 'value' => '/:,@x' ],
		[ 'src' => '/statics/emjoy/yhh_thumb.gif', 'content' => '/yhh', 'value' => '/:@>' ],
		[ 'src' => '/statics/emjoy/yw_thumb.gif', 'content' => '/yw', 'value' => '/:?' ],
		[ 'src' => '/statics/emjoy/yx_thumb.gif', 'content' => '/yx', 'value' => '/:X-)' ],
		[ 'src' => '/statics/emjoy/zhh_thumb.gif', 'content' => '/zhh', 'value' => '/:<@' ],
		[ 'src' => '/statics/emjoy/zy_thumb.gif', 'content' => '/zy', 'value' => '/::P' ]
	];

	public function __construct()
	{
		session_start();
	}

	public function index()
	{
		if (empty($_SESSION['user'])) {
			header('location:login.html');
			exit;
		}

		$account = $_SESSION['user'];
		### 获取配置
		$conf = Config::getInstance()->getConf('REDIS_SERVER');
		### 所有用户列表
		Lists::connect($conf['SERVICE_KEY']);
		$lists = Lists::hGet();
		$lists = is_array($lists) && isset($lists[$account['uniacid']]) ? $lists[$account['uniacid']] : [];

		require_once STATIC_PATH . 'index.html';
	}

	public function all_online()
	{
		global $data;
		global $request;
		global $config;
		header('Cache: no-cache');

		if ($_SERVER['REMOTE_ADDR'] !== '120.24.154.200') {
			$this->api_data(0, '没有权限');
		}

		### 获取配置
		$conf = Config::getInstance()->getConf('REDIS_SERVER');
		### 所有用户列表
		Fd::connect($conf['SERVICE_KEY']);
		$fds = Fd::hGet();
		$uniacids = Uniacid::hGet();
		$uniacid = $data['uniacid'];

		$online = array();
		if ( $uniacids && isset($uniacids[$uniacid]) ) {
			foreach ( $uniacids[$uniacid] as $fd => $total ) {
				unset($fds[$fd]['connect']);
				$online[] = $fds[$fd];
			}
		}

		$this->api_data(1, 'ok', $online);
	}

	public function offline()
	{
		global $data;
		global $request;
		global $config;

		// require_once dirname(__FILE__) . '/WebSocketClient.php';

		$redis = new Redis;
		$redis->connect('127.0.0.1', 6379);

		### 获取配置
		$conf = Config::getInstance()->getConf('REDIS_SERVER');
		### 所有用户列表
		Fd::connect($conf['SERVICE_KEY']);
		$fds = Fd::hGet();
		$uniacids = Uniacid::hGet();
		$uniacid = $data['uniacid'];
		$db = new Db;

		$account = $db->getConnect()->where('uniacid', $uniacid)->where('account', $data['account'])->getOne('account_client_service');
		if (empty($account)) {
			$this->api_json(0, '没有权限');
		}

		if ( $uniacids && isset($uniacids[$uniacid]) ) {
			foreach ( $uniacids[$uniacid] as $fd => $total ) {
				if ( $fds[$fd]['account'] === $data['account'] ) {
					unset($fds[$fd]);
					unset($uniacids[$uniacid][$fd]);
					break;
				}
			}
			Fd::hSet($fds);
			Uniacid::hSet($uniacids);
		}
		$this->api_json(1);
	}

	public function img()
	{
		global $data;
		global $request;
		$url = base64_decode($data['url']);
		if (!strpos($url, 'mmbiz.qpic.cn')) {
			header('HTTP/1.1 403 Forbidden');
			exit;
		}
		ob_end_clean();
		header('Content-type:image/jpeg');
		echo file_get_contents($url);
	}

	public function login()
	{
		global $data;
		global $request;

		$db = new Db;
		### 获取配置
		$conf = Config::getInstance()->getConf('REDIS_SERVER');
		### 所有用户列表
		Fd::connect($conf['SERVICE_KEY']);
		$fds = Fd::hGet();
		$uniacids = Uniacid::hGet();

		if ($request['ispost']) {
			$account = $this->check_login();
			$account['name'] = $db->getConnect()->where('uniacid', $account['uniacid'])->getValue('account_wxapp', 'name');

			if ( $uniacids && isset($uniacids[$account['uniacid']]) ) {
				foreach ( $uniacids[$account['uniacid']] as $fd => $total ) {
					if ( $fds[$fd]['account'] === $account['account'] ) {
						error('已有人登陆该客服，暂时无法登陆 <span style="color:red">(注意: 如不是本人操作，可前往后台 客服->在线客服列表 强制下线)</span>');
					}
				}
			}

			$token = md5($account['id'] . microtime());
			$r = $db->getConnect()->where('id', $account['id'])->update('account_client_service', [ 'token' => $token ]);

			$account['token'] = $token;
			$_SESSION['user'] = $account;

			success('登录成功', 'index.html');

		} else {
			require_once STATIC_PATH . 'login.html';
			if (!empty($data['token'])) {
				$account = $db->getConnect()->where('token', $data['token'])->getOne('account_client_service');
				if (!empty($account)) {
					if ( $uniacids && isset($uniacids[$account['uniacid']]) ) {
						foreach ( $uniacids[$account['uniacid']] as $fd => $total ) {
							if ( $fds[$fd]['account'] === $account['account'] ) {
								exit('<script>frontz.alert("提示", "已有人登陆该客服，暂时无法登陆 <span style=\"color:red\">(注意: 如不是本人操作，可前往后台 客服->在线客服列表 强制下线)</span>");</script>');
							}
						}
					}

					$account['name'] = $db->getConnect()->where('uniacid', $account['uniacid'])->getValue('account_wxapp', 'name');
					$account['token'] = md5($account['id'].microtime());
					$db->getConnect()->where('id', $account['id'])->update('account_client_service', [ 'token' => $account['token'] ]);
					$_SESSION['user'] = $account;
					header('location:index.html');
				}
			}
		}
	}

	public function logout()
	{
		global $data;
		global $request;

		session_destroy();
		if (!$data['isajax']) {
			header('location:login.html');
		}
	}

	public function deleteUser()
	{
		global $data, $request;

		if ( !isset($_SESSION['user']) ) {
			$this->api_data(0, '请先登录');
		}

		if ( !isset($data['openid']) ) {
			$this->api_data(0, '缺少参数');
		}

		$uniacid = $_SESSION['user']['uniacid'];
		### 获取配置
		$conf = Config::getInstance()->getConf('REDIS_SERVER');
		### 所有用户列表
		Lists::connect($conf['SERVICE_KEY']);
		$lists = Lists::hGet();
		Message::setMessageKey('message');
		$messages = Message::hGet();

		if ( $lists  && isset($lists[$uniacid]) && isset($lists[$uniacid][$data['openid']]) ) {
			unset($lists[$uniacid][$data['openid']]);
			Lists::hSet($lists);
		}

		if ( $messages && isset($messages[$uniacid]) && isset($messages[$uniacid][$data['openid']])  ) {
			unset($messages[$uniacid][$data['openid']]);
			Message::hSet($messages);
		}

		$this->api_data(1, 'ok');
	}

	public function messages()
	{
		global $data, $request;

		if ( !$request['isajax'] ) {
			header('Http/1.1 403 Forbidden');
			exit('Access Denied!');
		}

		if ( !isset($_SESSION['user']) ) {
			$this->api_data(0, '请先登录');
		}
		$openid = $data['openid'];
		$uniacid = $_SESSION['user']['uniacid'];
		$name = $_SESSION['user']['name'];
		$page = max(1, $data['page']);
		$keywords = trim($data['keywords']);
		$psize = 20;

		$db = new Db;
		$nickname = $db->getConnect()->where('uniacid', $uniacid)->where('openid', $openid)->getValue('ewei_shop_member', 'nickname');
		if ( !is_string($nickname) ) {
			$this->api_data(0, '参数错误');
		}
		$nickname = $nickname === '' ? '未知用户' : $nickname;

		$conf = Config::getInstance()->getConf('REDIS_SERVER');
		Message::connect($conf['SERVICE_KEY']);
		Message::setMessageKey('message');
		$messages = Message::hGet();
		$messages = !$messages || !isset($messages[$uniacid][$openid]) ? [] : $messages[$uniacid][$openid];
		// $messages = array_reverse($messages);


		if (!empty($keywords)) {
			foreach ($messages as $key => $value) {
				if ($value['msgtype'] === 'image' || strpos($value['content'], $keywords) === false) {
					unset($messages[$key]);
				}
			}
			$messages = array_values($messages);
		}

		$maxpage = ceil(count($messages)/20);
		$messages = array_slice($messages, ($page - 1) * $psize, $psize);
		$messages = array_reverse($messages);

		$html = '';
		foreach ( $messages as $message ) {
			$message['content'] = !$message['content'] ? '' : $message['content'];
			if ( $message['msgtype'] !== 'miniprogrampage' ) {
				$message['content'] = MessageParse::parseEmoji($message['content']);
				$message['content'] = str_replace("\n", '<br />', $message['content']);
			}
			$html .= '<li>' . ( $message['from'] === 'me' ? '<div class="colorRed"><span>我</span><span>' : ( '<div class="colorGreen"><span>' . $nickname . '</span><span>' ) ) . $message['time'] . '</span></div>' . ( $message['msgtype'] === 'image' && strpos($message['content'], 'base64') !== false ? ( '<img src="' . $message['content'] . '" />' ) : ( $message['msgtype'] === 'miniprogrampage' ? ('<div class="goodDetail"><div class="goodDetailgoods">'.$name.'</div><div class="goodDetailTitle">'.$message['content']['title'].'</div><img src="'.$message['content']['thumb'].'" /></div>') : $message['content'] ) ) . '</li>';
		}

		$this->api_data(1, 'ok', array('maxpage' => $maxpage, 'messages' => $messages, 'html' => $html));
	}

	public function logs()
	{
		global $data;

		$month = isset($data['month']) ? $data['month'] : date('Y-m');
		$keywords = isset($data['keywords']) ? $data['keywords'] : '';
		$page = isset($data['page']) ? max(1, $data['page']) : 1;

		$contents = [];
		$totalPage = 0;

		if (!empty($month)) {
			$file = ROOT_PATH . '/Logs/' . str_replace('-', '', $month) . '.log';
			if ( is_file($file) ) {
				$contents = file_get_contents($file);
				$contents = explode("\r\n", $contents);

				if ( !empty($keywords) ) {
					foreach ( $contents as $index => &$content ) {
						if ( strpos($content, $keywords) === false ) {
							unset($contents[$index]);
						}
					}
					unset($content);
				}

				$totalPage = ceil(count($contents)/20);
				$contents = array_slice($contents, ( $page - 1 ) * 20, 20);
				foreach ( $contents as &$content ) {
					$content = MessageParse::parseEmoji($content);
					$content = explode('  ', $content);
					$content = [ 'time' => $content[0], 'content' => $content[1] ];
				}
				unset($content);
			}
		}

		require_once STATIC_PATH . 'logs.html';
	}

	public function goodsList()
	{
		global $request, $data;

		if ( !$request['isajax'] ) {
			header('Http/1.1 403 Forbidden');
			exit('Access Denied!');
		}

		if ( !isset($_SESSION['user']) ) {
			$this->api_data(0, '请先登录');
		}

		$page = !isset($data['page']) ? 1 : max(1, (int) $data['page']);
		$keywords = !isset($data['keywords']) ? '' : $data['keywords'];
		$db = new Db;
		$account = $_SESSION['user'];
		$db->getConnect()->pageLimit = 10;
		$list = $db->getConnect()->where('uniacid', $account['uniacid'])->where('status', 1)->where('title', '%' . $keywords . '%', 'like')->orderBy('id', 'ASC')->paginate('ewei_shop_goods', $page, 'id,title,thumb');
		$conf = Config::getInstance()->getConf('THUMB_URL');

		foreach ( $list as &$l ) {
			$l['thumb'] = strpos($l['thumb'], 'http') === false ? ($conf . $l['thumb']) : $l['thumb'];
		}
		unset($l);

		$this->api_data(1, 'ok', [ 'totalPage' => $db->getConnect()->totalPages, 'list' => $list ]);
	}

	private function check_login()
	{
		global $data;

		if (empty($data['user']) || empty($data['pwd'])) {
			error('请输入用户名或密码');
		}

		$db = new Db;
		$account = $db->getConnect()->where('account', $data['user'])->getOne('account_client_service');

		if (empty($account)) {
			error('用户名不存在');
		}

		if (md5(md5($data['pwd']) . $account['encrypt']) !== $account['pwd']) {
			error('用户名或密码错误');
		}

		return $account;
	}

	/**
	 * 返回json数据
	 *
	 * @param int    $status
	 * @param string $msg
	 * @param array  $data
	 * @return void
	 */
	private function api_data($status, $msg, $data = array())
	{
		$ret = array('status' => $status, 'msg' => $msg, 'data' => $data);
		header('Content-type:text/json; charset=utf-8');
		exit(json_encode($ret));
	}

	private function api_json($status, $result = null)
	{
		$ret = array('status' => $status, 'result' => array('url' => $_SERVER['HTTP_REFERER']));
		if (!empty($result)) {
			$ret['result'] = $result;
		}
		header('Content-type:text/json; charset=utf-8');
		exit(json_encode($ret));
	}
}
