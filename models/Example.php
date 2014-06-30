<?php

Class Example extends DrunkModel {
	
	public static $model;
	
}

// Drunk will crash here because the table doesn't exist.
// Example::init('examples');