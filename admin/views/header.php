<?php if (!defined('HEADERINCLUDE')) { exit(); } ?>
<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
	<!--Meta-->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<title><?php echo $mvctemplate['title']; ?></title>
	
	<link rel="icon" type="image/x-icon" href="<?php echo $mvctemplate['url_public_folder']; ?>/img/favicon.png">
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $mvctemplate['url_public_folder']; ?>/css/plugin/icon-sets.css">
	<link rel="stylesheet" href="<?php echo $mvctemplate['url_public_folder']; ?>/css/main.min.css">
	<!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700">-->
	<link rel="stylesheet" href="./css/css2.css?family=Source+Sans+Pro:300,400,600,700">
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="<?php echo $mvctemplate['url_public_folder']; ?>/js/theme.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	
</head>


<style>
.dropdown-menu {
width: 100%;	
}
.nav .open>a, .nav .open>a:focus, .nav .open>a:hover {
background-color: transparent !important;	
}

.dropdown-menu li {
margin: 10px;;	
}

</style>

<body>
	<div id="wrapper">
		<div class="sidebar">
			<div class="brand">
				<a href="<?php echo $mvctemplate['url']; ?>/">
					<img src="<?php echo $mvctemplate['url_public_folder']; ?>./img/logo.png" alt="" class="img-responsive logo" height="190px"></img>
				</a>
			</div>
			<div class="sidebar-scroll">
				<nav>
				
				
				
				
					<ul class="nav">
						<li><a href="<?php echo $mvctemplate['url']; ?>/?do=dashboard" class=" menu_link"><i class="fa fa-tachometer"></i><span >Dashboard</span></a>	</li>
						<li><a href="<?php echo $mvctemplate['url']; ?>/?do=addlink" class=" menu_link"><i class="fa fa-link"></i><span >Add Link</span></a></li>
						<li><a href="<?php echo $mvctemplate['url']; ?>/?do=uploadvideo" class=" menu_link"><i class="fa fa-video-camera"></i><span >Upload Video</span></a></li>
						<li><a href="<?php echo $mvctemplate['url']; ?>/?do=links" class=" menu_link"><i class="fa fa-bars"></i><span >Manage Links</span></a></li>
						<?php if(user::isAdmin()) : ?><li><a href="<?php echo $mvctemplate['url']; ?>/?do=accounts" class=" menu_link"><i class="fa fa-users"></i><span >Manage Users</span></a></li><?php endif; ?>
						<?php if(user::isAdmin()) : ?><li><a href="<?php echo $mvctemplate['url']; ?>/?do=servers" class=" menu_link"><i class="fa fa-server"></i><span >Manage Servers</span></a></li><?php endif; ?>
						
						<?php if(user::isAdmin()) : ?>
						
					
							
			<li class="dropdown">
                <a href="#" class="dropdown-toggle menu_link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-sliders"></i><span> Settings <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo $mvctemplate['url']; ?>/?do=settings"><i class="fa fa-wrench"></i><span > General Settings</a></li>
                  <li><a href="<?php echo $mvctemplate['url']; ?>/?do=quality"><i class="fa fa-film"></i><span > Quality</a></li>
                </ul>
              </li>
						

						
						<?php endif; ?>
				
					
					
					
					
					
					
					
				</nav>
			</div>
		</div>
		<div class="main">
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-btn">
						<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i>
						</button>
					</div>
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-menu"><i class="sr-only">Toggle Navigation</i><i class="fa fa-bars icon-nav"></i>
						</button>
					</div>
					<div id="navbar-menu" class="navbar-collapse collapse">
						<ul class="nav navbar-nav navbar-right">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<img src="<?php echo $mvctemplate['url_public_folder']; ?>/img/profile.png" alt="Avatar" class="img-circle"></img><span> <?php echo htmlentities(user::$username); ?> </span><i class="icon-submenu lnr lnr-chevron-down"></i>
								</a>
								<ul class="dropdown-menu">
									<li><a href="<?php echo $mvctemplate['url']; ?>/?do=profile"><i class="lnr lnr-cog"></i><span >Edit Profile</span></a></li>
									<li><a href="<?php echo $mvctemplate['url']; ?>/?do=logout"><i class="lnr lnr-exit"></i><span >Logout</span></a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</nav>
			<div class="main-content">