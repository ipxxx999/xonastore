<?php
// include your composer dependencies
require(__DIR__ . './panel_system_include.php');
require_once './vendor/autoload.php';
define("UPLOAD_DIR", __DIR__ . "./videos");	
define("SUBIDAS_MP4", __DIR__ . "./uploads");	

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function convert_to_png($file_path_name, $path_and_filename_new){
		$filename = pathinfo($file_path_name, PATHINFO_BASENAME);
		$filenameNew = pathinfo($path_and_filename_new, PATHINFO_BASENAME);
		if(empty($filename)){
			throw new Exception('File empty.');
			return false;
		}
		if ( !file_exists($file_path_name) ) {
			throw new Exception('File not found.');
			return false;
		}
		
		if ( 'png' != pathinfo($path_and_filename_new, PATHINFO_EXTENSION ) ) {
			throw new Exception('File new exists.');
			return false;
		}
		
		/*
			Modifico la cabecera del archivo
		*/
		$header_and_payload_png = pack('C*', 137,80,78,71,13,10,26,10,0,0,0,13,73,72,68,82,0,0,0,1,0,0,0,1,8,2,0,0,0,144,119,83,222,0,0,0,1,115,82,71,66,0,174,206,28,233,0,0,0,4,103,65,77,65,0,0,177,143,11,252,97,5,0,0,0,9,112,72,89,115,0,0,14,195,0,0,14,195,1,199,111,168,100,0,0,0,12,73,68,65,84,24,87,99,248,255,255,63,0,5,254,2,254,167,53,129,132,0,0,0,0,73,69,78,68,174,66,96,130);
			
		$file = @fopen($file_path_name, "rb+");
		if(!$file){
			throw new Exception('File open failed.');
			return false;
		}
		fwrite($file, $header_and_payload_png);
		fclose($file);
		$new_name_path = str_replace($filename, $filenameNew, $file_path_name);
		if(!(@rename($file_path_name,$new_name_path))){
			throw new Exception('Rename failed.');
			return false;
		}
		if ( !file_exists($new_name_path) ) {
			throw new Exception('new file not found.');
			return false;
		}
		
		return true;
}

function createFile($response, $fullName) {
    // Aquí es mejor usar rutas absolutas
    // primero usamos la función fopen como le
    // colocamos 'w+' en nuestro segundo parámetro,
    // escribir y leer php creará el archivo, ya que no existe
    $outHandle =  fopen(UPLOAD_DIR.'/'.$fullName, "w+");
    // Hacemos el loop por nuestra respuesta,
    // recuerden, 1024 bytes cada vez
    while (!$response->getBody()->eof()) {
        fwrite($outHandle, $response->getBody()->read(1024));
    }
    // Cerramos el proceso
    fclose($outHandle);
}

function timeDiff($firstTime,$lastTime) {
    $firstTime=strtotime($firstTime);
    $lastTime=strtotime($lastTime);
    $timeDiff=$lastTime-$firstTime;
    return $timeDiff;
}

$medb = get_connect_db();

$consulta_registro = $medb->select("SELECT status_run, last_check FROM botStatus WHERE id = '1'", true);
$status_bot = $consulta_registro['status_run'];
$last_check = $consulta_registro['last_check'];

$datetime = date('Y-m-d H:i:s');	
$diff = round((timeDiff($last_check,$datetime)/60)/60);

