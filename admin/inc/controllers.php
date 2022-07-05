<?php
	// Zona horaria del servidor
	date_default_timezone_set("America/New_York");
?>
<?php 
function mvc_inicio(){
	global $mvctemplate;
	
	if (!user::isLoggedIn()){
		redirect_to('/?do=login');
		return;
	}
	
	//
	$mvctemplate['title'] = 'Home';
	$mvctemplate['template'] = 'home';
	
	$datos_servidor = verificar_version_remota();
	
	$datos_servidor = json_decode($datos_servidor);
	$version = $datos_servidor->version;
	$changelog = $datos_servidor->changelog;
	$version_local = $datos_servidor->version_local;
	
	$mvctemplate['stack']['version_remota'] = $version;
	$mvctemplate['stack']['version_remota_changelog'] = $changelog;
	$mvctemplate['stack']['version_local'] = $version_local;
	
	
	
	if(isset($_POST['actualizar_script'])) {
		
	$medb = get_connect_db();	
		
	if($version != $version_local) {
    $url_actualizacion = 'version.php?tipo=actualizacion&v='.$version_local;

    $data_actualizacion = get_data($url_actualizacion);
    $data_decode = json_decode($data_actualizacion);
    foreach($data_decode as $recorrido) {
    $version_actualizar = $recorrido->version;
    $archivo = '../versiones/'.$version_actualizar.'.zip';
    $archivo_descargado = get_data($archivo);
	
    $destination = '../update/'.basename($archivo); // NEW FILE LOCATION
    $file = fopen($destination, "w+");
    fputs($file, $archivo_descargado);
    fclose($file);

    $zip = new ZipArchive;
    $res = $zip->open($destination);
    if ($res === TRUE) {
    $zip->extractTo('../'); // 
    $zip->close();
	$medb->query("UPDATE options SET version = '$version_actualizar'");
	
	$datos_servidor = verificar_version_remota();
	$datos_servidor = json_decode($datos_servidor);
	$version = $datos_servidor->version;
	$changelog = $datos_servidor->changelog;
	$version_local = $datos_servidor->version_local;
	
	$mvctemplate['stack']['version_remota'] = $version;
	$mvctemplate['stack']['version_remota_changelog'] = $changelog;
	$mvctemplate['stack']['version_local'] = $version_local;
	
	
    }

    }

     } else {
     echo '<font style="color:green;">Ya tienes la ultima version</font>';

     }	
		
		
		
	}
	
	
}

/*

	LOGIN

*/
	
function mvc_login(){
	global $mvctemplate;
	//
	if (user::isLoggedIn()){
		redirect_to('/?do=dashboard');
		return;
	}
		
	if(isset($_POST) and !empty($_POST)){
		$mvc_login = mvc_login_post();
		if($mvc_login['success'] === true){
			redirect_to('/?do=dashboard');
			return;
		}
		
		$mvctemplate['stack']['msg'] = $mvc_login['msg'];
		
	}
	
	$mvctemplate['title'] = 'Login User';
	$mvctemplate['template'] = 'login';
}
	
function mvc_login_post(){
	
	try {
		$user = auth::loginUser($_POST['username'], $_POST['password']);
		return return_parse(true, $user);
	} catch (Exception $e) {
		return return_parse(false, $e->getMessage());
	}
	
}

/*

	LOGOUT

*/

function mvc_logout(){
	auth::logout();
	redirect_to('/?do=login');
	return;
}

/*

	PROFILE

*/

function mvc_profile(){
	global $mvctemplate;
	//
	if (!user::isLoggedIn()){
		redirect_to('/?do=login');
		return;
	}
		
	if(isset($_POST) and !empty($_POST)){
		$mvc_action = mvc_profile_post();
		$mvctemplate['stack']['color'] = $mvc_action['success'] ? 'success' : 'danger';
		$mvctemplate['stack']['msg'] = $mvc_action['msg'];
	}
	
	$mvctemplate['title'] = 'Profile User';
	$mvctemplate['template'] = 'profile';
}

function mvc_profile_post(){
	
	try {
		if(!isset($_POST['oldpassword']) or !isset($_POST['newpassword']) or !isset($_POST['newpassword2']) ){
			throw new Exception('ERROR: empty oldpassword or newpassword or re-newpassword');
		}
		if($_POST['newpassword'] != $_POST['newpassword2']){
			throw new Exception('ERROR: newpassword not math with re-password');
		}
		user::changePassword($_POST['oldpassword'],$_POST['newpassword']);
		return return_parse(true, 'password changed.');
	} catch (Exception $e) {
		return return_parse(false, $e->getMessage());
	}
	
}


