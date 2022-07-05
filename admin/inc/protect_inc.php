<?php 

function obtener_host($url){
	$host = parse_url($url, PHP_URL_HOST);
	return $host;
}
	
function allow_referer($allowed_referer = array(), $allow_referer_null = true, $referer = null){
	if(empty($referer)) @$referer = $_SERVER['HTTP_REFERER'];
	if(empty($referer)) return $allow_referer_null;
	$host_referer = obtener_host($referer);
	if(empty($host_referer)) return false;
	$host_referer = preg_replace('@^www\.@i', '', $host_referer);
	//
	if(empty($allowed_referer) or !is_array($allowed_referer)) return false;
	foreach($allowed_referer as $allowed_referer_i){
		$allowed_referer_i = trim($allowed_referer_i);
		if($allowed_referer_i == '*') return true;
		if($allowed_referer_i == $host_referer) return true;
	}
	return false;
}