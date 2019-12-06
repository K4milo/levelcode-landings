<?php 
$user = "admin@springplaza.co";
$pass = "f57ad00432e0581a1516e4d7a0ff7868e93a9c73d29105e19ea1758b8d6ab8ecf230e8bf7a9bd2d774fa8c2680d6340c57b15441132e5025825065feb9bdd3e7";
//Spring2019*
if(isset($_POST['val']))
{
	$val = $_POST['val'];
	$user_t = $_POST['user'];
	$pass_t = hash('sha512', $_POST['pass']);
	//obtener sha512
	//echo $pass_t;
	if($val == "st0654" && $user_t == $user && $pass_t == $pass)
	{
		session_start();
		$_SESSION["sesion"] = true;
    $_SESSION["admin"] = true;
		header("Location: main.php");
	}
}
?>
<?php include_once("includes/conn_admin.php"); ?>
<?php include_once("includes/head_admin.php"); ?>
<div class="container">
	<div class="row">
    	<div class="col-xs-12 col-sm-4 col-md-4 text-center"></div>
        <div class="col-xs-12 col-sm-4 col-md-4 text-center">
          <form class="form-signin" role="form" action="<? echo $_SERVER['PHP_SELF']; ?>" method="post">
            <h2 class="form-signin-heading">Colliers</h2>
            <h3 class="form-signin-heading">Spring Plaza</h3>
            
            <input type="email" class="form-control" placeholder="Usuario" name="user" required autofocus>
            <input type="password" class="form-control" placeholder="Contraseña" name="pass" required>
            <div class="checkbox">
              <label>
                <input type="checkbox" value="remember-me">Recordarme
              </label>
            </div>
            <input type="hidden" value="st0654" id="val" name="val" />
            <button class="btn btn-lg btn-primary btn-block" type="submit">Ingresar</button>
          </form>
  		</div>
      <div class="col-xs-4 col-sm-4 col-md-4 text-center"></div>
  </div>

<?php include_once("includes/footer_admin.php"); ?>