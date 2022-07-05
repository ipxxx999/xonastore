<?php 
require(__DIR__ . '/panel_system_include.php');

$options = get_options();

if(empty($options)){
	http_response_code(500);
	exit('ERROR 500.');
}
if(!isset($_SERVER['HTTP_REFERER'])) $_SERVER['HTTP_REFERER'] = null;
if(!allow_referer($options['allowed_referer'], $options['allowed_referer_null'], $_SERVER['HTTP_REFERER'])){
	http_response_code(403);
	exit('ERROR 403.');
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if(empty($id)){
	http_response_code(404);
	exit('ERROR 404.');
}

$data_link = get_link_data($id);

if(empty($data_link)){
	http_response_code(404);
	exit('ERROR 404.');
}

include(__DIR__ . '/view.embed.php');
