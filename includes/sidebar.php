<div class="col-md-4">

    <!-- Blog Search Well -->

    <div class="well">
    <h4>Blog Search</h4>
    
    <form action="search_category.php" method="post">
    <div class="input-group">
    <input name="searchCategory" type="text" class="form-control">
    <span class="input-group-btn">
    <button name="search" class="btn btn-default" type="submit">
    <span class="glyphicon glyphicon-search"></span>
    </button>
    </span>
    </div>
    </form>
    <!-- /.input-group -->
    </div>

    <!-- Login -->

    <div class="well">

    <?php if(!empty($_SESSION['user_status'])): ?>
        <h4>Logged in as <?php echo ucwords($_SESSION['user_firstname']) ." ". ucwords($_SESSION['user_lastname']); ?></h4>
        <a href="includes/logout.php" class="btn btn-primary">Logout</a>
    <?php else:?>
    <h4>Login</h4>
    <form action="includes/login.php" method="post" autocomplete="off">
    <div class="form-group">
    <input name="username" type="text" class="form-control" placeholder="enter username">
    </div>
    <div class="input-group">
    <input type="password" name="password" class="form-control" placeholder="enter password">
    <span class="input-group-btn">
    <button name="login" class="btn btn-primary" type="submit">Login</button>
    </span>
    </div>
    <div>
    <p class="text-center">Not Registered? <a href="registration.php">Register</a></p>
    </div>
    </form>
    <?php endif;?>

    
    <!-- /.input-group -->
    </div>


    <!-- Blog Categories Well -->

    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
        <div class="col-lg-12">
        <ul class="list-unstyled">

        <?php 

            $query = "SELECT * FROM category";
            $categoryName = mysqli_query($connect,$query);
            while($row = mysqli_fetch_assoc($categoryName))
            {
                $categoryTitle = $row['categoryName'];
                $categoryId = $row['categoryId'];
                echo "<li><a href='category.php?category=$categoryId'>{$categoryTitle}</a></li>";
            }

        ?>
        </ul>
        </div>
        <!-- /.col-lg-12 -->

        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <?php include "sidebar_widget.php"; ?>

</div>