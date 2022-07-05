<?php 
// ** Path settings ** //
define( 'ABSPATH', __DIR__ );
define( 'ABSINC', ABSPATH . '/inc' );
define( 'ABSCONTROLLERS', ABSPATH . '/controllers' );
define( 'ABSVIEWS', ABSPATH . '/views' );

// ** Config Include  ** //
define( 'HEADERINCLUDE', true );

// ** Global Vars ** //
$mvctemplate = array();

require(ABSPATH . '/config.php');
require(ABSINC . '/mysqld.php');
require(ABSINC . '/class.user.php');
require(ABSINC . '/class.auth.php');
require(ABSINC . '/controllers.php');
require(ABSINC . '/light_models.php');
require(ABSINC . '/models.php');


// ** Loads ** //
auth::sessionLoad();