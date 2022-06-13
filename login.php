<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php ob_start(); ?>

<?php

if(isset($_POST['login']))
{
    $the_username=mysqli_real_escape_string($connect,$_POST['username']);
    $password = mysqli_real_escape_string($connect,$_POST['password']);

    $query="SELECT * FROM users WHERE username='$the_username'";
    $select_user = mysqli_query($connect,$query) or die("query failed" . mysqli_error($connect));

    while($row=mysqli_fetch_assoc($select_user))
    {
        $user_id=$row['user_id'];
        $user_firstname=$row['user_firstname'];
        $user_lastname=$row['user_lastname'];
        $username=$row['username'];
        $user_password=$row['user_password'];
        $user_status=$row['user_status'];
        $salt=$row['encrypted_password'];
    }

    $password=crypt($password,$user_password);

    $_SESSION['username']=$username;
    $_SESSION['user_firstname']=$user_firstname;
    $_SESSION['user_lastname']=$user_lastname;
    $_SESSION['user_id']=$user_id;
    $_SESSION['user_password']=$user_password;

    if($password===$user_password && $user_status==="admin")
    {
        $_SESSION['user_status']="admin";
        header("Location:../admin\index.php");

    }
    else if($password===$user_password && $user_status==="subscriber")
    {
        $_SESSION['user_status']="subscriber";
        header("Location:../admin\index.php");
    }
    else
    {
        $_SESSION['user_status']='';
        header("Location:../index.php");
    }

}

?>



<!-- Navigation -->

<?php  include "includes/navigation.php"; ?>


<!-- Page Content -->
<div class="container">

	<div class="form-gap"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="text-center">


							<h3><i class="fa fa-user fa-4x"></i></h3>
							<h2 class="text-center">Login</h2>
							<div class="panel-body">


								<form id="login-form" role="form" autocomplete="off" class="form" method="post">

									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>

											<input name="username" type="text" class="form-control" placeholder="Enter Username">
										</div>
									</div>

									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
											<input name="password" type="password" class="form-control" placeholder="Enter Password">
										</div>
									</div>

									<div class="form-group">

										<input name="login" class="btn btn-lg btn-primary btn-block" value="Login" type="submit">
									</div>

                                    <div>
                                    <p>Not Registered? <a href="registration.php">Register</a></p>
                                    </div>

								</form>

							</div><!-- Body-->

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<hr>

	<?php include "includes/footer.php";?>

</div> <!-- /.container -->