<table class="table">
<tr>
<th>Id</th>
<th>Related To Post</th>
<th>Author</th>
<th>Email Id</th>
<th>Date</th>
<th>Content</th>
<th>Status</th>
<th>Approve</th>
<th>Unapprove</th>
<th>Delete</th>
</tr>
<?php
//Display all comments
if(isset($_SESSION['user_status']) && $_SESSION['user_status']=="admin")
{
    $query = "SELECT * FROM comments";
}
else
{
    $query = "SELECT * FROM comments,posts WHERE comments.comment_post_id=posts.post_id AND post_id IN (SELECT post_id FROM posts WHERE post_author='{$_SESSION['username']}')";
}

$show_all_comments = mysqli_query($connect,$query);
while($row = mysqli_fetch_assoc($show_all_comments))
{
    $comment_id = $row['comment_id'];
    $comment_post_id = $row['comment_post_id'];
    $comment_author= $row['comment_author'];
    $comment_author_email= $row['comment_author_email'];
    $comment_date= $row['comment_date'];
    $comment_content= $row['comment_content'];
    $comment_status= $row['comment_status'];

    echo "<tr>";
    echo "<td> $comment_id</td>";
  
    $query="SELECT * FROM posts WHERE post_id = $comment_post_id";

    $showposttitle = mysqli_query($connect,$query);

    if(!$showposttitle)
        echo "Query Failed";
    
    while($row=mysqli_fetch_assoc($showposttitle))
    {
        $post_id=$row['post_id'];
        $post_title = $row['post_title'];
        echo "<td><a href='../post.php?p_id=$post_id'>{$post_title}</a></td>";
    }

    echo "<td>$comment_author</td>";
    echo "<td>$comment_author_email</td>";
    echo "<td>$comment_date</td>";
    echo "<td>$comment_content</td>";
    echo "<td>$comment_status</td>";
    // echo "<td><a href='comments.php?approve=$comment_id'>Approve</a></td>";
    // echo "<td><a href='comments.php?unapprove=$comment_id'>Unapprove</a></td>";
    // echo "<td><a href='comments.php?delete=$comment_id'>Delete</a></td>";
    ?>
    <form action="" method="post">
        <input type="hidden" name="approve_comment_id" value="<?php echo $comment_id; ?>">
        <?php 
        echo "<td><input type='submit' name='approve' value='Approve' class='btn btn-info'></td>" ?>
    </form>
    <form action="" method="post">
        <input type="hidden" name="unapprove_comment_id" value="<?php echo $comment_id; ?>">
        <?php 
        echo "<td><input type='submit' name='unapprove' value='Unapprove' class='btn btn-primary'></td>" ?>
    </form>
    <form action="" method="post">
        <input type="hidden" name="delete_comment_id" value="<?php echo $comment_id; ?>">
        <?php 
        echo "<td><input type='submit' name='delete' value='Delete' class='btn btn-danger' onClick=\" javascript : return confirm('Proceed to delete the comment?') \"></td>" ?>
    </form>
    <?php
    echo "</tr>";

}
?>

<?php
//approve query
if(isset($_POST['approve']))
{
    $post_id = $_POST['approve_comment_id'];
    $query = "UPDATE comments SET comment_status='approved' WHERE comment_id = $post_id";
    $approve_query = mysqli_query($connect,$query);
    header("Location:comments.php");
}

//unapprove query
if(isset($_POST['unapprove']))
{
    $post_id = $_POST['unapprove_comment_id'];
    echo $post_id;
    $query = "UPDATE comments SET comment_status='unapproved' WHERE comment_id = $post_id";
    $unapprove_query = mysqli_query($connect,$query);
    header("Location:comments.php");
}

//delete query
if(isset($_POST['delete']))
{
    $post_id = $_POST['delete_comment_id'];
    $query = "DELETE FROM comments WHERE comment_id = $post_id";
    $delete_query = mysqli_query($connect,$query);
    header("Location:comments.php");
}
?>

</table>