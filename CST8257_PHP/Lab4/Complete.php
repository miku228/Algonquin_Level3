<?php 
    include("./common/header.php");
    session_start();
    // redirect to Disclaimer.php
    if(!isset($_SESSION["agree"]))
    {
        header("Location: Disclaimer.php");
        exit( );
    }
    
    // redirect to CustomerInfo.php
    if(!isset($_SESSION["name"]))
    {
        header("Location: CustomerInfo.php");
        exit( );
    }
    // redirect to DepositCalculator.php
    if(!isset($_SESSION["pAmount"]))
    {
        header("Location: DepositCalculator.php");
        exit( );
    }
   
    /*
    echo '****************';
    echo '</br>$_SESSION["pContactTime"]: ';
    var_dump($_SESSION["pContactTime"]);
    echo '</br>****************';
    */
    $resultTitleMsg = "";
    $resultPMsg = "";
    
    $Name = $_SESSION["name"];
    $pNumber = $_SESSION["pNumber"];
    $eAdress = $_SESSION["eAdress"];
    $pContactMethod = $_SESSION["pContactMethod"];
    if($pContactMethod == "Phone") {
        $pContactTime = explode(',', $_SESSION["pContactTime"]);
        
    }
    
    
    $resultTitleMsg .= "<div class='container'><h2 class='mt-4 mb-4'>Thank you, $Name, for using our deposit calculator!</h2>";
            
    
    if($pContactMethod == "Phone") {
        //***** Contact method : Phone *****
        $resultPMsg = "<p>Our customer service department will call you tomorrow ". trim(rtrim(trim(implode(" or ", $pContactTime)), "or")) ." at ".$pNumber.".</p>";

     }else{
        //***** Contact method : Email *****
        $resultPMsg = "<p>Our customer service department will email you tomorrow.</p>";
     }
     
     
     
?>

 <div class="container"> 
    <h1>Complete</h1>
    <hr class="solid">
    <?php 
    echo $resultTitleMsg;
    echo $resultPMsg;
    ?>
 </div> 


<?php 
    session_destroy();
    include('./common/footer.php'); 
?>
