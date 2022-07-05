<?php if (!defined('HEADERINCLUDE')) { exit(); } ?>
<!doctype html>
<html lang="en" class="fullscreen-bg">
   <head>
      <!--Meta-->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
      <title><?php echo $mvctemplate['title']; ?></title>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
      <link rel="stylesheet" href="<?php echo $mvctemplate['url_public_folder']; ?>/css/main.min.css">
      <link rel="stylesheet" href="<?php echo $mvctemplate['url_public_folder']; ?>/css/app.css">
      <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700">-->
      <link rel="stylesheet" href="./css/css2.css?family=Source+Sans+Pro:300,400,600,700">

   </head>
   <body>
      <div id="wrapper">
         <div class="vertical-align-wrap">
            <div class="vertical-align-middle">
               <div class="auth-box">
                  <div class="logo text-center"><img src="<?php echo $mvctemplate['url_public_folder']; ?>./img/logo.png" alt=""></img></div>
                  <div class="content">
					 <?php if(isset($mvctemplate['stack']['msg'])) : ?><div class="alert alert-danger text-left" role="alert"><?php echo $mvctemplate['stack']['msg']; ?></div><?php endif; ?>
                     <form method="post" class="form-auth-small">
                        <div class="form-group"><label for="jc_email" class="control-label">Username:</label><input type="text" class="form-control" id="jc_email" name="username" placeholder="Enter your username"></div>
                        <div class="form-group"><label for="jc_password" class="control-label">Password:</label><input type="password" class="form-control" id="jc_password" name="password" placeholder="Enter your password"></div>
                        <div class="form-group"><button type="submit" class="btn btn-success btn-lg btn-block">LOGIN</button></div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>