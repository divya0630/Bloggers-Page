<table class="table">
<tr>
<th>Id</th>
<th>Username</th>
<th>First Name</th>
<th>Last Name</th>
<th>Email Id</th>
<th>Status</th>
<th>Image</th>
<th>Change To</th>
<th>Change To</th>
<th>Edit</th>
<th>Delete</th>
</tr>
<?php
//Display all users
$query = "SELECT * FROM users";
$show_all_users = mysqli_query($connect,$query);
while($row = mysqli_fetch_assoc($show_all_users))
{
    $user_id = $row['user_id'];
    $username = $row['username'];
    $user_firstname= $row['user_firstname'];
    $user_lastname= $row['user_lastname'];
    $user_email= $row['user_email'];
    $user_status = $row['user_status'];
    $user_image= $row['user_image'];

    echo "<tr>";
    echo "<td> $user_id</td>";
    echo "<td>$username</td>";
    echo "<td>$user_firstname</td>";
    echo "<td>$user_lastname</td>";
    echo "<td>$user_email</td>";
    echo "<td>$user_status</td>";
    echo "<td><img src=' $user_image' width='50px' height='50px'></td>";
    // echo "<td><a href='users.php?admin=$user_id'>Admin</a></td>";
    // echo "<td><a href='users.php?subscriber=$user_id'>Subscriber</a></td>";
    ?>
    <form action="" method="post">
        <input type="hidden" name="admin_user_id" value="<?php echo $user_id; ?>">
        <?php 
        echo "<td><input type='submit' name='admin' value='Admin' class='btn btn-primary'></td>" ?>
    </form>
    <form action="" method="post">
        <input type="hidden" name="subs_user_id" value="<?php echo $user_id; ?>">
        <?php 
        echo "<td><input type='submit' name='subscriber' value='Subscriber' class='btn btn-warning'></td>" ?>
    </form>
    <?php
    echo "<td><a class='btn btn-info' href='users.php?source=editUser&user_id=$user_id'>Edit</a></td>";
    ?> 
    <form action="" method="post">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <?php 
        echo "<td><input type='submit' name='delete' value='Delete' class='btn btn-danger' onClick=\" javascript : return confirm('Delete User?') \"></td>" ?>
    </form>  
    <?php
    echo "</tr>";
}
?>

<?php
//delete query
if(isset($_POST['delete']))
{
    if(isset($_SESSION['user_status']) && $_SESSION['user_status']=='admin')
    {
        $user_id = $_POST['user_id'];
        $query = "DELETE FROM users WHERE user_id = $user_id";
        $delete_query = mysqli_query($connect,$query);
        header("Location:users.php");
    }

}
//change to admin query
if(isset($_POST['admin']))
{
    $user_id = $_POST['admin_user_id'];
    $query = "UPDATE users SET user_status='admin' WHERE user_id = $user_id";
    $admin_query = mysqli_query($connect,$query);
    header("Location:users.php");
}

//change to subscriber query
if(isset($_POST['subscriber']))
{
    $user_id = $_POST['subs_user_id'];
    $query = "UPDATE users SET user_status='subscriber' WHERE user_id = $user_id";
    $subscriber_query = mysqli_query($connect,$query);
    header("Location:users.php");
}

?>

</table>