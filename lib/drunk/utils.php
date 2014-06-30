<?php
Class Utils {
	
	public static $config;

	public static $routes;

	public static $db;

	public static function route(){
		$path = self::$config['path'] == "path"?$_SERVER['PATH_INFO']:$_GET['path'];
		if($path == '/' || $path == ''){
			return array(
				"page"=>"index",
				"params"=>array( 'path' => '/' )
			);
		}
		foreach (self::$routes as $key => $value) {
			if($match = self::tryRoute($value['pattern'], $path)){
				return array(
					"params"=>$match,
					"page"=>$key
				);
			}
		}
	}

	public static function tryRoute($route, $path){
		$params = array("path");
		$reg = str_replace('/','\/',preg_replace_callback('~\[([a-z0-9\.\-_\+]+)\:([a-z0-9\_]+)\]~', function($matches) use(&$params) {
			$params[] = $matches[2];
			return '([' . $matches[1] . ']+)';
		}, $route));
	    if(preg_match('~^' . $reg . '\/?$~',$path, $matches)){
			return array_combine($params, $matches);
	    }
		else{
			return false;
		}

	}

	public static function buildRoute($route, $params){
		return preg_replace_callback('~\[([a-z0-9\.\-_\+]+)\:([a-z0-9\_]+)\]~', function($matches) use(&$params) {
			if(isset($params[$matches[2]])){
				return $params[$matches[2]];
			}else{
				return 'null';
			}
		}, $route);
	}

	public static function build($params){
		$url = self::$config['baseUrl'];
		$path = self::buildRoute(self::$routes[$params['page']]['pattern'], $params['params']);
		if(self::$config['path'] == 'get'){
			$get = isset($params['get'])?$params['get']:array();
			$get['path'] = $path;
			$url .= 'index.php?' . http_build_query($get);
		}else{
			if(self::$config['path'] == 'path') $url .= "index.php/";
			$url .= $path;
			if(isset($params['get'])){
				$url .= '?' . http_build_query($params['get']);
			}
		}
		return $url;
	}

}