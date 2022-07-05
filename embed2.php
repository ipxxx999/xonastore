<?php 
require(__DIR__ . './panel_system_include.php');
require(__DIR__ . './src/autoload.php');

$options = get_options();

if(empty($options)){
	http_response_code(500);
	exit('Debes Configurar las Opciones en el Panel');
}

if(!allow_referer($options['allowed_referer'], $options['allowed_referer_null'], @$_SERVER['HTTP_REFERER'])){
	http_response_code(403);
	exit('ERROR 403.');
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if(empty($id)){
http_response_code(404);
define( 'HEADERINCLUDE', true );
$titulo_process = 'VIDEO NO DISPONIBLE';
$mensaje_process = 'El video no se encuentra disponible, intentelo mas tarde.';
require('./admin/views/process.php');
exit();
}

$data_link = get_link_data($id);
@$estado = $data_link['status'];
$ubicacion = $data_link['ubicacion'];

if(empty($data_link)){
http_response_code(404);
define( 'HEADERINCLUDE', true );
$titulo_process = 'VIDEO NO DISPONIBLE';
$mensaje_process = 'El video no se encuentra disponible, intentelo mas tarde.';
require('./admin/views/process.php');
exit();
}

$link = (isset($data_link['data']['link'])) ? $data_link['data']['link'] : '';
$sub = (isset($data_link['data']['subtitles'])) ? $data_link['data']['subtitles'] : '';
$poster = (isset($data_link['data']['poster_link'])) ? $data_link['data']['poster_link'] : '';

//

if($estado == 0) {
define( 'HEADERINCLUDE', true );
$titulo_process = 'Procesando Video';
$mensaje_process = 'El video se está procesando, inténtalo tarde.';
require('./admin/views/process.php');
exit();
}

if(empty($link)){
http_response_code(404);
define( 'HEADERINCLUDE', true );
$titulo_process = 'VIDEO NO DISPONIBLE';
$mensaje_process = 'El video no se encuentra disponible, intentelo mas tarde.';
require('./admin/views/process.php');
exit();
}



/*
$memcache_driver = new Memcached();
$memcache_driver->addServer('localhost', 11211);

$mp4Link = $memcache_driver->get($id);
*/

$mp4Link = '';
if(empty($mp4Link)){
    echo '<!-- NO CACHE -->';
	$pos = strpos($link, 'google.com');
    if($pos !== FALSE) {
	$nombre_video = $data_link['nombre_video'];
	$mp4Link = $nombre_video;	
	}
    //$mp4Link = get_link_mp4_mediafire($link);
    if(!empty($mp4Link)){
        $ttl = 60*10; // 10 minutos
        //$memcache_driver->set($id, $mp4Link, $ttl);
    }
}

$sources_decode = array(
  array(
    'file' => $mp4Link,
    'label' => 'HD',
    'type' => 'video/mp4'
  ),  
);

$sources = json_encode($sources_decode);

$ip = get_ip();
$salt = 'design by risklife';
$title = clean_string($data_link['title']);
$timestamp = time() + 3600; // one hour valid
$hash = md5($salt . $ip . $timestamp . $title);

preg_match('/file\/d\/(.*?)\/view/', $link, $id_google_drive);
$fileId = $id_google_drive[1];

if(empty($fileId)) {
preg_match('/file\/d\/(.*?)\/preview/', $link, $id_google_drive);
$fileId = $id_google_drive[1];	
}

actualizar_views_video_embed($id);

if($options['player'] == 'plyr'){
	include(__DIR__ . '/player.plyr.php');
} elseif($options['player'] == 'jwplayer'){
	include(__DIR__ . '/player.jwplayer.php');
} elseif($options['player'] == 'videojs') {
	include(__DIR__ . '/player.videojs.php');	
} else {
	include(__DIR__ . '/player.plyr.php');
}
