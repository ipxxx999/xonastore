<!DOCTYPE html>
<html>
<head>
	<meta charset="gb18030">
	<title>Reproductor Google Drive</title>
	<meta name="robots" content="noindex">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>	
	<meta name="referrer" content="no-referrer"/>
	<meta http-equiv="expires" content="0"/>
	<meta name="referrer" content="never"/>
	<meta http-equiv="expires" content="0"/>
	<meta name="referrer" content="never"/>
    
	<link href="https://vjs.zencdn.net/7.10.2/video-js.css" rel="stylesheet" />
	<link rel="stylesheet" href="https://www.bahiajobs.com/css/fonts/gotham-rounded/stylesheet.css" />
	
	<script src="front/js/promise-polyfill.js"></script>
    <script src="./front/js/devtools-detector.js"></script>
	<script src="./front/js/ua-parser.min.js"></script>
	
	<style type="text/css" media="screen">html,body{padding:0;margin:0;height:100%}#apicodes-player{width:100%!important;height:100%!important;overflow:hidden;background-color:#000}</style>
	<style>
        @font-face {
            font-family: GothamRoundedBold;
            src: url("font/Gotham-Rounded-Bold.ttf") format("truetype");
        }
        
	    body {
	        font-family: GothamRoundedBold, Helvetica, sans-serif;
	    }
		.vjs-default-skin .vjs-big-play-button {
  margin-left: -@big-play-width/2;
  margin-top: -@big-play-height/2;
  left: 50%;
  top: 50%;
}
		.vjs-icon-hd:before {
font-size: 20px;
position:absolute;
margin-left: 10px;
top: 5px;
		}
	</style>

<script type="text/javascript">
var parser = new UAParser();	
var ua = parser.getResult().ua;
!function() {
    ua == '' || (devtoolsDetector.addListener(function(t, e) {
        t && (document.location.href = "/embed.php")
    }), devtoolsDetector.lanuch())
}();
</script>		
		
</head>
<body>
<video id="apicodes-player" class="video-js vjs-default-skin" width="640px" height="267px" controls preload="none" poster='<?php echo $poster; ?>' data-setup='{ "aspectRatio":"640:267", "playbackRates": [1, 1.5, 2] }'>
<?php if(!empty($subtitles_options) and is_array($subtitles_options)){
	foreach($subtitles_options as $key => $value){
		if(isset($sub[$key]) and !empty($sub[$key])){ echo '<track kind="captions" label="'.$value.'" src="'.$sub[$key].'" srclang="'.$value.'" />'; }
	}
} ?>	
</video>
<script src="https://vjs.zencdn.net/7.10.2/video.min.js"></script>	
<script src="./front/js/videojs-hlsjs-plugin.js"></script>	
<script src="./front/js/vjs-quality-picker.js"></script>	
<script src="./front/js/hls.min.js"></script>	
<script>
<?php
require './src/Packer.php';
$js = " (function ($) {
        $(document).ready(function () {

            // An example of playing with the Video.js javascript API
            // Will start the video and then switch the source 3 seconds latter
            // You can look at the doc there: http://docs.videojs.com/docs/guides/api.html
            videojs('apicodes-player').ready(function () {
                var myPlayer = this;
                myPlayer.qualityPickerPlugin();
                myPlayer.src({type: 'application/x-mpegURL', src: '".$ubicacion."'});

                $('#change').on('click', function () {
                  var new_url = $('#myInput').val();
                    myPlayer.src({type: 'application/x-mpegURL', src: new_url});
                });
            });

        });
    })(jQuery);";
$packer = new Tholu\Packer\Packer($js, 'Normal', true, false, true);
$packed_js = $packer->pack();
echo $packed_js; ?>;
</script>

</body>
</html>
