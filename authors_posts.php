<?php include "includes/header.php" ?>
<?php include "includes/db.php"?>

    <!-- Navigation -->
    <?php include "includes/navigation.php" ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

            <?php
            
            if(isset($_GET['p_id']))
            {
                $postId = $_GET['p_id'];
                $author=$_GET['author'];
            }

            ?>

                <h2 class="page-header">
                    All Posts By <b><?php echo $author; ?></b>
                </h2>

                <!-- First Blog Post -->
                <?php 
                if(isset($_GET['p_id']))
                {
                    $postId = $_GET['p_id'];
                    $author=$_GET['author'];
                }
                if(isset($_SESSION['user_status']) && $_SESSION['user_status']=="admin")
                {
                    $query = "SELECT * FROM posts WHERE post_author='$author'";
                }
                else
                {
                    $query = "SELECT * FROM posts WHERE post_author='$author' AND post_status='published'";
                }
                
                $select_posts = mysqli_query($connect,$query);
                $post_count=mysqli_num_rows($select_posts);
                if($post_count>0)
                {
                while($row = mysqli_fetch_assoc($select_posts))
                {
                    
                ?>
                
                <h2>
                    <a href="post.php?p_id=<?php echo $row['post_id']; ?>"><?php echo $row['post_title']; ?></a>
                </h2>
               
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $row['post_date']; ?></p>
                <hr>
                <img class="img-responsive" src="<?php echo $row['post_image']; ?>" alt="">
                <hr>
                <p><?php echo substr($row['post_content'],0,100); ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $row['post_id']; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                <hr>
                <?php 
                } 
                }
                else
                {
                    echo "<h3 class='text-center'>No Posts Available For This Author!</h3>";
                }
                ?>

                <!-- Blog Comments -->
                
                <!-- Comments Form -->
              

                <hr>

                <!-- Posted Comments -->
                
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php" ?>

        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <?php include "includes/footer.php" ?>