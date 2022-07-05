<!DOCTYPE html>
<html>
<head>
	<meta charset="gb18030">
	<title>Reproductor Google Drive</title>
	<meta name="robots" content="noindex">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdn.plyr.io/3.6.2/plyr.js"></script>
	<meta name="referrer" content="no-referrer"/>
	<meta http-equiv="expires" content="0"/>
	<meta name="referrer" content="never"/>
	<meta http-equiv="expires" content="0"/>
	<meta name="referrer" content="never"/>
	<link rel="stylesheet" href="https://cdn.plyr.io/3.6.2/plyr.css" />
	<link rel="stylesheet" href="https://www.bahiajobs.com/css/fonts/gotham-rounded/stylesheet.css" />
	<script src="https://cdn.jsdelivr.net/hls.js/latest/hls.js"></script>
	<script src="./front/js/promise-polyfill.js"></script>
    <script src="./front/js/devtools-detector.js"></script>
	<script src="./front/js/ua-parser.min.js"></script>
	<style type="text/css" media="screen">html,body{padding:0;margin:0;height:100%}#apicodes-player{width:100%!important;height:100%!important;overflow:hidden;background-color:#000}</style>
	<style>
        @font-face {
            font-family: GothamRoundedBold;
            src: url("./font/Gotham-Rounded-Bold.ttf") format("truetype");
        }
        
	    body {
	        font-family: GothamRoundedBold, Helvetica, sans-serif;
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
<video controls crossorigin playsinline data-poster="<?php echo $poster; ?>">
 
</video>
<script type="text/javascript">
<?php
require './src/Packer.php';
$data = array();
if(!empty($subtitles_options) and is_array($subtitles_options)){ foreach($subtitles_options as $key => $value){ if(isset($sub[$key]) and !empty($sub[$key])){
//$data[] = "{ kind: 'captions', label: '".$value."', srclang: '".$value."',src: '".$sub[$key]."'}";
$data[] = "const track = document.createElement('track');
Object.assign(track, {
  label: '".$value."',
  srclang: '".$value."',
  src: '".$sub[$key]."'
});
video.appendChild(track);";
} } }

if(empty($data)) {
$tracks = '{}';	
} else {
$unir_tracks = implode(',', $data);
$tracks = $unir_tracks;	
}
$js = "document.addEventListener('DOMContentLoaded', () => {
  const video = document.querySelector('video');
  const source = '".$ubicacion."';
  const defaultOptions = {};

  if (Hls.isSupported()) {
    const hls = new Hls();
    hls.loadSource(source);
    hls.on(Hls.Events.MANIFEST_PARSED, function (event, data) {

      const availableQualities = hls.levels.map((l) => l.height)
      defaultOptions.quality = {
        default: availableQualities[0],
        options: availableQualities,
        forced: true,        
        onChange: (e) => updateQuality(e),
      }

      // Initialize new Plyr player with quality options
      const player = new Plyr(video, defaultOptions);
		  
	  ".$tracks."
	  
    });
    hls.attachMedia(video);
    window.hls = hls;
  } else {
    // default options with no quality update in case Hls is not supported
    const player = new Plyr(video, defaultOptions);
  }

  function updateQuality(newQuality) {
    window.hls.levels.forEach((level, levelIndex) => {
      if (level.height === newQuality) {
        console.log('Found quality match with ' + newQuality);
        window.hls.currentLevel = levelIndex;
      }
    });
  }
});";
$packer = new Tholu\Packer\Packer($js, 'Normal', true, false, true);
$packed_js = $packer->pack();
echo $js; ?>
</script>
</body>
</html>
