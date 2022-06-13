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
                        <div class="col-xs-6">
                        <?php
                        
                        if(isset($_POST['add_category']))
                        {
                            $categoryTitle = $_POST['category_title'];
                            if(!empty($categoryTitle))
                            {
                                $query = "INSERT INTO category(categoryName) VALUE ('{$categoryTitle}')";
                                $add_query = mysqli_query($connect,$query);
                            }
                            else
                            {
                                echo "This field cannot be empty!";
                                
                            }
                        }
                        ?>
                        <!-- Add category form -->
                        <form action="" method="post">
                        <div class="form-group">
                        <label for="category_title">Add Category</label>
                        <input type="text" class="form-control" name="category_title">
                        </div>
                        <div class="group-form">
                        <input type="submit" class="btn btn-primary" name="add_category" value="Add">
                        </div>
                        <br>
                        </form>
                        <!-- Update category form -->
                        <?php if(isset($_GET['edit'])) {?>
                    
                        <form action="" method="post">
                        <div class="form-group">
                        <label for="category_title">Edit Category</label>
                        <input type="text" class="form-control" name="category_title" value="<?php echo $_GET['name'];?>">
                        </div>
                        <div class="group-form">
                        <input type="submit" class="btn btn-primary" name="edit_category" value="Update">
                        </div>
                        </form>

                        <?php }?>
                        <!-- /Update category form -->
                        </div>
                        <div class="col-xs-6">
                        <table class="table">
                        <tr>
                        <th>Category Id</th>
                        <th>Category Name</th>
                        </tr>
                        <?php
                        //Display all categories with edit delete option in table query
                            $query = "SELECT * FROM category";
                            $show_category = mysqli_query($connect,$query);
                            while($row = mysqli_fetch_assoc($show_category))
                            {
                                echo "<tr>";
                                echo "<td>{$row['categoryId']}</td>";
                                echo "<td>{$row['categoryName']}</td>";
                                echo "<td><a class='btn btn-info' href='categories.php?edit={$row['categoryId']}&name={$row['categoryName']}'>Edit</a></td>";
                                ?>
                                <form action="" method="post">
                                    <input type="hidden" name="categoryId" value="<?php echo $row['categoryId']; ?>">
                                    <?php 
                                    echo "<td><input type='submit' name='delete' value='Delete' class='btn btn-danger' onClick=\" javascript : return confirm('Delete category?') \"></td>" ?>
                                </form>  
                                <?php
                                echo "</tr>";
                            }
                        ?>
                        <?php
                        //delete query
                        if(isset($_POST['delete']))
                        {
                            $category_id = $_POST['categoryId'];
                            $query = "DELETE FROM category WHERE categoryId = $category_id";
                            $delete_query = mysqli_query($connect,$query);
                            header("Location:categories.php");
                        }
                        ?>
                        <?php
                        //Update query         
                            if(isset($_POST['edit_category']))
                            {
                                $category_id = $_GET['edit'];
                                $category_title = $_POST['category_title'];
                                $query = "UPDATE category SET categoryName='$category_title' WHERE categoryId = $category_id";
                                $update_query = mysqli_query($connect,$query);
                                header("Location:categories.php");
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