<?php
/*--------------------------------------------------------------------------
 | Software: [WillPHP framework]
 | Site: www.113344.com
 |--------------------------------------------------------------------------
 | Author: 无念 <24203741@qq.com>
 | WeChat: www113344
 | Copyright (c) 2020-2022, www.113344.com. All Rights Reserved.
 |-------------------------------------------------------------------------*/
namespace willphp\session;
use willphp\config\Config;
class Session {
	protected static $link;	
	public static function single()	{
		if (is_null(self::$link)) {
			$driver = ucfirst(Config::get('session.driver', 'file')); //session驱动
			$class = '\willphp\session\\build\\'.$driver.'Handler';
			self::$link = new $class();
		}		
		return self::$link;
	}	
	public function __call($method, $params) {
		return call_user_func_array([self::single(), $method], $params);
	}	
	public static function __callStatic($name, $arguments) {
		return call_user_func_array([static::single(), $name], $arguments);
	}
}