<?php
/*--------------------------------------------------------------------------
 | Software: [WillPHP framework]
 | Site: www.113344.com
 |--------------------------------------------------------------------------
 | Author: no-mind <24203741@qq.com>
 | WeChat: www113344
 | Copyright (c) 2020-2022, www.113344.com. All Rights Reserved.
 |-------------------------------------------------------------------------*/
namespace willphp\session;
use willphp\framework\build\Provider;
class SessionProvider extends Provider {
	public $defer = false; //ÑÓ³Ù¼ÓÔØ	
	public function boot() {		
		Session:bootstrap(); //Æô¶¯session
	}
	public function register() {
		$this->app->single('Session', function () {
			return Session::single();
		});
	}
}