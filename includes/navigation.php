
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">CMS</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">

                <?php
                 
                    $query = "SELECT * from category";
                    $navbartitle = mysqli_query($connect,$query);

                    while($row = mysqli_fetch_assoc($navbartitle))
                    {
                        $category_class='';
                        $registration_class='';
                        $contact_class='';

                        $pagename= basename($_SERVER['PHP_SELF']);
                        if(isset($_GET['category']) && $_GET['category']==$row['categoryId'])
                        {
                            $category_class='active';
                        }
                        else if($pagename=='registration.php')
                        {
                            $registration_class='active';
                        }
                        else if($pagename=='contact.php')
                        {
                            $contact_class='active';
                        }
                        
                        echo "<li class='$category_class'><a href='../category_display.php?category={$row['categoryId']}'>{$row['categoryName']}</a></li>";
                    }

                ?>
                    <!-- <?php if(!isset($_SESSION['user_status']) || $_SESSION['user_status']==""): ?>
                    <li class="<?php echo $registration_class; ?>">
                        <a href="../registration.php" >Register</a>
                    </li>
                    <?php endif;?> -->

                    <!-- <li class="<?php echo $contact_class; ?>">
                        <a href="../contact.php" >Contact Us</a>       
                    </li>
                     -->
                    <?php
                    
                    
                        if(isset($_GET['p_id']))
                        {
                            if(isset($_SESSION['user_status']) && $_SESSION['user_status']=="admin")
                            {
                                $postid=$_GET['p_id'];
                                echo "<li><a href='admin/posts.php?source=editPosts&post_id=$postid'>Edit Post</a></li>";
                            } 
                        }
                    
                    ?>
                     <li>
                    <?php 
                     if(isset($_SESSION['user_status']) && $_SESSION['user_status']=="admin"):
                     ?>
                        <a href="../admin/index.php" >Admin</a>      
                    </li>
                    <?php endif;?> 
                    <li>
                    <?php if(isset($_SESSION['user_status']) && $_SESSION['user_status']=="subscriber"):
                    ?>
                        <a href="../admin/index.php" >Profile</a>      
                    </li>
                    <?php endif;?>
                  
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>