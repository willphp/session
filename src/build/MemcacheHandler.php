<?php
/*--------------------------------------------------------------------------
 | Software: [WillPHP framework]
 | Site: www.113344.com
 |--------------------------------------------------------------------------
 | Author: no-mind <24203741@qq.com>
 | WeChat: www113344
 | Copyright (c) 2020-2022, www.113344.com. All Rights Reserved.
 |-------------------------------------------------------------------------*/
namespace willphp\session\build;
use willphp\config\Config;
/**
 * Memcache session处理
 * Class MemcacheHandler
 * @package willphp\session
 */
class MemcacheHandler implements InterfaceSession {
	use Base;
	private $memcache;	
    /**
     * 连接
     */
	public function connect() {
		$options = Config::get('session.memcache');
		$this->memcache = new \Memcache();
		$this->memcache->connect($options['host'], $options['port']);
	}
	/**
     * 读取数据
     */
	public function read() {
		$data = $this->memcache->get($this->session_id);		
		return $data? json_decode($data, true) : [];
	}
	/**
     * 保存数据
     */
	public function write() {
		return $this->memcache->set($this->session_id, json_encode($this->items, JSON_UNESCAPED_UNICODE));
	}
	/**
     * 垃圾回收
     */
	public function gc() {}
}
