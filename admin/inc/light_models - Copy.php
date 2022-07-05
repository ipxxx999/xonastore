<?php 

function get_connect_db(){
	$link = new meMySQL(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_CHARSET);
	return $link;
}

function get_server_data($id){
	if(!is_numeric($id)) return;
	$medb = get_connect_db();
	$id = $medb->set_security($id);
	$row = $medb->select("SELECT * FROM servers WHERE id = '{$id}' LIMIT 1", true);
	$medb->disconnect();
	if(empty($row)){
		return array();
	}
	return $row;
}

function get_link_data($id){
	if(!is_numeric($id)) return;
	$medb = get_connect_db();
	$id = $medb->set_security($id);
	$row = $medb->select("SELECT * FROM links WHERE id = '{$id}' LIMIT 1", true);
	$medb->disconnect();
	if(empty($row)){
		return array();
	}
	$data = json_decode($row['data'], true);
	if(empty($data)) $data = array();
	$row['data'] = $data;
	return $row;
}

function get_options(){
	$medb = get_connect_db();
	$row = $medb->select("SELECT * FROM options WHERE option_key = 'general' LIMIT 1", true);
	$medb->disconnect();
	if(empty($row)){
		return array();
	}
	$data = json_decode($row['option_value'], true);
	if(empty($data)) return array();
	return $data;
}

function get_links_sin_procesar() {
$medb = get_connect_db();
$row = $medb->select("SELECT * FROM links WHERE status = 0 AND data LIKE '%google.com%' AND error = ''", false);
$medb->disconnect();
if(empty($row)){
return array();
}
return $row;	
}

function actualizar_estado_video($id, $status, $nombre) {
$medb = get_connect_db();
$row = $medb->query("UPDATE links SET status = $status, ubicacion = '$nombre' WHERE id = $id");
$medb->disconnect();
if(empty($row)){
return array();
}
return $row;
	
}

function get_ip() {
	
if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
  $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
} elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

return $ip;
}

function get_link_video($id) {
if(!is_numeric($id)) return;
$medb = get_connect_db();
$id = $medb->set_security($id);
$row = $medb->select("SELECT ubicacion FROM links WHERE id = '{$id}' LIMIT 1", true);
$medb->disconnect();
if(empty($row)){
return array();
}
return $row['ubicacion'];
	
}

