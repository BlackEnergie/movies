<?php
class dispatcher{
	public static function dispatch($unMenuP){
	    $unMenuP = str_replace(' ', '',$unMenuP);
		$unMenuP = "controller" . ucfirst($unMenuP) ;
		$unMenuP .= ".php";
		$unMenuP = "controllers/" . $unMenuP;
		return $unMenuP ;
	}
}
