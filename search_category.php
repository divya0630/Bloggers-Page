<?php include "includes/header.php" ?>
<?php include "includes/db.php"?>

    <!-- Navigation -->
    <?php include "includes/navigation.php" ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

            
                <h2 class="page-header">
                    Search Result      
                </h2>
           
                <!-- First Blog Post -->
                <?php 

    
                if(isset($_POST['search']))
                {
                    $searchCategory = $_POST['searchCategory'];
                    $query = "SELECT * FROM posts WHERE post_tags LIKE '%$searchCategory%' ";
                    $searchResult = mysqli_query($connect,$query);
                    if(!$searchResult)
                    {
                        die("Query Failed!" . mysqli_error($connect));
                    }

                    $count = mysqli_num_rows($searchResult);
                    if($count == 0)
                        echo "<h3 class='text-center'>No Posts Found!</h3>";
                    else
                    {
                        while($row = mysqli_fetch_assoc($searchResult))
                        {
                            
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
                        <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                        <?php }}}?> 

                <hr>
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php" ?>

        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <?php include "includes/footer.php" ?>