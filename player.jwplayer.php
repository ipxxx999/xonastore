<!DOCTYPE html>
<html>
<head>
	<title>Google Drive Proxy Video Player</title>
	<meta name="robots" content="noindex">
	<meta charset="UTF-8">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
	<script type="text/javascript" src="https://ssl.p.jwpcdn.com/player/v/8.8.6/jwplayer.js"></script>
	<script src="front/js/promise-polyfill.js"></script>
    <script src="./front/js/devtools-detector.js"></script>
	<script src="./front/js/ua-parser.min.js"></script>
	<script type="text/javascript">jwplayer.key="64HPbvSQorQcd52B8XFuhMtEoitbvY/EXJmMBfKcXZQU2Rnn";</script>
	<style type="text/css" media="screen">html,body{padding:0;margin:0;height:100%}#apicodes-player{width:100%!important;height:100%!important;overflow:hidden;background-color:#000}</style>

	<script type="text/javascript">
	
var parser = new UAParser();	
var ua = parser.getResult().ua;
!function() {
    ua == '' || (devtoolsDetector.addListener(function(t, e) {
        t && (document.location.href = "./embed.php")
    }), devtoolsDetector.lanuch())
}();
</script>
	
	</head>
<body>
<?php
			$tracks = '';
			if(!empty($subtitles_options) and is_array($subtitles_options)){
				foreach($subtitles_options as $key => $value){
						if(isset($sub[$key]) and !empty($sub[$key])){ 
							$tracks .= '{ 
								file: "'.$sub[$key].'", 
								label: "'.$value.'",
								kind: "captions"
							},';
						}
				}
			}

?>
<div id="apicodes-player"></div>
<script type="text/javascript">
<?php 
require 'src/Packer.php';
$js = "function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}
var title = '".$title."';
var hash = '".$hash."';
var time = '".$timestamp."';
var id = getUrlVars()['id'];
var player = jwplayer('apicodes-player');
	player.setup({
		sources: [{'file':'".$ubicacion."'}],
		cast: {},
		aspectratio: '16:9',
		startparam: 'start',
		primary: 'html5',
		autostart: false,
		preload: 'auto',
		image: '".$poster."',
		advertising: {
			client: 'vast',
			tag: ''
		},
		captions: {
			color: '#f3f368',
			fontSize: 16,
			backgroundOpacity: 0,
			fontfamily: 'Helvetica',
			edgeStyle: 'raised'
		},
		tracks: [".$tracks."]
	});
	player.on('setupError', function() {
		swal('Server Error!', 'Please contact us to fix it asap. Thank you!', 'error');
	});
	player.on('error' , function(){
		swal('Server Error!', 'Please contact us to fix it asap. Thank you!', 'error');
	});";
	
$packer = new Tholu\Packer\Packer($js, 'Normal', true, false, true);
$packed_js = $packer->pack();
echo $packed_js; ?>;
</script>
</body>
</html>