/*

	ACCOUNTS

*/

function mvc_accounts(){
	global $mvctemplate;
	//
	if (!user::isLoggedIn()){
		redirect_to('/?do=login');
		return;
	}
	
	if(!user::isAdmin()){
		error_404();
	}
	
	
	if(isset($_POST) and !empty($_POST) and isset($_POST['action'])){
		$extra = array();
		if($_POST['action'] == 'createUser'){
			$extra['titulo'] = 'New User';
			$mvc_action = mvc_accounts_post_createUser();
			if($mvc_action['success'] === true){
				$extra['botones']['List Accounts'] = url_to_path('/?do=accounts');
			} else {
				$extra['botones']['Back'] = 'javascript:history.back(1)';
			}
		} elseif($_POST['action'] == 'editUser'){
			$extra['titulo'] = 'Edit User';
			$mvc_action = mvc_accounts_post_editUser();
			if($mvc_action['success'] === true){
				$extra['botones']['List Accounts'] = url_to_path('/?do=accounts');
			} else {
				$extra['botones']['Back'] = 'javascript:history.back(1)';
			}
		}
		
		$extra['mensaje'] = $mvc_action['msg'];
		mostrar_aviso($extra);
		return;
	}
	
	if(isset($_GET['sa']) and $_GET['sa'] == 'delete' and !empty($_GET['id'])){
		user::deleteUser($_GET['id']);
		redirect_to('/?do=accounts');
		return;
	}
	
	$mvctemplate['stack']['users'] = user::get_all_users();
	
	$mvctemplate['title'] = 'Accounts';
	$mvctemplate['template'] = 'accounts';
}

function mvc_accounts_post_createUser(){
	try {
		if(!isset($_POST['username']) or !isset($_POST['password']) or !isset($_POST['rol']) ){
			throw new Exception('ERROR: empty username or password or rol');
		}
		user::newUser($_POST['username'],$_POST['password'],$_POST['rol']);
		return return_parse(true, 'New user create success');
	} catch (Exception $e) {
		return return_parse(false, $e->getMessage());
	}
}

function mvc_accounts_post_editUser(){
	try {
		if(!isset($_POST['userid']) or empty($_POST['userid']) ){
			throw new Exception('ERROR: empty userid');
		}
		user::editUser($_POST['userid'], $_POST['password'], $_POST['rol']);
		return return_parse(true, 'User edit success');
	} catch (Exception $e) {
		return return_parse(false, $e->getMessage());
	}
}

/*
	SETTINGS
*/

function mvc_settings(){
	global $mvctemplate;
	//
	if (!user::isLoggedIn()){
		redirect_to('/?do=login');
		return;
	}
	
	if(!user::isAdmin()){
		error_404();
		die();
	}
	
	
	if(isset($_POST) and !empty($_POST) && isset($_POST['edit_settings'])){
		$mvc_action = mvc_settings_post();
		$mvctemplate['stack']['msg'] = $mvc_action['msg'];
	}
	
	if(isset($_POST['reiniciar_bot'])) {
	// Only linux

	$dump_grep = shell_exec("ps aux | grep bot.php | grep -v grep | awk '{print $2}'");
	$pid_array = explode(PHP_EOL, $dump_grep);

	if(!empty($pid_array) and is_array($pid_array)){
		foreach($pid_array as $pid){
			$pid = trim($pid);
			if(empty($pid)) continue;
			shell_exec("kill {$pid}");
		}
	}
	$medb = get_connect_db();
    $actualizar_bot = $medb->query("UPDATE botStatus SET status_run = '0' WHERE id = '1'");

	}
	
	
	$mvctemplate['stack']['players'] = get_allows_players();
	$mvctemplate['stack']['bot']['status_run'] = get_estado_bot()['status_run'];	
	$mvctemplate['stack']['bot']['last_run'] = get_estado_bot()['last_run'];	
	$mvctemplate['stack']['bot']['last_check'] = get_estado_bot()['last_check'];
	
	//Comparar Fecha
    $hour1 = 0; $hour2 = 0;
    $date1 = get_estado_bot()['last_check'];
    $date2 = date('Y-m-d H:i:s');
    $datetimeObj1 = new DateTime($date1);
    $datetimeObj2 = new DateTime($date2);
    $interval = $datetimeObj1->diff($datetimeObj2);
    $hours = $interval->format('%h'); 
    $minutes = $interval->format('%i');
    $tiempo_transcurrido = ($hours * 60) + $minutes;
    $tiempo_transcurrido = $tiempo_transcurrido.' min';
	$mvctemplate['stack']['bot']['tiempo_transcurrido'] = $tiempo_transcurrido;
	
	$mvctemplate['stack']['options'] = array_merge(default_config(), get_options());
	
	$mvctemplate['title'] = 'Settings';
	$mvctemplate['template'] = 'settings';
}

