<?php

if(isset($_POST['add_user']))
{
    $username = $_POST['username'];
    $user_firstname= $_POST['user_firstname'];
    $user_lastname= $_POST['user_lastname'];
    $user_email= $_POST['user_email'];
    $user_password= $_POST['user_password'];
    $user_status = $_POST['user_status'];

    $user_image= $_FILES['user_image']['name'];
    $user_image_temp=$_FILES['user_image']['tmp_name'];
    move_uploaded_file($user_image_temp,"../images/$user_image");
        
    $user_password=password_hash($user_password,PASSWORD_BCRYPT,array("cost"=>10));

    $query = "INSERT INTO users VALUES(NULL,'$username','$user_firstname','$user_lastname','$user_email','$user_status','$user_password','../images/$user_image','')";
    $createuser = mysqli_query($connect,$query);

    if($createuser)
    {
        echo "User added successfully! <a href='users.php'>View Users</a>";
    }
    else
    {
        die("Insert Query Failed!" . mysqli_error($connect));
    }
}
?>


<form action="" method="post" enctype="multipart/form-data" autocomplete="off">
<div class="form-group">
<label for="user_status">Select Status</label><br>
<select name="user_status">
<option value="admin">admin</option>
<option value="subscriber">subscriber</option>
</select>
</div>
<br>
<div class="form-group">
<label for="username">Username</label>
<input type="text" class="form-control" name="username">
</div>
<br>
<div class="form-group">
<label for="user_firstname">First Name</label>
<input type="text" class="form-control" name="user_firstname">
</div>
<br>
<div class="form-group">
<label for="user_lastname">Last Name</label>
<input type="textarea" class="form-control" name="user_lastname">
</div>
<br>
<div class="form-group">
<label for="user_image">Image</label>
<input type="file" class="form-control" name="user_image">
</div>
<br>
<div class="form-group">
<label for="user_email">Email Id</label>
<input type="email" class="form-control" name="user_email">
</div>
<br>
<div class="form-group">
<label for="user_password">Password</label>
<input type="password" class="form-control" name="user_password">
</div>
<br>
<div class="group-form"> 
<input type="submit" class="btn btn-primary" name="add_user" value="Add">
</div>
<br>
</form>