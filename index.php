<?php 

    include("includes/header.php"); 
    $photos = Photo::find_all();

?>


<div class="row">
    
    <div class="col-md-12">

        <div class="thumbnails row">

            <?php foreach($photos as $photo): ?>
            
                <div class="col-xs-6 cold-md-3">

                    <a href="photo.php?id=<?php echo $photo->id; ?>" class="thumbnail">

                        <img width="180" src="admin/<?php echo $photo->picturePath(); ?>" alt="">

                    </a>

                </div>
                
            <?php endforeach; ?>

        </div>
        
    </div>

<?php include("includes/footer.php"); ?>