function mvc_quality(){
	global $mvctemplate;
	//
	if (!user::isLoggedIn()){
		redirect_to('/?do=login');
		return;
	}
	
	if(!user::isAdmin()){
		error_404();
		die();
	}
	
	
	if(isset($_POST) and !empty($_POST) && isset($_POST['edit_settings'])){
		$mvc_action = mvc_quality_post();
		$mvctemplate['stack']['msg'] = $mvc_action['msg'];
	}
	
	$mvctemplate['stack']['options'] = array_merge(default_config(), get_options());
	
	$mvctemplate['title'] = 'Quality';
	$mvctemplate['template'] = 'quality';
}

function mvc_quality_post(){
	
	try {		
		$calidades = isset($_POST['calidades']) ? $_POST['calidades'] : '360p';
		$data = array();
		$data['calidades'] = $calidades;	
		$combinar = array_merge(get_options(), $data);
		$data = array_merge(default_config(), $combinar);
		
		save_options($data);
		return return_parse(true, 'edit.');
	} catch (Exception $e) {
		return return_parse(false, $e->getMessage());
	}
	
}

function mvc_settings_post(){
	
	try {
		$player = isset($_POST['player']) ? $_POST['player'] : '';
		$api_key_google_drive = isset($_POST['api_key_google_drive']) ? $_POST['api_key_google_drive'] : '';
		$allow_referer_null = empty($_POST['null_referer']) ? false : true;
		$allow_referer_domain = array_values(array_filter(explode(PHP_EOL, $_POST['domains_allowed_referer'])));
		$calidades = isset($_POST['calidades']) ? $_POST['calidades'] : '';
		if(!in_array($_POST['player'], get_allows_players())){
			throw new Exception('ERROR: player option wrong');
		}
		
		
		$data = array();
		$data['player'] = $_POST['player'];
		$data['allowed_referer'] = $allow_referer_domain;
		$data['allowed_referer_null'] = $allow_referer_null;
		$data['api_key_google_drive'] = $api_key_google_drive;
		$combinar = array_merge(get_options(), $data);
		$data = array_merge(default_config(), $combinar);
		
		save_options($data);
		return return_parse(true, 'edit.');
	} catch (Exception $e) {
		return return_parse(false, $e->getMessage());
	}
	
}

/*

	LINKS

*/

function mvc_links(){
	global $mvctemplate;
	//
	if (!user::isLoggedIn()){
		redirect_to('/?do=login');
		return;
	}
	
	
	if(isset($_GET['sa']) and $_GET['sa'] == 'delete' and !empty($_GET['id'])){
		delete_link($_GET['id']);
		redirect_to('/?do=links');
		return;
	}
	
	
	$page = !(isset($_GET['page']) and is_numeric($_GET['page'])) ? 1 : intval($_GET['page']);
	$search = isset($_GET['search']) ? $_GET['search'] : null;
	$mvctemplate['stack']['data_links'] = get_last_links($page, $search);
	
	$mvctemplate['title'] = 'Manage Links';
	$mvctemplate['template'] = 'links';
}


function mvc_servers() {
	global $mvctemplate;
	//
	if (!user::isLoggedIn()){
		redirect_to('/?do=login');
		return;
	}
	
	if(isset($_GET['sa']) and $_GET['sa'] == 'delete' and !empty($_GET['id'])){
		delete_server($_GET['id']);
		redirect_to('/?do=servers');
		return;
	}
	
	if(isset($_GET['sa']) and $_GET['sa'] == 'verify' and !empty($_GET['id'])){
		
	verificar_conexion_server($_GET['id']);	
		
    }
	
	
	
	$page = !(isset($_GET['page']) and is_numeric($_GET['page'])) ? 1 : intval($_GET['page']);
	$search = isset($_GET['search']) ? $_GET['search'] : null;
	$mvctemplate['stack']['servers'] = get_last_servers($page, $search);
	
	$mvctemplate['title'] = 'Manage Servers';
	$mvctemplate['template'] = 'servers';
	
	
	
	
	
}

