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
use willphp\cookie\Cookie;
/**
 * Trait Base
 * @package willphp\session\build
 */
trait Base {
	protected $session_id; //session ID
	protected $session_name; //session 名称
	protected $expire; //过期时间
	protected $items = []; //session 数据
	static protected $startTime; //开始时间
    /**
     * SESSION 启动器
     * @return $this
     */	
	public function bootstrap()	{
		$this->session_name = Config::get('session.name', 'WILLPHPID');
		$this->expire = intval(Config::get('session.expire', 864000));
		$this->session_id = $this->getSessionId();		
		$this->connect();
		$content = $this->read();		
		$this->items = is_array($content) ? $content : [];		
		if (is_null(self::$startTime)) {
			self::$startTime = microtime(true);
		}		
		return $this;
	}
    /**
     * 获取SESSION_ID
     * @return string
     */	
	final protected function getSessionId() {
		$id = Cookie::get($this->session_name);
		if (!$id) {
			$id = 'willphp'.md5(microtime(true).mt_rand(1, 6));
		}
		Cookie::set($this->session_name, $id, $this->expire, '/', Config::get('session.domain'));		
		return $id;
	}
    /**
     * 检测是否存在
     * @param $name
     * @return bool
     */	
	public function has($name) {
		return isset($this->items[$name]);
	}
    /**
     * 批量设置
     * @param $data
     */
	public function batch($data) {
		foreach ($data as $k => $v) {
			$this->set($k, $v);
		}
	}
    /**
     * 设置数据
     * @param string $name  名称(支持名称.名称)
     * @param mixed  $value 值
     * @return mixed
     */
	public function set($name, $value) {
		$tmp  = &$this->items;
		$exts = explode('.', $name);
		if (is_array($exts) && ! empty($exts)) {
			foreach ($exts as $d) {
				if ( ! isset($tmp[$d])) {
					$tmp[$d] = [];
				}
				$tmp = &$tmp[$d];
			}			
			$tmp = $value;			
			return true;
		}
		return false;
	}
    /**
     * 获取session数据
     * @param string $name 名称(支持名称.名称)
     * @param string $value 默认值
     * @return null
     */
	public function get($name = '', $value = null) {
		$tmp = $this->items;
		$arr = explode('.', $name);
		foreach ((array)$arr as $d) {
			if (isset($tmp[$d])) {
				$tmp = $tmp[$d];
			} else {
				return $value;
			}
		}		
		return $tmp;
	}
    /**
     * 删除
     * @param $name
     * @return bool
     */
	public function del($name) {
		if (isset($this->items[$name])) {
			unset($this->items[$name]);
		}		
		return true;
	}
    /**
     * 获取所有
     * @return mixed
     */
	public function all() {
		return $this->items;
	}
    /**
     * 清除所有(闪存数据不删除)
     * @return bool
     */
	public function flush() {
		$this->items = [];		
		return true;
	}
    /**
     * 闪存管理
     * @param        $name
     * @param string $value
     * @return bool|mixed|void
     */
	public function flash($name = '', $value = '') {
		if (is_array($name)) {		
			foreach ($name as $name => $value) {
				$this->set('_FLASH_.'.$name, [$value, self::$startTime]);
			}			
			return;
		} elseif ($name === '') {			
			return $this->get('_FLASH_', []);
		} elseif (is_null($name)) {			
			return $this->del('_FLASH_');
		}
		if (is_null($value)) {
			if (isset($this->items['_FLASH_'][$name])) {
				unset($this->items['_FLASH_'][$name]);
			}
		} elseif ($value === '') {
			$data = $this->get('_FLASH_.'.$name);
			return isset($data[0])? $data[0] : '';			
		} 
		return $this->set('_FLASH_.'.$name, [$value, self::$startTime]);
	}
    /**
     * 清除无效闪存
     */
	public function clearFlash() {
		$flash = $this->flash();
		foreach ($flash as $k => $v) {
			if ($v[1] != self::$startTime) {
				$this->flash($k, null);
			}
		}
	}
    /**
     * 关闭写入会话数据,同时执行垃圾清理
     */
	public function close() {
		$this->write();
		if (mt_rand(1, 100) == 1) {
			$this->gc();
		}
	}
    /**
     * 析构函数
     */
	public function __destruct() {
		$this->clearFlash();
		$this->close();
	}
}