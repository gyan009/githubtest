<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MIS: Sign in</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="dist/css/signin.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
	<form class="form-signin" action="checklogin.php" method="post">
	    <img data-src="holder.js/200x300" src="images/logo.png" class="img-responsive">
        <h2 class="form-signin-heading">Please sign in</h2>
	<?php if(isset($_SESSION['error'])){?>
	 <div class="alert alert-danger"><?php echo $_SESSION['error'];?></div>
	<?php unset($_SESSION['error']); 
		}?>
        <input type="text" class="form-control" placeholder="Username" name="username" autofocus required>
        <input type="password" class="form-control" placeholder="Password" name="password" required>
<!--        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>-->
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div> <!-- /container -->

  </body>
</html>
