<?php 

function get_server_info($link){
	$data = array(
		'link' => $link,
		'icono' => null,
		'name' => null,
		'txt' => null
	);
	
	$name = parse_url($link, PHP_URL_HOST);
	$data['icono'] = $name.'.png';
	$data['name'] = $name;

	if(!file_exists(__DIR__ . './static/server/'.$data['icono'])){
		$data['icono'] = 'default.png';
	}
	
	return $data;
}

$first = true;

?>
<html>
   <head>
      <meta charset="UTF-8">
	<meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta http-equiv="cleartype" content="on">
        <meta name="HandheldFriendly" content="True">
        <meta name="MobileOptimized" content="320">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
        <meta name="author" content="Elio Equipo">
        <meta name="apple-itunes-app" content="app-id=">
        <base target="_blank">
        <meta name="description" content="">
        <link href="./static/assets/css-wide.css" type="text/css" rel="stylesheet" media="all">
        <link href="./static/assets/css-tablet.css" type="text/css" rel="stylesheet" media="all">
        <link href="./static/assets/css-mobile320.css" type="text/css" rel="stylesheet" media="all">
        <link href="./static/assets/css-mobile480.css" type="text/css" rel="stylesheet" media="all">
        <script type="text/javascript" src="./static/assets/managed-chat.js"></script>
	<title><?php echo $mvctemplate['title']; ?></title>
	<link rel="icon" type="image/x-icon" href="./static/server/favicon.png">
      <title>Player</title>
      <link href="./static/iframe.css" rel="stylesheet">
      <link href="./static/css.css?family=Roboto+Condensed:300,400,700" rel="stylesheet">
      <meta name="robots" content="noindex,nofollow">
   </head>
<style>
a:link {
  color: green;
  background-color: transparent;
  text-decoration: none;
}
a:visited {
  color: pink;
  background-color: transparent;
  text-decoration: none;
}
a:hover {
  color: red;
  background-color: transparent;
  text-decoration: underline;
}
a:active {
  color: yellow;
  background-color: transparent;
  text-decoration: underline;
}
</style>
   <body class="directAc" style="">
      <div id="DisplayContent">
         <div id="PlayerDisplay">
            <div class="wpw" style="background-image: linear-gradient(rgba(16, 16, 23, 0.71), #000000), url('<?php echo htmlentities($data_link['data']['poster_link']); ?>'); background-size: 100%; background-repeat: no-repeat;"></div>
            <div class="SelectLangDisp">
			<?php 
				if(isset($language_options) and !empty($language_options) and is_array($language_options)){ 
					foreach($language_options as $key => $value){ 
						if(!isset($data_link['data']['embeds'][$key]) or empty($data_link['data']['embeds'][$key])) continue;
			?>
					<li onclick="SelLang(this, '<?php echo $key; ?>');" class="<?php if($first === true){ echo 'SLD_A'; $first = false; } ?>"><img src="./static/lang/<?php echo $key; ?>.png"></li>
			<?php }
			} ?>
            </div>
            <div class="OptionsLangDisp">
               <div class="ODDIV">
				<?php 
				$first = true;
				if(isset($language_options) and !empty($language_options) and is_array($language_options)){ 
					foreach($language_options as $key => $value){ 
						if(!isset($data_link['data']['embeds'][$key]) or empty($data_link['data']['embeds'][$key])) continue;
				?>
                  <div class="OD OD_<?php echo $key; ?> <?php if($first === true){ echo 'REactiv'; $first = false; } ?>">
					<?php foreach($data_link['data']['embeds'][$key] as $link){ 
						$server_info = get_server_info($link); 
					?>
                     <li onclick="go_to_player('<?php echo $server_info['link']; ?>')">
                        <img src="./static/server/<?php echo $server_info['icono']; ?>">
                        <span>ECDLMA THE ALIEN</span>
                        <p><?php echo $value; ?> - <?php echo $server_info['txt']; ?> Ver Filme</p>
                     </li>
					<?php } ?>
                  </div>
				<?php }
			} ?>

</footer><a href="https://t.me/ECDLMATeam?start" target="_blank">Pedir Ayuda</a> <b> 

               </div>
            </div>
         </div>
         <div class="FirstLoad"></div>
         <div class="BotHumano"></div>
         <div class="DisplayVideo"></div>
      </div>
      <script src="./static/iframen.js"></script>

            <script>
                var GOOG_FIXURL_LANG = (navigator.language || '').slice(0,2),GOOG_FIXURL_SITE = location.host;
            </script>
            <script src="./static/server/fixurl.js"></script>
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
   </body>
</html>