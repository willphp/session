# Session组件
Session组件通过加密cookie数据提高网站安全性

#开始使用

####安装组件
使用 composer 命令进行安装或下载源代码使用(依赖willphp/config组件)。

    composer require willphp/session

> WillPHP 框架已经内置此组件，无需再安装。

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
			'path' => WIPHP_URI.'/runtime/session', //文件类session保存路径
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

#cookie函数

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



