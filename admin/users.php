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
                        <?php
                            if(isset($_GET['source']))
                            {
                                $source = $_GET['source'];
                            }
                            else
                            {
                                $source='';
                            }

                            switch($source)
                            {
                                case 'addUser' : include "includes/addUser.php";
                                                   break;

                                case 'editUser' : include "includes/editUser.php";
                                                   break;

                                default : include "includes/view_all_users.php";
                            }
                        ?>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php"; ?>