function mvc_addlink(){
	global $mvctemplate, $subtitles_options;
	//
	if (!user::isLoggedIn()){
		redirect_to('/?do=login');
		return;
	}
	
	if(isset($_POST) and !empty($_POST)){
		$mvc_action = mvc_addlink_post();
		$extra['titulo'] = 'Add link';
		if($mvc_action['success'] === true){
			$extra['template'] = 'avisoembed';
			$extra['botones']['View Link'] = url_to_path('/?do=editlink&id='.$mvc_action['msg']);
			$extra['botones']['Add New'] = url_to_path('/?do=addlink');
		} else {
			$extra['botones']['Back'] = 'javascript:history.back(1)';
		}
		
		$extra['mensaje'] = $mvc_action['msg'];
		mostrar_aviso($extra);
		return;
	}
	
	$mvctemplate['stack']['subtitles'] = $subtitles_options;
	
	$mvctemplate['title'] = 'Add Link';
	$mvctemplate['template'] = 'addlink';
}

function mvc_uploadvideo(){
	global $mvctemplate, $subtitles_options;
	//
	if (!user::isLoggedIn()){
		redirect_to('/?do=login');
		return;
	}
	
	if(isset($_POST) and !empty($_POST)){
		$mvc_action = mvc_uploadvideo_post();
		$extra['titulo'] = 'Add link';
		if($mvc_action['success'] === true){
			$extra['template'] = 'avisoembed';
			$extra['botones']['View Link'] = url_to_path('/?do=editlink&id='.$mvc_action['msg']);
			$extra['botones']['Add New'] = url_to_path('/?do=uploadvideo');
		} else {
			$extra['botones']['Back'] = 'javascript:history.back(1)';
		}
		
		$extra['mensaje'] = $mvc_action['msg'];
		mostrar_aviso($extra);
		return;
	}
	
	$mvctemplate['stack']['subtitles'] = $subtitles_options;
	
	$mvctemplate['title'] = 'Upload Video';
	$mvctemplate['template'] = 'uploadvideo';
}

function mvc_addservers(){
	global $mvctemplate, $subtitles_options;
	//
	if (!user::isLoggedIn()){
		redirect_to('/?do=login');
		return;
	}
	
	if(isset($_POST) and !empty($_POST)){
		mvc_addservers_post();
		redirect_to('/?do=servers');
		return;
	}
	
	$mvctemplate['title'] = 'Add Server';
	$mvctemplate['template'] = 'addservers';
}

function mvc_addservers_post(){
	
	try {
		if(!isset($_POST['ip_ftp']) or !isset($_POST['usuario_ftp']) or empty($_POST['password_ftp']) or empty($_POST['puerto_ftp'])){
			throw new Exception('ERROR: empty IP or Usuario, Password Or Port.');
		}
		
		
		$nombre_servidor = isset($_POST['nombre_servidor']) ? $_POST['nombre_servidor'] : null;
		$ip_ftp = isset($_POST['ip_ftp']) ? $_POST['ip_ftp'] : null;
		$usuario_ftp = isset($_POST['usuario_ftp']) ? $_POST['usuario_ftp'] : null;
		$password_ftp = isset($_POST['password_ftp']) ? $_POST['password_ftp'] : null;
		$puerto_ftp = isset($_POST['puerto_ftp']) ? $_POST['puerto_ftp'] : null;
		$tipo_servidor = isset($_POST['tipo_servidor']) ? $_POST['tipo_servidor'] : null;
		$ruta_ftp = isset($_POST['ruta']) ? $_POST['ruta'] : null;
		$id = add_server($nombre_servidor, $ip_ftp, $usuario_ftp, $password_ftp, $puerto_ftp, $tipo_servidor, $ruta_ftp);
		return return_parse(true, $id);
	} catch (Exception $e) {
		return return_parse(false, $e->getMessage());
	}
	
}



