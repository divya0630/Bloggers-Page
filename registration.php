<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>
<?php include "./admin/functions.php"; ?>


    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
    <?php 
    
    $errors=['username'=>'','password'=>'','email'=>''];
    if(isset($_POST['submit']))
    {   
        $firstname=mysqli_real_escape_string($connect,$_POST['firstname']);
        $lastname=mysqli_real_escape_string($connect,$_POST['lastname']);
        $username=mysqli_real_escape_string($connect,$_POST['username']);
        $email=mysqli_real_escape_string($connect,$_POST['email']);
        $password=$_POST['password'];

        $query="SELECT username FROM users WHERE username='$username'";
        $check=mysqli_query($connect,$query);
        $username_check=mysqli_fetch_assoc($check);

        if($username_check !== NULL)
            $errors['username']='Username already taken! Please try another.';

        if(strlen($username)<=4)
            $errors['username']='Username too short! Minimum 5 characters required.';

        if(strlen($username)>15)
            $errors['username']='Username too long! Maximum 15 characters allowed.';

        $query="SELECT user_email FROM users WHERE user_email='$email'";
        $check=mysqli_query($connect,$query);
        $email_check=mysqli_fetch_assoc($check);
    
        if($email_check !== NULL)
            $errors['email']='This email id is already registered! Please try another.';

        if(strlen($password)<3 || strlen($password)>20)
            $errors['password']='Password should be 3 to 20 characters long!';

       

        if($errors['username']=='' && $errors['email']=='' && $errors['password']=='')
        {
            register_user($firstname,$lastname,$username,$email,$password);
            login_user($username,$password);
        }
        

    }
 
    ?>
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="firstname" class="sr-only">firstname</label>
                            <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Enter Firstname" required>
                        </div>
                        <div class="form-group">
                            <label for="lastname" class="sr-only">lastname</label>
                            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Enter Lastname" required>
                        </div>
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" required>
                            <?php echo $errors['username']; ?>
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" required>
                            <?php echo $errors['email']; ?>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password" required>
                            <?php echo $errors['password']; ?>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-light btn-lg btn-block" style="background-color: #C8C6C6;" value="Register">
                        <br><center>Already Signed Up?<a href="login.php">Login</a></center>
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
