<?php include "includes/admin_header.php"; ?>

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
if(isset($_GET['id']))
{
    $pid=$_GET['id'];
}
else
{
    $pid="";
}
$query = "SELECT * FROM comments WHERE comment_post_id=$pid";
$show_all_comments = mysqli_query($connect,$query);
if($show_all_comments != NULL)
{
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
    echo "<td><a href='post_comments.php?approve=$comment_id&id=$pid'>Approve</a></td>";
    echo "<td><a href='post_comments.php?unapprove=$comment_id&id=$pid'>Unapprove</a></td>";
    echo "<td><a href='post_comments.php?delete=$comment_id&id=$pid'>Delete</a></td>";
    echo "</tr>";

}
}
?>

<?php
//approve query
if(isset($_GET['approve']))
{
    $post_id = $_GET['approve'];
    $query = "UPDATE comments SET comment_status='approved' WHERE comment_id = $post_id";
    $approve_query = mysqli_query($connect,$query);
    header("Location:post_comments.php?id=$pid");
}

//unapprove query
if(isset($_GET['unapprove']))
{
    $post_id = $_GET['unapprove'];
    echo $post_id;
    $query = "UPDATE comments SET comment_status='unapproved' WHERE comment_id = $post_id";
    $unapprove_query = mysqli_query($connect,$query);
    header("Location:post_comments.php?id=$pid");
}

//delete query
if(isset($_GET['delete']))
{
    $post_id = $_GET['delete'];
    $query = "DELETE FROM comments WHERE comment_id = $post_id";
    $delete_query = mysqli_query($connect,$query);
    header("Location:post_comments.php?id=$pid");
}
?>

</table>
</div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php"; ?>