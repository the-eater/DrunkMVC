<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>DrunkMVC</title>
</head>
<body>
	<h1>Welcome to DrunkMVC</h1>
	<p>
		I like to use this moment to thank you for making this horrible choice. but now, lets get down to bussiness.
	</p>
	<h2>Pages</h2>
	<p>
		Pages are alot like controllers but instead of controlling more urls a page only controls one url, which allows you to write spaghetti code! convenient isn't it?
	</p>
	<p>
		In a page you have access to the following static classes and variables: <kbd>$db</kbd>, <kbd>$tplEngine</kbd>, <kbd>Utils</kbd> and all your models.
	</p>
	<p>
		An example page is
	</p>
	<pre>
	&lt;?php
		$tplEngine->freeBeer = Beer::getFree();
		$tplEngine->render('free-beer');
	</pre>
	<h2>Models</h2>
	<p>
		Models are powered by <a href="https://github.com/ddliu/tinydb">TinyDB</a>, <kbd>$db</kbd> is the main TinyDB class. and Model::$model is a TinyDBModel.		
	</p>
	<p>
		Models are easily set up, see the example code below
	</p>
	<pre>
	&lt;?php
		class Beer extend DrunkModel {
			
			// You're gonna have a bad time if you forget this one
			public static $model;

			public static getFree(){
				// TinyDB is easy-peasy.
				return self::$model->findBy('isFree',1);
			}
		}
		
		// We need this one to define Beer::$model,
		// You may do it anywhere you want.
		// But recommend is at the end of the model file
		Beer::init('beers');
	</pre>
	<h2>Views</h2>
	<p>
		Views are plain HTML/PHP. with an <kbd>$this</kbd> object for the variables. and recursion. <kbd>$this</kbd> is the same object as <kbd>tplEngine</kbd>.
	</p>
	<p>An view is for example</p>
	<pre>
		&lt;!DOCTYPE html>
		&lt;html lang="en">
		&lt;head>
			&lt;meta charset="UTF-8">
			&lt;title>FREE BEER&lt;/title>
		&lt;/head>
		&lt;body>
			amount: &lt;?= count($this->freeBeer);?>

			Beers:
			&lt?php foreach ($this->freeBeer as $value) {
				$this->currBeer = $value;
				$this->render('one-beer');
			} ?>
		&lt;/body>
		&lt;/html>
	</pre>
	<h2>Config</h2>
	<p>The config file is mostly self explainatory and filled with comments.</p>
	<h2>Routes</h2>
	<p>Routing is hip and cool right? well its there!</p>
	<p>Routing is done by an Regex like sort of pattern, an example of a routing pattern is <kbd>/user/[a-z0-9:username]</kbd>. in this pattern we allow the username to be everything alphanumeric and <kbd>$params['username']</kbd> will now be the matched username</p>
	<p>an example routing file is</p>
	<pre>
		&lt;?php
		$routes = array(
			// name of page	
			"page" => array(
				// pattern to page
				"pattern"=>"/page/[0-9:id]"
			),
			// pages may be nested in folders
			"page.d/details" => array(
				"pattern" => "/page/[0-9:id]/details"
			)
		);
	</pre>
	<p>
		/ is a magic route and will always point to the page "index"
	</p>
</body>
</html>