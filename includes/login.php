<?php include "db.php";?>
<?php session_start(); ?>
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