<?php 
include '../header.php';

if(user::isAdmin()){
$id = trim(strip_tags($_POST['id']));

if(!is_numeric($id)) return;
$medb = get_connect_db();


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
	
$dir_360_1 = PROXYDOMAIN . '/videos/'.$fileId.'/360/360p.m3u8';
$contenido1 = file_get_contents($dir_360_1);
	
if(!empty($fileId)) {
if(file_exists( $path.'/videos/'.$fileId.'/' ) || !empty($contenido1)) {
$borrado = unlink($path.'/videos/'.$fileId.'/');
$dir = $path.'/videos/'.$fileId.'/';
if(!$borrado) {
exec('rm -rf '.escapeshellarg($dir));	
}
		
}
}


$actualizar_link = $medb->query("UPDATE links SET status = '0', error = '', ubicacion = '', calidades = '', views = '0' WHERE id = '$id'");
echo $actualizar_link;
}





?>