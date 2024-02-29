<?php include("includes/header.php"); ?>

<?php 
    if(!$session->isSignedIn()){
        redirect("login.php");
    }
?>

<?php 

    if(empty($_GET['id'])){
        redirect('comments.php');
    }

    $comment = Comment::find_by_id($_GET['id']);

    if($comment){
        $comment->delete();
    }
    
    redirect("photo_comment?id={$comment->photo_id}.php");
     
?>