function mvc_addlink_post(){

	try {
		if(!isset($_POST['title']) or !isset($_POST['link']) or empty($_POST['title']) or empty($_POST['link'])){
			throw new Exception('ERROR: empty title or link');
		}
		$title = isset($_POST['title']) ? $_POST['title'] : null;
		$link = isset($_POST['link']) ? $_POST['link'] : null;
		$posterlink = isset($_POST['posterlink']) ? $_POST['posterlink'] : null;
		$subtitles = isset($_POST['subtitles']) ? $_POST['subtitles'] : null;
		$id = add_link($title, $link, $posterlink, $subtitles);
		return return_parse(true, $id);
	} catch (Exception $e) {
		return return_parse(false, $e->getMessage());
	}
	
}

function mvc_uploadvideo_post(){
	$target_dir = "../uploads/";
	try {
		if(!isset($_POST['title']) && empty($_FILES['archivo_mp4']['name']) or empty($_POST['title']) && empty($_FILES['archivo_mp4']['name'])){
			throw new Exception('ERROR: empty title or video file');
		}
		$title = isset($_POST['title']) ? $_POST['title'] : null;
		
		$file = $target_dir . str_replace(' ', '-', basename($_FILES["archivo_mp4"]["name"]));
		
		if(!empty($file)) {
        if (move_uploaded_file($_FILES["archivo_mp4"]["tmp_name"], $file)) {
        $link = str_replace(' ', '-', basename($_FILES["archivo_mp4"]["name"]));
        }
		}		
		

		
		$posterlink = isset($_POST['posterlink']) ? $_POST['posterlink'] : null;
		$subtitles = isset($_POST['subtitles']) ? $_POST['subtitles'] : null;
		$id = add_link($title, $link, $posterlink, $subtitles);
		return return_parse(true, $id);
	} catch (Exception $e) {
		return return_parse(false, $e->getMessage());
	}
	
}

function mvc_editservers(){
	global $mvctemplate, $subtitles_options;
	//
	if (!user::isLoggedIn()){
		redirect_to('/?do=login');
		return;
	}
	
	$linkid = isset($_GET['id']) ? intval($_GET['id']) : 0;
	
	if(empty($linkid)){
		error_404();
		return;
	}
	
	$data_link = get_server_data($linkid);
	
	if(empty($data_link)){
		error_404();
		return;
	}
	
	if(isset($_POST) and !empty($_POST)){
		$mvc_action = mvc_editserver_post();
		$extra['titulo'] = 'Edit Server';
		if($mvc_action['success'] === true){
			$extra['botones']['View Server'] = url_to_path('/?do=editservers&id='.$linkid);
			$extra['botones']['Add New'] = url_to_path('/?do=addservers');
		} else {
			$extra['botones']['Back'] = 'javascript:history.back(1)';
		}
		
		$extra['mensaje'] = $mvc_action['msg'];
		mostrar_aviso($extra);
		return;
	}
	
	$mvctemplate['stack']['servers'] = $data_link;
	
	$mvctemplate['title'] = 'Edit Server';
	$mvctemplate['template'] = 'editserver';
}

function mvc_editlink(){
	global $mvctemplate, $subtitles_options;
	//
	if (!user::isLoggedIn()){
		redirect_to('/?do=login');
		return;
	}
	
	$linkid = isset($_GET['id']) ? intval($_GET['id']) : 0;
	
	if(empty($linkid)){
		error_404();
		return;
	}
	
	$data_link = get_link_data($linkid);
	
	if(empty($data_link)){
		error_404();
		return;
	}
	
	if(isset($_POST) and !empty($_POST) and user::canEditPost($data_link['user_id'])){
		$mvc_action = mvc_editlink_post();
		$extra['titulo'] = 'Edit link';
		if($mvc_action['success'] === true){
			$extra['botones']['View Link'] = url_to_path('/?do=editlink&id='.$linkid);
			$extra['botones']['Add New'] = url_to_path('/?do=addlink');
		} else {
			$extra['botones']['Back'] = 'javascript:history.back(1)';
		}
		
		$extra['mensaje'] = $mvc_action['msg'];
		mostrar_aviso($extra);
		return;
	}
	
	$mvctemplate['stack']['data_links'] = $data_link;
	$mvctemplate['stack']['subtitles'] = $subtitles_options;
	
	$mvctemplate['title'] = 'Edit Link';
	$mvctemplate['template'] = 'editlink';
}

