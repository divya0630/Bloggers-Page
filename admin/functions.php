<?php


// function query($query){
//     include "../includes/db.php";
//     return mysqli_query($connect, $query);
// }





function users_online()
{
    if(isset($_GET['onlineusers']))
    {
        session_start();
        include "../includes/db.php";
        $session = session_id();
        $time=time();
        $timeout_in_seconds = 10;
        $timeout=$time-$timeout_in_seconds;

        $query="SELECT * FROM users_online WHERE user_session='$session'";
        $check_user=mysqli_query($connect,$query);
        $user_count=mysqli_num_rows($check_user);

        if($user_count == NULL)
        {
            mysqli_query($connect,"INSERT INTO users_online(user_session,user_time) VALUES('$session',$time)");
        }
        else
        {
            mysqli_query($connect,"UPDATE users_online SET user_time=$time WHERE user_session='$session'");
        }

        $users_online=mysqli_query($connect,"SELECT * FROM users_online WHERE user_time > $timeout");
        echo $final_count= mysqli_num_rows($users_online);
        }
}

users_online();

function recordCount($table)
{
    include "../includes/db.php";
    $query = "SELECT * FROM $table";
    $record_count = mysqli_query($connect,$query);
    return mysqli_num_rows($record_count);
}

function statusCount($table,$column,$condition)
{
    include "../includes/db.php";
    $query = "SELECT * FROM $table WHERE $column='$condition'";
    $result = mysqli_query($connect,$query);
    return mysqli_num_rows($result);
}

function register_user($firstname,$lastname,$username,$email,$password)
{
    include "./includes/db.php";

    $password=password_hash($password,PASSWORD_BCRYPT,array("cost"=>10));

    $query="INSERT INTO users(username,user_firstname,user_lastname,user_email,user_status,user_password) VALUES ('$username','$firstname','$lastname','$email','subscriber','$password')";
    $new_user=mysqli_query($connect,$query);

    if($new_user)
    {
        echo "<h4 class='text-center'>You have been Registered Successfully!</h4>";
    }
    else
    {
        die("QueryFailed!".mysqli_error($connect));
    }   
}

function login_user($the_username,$password)
{
    include "./includes/db.php";
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
        header("Location:../index.php");
    }
    else
    {
        $_SESSION['user_status']='';
        header("Location:../index.php");
    }
}

?>