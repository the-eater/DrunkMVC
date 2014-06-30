<?php

abstract class DrunkModel {

	protected static $model;

	public static function getModel(){
		return static::$model;
	}

	public static function init($name){
		static::$model = Utils::$db->factory('@{{' . $name . '}}');
	}

}