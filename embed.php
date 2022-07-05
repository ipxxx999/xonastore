<?php
?>
<script language="Javascript">  clabHack=0;
document.oncontextmenu = function(){return false} 
 function right(e) {if (navigator.appName == 'Netscape'){
 if (e.which == 3 || e.which == 2){alert("Aqui no puedes utilizar el botón derecho del mouse...");
 for(i=0;i!=clabHack;i++)alert("Ya te lo habia advertido, ahora te penalizaré con \n                 "+(clabHack-i)+"\n              clicks !!!...");
 clabHack+=2;
 alert("La proxima vez que lo hagas será peor !!! - Estas Advertido");  return false;}}
 if (navigator.appName == 'Microsoft Internet Explorer'){
 if (event.button == 2 || event.button == 3){
 alert("Aqui no puedes utilizar el botón derecho del mouse...");
 for(i=0;i!=clabHack;i++)alert("Ya te lo habia advertido, ahora te penalizaré con \n                 "+(clabHack-i)+"\n              clicks !!!...");
 clabHack+=2;
 alert("La proxima vez que lo hagas será peor !!! - Estas Advertido");
 return false;}}  return true;}  document.onmousedown = right;
 if (document.layers) window.captureEvents(Event.MOUSEDOWN);
 window.onmousedown=right; </script>

<script>
    // disable right click
    document.addEventListener('contextmenu', event => event.preventDefault());
 
    document.onkeydown = function (e) {
 
        // disable F12 key
        if(e.keyCode == 123) {
            return false;
        }
 
        // disable I key
        if(e.ctrlKey && e.shiftKey && e.keyCode == 73){
            return false;
        }
 
        // disable J key
        if(e.ctrlKey && e.shiftKey && e.keyCode == 74) {
            return false;
        }
 
        // disable U key
        if(e.ctrlKey && e.keyCode == 85) {
            return false;
        }
    }
 
</script>

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

