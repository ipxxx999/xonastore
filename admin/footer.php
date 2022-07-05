<?php 
	if (!defined('HEADERINCLUDE')) { exit(); }

	//-> VARIABLES FIJAS TEMPLATE
	$mvctemplate['url_public_folder'] = $mvctemplate['url'].'/static';
	
	// ERROR 404
	if(!file_exists(ABSVIEWS . '/' . $mvctemplate['template'] . '.php')) { 
		error_404();
	}
	
	//-> MOSTRAR VISTA
	require(ABSVIEWS . '/' . $mvctemplate['template'] . '.php');