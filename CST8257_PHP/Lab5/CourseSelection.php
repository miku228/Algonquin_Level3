<?php 
    include("./Common/header.php");
    
    include_once "Functions.php";
    include_once "EntityClassLib.php";
    session_start();
    
    if($_SESSION['student']){
        $student = unserialize($_SESSION['student']);
        $name = $student->getName();
        
    }else{
        header("Location: index.php");
        exit();
    }
    
?>
<div class="container">
    <h1>Course Selection</h1>
    <hr class="solid">
    <p>Hello <?php echo $name; ?>, you successfully logged in</p>
    
</div>
<?php include('./Common/footer.php'); ?>
