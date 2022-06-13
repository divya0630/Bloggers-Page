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
                        <?php if(isset($_SESSION['user_status']) && $_SESSION['user_status']=="admin"):?>
                            Weclome To Admin
                        <?php endif; ?>

                        <?php if(isset($_SESSION['user_status']) && $_SESSION['user_status']=="subscriber"):?>
                            Weclome To Your Profile
                        <?php endif; ?>

                            <small><?php echo $_SESSION['user_firstname']; ?></small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->       
                <!-- /.row -->
                
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">

                <?php
                if(isset($_SESSION['user_status']) && $_SESSION['user_status']=="admin")
                {
                    echo "<div class='huge'>" .recordCount('posts'). "</div>";
                }
                else
                {
                    echo "<div class='huge'>" .statusCount('posts','post_author',$_SESSION['username']). "</div>";
                }
                  
                ?>
                        <div>Posts</div>
                    </div>
                </div>
            </div>
            <a href="posts.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">

                    <?php

                    if(isset($_SESSION['user_status']) && $_SESSION['user_status']=="admin")
                    {
                        echo "<div class='huge'>" .recordCount('comments'). "</div>";
                    }
                    else
                    {
                        $query = "SELECT * FROM comments,posts WHERE comments.comment_post_id=posts.post_id AND post_id IN (SELECT post_id FROM posts WHERE post_author='{$_SESSION['username']}')"; 
                        $result = mysqli_query($connect,$query);
                        echo "<div class='huge'>" .mysqli_num_rows($result). "</div>";
                    }
        
                    ?>
  
                      <div>Comments</div>
                    </div>
                </div>
            </div>
            <a href="comments.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <?php if(isset($_SESSION['user_status']) && $_SESSION['user_status']=="admin"):?>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">

                    <?php echo "<div class='huge'>" .recordCount('users'). "</div>"; ?>

                    <div> Users</div>
                    </div>
                </div>
            </div>
            <a href="users.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <?php endif; ?>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">

                    <?php echo "<div class='huge'>" .recordCount('category'). "</div>"; ?>
                    
                         <div>Categories</div>
                    </div>
                </div>
            </div>
            <a href="categories.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
                <!-- /.row -->
                <?php
        
        if(isset($_SESSION['user_status']) && $_SESSION['user_status']=="admin")
        {
            $category_count = recordCount('category');
            $admin_count = statusCount('users','user_status','admin');
            $subscriber_count = statusCount('users','user_status','subscriber');
            $unapproved_comment_count = statusCount('comments','comment_status','unapproved');
            $approved_comment_count = statusCount('comments','comment_status','approved');
            $published_post_count = statusCount('posts','post_status','published');
            $draft_post_count = statusCount('posts','post_status','draft');

            $chart_title = ['Published_Posts','Draft_Posts','Approved_Comments','Unapproved_Comments','Admins','Subscribers','Catoegories'];
            $chart_value = [$published_post_count,$draft_post_count,$approved_comment_count,$unapproved_comment_count,$admin_count,$subscriber_count,$category_count];
        }
        else
        {
            $category_count = recordCount('category');

            $query = "SELECT * FROM comments,posts WHERE comments.comment_post_id=posts.post_id AND comment_status='approved' AND post_id IN (SELECT post_id FROM posts WHERE post_author='{$_SESSION['username']}')"; 
            $result = mysqli_query($connect,$query);
            $approved_comment_count=mysqli_num_rows($result);

            $query = "SELECT * FROM comments,posts WHERE comments.comment_post_id=posts.post_id AND comment_status='unapproved' AND post_id IN (SELECT post_id FROM posts WHERE post_author='{$_SESSION['username']}')"; 
            $result = mysqli_query($connect,$query);
            $unapproved_comment_count=mysqli_num_rows($result);

            $query = "SELECT * FROM posts WHERE post_status='published' AND post_author='{$_SESSION['username']}'";
            $result = mysqli_query($connect,$query);
            $published_post_count = mysqli_num_rows($result);

            $query = "SELECT * FROM posts WHERE post_status='draft' AND post_author='{$_SESSION['username']}'";
            $result = mysqli_query($connect,$query);
            $draft_post_count = mysqli_num_rows($result);

            $chart_title = ['Published_Posts','Draft_Posts','Approved_Comments','Unapproved_Comments','Catoegories'];
        $chart_value = [$published_post_count,$draft_post_count,$approved_comment_count,$unapproved_comment_count,$category_count];
        }

        ?>

        <div class="row">
        
        <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
        ['Data', 'Count'],
        
          <?php

            for($i=0 ; $i<sizeof($chart_title) ; $i++)
            {
                echo "['{$chart_title[$i]}', {$chart_value[$i]}],";
            }

          ?>
        ]);

        var options = {
          chart: {
            title: '',
            subtitle: '',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
    
        </div>
        <!-- /.row -->
        <div id="columnchart_material" style="width: 800px; height: 500px;"></div>
        </div>
        <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php"; ?>