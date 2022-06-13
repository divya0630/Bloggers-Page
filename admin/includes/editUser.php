<?php
if(isset($_GET['user_id']))
{
    $the_user_id=$_GET['user_id'];

    $query = "SELECT * FROM users WHERE user_id =$the_user_id";
    $select_user = mysqli_query($connect,$query);
    while($row = mysqli_fetch_assoc($select_user))
    {
        $username = $row['username'];
        $user_firstname= $row['user_firstname'];
        $user_lastname= $row['user_lastname'];
        $user_email= $row['user_email'];
        $user_status = $row['user_status'];
        $user_image= $row['user_image'];
        $user_password=$row['user_password'];
    }
}
      
if(isset($_POST['edit_user']))
{
    $username = $_POST['username'];
    $user_firstname= $_POST['user_firstname'];
    $user_lastname= $_POST['user_lastname'];
    $user_email= $_POST['user_email'];
    $user_password= $_POST['user_password'];

    $new_password=password_hash($user_password,PASSWORD_BCRYPT,array("cost"=>10));

    if(empty($user_password))
    {
        $query="SELECT * FROM users WHERE user_id=$the_user_id";
        $selectpassword = mysqli_query($connect,$query);
        while($row=mysqli_fetch_assoc($selectpassword))
        {
            $new_password=$row['user_password'];
        }
    }
    $user_status = $_POST['user_status'];
    if(empty($user_status))
    {
        $query="SELECT * FROM users WHERE user_id=$the_user_id";
        $selectimage = mysqli_query($connect,$query);
        while($row=mysqli_fetch_assoc($selectimage))
        {
            $user_status=$row['user_status'];
        }
    }

    $user_image= $_FILES['user_image']['name'];
    $user_image_temp=$_FILES['user_image']['tmp_name'];
    move_uploaded_file($user_image_temp,"../images/$user_image");
    
    if(empty($user_image))
    {
        $query="SELECT * FROM users WHERE user_id=$the_user_id";
        $selectimage = mysqli_query($connect,$query);
        while($row=mysqli_fetch_assoc($selectimage))
        {
            $user_image=$row['user_image'];
        }
    }

    $query="UPDATE users SET
                            user_firstname='$user_firstname',
                            user_lastname='$user_lastname',
                            username='$username',
                            user_password='$new_password',
                            user_image='../images/$user_image',
                            user_email='$user_email',
                            user_status='$user_status'
                            WHERE user_id=$the_user_id";
    $updateuser=mysqli_query($connect,$query);
    if($updateuser)
    {
        echo "Changes Updated Successfully! <a href='users.php'>View Users</a>";
    }
    else
    {
        die("Query Failed!" . mysqli_error($connect));
    } 
}

?>


<form action="" method="post" enctype="multipart/form-data">
<div class="form-group">
<label for="user_image">Image</label>
<img src=' ../images/<?php echo $user_image; ?>' width='50px' height='50px'>
<input type="file" class="form-control" name="user_image" >
</div>
<br>
<div class="form-group">
<label for="username">Username</label>
<input type="text" class="form-control" name="username" value="<?php echo "$username"; ?>">
</div>
<br>
<div class="form-group">
<label for="user_status">User Status</label><br>
<select name="user_status">
<?php 
if($user_status=='admin')
{
    echo "<option value='admin'>admin</option>";
    echo "<option value='subscriber'>subscriber</option>";
}
else
{
    echo "<option value='subscriber'>subscriber</option>";
    echo "<option value='admin'>admin</option>";
}

?>
</select>
</div>
<br>
<div class="form-group">
<label for="user_firstname">First Name</label>
<input type="text" class="form-control" name="user_firstname" value="<?php echo "$user_firstname"; ?>">
</div>
<br>
<div class="form-group">
<label for="user_lastname">Last Name</label>
<input type="text" class="form-control" name="user_lastname" value="<?php echo "$user_lastname"; ?>">
</div>
<br>
<div class="form-group">
<label for="user_email">Email Id</label>
<input type="textarea" class="form-control" name="user_email" value="<?php echo $user_email; ?>">
</div>
<br>
<div class="form-group">
<label for="user_password">Password</label>
<input autocomplete="off" type="password" class="form-control" name="user_password">
</div>
<br>
<div class="group-form"> 
<input type="submit" class="btn btn-primary" name="edit_user" value="Update">
</div>
<br>
</form>


