<?php
if (!function_exists('session')) {
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
}