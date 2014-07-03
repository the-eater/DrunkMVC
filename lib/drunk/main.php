
<?php
/**
 *	Load third party libs
 */
$thirdParty = array_merge(glob(__DIR__ . '/../third party/*.php'), glob(__DIR__ . '/../../ext/*.php'));
foreach($thirdParty as $lib) require_once($lib);
unset($thirdParty);

require __DIR__ . '/tpl.php';
require __DIR__ . '/utils.php';
require __DIR__ . '/model.php';

/**
 * Load utils
 */
Utils::$config = $config;

/**
 * Routes
 */
Utils::$routes = $routes;
/**
 * 
 */
$tplEngine = new DrunkTemplate(realpath(__DIR__ . '/../../views/' . $config['theme'] . '/'));

$tplEngine->cfgVars = $config['tplVars'];


/**
 * Init DB connectiong
 */
$db = new TinyDB($config['db']['dsn'], $config['db']['user'], $config['db']['pass'],array(
	'prefix'=>$config['db']['prefix']
));

Utils::$db = $db;

/**
 * Load models
 */
$models = glob(__DIR__ . '/../../models/*.php');
foreach($models as $model) require_once($model);
unset($models);

/**
 * load and execute page
 */
$page = Utils::route();

if(file_exists(__DIR__ . '/../../boot.php')){
	require __DIR__ . '/../../boot.php';
}
$pagePath = __DIR__ . '/../../pages/' . $page['page'] . '.php';

if(file_exists($pagePath)){
	require $pagePath;
}else{
	/**
	 * Render 404 template when cant find the page
	 */
	header('Status: 404 Not Found');
	$tplEngine->error = "Can't find page";
	$tplEngine->render('404');
}