function clean_string($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

function getFileExtension($contentType) {
    switch ($contentType) {
        case 'image/gif':
            $ext = '.gif';
            break;
        case 'image/jpeg':
            $ext = '.jpg';
            break;
        case 'image/png':
            $ext = '.png';
            break;
		case 'video/mp4':
			 $ext = '.mp4';
             break;
		case 'video/flv';
		     $ext = '.flv';
             break;
		case 'video/avi';
		     $ext = '.avi';
             break;	 
			
    }
    return $ext;
}

function getFile($service, $id) {
    // $service la creamos arriba, es la nueva
    // instancia de nuestro llamado a google,
    // aquí pasamos el ID
    return $service->files->get($id, array('alt' => 'media'));
}

function get_estado_bot() {
$medb = get_connect_db();	
$row = $medb->select("SELECT * FROM botStatus LIMIT 1", true);	
$medb->disconnect();
if(empty($row)){
return array();
}
return $row;			
}


function get_servers_write() {
$medb = get_connect_db();	
$row = $medb->select("SELECT * FROM servers WHERE tipo_servidor = 'read-write' ORDER BY RAND() LIMIT 1", true);	
$medb->disconnect();
if(empty($row)){
return array();
}
return $row;
}

function send_ftp($conn_id, $src_dir, $dst_dir) {	
$d = dir($src_dir);
    while($file = $d->read()) { // do this for each file in the directory
        if ($file != "." && $file != "..") { // to prevent an infinite loop
            if (is_dir($src_dir."/".$file)) { // do the following if it is a directory
                if (!@ftp_chdir($conn_id, $dst_dir."/".$file)) {
                    ftp_mkdir($conn_id, $dst_dir."/".$file); // create directories that do not yet exist
                }
                send_ftp($conn_id, $src_dir."/".$file, $dst_dir."/".$file); // recursive part
            } else {
                $upload = ftp_put($conn_id, $dst_dir."/".$file, $src_dir."/".$file, FTP_BINARY); // put the files
            }
        }
    }
    $d->close();		
}

function actualizar_error_video($id, $status, $error) {
$medb = get_connect_db();
$row = $medb->query("UPDATE links SET status = $status, error = '$error' WHERE id = $id");
$medb->disconnect();
if(empty($row)){
return array();
}
return $row;
	
}

function actualizar_calidad($id, $calidad) {
if(!is_numeric($id)) return;
$medb = get_connect_db();
$id = $medb->set_security($id);

$row = $medb->select("SELECT calidades FROM links WHERE id = '{$id}' LIMIT 1", true);
$data = json_decode($row['calidades']);

if(empty($data)) {
$data = array();	
}

if (!in_array("360p", $data) && $calidad == '360p') {
    $data[] = '360p';
}

if (!in_array("720p", $data) && $calidad == '720p') {
    $data[] = '720p';
}

if (!in_array("1080p", $data) && $calidad == '1080p') {
    $data[] = '1080p';
}

$calidades = json_encode($data);
$row = $medb->query("UPDATE links SET calidades = '$calidades' WHERE id = $id");
$medb->disconnect();
	
}

function obtener_calidades($id) {
if(!is_numeric($id)) return;
$medb = get_connect_db();
$id = $medb->set_security($id);
$row = $medb->select("SELECT * FROM links WHERE id = '{$id}' LIMIT 1", true);
$status = $row['status'];
$ubicacion = $row['ubicacion'];
$ubicacion = str_replace('/master.m3u8', '', $ubicacion);
$medb->disconnect();
$error = $row['error'];
if(empty($row)){
	return array();
}
if(!empty($error)) {
return $error;	
}

if(empty($status)) {
  return 'En Proceso';	
}

$calidades = json_decode($row['calidades']);

if(empty($calidades)) {
return '';	
}

$unir = implode(',', $calidades);
return $unir;
	
}

function ftp_rrmdir($conn_id, $directory){
  
    $p1080 = ftp_is_dir($conn_id, $directory.'/1080');
	$p720 = ftp_is_dir($conn_id, $directory.'/720');
	$p360 = ftp_is_dir($conn_id, $directory.'/360');
	$master = $directory.'/master.m3u8';

    if($p1080) {
	$lists_1080 = ftp_nlist($conn_id, $directory.'/1080');
	
	foreach($lists_1080 as $list_1080){
	ftp_delete($conn_id, $list_1080);
	}
	ftp_rmdir($conn_id, $directory.'/1080');
    }

    if($p720) {
	$lists_720 = ftp_nlist($conn_id, $directory.'/720');
	
	foreach($lists_720 as $list_720){
	ftp_delete($conn_id, $list_720);
	}
	ftp_rmdir($conn_id, $directory.'/720');
    }
	
	if($p360) {
	$lists_360 = ftp_nlist($conn_id, $directory.'/360');
	
	foreach($lists_360 as $list_360){
	ftp_delete($conn_id, $list_360);
	}
	ftp_rmdir($conn_id, $directory.'/360');
    }
	
	
	ftp_delete($conn_id, $master);
    ftp_rmdir($conn_id, $directory);
}

function ftp_is_dir( $conn_id, $dir ) {
    // get current directory
    $original_directory = ftp_pwd( $conn_id );
    // test if you can change directory to $dir
    // suppress errors in case $dir is not a file or not a directory
    if ( @ftp_chdir( $conn_id, $dir ) ) {
        // If it is a directory, then change the directory back to the original directory
        ftp_chdir( $conn_id, $original_directory );
        return true;
    }
    else {
        return false;
    }       
}

function actualizar_views_video_embed($id) {
if(!is_numeric($id)) return;
$medb = get_connect_db();
$id = $medb->set_security($id);	
$ip = get_ip();
$consulta_registro = $medb->select("SELECT fecha FROM visitas WHERE ip = '{$ip}' AND video = '{$id}' LIMIT 1", true);
$fecha_actual = date('Y-m-d H:i:s');

if(empty($consulta_registro)) {	
$medb->query("UPDATE links SET views = views + 1 WHERE id = $id");	
$medb->query("INSERT INTO visitas(video, ip, fecha) VALUES('$id', '$ip', '$fecha_actual')");
} else {
$fecha_visita = $consulta_registro['fecha'];	
$datetime1 = new DateTime($fecha_visita);
$datetime2 = new DateTime($fecha_actual);
$interval = $datetime1->diff($datetime2);
$interval = $interval->format('%a');
if($interval > 0) {
$medb->query("UPDATE links SET views = views + 1 WHERE id = $id");		
$medb->query("UPDATE visitas SET fecha = '$fecha_actual' WHERE ip = '$ip' AND video = '$id'");	
}


}

$medb->disconnect();
return;
}

function get_data($url)
{
$ch = curl_init();
$timeout = 5;
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
$data = curl_exec($ch);
curl_close($ch);
return $data;
}

function verificar_version_remota() {
$medb = get_connect_db();	
$url = 'https://xonaplay.com/panel/version.php?tipo=consulta';

$row = $medb->select("SELECT version FROM options", true);
$contenido = get_data($url);
$contenido = json_decode($contenido);	
$version = $contenido->version;
$changelog = $contenido->changelog;
$version_local = $row['version'];
return json_encode(array('version' => $version, 'changelog' => $changelog, 'version_local' => $version_local));

}
