<?php include("includes/header.php"); ?>

<?php 
    if(!$session->isSignedIn()){
        redirect("login.php");
    }
?>

<?php 
    $message = "";
    if(isset($_POST['submit'])){
        $photo = new Photo();
        $photo->title = $_POST['title'];
        $photo->setFile($_FILES['file_upload']);

        if($photo->save()){
            $message = "Photo uploaded succesfyllu!";
        }else{
            $message = join("<br>", $photo->customErrors);
        }

    }

?>

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            
            <?php include("includes/top_nav.php") ?>

            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            
            <?php include("includes/side_nav.php") ?>

            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

          <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        UPLOADS
                        <small>Subheading</small>
                    </h1>
                    
                    <div class="col-md-6">
                        <?php echo $message; ?>
                        <form method="post" action="upload.php" enctype="multipart/form-data">
                 
                            <div class="form-group">
                                <input type="text" name="title" class="form-control">
                            </div>

                            <div class="form-group">
                                <input type="file" name="file_upload" class="form-control">
                            </div>

                            <input type="submit" name="submit">
                            
                        </form>
                    </div>

                </div>
            </div>
            <!-- /.row -->

          </div>
          <!-- /.container-fluid -->

        </div>

        
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>