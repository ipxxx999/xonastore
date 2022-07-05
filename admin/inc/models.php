<?php 

function save_options($data = array()){
	$medb = get_connect_db();
	$data_json = json_encode($data);
	$data_json = $medb->set_security($data_json);
	$medb->query("UPDATE options SET option_value = '{$data_json}' WHERE option_key = 'general' LIMIT 1", true);
	$medb->disconnect();
}

function get_last_links($page = 1, $search = null){
	if($page < 1){
		$page = 1;
	}
	$medb = get_connect_db();
	$sql_extra = "";
	if(!empty($search)){	
		$search = strip_tags($search);
		$search = $medb->set_security($search);
		$sql_extra = "WHERE links.title LIKE '%{$search}%'";
	}
	$row = $medb->select("SELECT count(id) as total FROM links {$sql_extra}", true);
	
	$per_page = 20;
	$total_rows = 0;
	$total_pages = 1;
	$row_links = array();
	if(isset($row['total']) and !empty($row['total'])){
		$total_rows = intval($row['total']);
		$total_pages = ceil($total_rows / $per_page);
		$offset = ($page-1) * $per_page;
		
		//
		$row_links = $medb->select("SELECT links.*, users.username FROM links LEFT JOIN users ON links.user_id = users.id {$sql_extra} ORDER BY links.id DESC LIMIT {$offset},{$per_page}");
		$medb->disconnect();
	}
	
	$prev = 0;
	$next = 0;
	
	if($page > $total_pages){
		$prev = $total_pages;		
	} elseif($page > 1) {
		$prev = $page - 1;
	}
	
	if($page < $total_pages){
		$next = $page + 1;
	}
	
	return array(
		'current_page' => $page,
		'next_page' => $next,
		'prev_page' => $prev,
		'total_rows' => $total_rows,
		'total_pages' => $total_pages,
		'links' => $row_links,
		'per_page' => $per_page,
		'search' => htmlentities($search),
	);	
}

function get_last_servers($page = 1, $search = null){
	if($page < 1){
		$page = 1;
	}
	$medb = get_connect_db();
	$sql_extra = "";
	$row = $medb->select("SELECT count(id) as total FROM servers {$sql_extra}", true);
	
	$per_page = 50;
	$total_rows = 0;
	$total_pages = 1;
	$row_links = array();
	if(isset($row['total']) and !empty($row['total'])){
		$total_rows = intval($row['total']);
		$total_pages = ceil($total_rows / $per_page);
		$offset = ($page-1) * $per_page;
		
		//
		$row_links = $medb->select("SELECT * FROM servers ORDER BY id DESC LIMIT {$offset},{$per_page}");
		$medb->disconnect();
	}
	
	$prev = 0;
	$next = 0;
	
	if($page > $total_pages){
		$prev = $total_pages;		
	} elseif($page > 1) {
		$prev = $page - 1;
	}
	
	if($page < $total_pages){
		$next = $page + 1;
	}
	
	return array(
		'current_page' => $page,
		'next_page' => $next,
		'prev_page' => $prev,
		'total_rows' => $total_rows,
		'total_pages' => $total_pages,
		'servidores' => $row_links,
		'search' => htmlentities($search),
	);	
}


function add_server($nombre_servidor, $ip_ftp, $usuario_ftp, $password_ftp, $puerto_ftp, $tipo_servidor, $ruta_ftp){
	
	$medb = get_connect_db();
	
	$nombre_servidor = $medb->set_security(strip_tags($nombre_servidor));
	$ip_ftp = $medb->set_security(strip_tags($ip_ftp));
	$usuario_ftp = $medb->set_security(strip_tags($usuario_ftp));
	$password_ftp = $medb->set_security(strip_tags($password_ftp));
	$puerto_ftp = $medb->set_security(strip_tags($puerto_ftp));
	$tipo_servidor = $medb->set_security(strip_tags($tipo_servidor));
	$ruta_ftp = $medb->set_security(strip_tags($ruta_ftp));
	
	$medb->query("INSERT INTO servers (nombre, ip_ftp, usuario_ftp, password_ftp, puerto_ftp, tipo_servidor, ruta) VALUES ('{$nombre_servidor}', '{$ip_ftp}', '{$usuario_ftp}', '{$password_ftp}', '{$puerto_ftp}', '{$tipo_servidor}', '{$ruta_ftp}')");
	$id = $medb->insert_id();
	$medb->disconnect();
	return $id;
}