if($status_bot == 0 || $diff > 2) {
$options = get_options();	
$calidades = $options['calidades'];
$client = new Google\Client();
$client->setApplicationName("Quickstart");
$client->setDeveloperKey($options['api_key_google_drive']);
$service = new Google_Service_Drive($client);
    
$contar_registro = $medb->select("SELECT id FROM botStatus", true);
	
if(empty($contar_registro)) {
$registro_bot = $medb->query("INSERT INTO botStatus(id, status_run, last_check, last_run) VALUES('1', '1', '$datetime', '$datetime')");
} else {
$actualizar_bot = $medb->query("UPDATE botStatus SET status_run = '1', last_check = '$datetime' WHERE id = '1'");
}    
    
	
$links_sin_procesar = get_links_sin_procesar();
$servidor_remoto = get_servers_write();	

if(!empty($servidor_remoto)) {
$ip_ftp = $servidor_remoto['ip_ftp'];
$usuario_ftp = $servidor_remoto['usuario_ftp']; 
$password_ftp = $servidor_remoto['password_ftp']; 
$puerto_ftp = $servidor_remoto['puerto_ftp'];
$ruta_ftp = $servidor_remoto['ruta']; 

if(empty($ruta_ftp)) $ruta_ftp = '/'; 
}


foreach($links_sin_procesar as $videos) {

$id = $videos['id'];
$data = json_decode($videos['data']);
$link = $data->link;

$nombre_link = basename($link);
$ext = pathinfo($nombre_link, PATHINFO_EXTENSION);
$check_enlace = false;	
$enlace = $link;
if(strpos($enlace, 'http') !== FALSE) $check_enlace = true;


$verificar_google_drive = strpos($link, 'google.com');

if($check_enlace && $ext == 'mp4' && $verificar_google_drive === FALSE || $check_enlace && $ext == 'mkv' && $verificar_google_drive === FALSE) {	

$file = SUBIDAS_MP4 . '/' . str_replace(' ', '-', $nombre_link);
copy($enlace, $file);	
	
} elseif($verificar_google_drive !== FALSE) {
preg_match('/file\/d\/(.*?)\/view/', $link, $id_google_drive);
$fileId = $id_google_drive[1];

if(empty($fileId)) {
preg_match('/file\/d\/(.*?)\/preview/', $link, $id_google_drive);
$fileId = $id_google_drive[1];	
}

if(empty($fileId)) {
actualizar_error_video($id, '0', 'Error, Verifique el enlace.');	
$actualizar_bot = $medb->query("UPDATE botStatus SET status_run = '0', last_run = '$datetime' WHERE id = '1'");	
continue;
}

}

try {

		
if($verificar_google_drive !== FALSE) {	
$obtener_file = getFile($service, $fileId);
$ct = $obtener_file->getHeaders()['Content-Type'][0];
$ext = getFileExtension($ct);

$nombre = $medb->set_security(strip_tags(str_replace(' ','-',$videos['title'].$ext)));
$crear = createFile($obtener_file, $nombre);
$ubicacion = UPLOAD_DIR.'/'.$nombre;
} else {
$nombre = basename($link);	
$nombre = str_replace(' ', '-', $nombre);
$ubicacion = SUBIDAS_MP4.'/'.$nombre;	
$fileId = md5(time() . $nombre);
}

if (file_exists($ubicacion)) {	
//Comprimir

$id_file = $fileId;
$dir = UPLOAD_DIR . '/'.$id_file;
$dir_1080 = UPLOAD_DIR . '/'.$id_file.'/1080/';
$dir_720 = UPLOAD_DIR . '/'.$id_file.'/720/';
$dir_360 = UPLOAD_DIR . '/'.$id_file.'/360/';
$dir_480 = UPLOAD_DIR . '/'.$id_file.'/480/';

if ( !file_exists( $dir ) && !is_dir( $dir ) ) mkdir( $dir );     

if (in_array("1080p", $calidades)) {
if ( !file_exists( $dir_1080 ) && !is_dir( $dir_1080 ) ) mkdir( $dir_1080 );  
}

if (in_array("720p", $calidades)) {
if ( !file_exists( $dir_720 ) && !is_dir( $dir_720 ) ) mkdir( $dir_720 ); 
}

if (in_array("360p", $calidades)) {
if ( !file_exists( $dir_360 ) && !is_dir( $dir_360 ) ) mkdir( $dir_360 );
}

if (in_array("480p", $calidades)) {
if ( !file_exists( $dir_480 ) && !is_dir( $dir_480 ) ) mkdir( $dir_480 );
}

$p1080 = "-vf scale=1920:-2 -c:a aac -ar 48000 -b:a 192k -c:v h264 -profile:v main -crf 20 -g 48 -keyint_min 48 -sc_threshold 0 -b:v 5000k -maxrate 5320k -bufsize 7500k -preset ultrafast -hls_time 4 -hls_playlist_type vod -hls_segment_filename ". UPLOAD_DIR ."/".$id_file."/1080/1080p_%03d.png ". UPLOAD_DIR ."/".$id_file."/1080/1080p.m3u8";	
$p720 = "-vf scale=1280:-2 -c:a aac -ar 48000 -b:a 128k -c:v h264 -profile:v main -crf 20 -g 48 -keyint_min 48 -sc_threshold 0 -b:v 2500k -maxrate 2675k -bufsize 3750k -preset ultrafast -hls_time 4 -hls_playlist_type vod -hls_segment_filename ". UPLOAD_DIR ."/".$id_file."/720/720p_%03d.png ". UPLOAD_DIR ."/".$id_file."/720/720p.m3u8";	
$p360 = "-vf scale=640:-2 -c:a aac -ar 48000 -b:a 96k -c:v h264 -profile:v main -crf 20 -g 48 -keyint_min 48 -sc_threshold 0 -b:v 800k -maxrate 856k -bufsize 1200k -preset ultrafast -hls_time 4 -hls_playlist_type vod -hls_segment_filename ". UPLOAD_DIR ."/".$id_file."/360/360p_%03d.png ". UPLOAD_DIR ."/".$id_file."/360/360p.m3u8";
$p480 = "-vf scale=842:-2 -c:a aac -ar 48000 -b:a 128k -c:v h264 -profile:v main -crf 20 -g 48 -keyint_min 48 -sc_threshold 0 -b:v 1400k -maxrate 1498k -bufsize 2100k -preset ultrafast -hls_time 4 -hls_playlist_type vod -hls_segment_filename ". UPLOAD_DIR ."/".$id_file."/480/480p_%03d.png ". UPLOAD_DIR ."/".$id_file."/480/480p.m3u8";


if (in_array("360p", $calidades)) {
	
$salida = shell_exec("/usr/local/bin/ffmpeg -i ".$ubicacion." ".$p360." ");

if ( file_exists( $dir_360 . '360p.m3u8') ) {
$contenido = "#EXTM3U".PHP_EOL;
//$contenido .= "## Writed by RiskLife | Skype : skyzzygg ##".PHP_EOL;
$contenido .= "#EXT-X-STREAM-INF:BANDWIDTH=800000,RESOLUTION=640x360".PHP_EOL;
$contenido .= '360/360p.m3u8'.PHP_EOL;


$files_360 = glob($dir_360 . "*.png");
foreach($files_360 as $file) {
convert_to_png($file, $file);
}


$file = fopen(UPLOAD_DIR . '/'.$id_file . "/master.m3u8", "a");
fwrite($file, $contenido . PHP_EOL);
fclose($file);
actualizar_calidad($id, '360p');

if(!empty($servidor_remoto)) {
$nombre = 'https://'.$ip_ftp.'/'.$id_file.'/master.m3u8';	
actualizar_estado_video($id, '1', $nombre);
} else {
$nombre = 'videos/'.$id_file.'/master.m3u8';
actualizar_estado_video($id, '1', $nombre);
}


}

}

if (in_array("480p", $calidades)) {
	
$salida = shell_exec("/usr/local/bin/ffmpeg -i ".$ubicacion." ".$p480." ");

if ( file_exists( $dir_480 . '480p.m3u8') ) {
$contenido4 = "#EXTM3U".PHP_EOL;
//$contenido4 .= "## Writed by RiskLife | Skype : skyzzygg ##".PHP_EOL;
$contenido4 .= "#EXT-X-STREAM-INF:BANDWIDTH=1400000,RESOLUTION=842x480".PHP_EOL;
$contenido4 .= '480/480p.m3u8'.PHP_EOL;

$files_480 = glob($dir_480 . "*.png");
foreach($files_480 as $file) {
convert_to_png($file, $file);
}


$file = fopen(UPLOAD_DIR . '/'.$id_file . "/master.m3u8", "a");
fwrite($file, $contenido4 . PHP_EOL);
fclose($file);
actualizar_calidad($id, '480p');

if(!empty($servidor_remoto)) {
$nombre = 'https://'.$ip_ftp.'/'.$id_file.'/master.m3u8';	
actualizar_estado_video($id, '1', $nombre);
} else {
$nombre = 'videos/'.$id_file.'/master.m3u8';
actualizar_estado_video($id, '1', $nombre);
}


}

}


//Fin Comprimir

if (in_array("720p", $calidades)) {
	
$salida2 = shell_exec("/usr/local/bin/ffmpeg -i ".$ubicacion." ".$p720." ");

if ( file_exists( $dir_720 . '720p.m3u8')) {
$contenido2 = "#EXTM3U".PHP_EOL;	
$contenido2 .= "#EXT-X-STREAM-INF:BANDWIDTH=2800000,RESOLUTION=1280x720".PHP_EOL;
$contenido2 .= '720/720p.m3u8'.PHP_EOL;

$files_720 = glob($dir_720 . "*.png");
foreach($files_720 as $file) {
convert_to_png($file, $file);
}


$file = fopen(UPLOAD_DIR . '/'.$id_file . "/master.m3u8", "a");
fwrite($file, $contenido2 . PHP_EOL);
fclose($file);
actualizar_calidad($id, '720p');

if(!empty($servidor_remoto)) {
$nombre = 'https://'.$ip_ftp.'/'.$id_file.'/master.m3u8';	
actualizar_estado_video($id, '1', $nombre);
} else {
$nombre = 'videos/'.$id_file.'/master.m3u8';
actualizar_estado_video($id, '1', $nombre);
}

}

}

if (in_array("1080p", $calidades)) {
	
$salida3 = shell_exec("/usr/local/bin/ffmpeg -i ".$ubicacion." ".$p1080." ");

if ( file_exists( $dir_1080 . '1080p.m3u8')) {
$contenido3 = "#EXTM3U".PHP_EOL;	
$contenido3 .= "#EXT-X-STREAM-INF:BANDWIDTH=5000000,RESOLUTION=1920x1080".PHP_EOL;
$contenido3 .= '1080/1080p.m3u8'.PHP_EOL;


$files_1080 = glob($dir_1080 . "*.png");
foreach($files_1080 as $file) {
convert_to_png($file, $file);
}

$file = fopen(UPLOAD_DIR . '/'.$id_file . "/master.m3u8", "a");
fwrite($file, $contenido3 . PHP_EOL);
fclose($file);
actualizar_calidad($id, '1080p');


if(!empty($servidor_remoto)) {
$nombre = 'https://'.$ip_ftp.'/'.$id_file.'/master.m3u8';	
actualizar_estado_video($id, '1', $nombre);
} else {
$nombre = 'videos/'.$id_file.'/master.m3u8';
actualizar_estado_video($id, '1', $nombre);
}

}

}


if(!empty($servidor_remoto)) {
$file = UPLOAD_DIR.'/'.$id_file.'/';
$conn_id = ftp_connect($ip_ftp, $puerto_ftp);
$login_result = ftp_login($conn_id, $usuario_ftp, $password_ftp);
ftp_pasv($conn_id, true);
if (ftp_mkdir($conn_id, $ruta_ftp.$id_file)) {
send_ftp($conn_id, $file, $ruta_ftp.$id_file);
}

$nombre = 'https://'.$ip_ftp.'/'.$id_file.'/master.m3u8';

$dir = UPLOAD_DIR.'/'.$id_file.'/';
exec('rm -rf '.escapeshellarg($dir));	

} else {
$nombre = 'videos/'.$id_file.'/master.m3u8';	
}

actualizar_estado_video($id, '1', $nombre);
unlink($ubicacion);

} else {
actualizar_error_video($id, '0', 'Error, Verifique el enlace.');	
$actualizar_bot = $medb->query("UPDATE botStatus SET status_run = '0', last_run = '$datetime' WHERE id = '1'");	
continue;	
}

} catch (Exception $e) {
	var_dump($e->getMessage());
	$mensaje_error = json_decode($e->getMessage())->error->message;
    actualizar_error_video($id, '0', $mensaje_error);	
}

	
}


shell_exec('chown -R nobody:nobody '. UPLOAD_DIR);
$actualizar_bot = $medb->query("UPDATE botStatus SET status_run = '0', last_run = '$datetime' WHERE id = '1'");
}

?>