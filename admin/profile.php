<?php include "includes/admin_header.php"; ?>
<?php

if(isset($_SESSION['username']))
{
    $username = $_SESSION['username'];
    $query="SELECT * FROM users WHERE username='$username'";
    $user_profile=mysqli_query($connect,$query);
    while($row = mysqli_fetch_assoc($user_profile))
    {
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

    if(empty($user_password))
    {
        $query="SELECT * FROM users WHERE username='$username'";
        $selectimage = mysqli_query($connect,$query);
        while($row=mysqli_fetch_assoc($selectimage))
        {
            $user_password=$row['user_password'];
        }
    }
    $user_status = $_POST['user_status'];
    if(empty($user_status))
    {
        $query="SELECT * FROM users WHERE username='$username'";
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
        $query="SELECT * FROM users WHERE username='$username'";
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
                            user_password='$user_password',
                            user_image='../images/$user_image',
                            user_email='$user_email',
                            user_status='$user_status'
                            WHERE username='$username'";
    $updateuser=mysqli_query($connect,$query);
    if(!$updateuser)
    {
        die("Query Failed!" . mysqli_error($connect));
    } 
}




?>
    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/admin_navigation.php"; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Blank Page
                            <small>Subheading</small>
                        </h1>
                        <div class="col-xs-12">
                        </div>
                        <div class="col-xs-12">
                        <!--form-->
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
                        <input type="textarea" class="form-control" name="user_email" value="<?php echo "$user_email"; ?>">
                        </div>
                        <br>
                        <div class="form-group">
                        <label for="user_password">Password</label>
                        <input type="password" class="form-control" name="user_password">
                        </div>
                        <br>
                        <div class="group-form"> 
                        <input type="submit" class="btn btn-primary" name="edit_user" value="Update Profile">
                        </div>
                        <br>
                        </form>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php"; ?>