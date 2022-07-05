<!DOCTYPE html>
<html lang="en">
<head>
	<!--Meta-->
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--Title-->
	<title>Xonaplay - Video</title>
	<!--CSS-->
	<link rel="stylesheet" href="front/css/main-blue.css" id="color-switcher">
	<link rel="stylesheet" href="front/css/font-awesome.min.css">
	<link rel="stylesheet" href="front/css/jquery.mCustomScrollbar.min.css">
	<!--Fonts-->
	<!--<link href="https://fonts.googleapis.com/css?family=Montserrat|Open+Sans|Raleway|Righteous" rel="stylesheet">-->
	<link href="./front/css/css.css?family=Montserrat|Open+Sans|Raleway|Righteous" rel="stylesheet">

</head>
<body style="overflow:hidden;">
	<!--Hero-->
	<div class="hero" id="particles-js">
		<div class="centered">
			<img class="logo" src="./front/images/logo.png" alt="PULSE">
			<h1 class="title">X-Toria</h1>
			<h2 class="heading"><?php echo $titulo_process; ?></h2>
			<div class="countdown" id="countdown"></div>
			<p class="description"><?php echo $mensaje_process; ?></p>
			
		</div>
		
	</div>

	<!--Overlay-->
	<div class="overlay" id="overlay"></div>

	

	<!--Scripts-->
	<script src="front/js/jquery-3.1.1.min.js"></script>
	<script src="front/js/jquery.ajaxchimp.min.js"></script>
	<script src="front/js/jquery.countdown.min.js"></script>
	<script src="front/js/jquery.mCustomScrollbar.min.js"></script>
	<script src="front/js/config.js"></script>
	<script src="front/js/particles.min.js"></script>
	<script src="front/js/main.js"></script>
</body>
</html>