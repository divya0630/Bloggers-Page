<?php

if(isset($_POST['checkBoxArray']))
{
    $selected_bulk_option = $_POST['bulk_options'];
    foreach($_POST['checkBoxArray'] as $checkBoxValue)
    {

        switch($selected_bulk_option)
        {
            case 'delete'   :   $query="DELETE FROM posts WHERE post_id=$checkBoxValue";
                                $delete_posts=mysqli_query($connect,$query);
                                header("Location:posts.php");
                                break;

            case 'published':   $query="UPDATE posts SET post_status='published' WHERE post_id=$checkBoxValue";
                                $update_status=mysqli_query($connect,$query);
                                break;

            case 'draft'    :   $query="UPDATE posts SET post_status='draft' WHERE post_id=$checkBoxValue";
                                $update_status=mysqli_query($connect,$query);
                                break;

            case 'clone'    :   $query = "SELECT * FROM posts  WHERE post_id=$checkBoxValue";
                                $show_allposts = mysqli_query($connect,$query);
                                while($row = mysqli_fetch_assoc($show_allposts))
                                {
                                    $post_id = $row['post_id'];
                                    $post_category_id = $row['post_category_id'];
                                    $post_title= $row['post_title'];
                                    $post_author= $row['post_author'];
                                    $post_date= $row['post_date'];
                                    $post_image= $row['post_image'];
                                    $post_content= $row['post_content'];
                                    $post_status= $row['post_status'];
                                    $post_tags= $row['post_tags'];
                                    $post_comment_count= $row['post_comment_count'];
                                }
                                $query = "INSERT INTO posts VALUES (NULL,$post_category_id,'$post_title','$post_author','$post_date','../images/$post_image','$post_content','$post_status','$post_tags',0,0)";
                                $clone_posts=mysqli_query($connect,$query);
                                if(!$clone_posts)
                                {
                                    die("Cloning failed!" . mysqli_error($connect));
                                }
                                break;
        }
    }
}


?>
<form method="post" action="">
<div>
    <div id="bulkOptionContainer" class="col-xs-4">
    <select class="form-control" name="bulk_options">
    <option value="Select Option">Select Option</option>
    <option value="published">Publish</option>
    <option value="draft">Save as Draft</option>
    <option value="clone">Clone</option>
    <option value="delete">Delete</option>
    </select>    
    </div>
    <div>
    <input type="submit" name="submit" id="" class="btn btn-success" value="Apply">
    <a class="btn btn-primary" href="posts.php?source=addPosts">Add New</a>
    </div>
</div>

<table class="table">
<tr>
<th><input type="checkbox" name="" id="selectAllBoxes"></th>
<th>Id</th>
<th>Category Id</th>
<th>Title</th>
<th>Author</th>
<th>Date</th>
<th>Image</th>
<th>Content</th>
<th>Status</th>
<th>Tags</th>
<th>Views</th>
<th>Comment Count</th>
<th>Edit</th>
<th>Delete</th>
</tr>
<?php
//Display all posts

if(isset($_SESSION['user_status']) && $_SESSION['user_status']=="admin")
{
    $query = "SELECT * FROM posts ORDER BY post_id DESC";
}
else
{
    $query = "SELECT * FROM posts WHERE post_author='{$_SESSION['username']}' ORDER BY post_id DESC";
}

$show_allposts = mysqli_query($connect,$query);
while($row = mysqli_fetch_assoc($show_allposts))
{
    $post_id = $row['post_id'];
    $post_category_id = $row['post_category_id'];
    $post_title= $row['post_title'];
    $post_author= $row['post_author'];
    $post_date= $row['post_date'];
    $post_image= $row['post_image'];
    $post_content= $row['post_content'];
    $post_status= $row['post_status'];
    $post_tags= $row['post_tags'];
    $view_count=$row['view_count'];

    echo "<tr>";
    ?>

    <th><input type="checkbox" class="checkBoxes" name="checkBoxArray[]" value="<?php echo $post_id; ?>"></th>
    
    <?php
    echo "<td> $post_id</td>";

    $query="SELECT * FROM category WHERE categoryID = $post_category_id";

    $showcategorytitle = mysqli_query($connect,$query);

    if(!$showcategorytitle)
        echo "Query Failed";
    
    while($row=mysqli_fetch_assoc($showcategorytitle))
    {
        $categoryid=$row['categoryId'];
        $categoryname = $row['categoryName'];
        echo "<td>{$categoryname}</td>";
    }


    
    echo "<td><a href='../post.php?p_id=$post_id'>{$post_title}</a></td>";
    echo "<td>$post_author</td>";
    echo "<td>$post_date</td>";
    echo "<td><img src=' $post_image' width='50px' height='50px'></td>";
    echo "<td>$post_content</td>";
    echo "<td>$post_status</td>";
    echo "<td>$post_tags</td>";
    echo "<td>$view_count</td>";

    $query="SELECT * FROM comments WHERE comment_post_id=$post_id";
    $comment_count=mysqli_query($connect,$query);
    $post_comment_count=mysqli_num_rows($comment_count);
    echo "<td><a href='post_comments.php?id=$post_id' alt='view comment(s)'>$post_comment_count</a></td>";
    
    echo "<td><a class='btn btn-info' href='posts.php?source=editPosts&post_id=$post_id'>Edit</a></td>";
    ?>
    
    <!-- echo "<td><a onClick=\" javascript : return confirm('Proceed to delete the post?') \" href='posts.php?delete=$post_id'>Delete</a></td>"; -->
    <form action="" method="post">
        <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
        <?php 
        echo "<td><input type='submit' name='delete' value='Delete' class='btn btn-danger' onClick=\" javascript : return confirm('Proceed to delete the post?') \"></td>" ?>
    </form>
    
    <?php echo "</tr>";
}
?>

<?php
//delete query
if(isset($_POST['delete']))
{
    $post_id = $_POST['post_id'];
    $query = "DELETE FROM posts WHERE post_id = $post_id";
    $delete_query = mysqli_query($connect,$query);
    header("Location:posts.php");
}
?>

</table>
</form>