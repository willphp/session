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
/**
 * Session处理接口
 * Interface InterfaceCache
 * @package willphp\cache\build
 */
interface InterfaceSession {
    public function connect();
    public function read();
    public function gc();
    public function flush();
}