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
 * 文件session处理
 * Class FileHandler
 * @package willphp\session
 */
class FileHandler implements InterfaceSession {
	use Base;
	protected $dir; //session存放目录
	protected $file;	
    /**
     * 连接
     */
	public function connect() {
		$dir = Config::get('session.file.path');
		if (!is_dir($dir)) {
			mkdir($dir, 0755, true);
		}
		$this->dir = realpath($dir);
		$this->file = $this->dir.'/'.$this->session_id.'.php';	
	}
	/**
     * 读取数据
     */
	public function read() {
		if (!is_file($this->file)) {
			return [];
		}		
		return unserialize(file_get_contents($this->file));
	}
	/**
     * 保存数据
     */
	public function write()	{
		$data = serialize($this->items);	
		return file_put_contents($this->file, $data, LOCK_EX);
	}	
	/**
     * 垃圾回收
     */
	public function gc() {
		foreach (glob($this->dir.'/*.php') as $f) {
			if (basename($f) != basename($this->file) && (filemtime($f) + $this->expire + 3600) < time()) {
				unlink($f);
			}
		}
	}
}