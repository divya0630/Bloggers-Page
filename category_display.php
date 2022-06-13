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
            
            if(isset($_GET['category']))
            {
                $category=$_GET['category'];
            }

            ?>

                <h2 class="page-header">
                    All <b><?php
                        $cat_name=mysqli_query($connect,"SELECT categoryName FROM category WHERE categoryId=$category");
                        $name=mysqli_fetch_array($cat_name);
                        echo $name['categoryName']; 
                        ?></b> Posts      
                </h2>

                <!-- First Blog Post -->
                <?php 
                $per_page=5;
                if(isset($_GET['page']))
                {
                    $current_page=$_GET['page'];
                }
                else
                {
                    $current_page="";
                }
                if($current_page=="" || $current_page==1)
                {
                    $page_1=0;
                }
                else
                {
                    $page_1=($current_page * $per_page) - $per_page;
                }

                if(isset($_GET['category']))
                {
                    $category=$_GET['category'];
                }
                if(isset($_SESSION['user_status']) && $_SESSION['user_status']=="admin")
                {
                    $query = "SELECT * FROM posts WHERE post_category_id=$category";
                }
                else
                {
                    $query = "SELECT * FROM posts WHERE post_category_id=$category AND post_status='published'";
                }

                $select_posts = mysqli_query($connect,$query);
                $post_count=mysqli_num_rows($select_posts);

                if($post_count>0)
                {
                    $count=ceil($post_count/5);
                    if(isset($_SESSION['user_status']) && $_SESSION['user_status']=="admin")
                    {
                        $query = "SELECT * FROM posts WHERE post_category_id=$category LIMIT $page_1,$per_page";
                    }
                    else
                    {
                        $query = "SELECT * FROM posts WHERE post_category_id=$category AND post_status='published' LIMIT $page_1,$per_page";
                    }
                 
                    $select_posts = mysqli_query($connect,$query);
                while($row = mysqli_fetch_assoc($select_posts))
                {
                    
                ?>
                
                <h2>
                    <a href="post.php?p_id=<?php echo $row['post_id']; ?>"><?php echo $row['post_title']; ?></a>
                </h2>
                <p class="lead">
                    by <a href="authors_posts.php?author=<?php echo $row['post_author'];?>&p_id=<?php echo $row['post_id']; ?>"><?php echo $row['post_author']; ?></a>
                </p>
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
                    echo "<h3 class='text-center'>No Posts Available For This Category!</h3>";
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
        <ul class="pager">
            <?php 
            
            for($i=1;$i<=$count;$i++)
            {
                if($i==$current_page)
                {
                    echo "<li><a class='active_link' href='index.php?page=$i'>$i</a></li>";
                }
                else
                {
                    echo "<li><a href='index.php?page=$i'>$i</a></li>";
                }
            }
                

            ?>
        </ul>

        <!-- Footer -->
        <?php include "includes/footer.php" ?>