function add_link($title, $link, $poster, $subtitles){
	global $subtitles_options;
	
	$medb = get_connect_db();
	
	$title = $medb->set_security(strip_tags($title));
	$userid = $medb->set_security(user::$id);
	
	$data = array();
	$data['link'] = strip_tags($link);
	$data['poster_link'] = strip_tags($poster);
	$data['subtitles'] = array();
	
	if(!empty($subtitles) and is_array($subtitles) and !empty($subtitles_options) and is_array($subtitles_options)){
		foreach($subtitles_options as $key => $value){
			if(isset($subtitles[$key]) and !empty($subtitles[$key])){
				$data['subtitles'][$key] = strip_tags($subtitles[$key]);
			}
		}
	}
	
	$data_json = json_encode($data);
	$data_json = $medb->set_security($data_json);
	$medb->query("INSERT INTO links (title, user_id, data, status, views, ubicacion, error, calidades) VALUES ('{$title}', '{$userid}', '{$data_json}', '0', '0', '', '', '')");
	$id = $medb->insert_id();
	$medb->disconnect();
	return $id;
}

function edit_link($id, $title, $link, $poster, $subtitles){
	global $subtitles_options;
	
	$medb = get_connect_db();
	
	$title = $medb->set_security(strip_tags($title));
	$userid = $medb->set_security(user::$id);
	
	$data = array();
	$data['link'] = strip_tags($link);
	$data['poster_link'] = strip_tags($poster);
	$data['subtitles'] = array();
	
	if(!empty($subtitles) and is_array($subtitles) and !empty($subtitles_options) and is_array($subtitles_options)){
		foreach($subtitles_options as $key => $value){
			if(isset($subtitles[$key]) and !empty($subtitles[$key])){
				$data['subtitles'][$key] = strip_tags($subtitles[$key]);
			}
		}
	}
	
	$data_json = json_encode($data);
	$data_json = $medb->set_security($data_json);
	$medb->query("UPDATE links SET title = '{$title}', data='{$data_json}' WHERE id = '{$id}' LIMIT 1");
	$medb->disconnect();
}

function edit_server($id, $nombre_servidor, $ip_ftp, $usuario, $password_ftp, $puerto_ftp, $tipo_servidor, $ruta_ftp){
	global $subtitles_options;
	
	$medb = get_connect_db();
	
	$nombre_servidor = $medb->set_security(strip_tags($nombre_servidor));
	$ip_ftp = $medb->set_security(strip_tags($ip_ftp));
	$usuario_ftp = $medb->set_security(strip_tags($usuario));
	$password_ftp = $medb->set_security(strip_tags($password_ftp));
	$puerto_ftp = $medb->set_security(strip_tags($puerto_ftp));
    $tipo_servidor = $medb->set_security(strip_tags($tipo_servidor));	
    $ruta_ftp = $medb->set_security(strip_tags($ruta_ftp));
	
	$medb->query("UPDATE servers SET nombre = '{$nombre_servidor}', ip_ftp='{$ip_ftp}', usuario_ftp='{$usuario_ftp}', password_ftp='{$password_ftp}', puerto_ftp='{$puerto_ftp}', tipo_servidor='{$tipo_servidor}', ruta='{$ruta_ftp}'  WHERE id = '{$id}' LIMIT 1");
	
	$medb->disconnect();
}


