<?php include("includes/header.php"); ?>

<?php 
    if(!$session->isSignedIn()){
        redirect("login.php");
    }
?>

<?php 

    if(empty($_GET['id'])){
        redirect('users.php');
    }

    $user = User::find_by_id($_GET['id']);

    if($user){
        $user->delete();
        $targetPath = SITE_ROOT . DS . 'admin' . DS . $user->uploadDirectory . DS . $user->user_image;
        unlink($targetPath);
        redirect('users.php');
    }else{
        redirect('users.php');
    }
     
?>