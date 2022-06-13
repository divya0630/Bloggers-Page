<?php
if(isset($_GET['post_id']))
{
    $post_id=$_GET['post_id'];
}
   
    $query = "SELECT * FROM posts WHERE post_id=$post_id";
    $selectpost = mysqli_query($connect,$query);
    while($row = mysqli_fetch_assoc($selectpost))
    {
        $post_category_id = $row['post_category_id'];
        $post_title= $row['post_title'];
        $post_author= $row['post_author'];
        $post_date= $row['post_date'];
        $post_image= $row['post_image'];
        $post_content= $row['post_content'];
        $post_status= $row['post_status'];
        $post_tags= $row['post_tags'];
        $post_comment_count= $row['post_comment_count'];
        $view_count= $row['view_count'];
    }

    if(isset($_POST['edit_post']))
    {
        $post_id=$_POST['post_id'];
        $post_category_id = $_POST['post_category_id'];
        $post_title= $_POST['post_title'];
        $post_author= $_POST['post_author'];
        $post_date= $_POST['post_date'];

        $postImage= $_FILES['postImage']['name'];
        $postImage_temp=$_FILES['postImage']['tmp_name'];
        move_uploaded_file($postImage_temp,"../images/$postImage");

        $post_content= $_POST['post_content'];
        $post_status= $_POST['post_status'];
        $post_tags= $_POST['post_tags'];
        $view_count= $_POST['view_count'];
        
        if(empty($postImage))
        {
            $query="SELECT * FROM posts WHERE post_id=$post_id";
            $selectimage = mysqli_query($connect,$query);
            while($row=mysqli_fetch_assoc($selectimage))
            {
                $postImage=$row['post_image'];
            }
        }

        $query="UPDATE posts SET post_category_id=$post_category_id,
                                post_title='$post_title',
                                post_author='$post_author',
                                post_date='$post_date',
                                post_image='../images/$postImage',
                                post_content='$post_content',
                                post_status='$post_status',
                                post_tags='$post_tags',
                                view_count= $view_count 
                                WHERE post_id=$post_id";
        $updatepost=mysqli_query($connect,$query);
        if($updatepost)
        {
            echo "<p class='bg-success'>Post Updated! <a href='../post.php?p_id={$post_id}'>View Post</a> | <a href='posts.php'>Edit More Posts</a></p>";
        }
        else
        {
            die("Query Failed!" . mysqli_error($connect));
        } 
    }

?>


<form action="" method="post" enctype="multipart/form-data">
<div class="form-group">
<label for="post_id">Post ID</label>
<input type="text" class="form-control" name="post_id" value="<?php echo "$post_id"; ?>">
</div>
<br>
<div class="form-group">
<label for="post_category_id">Post Category</label><br>
<select name="post_category_id">

<?php 

$query = "SELECT * FROM category WHERE categoryId = $post_category_id";
$show_category = mysqli_query($connect,$query);
while($row = mysqli_fetch_assoc($show_category))
{
    echo "<option value='{$row['categoryId']}'>{$row['categoryName']}</option>";
}
$query = "SELECT * FROM category WHERE categoryId != $post_category_id";
$show_category = mysqli_query($connect,$query);
while($row = mysqli_fetch_assoc($show_category))
{
    echo "<option value='{$row['categoryId']}'>{$row['categoryName']}</option>";
}


?>

</select>
</div>
<br>
<div class="form-group">
<label for="post_title">Title</label>
<input type="text" class="form-control" name="post_title" value="<?php echo "$post_title"; ?>">
</div>
<br>

<div class="form-group">
<label for="post_author">Select Author</label><br>
<select name="post_author">
<option value="<?php echo $post_author; ?>"><?php echo $post_author; ?></option>

<?php 

$query = "SELECT * FROM users WHERE username!='$post_author'";
$show_user = mysqli_query($connect,$query);
while($row = mysqli_fetch_assoc($show_user))
{
    echo "<option value='{$row['username']}'>{$row['username']}</option>";
}

?>

</select>
</div>
<br>


<div class="form-group">
<label for="post_date">Date</label>
<input type="text" class="form-control" name="post_date" value="<?php echo "$post_date"; ?>">
</div>
<br>
<div class="form-group">
<label for="post_image">Image</label>
<img src=' ../images/<?php echo $post_image; ?>' width='50px' height='50px'>
<input type="file" class="form-control" name="postImage" >
</div>
<br>
<div class="form-group">
<label for="summernote">Content</label>
<textarea name="post_content" id="summernote" rows="10" cols="30" ><?php echo $post_content; ?></textarea>
</div>
<br>
<div class="form-group">
<label for="post_status">Status</label>

<select name="post_status">
<?php 
if($post_status=='published')
{
    echo "<option value='published'>published</option>";
    echo "<option value='draft'>draft</option>";
}
else
{
    echo "<option value='draft'>draft</option>";
    echo "<option value='published'>published</option>";
}

?>
</select>

</div>
<br>
<div class="form-group">
<label for="post_tags">Tags</label>
<input type="text" class="form-control" name="post_tags" value="<?php echo "$post_tags"; ?>">
</div>
<br>
<div class="form-group">
<label for="view_count">Views</label>
<input type="text" class="form-control" name="view_count" value="<?php echo "$view_count"; ?>">
</div>
<br>
<div class="group-form"> 
<input type="submit" class="btn btn-primary" name="edit_post" value="Update">
</div>
<br>
</form>