function delete_link($id){
    $data = get_link_data($id);
    if(empty($data)) return;
    if(!user::canEditPost($data['user_id'])) return;
    $medb = get_connect_db();
    $id = $medb->set_security($id);
	$consulta_video = $medb->select("SELECT data, ubicacion FROM links WHERE id = '$id'", true);
	$id_video = json_decode($consulta_video['data']);
	$ubicacion = $consulta_video['ubicacion'];
    $link = $id_video->link;
    $path = $_SERVER['DOCUMENT_ROOT'];
    preg_match('/file\/d\/(.*?)\/view/', $link, $id_google_drive);
    $fileId = $id_google_drive[1];	

    if(empty($fileId)) {
    preg_match('/file\/d\/(.*?)\/preview/', $link, $id_google_drive);
    $fileId = $id_google_drive[1];	
    }
	
	if(empty($fileId)) {
	preg_match('/videos\/(.*?)\/master.m3u8/', $ubicacion, $fileId);
	$fileId = $fileId[1];		
	}
	
	if(empty($fileId)) {
	$medb->query("DELETE FROM links WHERE id = '{$id}' LIMIT 1");	
	return;	
	}
	
    $dir_360_1 = PROXYDOMAIN . '/videos/'.$fileId.'/360/360p.m3u8';
    $contenido1 = file_get_contents($dir_360_1);
	
	if(file_exists( $path.'/videos/'.$fileId.'/' ) || !empty($contenido1)) {
		$borrado = unlink($path.'/videos/'.$fileId.'/');
		$dir = $path.'/videos/'.$fileId.'/';
		if(!$borrado) {
		exec('rm -rf '.escapeshellarg($dir));	
		}
		
	}
	
	if(strpos($ubicacion, 'http') !== FALSE) {	
	$host = parse_url($ubicacion, PHP_URL_HOST);
	$consulta_servidor = $medb->select("SELECT * FROM servers WHERE ip_ftp LIKE '%$host%' LIMIT 1", true);
	
	if(!empty($consulta_servidor)) {
	$ip_ftp = $consulta_servidor['ip_ftp'];
    $usuario_ftp = $consulta_servidor['usuario_ftp']; 
    $password_ftp = $consulta_servidor['password_ftp']; 
    $puerto_ftp = $consulta_servidor['puerto_ftp'];
    $ruta_ftp = $consulta_servidor['ruta'];    

    // Connection
    $conn_id = ftp_connect($ip_ftp, $puerto_ftp);
    $login_result = ftp_login($conn_id, $usuario_ftp, $password_ftp);
    ftp_pasv($conn_id, true);
	ftp_rrmdir($conn_id, $ruta_ftp.$fileId);	
	}
	}
	
	
	
    $medb->query("DELETE FROM links WHERE id = '{$id}' LIMIT 1");
	$medb->disconnect();
}

function delete_server($id){
    $medb = get_connect_db();
    $id = $medb->set_security($id);
    $medb->query("DELETE FROM servers WHERE id = '{$id}' LIMIT 1");
	$medb->disconnect();
}


function verificar_conexion_server($id) {
if(!is_numeric($id)) return;
$medb = get_connect_db();
$id = $medb->set_security($id);
$row = $medb->select("SELECT * FROM servers WHERE id = '{$id}'", true);	
if(empty($row)) {
return;	
}

$ip_ftp = $row['ip_ftp'];
$usuario_ftp = $row['usuario_ftp']; 
$password_ftp = $row['password_ftp']; 
$puerto_ftp = $row['puerto_ftp'];
$ruta_ftp = $row['ruta'];

try {
 $result = checkFtp($ip_ftp, $usuario_ftp, $password_ftp, $puerto_ftp, 10, $ruta_ftp);
} catch(Exception $e) {
 $result = $e->getMessage();
}

if($result) {
   print $result;
} else {
   print $result;
}
	
}

function checkFtp($host, $username, $password, $port = 21, $timeout = 10, $ruta_ftp) {
        $con = ftp_connect($host, $port, $timeout);
        if (false === $con) {
            throw new Exception('No se puede conectar al servidor FTP.');
        }
        $loggedIn = ftp_login($con,  $username,  $password);
		ftp_pasv($con, true);
		
		$file = fopen("test.txt", "a");
        fwrite($file, "Test FTP" . PHP_EOL);
        fclose($file);
		
		if (ftp_put($con, $ruta_ftp.'test.txt', 'test.txt', FTP_ASCII)) {
		unlink('test.txt');	
        echo "Cargado Correctamente";
        } else {
        echo "Hubo un problema al intentar subir un archivo.";
        }		
		
		
        ftp_close($con);
}