<?php
/**
 *	Load third party libs
 */
$thirdParty = glob(__DIR__ . '/../third party/*.php');
foreach($thirdParty as $lib) require_once($lib);

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

$tplEngine = new DrunkTemplate(realpath(__DIR__ . '/../../views/' . $config['theme'] . '/'));

$tplEngine->name = $config['name'];
$tplEngine->description = $config['description'];


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

/**
 * load and execute page
 */
$page = Utils::route();
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