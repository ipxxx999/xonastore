<?php 

require(__DIR__ . '/header.php');

$do = (isset($_GET['do']) and !empty($_GET['do'])) ? htmlentities($_GET['do']) : NULL;

	if(empty($do)) mvc_inicio();
	elseif($do == 'dashboard') mvc_inicio();
	elseif($do == 'login') mvc_login();
	elseif($do == 'logout') mvc_logout();
	elseif($do == 'profile') mvc_profile();
	elseif($do == 'accounts') mvc_accounts();
	elseif($do == 'settings') mvc_settings();
	elseif($do == 'quality') mvc_quality();
	elseif($do == 'links') mvc_links();
	elseif($do == 'addlink') mvc_addlink();
	elseif($do == 'uploadvideo') mvc_uploadvideo();
	elseif($do == 'addservers') mvc_addservers();
	elseif($do == 'editlink') mvc_editlink();
	elseif($do == 'servers') mvc_servers();
	elseif($do == 'editservers') mvc_editservers();
	else {
		error_404();
	}

require(__DIR__ . '/footer.php');