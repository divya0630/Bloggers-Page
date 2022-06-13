<?php include "includes/header.php" ?>
<?php include "includes/db.php"?>
<?php

function loggedInUserId(){
    if(isset($_SESSION['username']) && !empty($_SESSION['username'])){
        include "includes/db.php";
        $result = mysqli_query($connect,"SELECT * FROM users WHERE username='" . $_SESSION['username'] ."'");
        $user = mysqli_fetch_array($result);
        $count=mysqli_num_rows($result);
        return $count >= 1 ? $user['user_id'] : false;
    }
    return false;

}

function userLikedThisPost($post_id){
    if(isset($_SESSION['username']) && !empty($_SESSION['username'])){
    include "includes/db.php";
    $result = mysqli_query($connect,"SELECT * FROM likes WHERE user_id=" .loggedInUserId() . " AND post_id={$post_id}");    
    $count=mysqli_num_rows($result);
    return $count >= 1 ? true: false;
    }
    return false;
    // return mysqli_num_rows($result) >= 1 ? true : false;
}

function getPostlikes($post_id){
    
    include "includes/db.php";
    $result = mysqli_query($connect,"SELECT * FROM likes WHERE post_id=$post_id");
    echo mysqli_num_rows($result);

}

?>
    <!-- Navigation -->
    <?php include "includes/navigation.php" ?>

    <?php

if(isset($_POST['liked'])) {

    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];

     //1 =  FETCHING THE RIGHT POST

    $query = "SELECT * FROM posts WHERE post_id=$post_id";
    $postResult = mysqli_query($connect, $query);
    $post = mysqli_fetch_array($postResult);
    $likes = $post['likes'];

    // 2 = UPDATE - INCREMENTING WITH LIKES

    mysqli_query($connect, "UPDATE posts SET likes=$likes+1 WHERE post_id=$post_id");

    // 3 = CREATE LIKES FOR POST

    mysqli_query($connect, "INSERT INTO likes(user_id, post_id) VALUES($user_id, $post_id)");
    exit();


}



if(isset($_POST['unliked'])) {



    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];

    //1 =  FETCHING THE RIGHT POST

    $query = "SELECT * FROM posts WHERE post_id=$post_id";
    $postResult = mysqli_query($connect, $query);
    $post = mysqli_fetch_array($postResult);
    $likes = $post['likes'];

    //2 = DELETE LIKES

    mysqli_query($connect, "DELETE FROM likes WHERE post_id=$post_id AND user_id=$user_id");


    //3 = UPDATE WITH DECREMENTING WITH LIKES

    mysqli_query($connect, "UPDATE posts SET likes=$likes-1 WHERE post_id=$post_id");

    exit();


}
?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <!-- First Blog Post -->
                <?php 
                
                if(isset($_GET['p_id']))
                {
                    $postId = $_GET['p_id'];
                    $query="UPDATE posts SET view_count=view_count+1 WHERE post_id=$postId";
                    $update_view_count=mysqli_query($connect,$query);
                }

                if(isset($_SESSION['user_status']) && $_SESSION['user_status']=="admin")
                {
                    $query = "SELECT * FROM posts WHERE post_id = $postId";
                }
                else
                {
                    $query = "SELECT * FROM posts WHERE post_id = $postId AND post_status='published'";
                }
                
                $select_posts = mysqli_query($connect,$query);
                $post_count=mysqli_num_rows($select_posts);
                while($row = mysqli_fetch_assoc($select_posts))
                {
                    $the_post_id=$row['post_id'];
                ?>
                
                <h2>
                    <a href="#"><?php echo $row['post_title']; ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $row['post_author']; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $row['post_date']; ?></p>
                <hr>
                <img class="img-responsive" src="<?php echo $row['post_image']; ?>" alt="">
                <hr>
                <p><?php echo $row['post_content']; ?></p>
                <hr>
                

               <!-- Like/Unlike Feature -->
            <?php
               if(isset($_SESSION['username']) && !empty($_SESSION['username'])){ ?>


                    <div class="row">
                        <p class="pull-right"><a
                                class="<?php echo userLikedThisPost($the_post_id) ? 'unlike' : 'like'; ?>"
                                href=""><span class="glyphicon glyphicon-thumbs-up"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="<?php echo userLikedThisPost($the_post_id) ? ' I liked this before' : 'Want to like it?'; ?>"

                                ></span>
                                <?php echo userLikedThisPost($the_post_id) ? ' Unlike' : ' Like'; ?>

                            </a></p>
                    </div>


                <?php  } else { ?>

                <div class="row">
                    <p class="pull-right login-to-post">You need to <a href="login.php">Login</a> to like </p>
                </div>

                <?php } ?>
                <div class="row">
                <p class="pull-right likes">Like: <?php getPostlikes($the_post_id); ?></p>
                </div>

                 <div class="clearfix"></div>
                 <?php } ?>

                <!-- Blog Comments -->
                <?php
                if($post_count>=1)
                {
                    if(isset($_POST['create_comment']))
                    {
                        $comment_author=$_POST['comment_author'];
                        $comment_author_email=$_POST['comment_author_email'];
                        $comment_content=$_POST['comment_content'];
                        $comment_post_id= $postId;
                        $comment_status="unapproved";

                        $query="INSERT INTO comments VALUES(NULL,'$comment_author','$comment_author_email','$comment_status',now(),$comment_post_id,'$comment_content')";
                        $add_comment=mysqli_query($connect,$query);

                        if(!$add_comment)
                        {
                            echo "Query Failed!" . mysqli_error($connect);
                        }
                    }
                ?>
                <!-- Comments Form -->
                <div class="well">
                    <form action="" method="POST" autocomplete="off">
                        <div class="form-group">
                            <label for="comment_author">Author</label>
                            <input type="text" name="comment_author" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="comment_author_email">Email</label>
                            <input type="email" name="comment_author_email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="comment_content">Comment</label>
                            <textarea class="form-control" rows="3" name="comment_content" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->
                <?php
                
                $query="SELECT * FROM comments WHERE comment_status='approved' AND comment_post_id = $postId";
                $show_query=mysqli_query($connect,$query);

                while($row=mysqli_fetch_assoc($show_query))
                {
                    $comment_author = $row['comment_author'];
                    $comment_date = $row['comment_date'];          
                    $comment_content = $row['comment_content'];
                 
                ?>

                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                        <?php echo $comment_content; ?>
                    </div>
                </div>
                <?php } 
                    }
                    else
                    {
                        echo "<h3>No Posts Available</h3>";
                    }
                
                ?>
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php" ?>

        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <?php include "includes/footer.php" ?>

        <script>
            $(document).ready(function(){

                  $("[data-toggle='tooltip']").tooltip();
                    var post_id = <?php echo $the_post_id; ?>;
                    var user_id = <?php echo loggedInUserId(); ?>;

                // LIKING

                $('.like').click(function(){
                    $.ajax({
                        url: "post.php?p_id=<?php echo $the_post_id; ?>",
                        type: 'post',
                        data: {
                            'liked': 1,
                            'post_id': post_id,
                            'user_id': user_id
                        }
                    });
                });

                // UNLIKING

                $('.unlike').click(function(){

                    $.ajax({

                        url: "post.php?p_id=<?php echo $the_post_id; ?>",
                        type: 'post',
                        data: {
                            'unliked': 1,
                            'post_id': post_id,
                            'user_id': user_id

                        }
                    });
                });
            });
        </script>