function mvc_editlink_post(){
	
	try {
		$linkid = isset($_GET['id']) ? intval($_GET['id']) : 0;
		if(empty($linkid) or !isset($_POST['title']) or !isset($_POST['link']) or empty($_POST['title']) or empty($_POST['link'])){
			throw new Exception('ERROR: empty title or link');
		}
		$title = isset($_POST['title']) ? $_POST['title'] : null;
		$link = isset($_POST['link']) ? $_POST['link'] : null;
		$posterlink = isset($_POST['posterlink']) ? $_POST['posterlink'] : null;
		$subtitles = isset($_POST['subtitles']) ? $_POST['subtitles'] : null;
		edit_link($linkid, $title, $link, $posterlink, $subtitles);
		return return_parse(true, 'Edit success');
	} catch (Exception $e) {
		return return_parse(false, $e->getMessage());
	}
	
}

function mvc_editserver_post(){
	
	try {
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		if(empty($id) or !isset($_POST['nombre_servidor']) or !isset($_POST['ip_ftp']) or empty($_POST['usuario_ftp']) or empty($_POST['password_ftp']) or empty($_POST['puerto_ftp'])){
			throw new Exception('ERROR: Debes configurar todos los datos necesarios');
		}
		$nombre_servidor = isset($_POST['nombre_servidor']) ? $_POST['nombre_servidor'] : null;
		$ip_ftp = isset($_POST['ip_ftp']) ? $_POST['ip_ftp'] : null;
		$usuario = isset($_POST['usuario_ftp']) ? $_POST['usuario_ftp'] : null;
		$password_ftp = isset($_POST['password_ftp']) ? $_POST['password_ftp'] : null;
		$puerto_ftp = isset($_POST['puerto_ftp']) ? $_POST['puerto_ftp'] : null;
		$tipo_servidor = isset($_POST['tipo_servidor']) ? $_POST['tipo_servidor'] : null;
		$ruta_ftp = isset($_POST['ruta']) ? $_POST['ruta'] : null;
		edit_server($id, $nombre_servidor, $ip_ftp, $usuario, $password_ftp, $puerto_ftp, $tipo_servidor, $ruta_ftp);
		return return_parse(true, 'Edit success');
	} catch (Exception $e) {
		return return_parse(false, $e->getMessage());
	}
	
}

/*
	
	OTHERS

*/

function default_config(){
	$data = array();
	$data['player'] = 'plyr';
	$data['allowed_referer'] = array();
	$data['allowed_referer_null'] = true;	
	return $data;
}

function get_allows_players(){
	return ['plyr','jwplayer', 'videojs'];
}

function return_parse($error, $msg){
	return array('success' => $error, 'msg' => $msg);
}

function redirect_to($path){
	global $mvctemplate;
	$url = $mvctemplate['url'].$path;
	header("Location: ".$url);
	die();
}

function error_404(){
	global $mvctemplate;
	//
	$mvctemplate['title'] = 'Error 404';
	$mvctemplate['template'] = 'error404';
}
	
function mvc_static($title, $tpl){
	global $mvctemplate;
	//
	$mvctemplate['title'] = $title;
	$mvctemplate['template'] = $tpl;
}

function translate_rol($rol){
	if($rol == 1) return 'Admin';
	elseif($rol == 2) return 'Editor';
	elseif($rol == 3) return 'Author';
	elseif($rol == 4) return 'Collaborator';
	return $rol;
}


function url_to_path($path){
	global $mvctemplate;
	return $mvctemplate['url'].$path;
}
	
function mostrar_aviso($extra){
	global $mvctemplate;
	//
	$mvctemplate['title'] = 'Notice';
	$mvctemplate['template'] = 'alert';
	$mvctemplate['extra'] = $extra;
	
	if(isset($extra['template'])) $mvctemplate['template'] = $extra['template'];
	/*
	$mvctemplate['extra']['titulo'] = 'Error';
	$mvctemplate['extra']['mensaje'] = 'Falta completar el campo obligatorio: '.$nombre_campo;
	$mvctemplate['extra']['botones']['Volver atras'] = 'javascript:history.back(1)';
	*/
}


function get_embed_code($id){
	return '<iframe width="100%" height="100%" src="'.get_link_embed($id).'" frameborder="0" allowfullscreen="true"></iframe>';	
}

function get_link_embed($id){
	global $mvctemplate;
	return $mvctemplate['url_embed'].$id;
}