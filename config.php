<?php

/**
 * Why $config an array in a PHP file? well if it was an INI it would be alot harder to do vhosts on the same code!
 */

$config = array();

$config['theme'] = "default";

$config['db'] = array(
	"dsn"=>"mysql:host=localhost;dbname=drunk",
	"user"=>"root",
	"pass"=>"",
	"prefix"=>"drunk_"
);

/**
 * Options: rewrite, path, get
 * Rewrite: /go/home (you need a rewrite to ?path=/user/l33t)
 * Path: index.php/go/home
 * Get: index.php?path=/go/home
 */
$config['path'] = "get";
$config['baseUrl'] = '/';