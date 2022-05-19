# Session组件

Session组件处理网站session,引擎包括File、Memcache、Redis,支持统一调用接口

#开始使用

####安装组件

使用 composer 命令进行安装或下载源代码使用，依赖(willphp/config,willphp/cookie)。

    composer require willphp/session

> WillPHP框架已经内置此组件，无需再安装。

####调用说明

    \willphp\config\Session::bootstrap(); //调用之前必须先启动

####Session配置

config/session.php配置文件示例如下：

	return [
		'driver' => 'file', //默认驱动
		'name' => 'willphpid', //名称前缀
		'domain' => '', //有效域名
		'expire'=> 86400 * 10, //过期时间
		'file' => [
			'path' => RUNTIME_PATH.'/session', //文件类session保存路径
		],
		'memcache' => [
			'host' => 'localhost',
			'port' => 11211,
		],
		'redis' => [
			'host' => 'localhost',
			'port' => 11211,
			'password' => '',
			'database' => 0,
		],
	];

####设置

    Session::set('app', 'willphp');  

####检测

    Session::has('app'); //是否存在

####获取

    Session::get('app'); 

####删除

    Session::del('app'); 

####清空

    Session::flush(); 

####闪存

通过 flash 设置的数据会在下次请求结束时自动删除。	

	Session::flash('home', '113344.com');

#助手函数

已去除内置，请自行设置此函数。

	/**
	 * 获取和设置session
	 * @param string	$name  名称
	 * @param mixed		$value 值
	 * @return mixed
	 */
	function session($name = '', $value = '') {
		if ($name == '') {
			return \willphp\session\Session::all();
		}
		if (is_null($name)) {
			return \willphp\session\Session::flush();
		}
		if ('' === $value) {
			return (0 === strpos($name, '?'))? \willphp\session\Session::has(substr($name, 1)) : \willphp\session\Session::get($name);
		}
		if (is_null($value)) {
			return \willphp\session\Session::del($name);
		}
		return \willphp\session\Session::set($name, $value);
	}

####设置

    session('app', 'willphp);

####检测

    $bool= session('?app');

####获取
	
    $session= session('app');

####删除

    session('app', null);

####清空

    session(null);
