<?php

if(isset($_POST['add_post']))
{
    $post_category_id = $_POST['post_category_id'];
    $post_title= $_POST['post_title'];
    $post_author= $_POST['post_author'];
    $post_date= date("Y-m-d");

    $post_image= $_FILES['post_image']['name'];
    $post_image_temp=$_FILES['post_image']['tmp_name'];
    move_uploaded_file($post_image_temp,"../images/$post_image");

    $post_content= $_POST['post_content'];
    $post_status= $_POST['post_status'];
    $post_tags= $_POST['post_tags'];

    $query = "INSERT INTO posts VALUES (NULL,$post_category_id,'$post_title','$post_author','$post_date','../images/$post_image','$post_content','$post_status','$post_tags',0,0,0)";
    $createpost = mysqli_query($connect,$query);

    if($createpost)
    {
        $new_post_id=mysqli_insert_id($connect);
        echo "<p class='bg-success'>Post Added Successfully! <a href='../post.php?p_id={$new_post_id}'>View Post</a> | <a href='posts.php'>View All Posts</a></p>";
    }
    else
    {
        die("Query Failed!" . mysqli_error($connect));
    }
}
?>


<form action="" method="post" enctype="multipart/form-data">
<div class="form-group">
<label for="post_category_id">Select Post Category</label><br>
<select name="post_category_id">

<?php 

$query = "SELECT * FROM category";
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
<input type="text" class="form-control" name="post_title">
</div>
<br>

<div class="form-group">
<label for="post_author">Select Author</label><br>
<select name="post_author">

<?php 



$query = "SELECT * FROM users";
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
<label for="post_image">Image</label>
<input type="file" class="form-control" name="post_image">
</div>
<br>
<div class="form-group">
<label for="summernote">Content</label>
<textarea class="form-control" name="post_content" id="summernote" rows="10" cols="30" ></textarea>
</div>
<br>
<div class="form-group">
<label for="post_status">Status</label><br>

<select name="post_status">

    <option value='published'>Publish</option>
    <option value='draft'>Save as Draft</option>

</select>


</div>
<br>
<div class="form-group">
<label for="post_tags">Tags</label>
<input type="text" class="form-control" name="post_tags">
</div>
<br>
<div class="group-form"> 
<input type="submit" class="btn btn-primary" name="add_post" value="Add">
</div>
<br>
</form>