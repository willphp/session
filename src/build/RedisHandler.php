<?php
/*--------------------------------------------------------------------------
 | Software: [WillPHP framework]
 | Site: www.113344.com
 |--------------------------------------------------------------------------
 | Author: 无念 <24203741@qq.com>
 | WeChat: www113344
 | Copyright (c) 2020-2022, www.113344.com. All Rights Reserved.
 |-------------------------------------------------------------------------*/
namespace willphp\session\build;
use willphp\config\Config;
/**
 * Redis session处理
 * Class RedisHandler
 * @package willphp\session
 */
class RedisHandler implements InterfaceSession {
	use Base;
	private $redis;
    /**
     * 连接
     */
	public function connect() {
		$config = Config::get('session.redis');
		$this->redis = new \Redis();
		$this->redis->connect($config['host'], $config['port']);
		if (!empty($config['password'])) {
			$this->redis->auth($config['password']);
		}
		$this->redis->select((int) $config['database']);
	}
	/**
     * 读取数据
     */
	public function read() {
		$data = $this->redis->get($this->session_id );
		return $data? json_decode($data, true) : [];
	}
	/**
     * 保存数据
     */
	public function write() {
		return $this->redis->set($this->session_id, json_encode($this->items, JSON_UNESCAPED_UNICODE));
	}
	/**
     * 垃圾回收
     */
	public function gc() {}
}
