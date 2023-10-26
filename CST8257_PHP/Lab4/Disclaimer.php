<?php 
    include("./common/header.php"); 
    
    //**********************
    //***** validation *****
    //**********************
    session_start();
    $errorMessage= "";
    $agree = "false";
    
    /*
    echo '****************';
    echo '</br>$agree: ';
    var_dump($agree);
    echo '</br>$_SESSION["agree"]: ';
    var_dump($_SESSION["agree"]);
    echo '</br>****************';
    */
    
    if(isset($_POST["start"])){
        if(!isset($_POST["AgreewithTerms"])){
            $errorMessage= "You must agree to the terms and conditions!";
            
        }else{
            $_SESSION["agree"] = "true";
            header("Location: CustomerInfo.php");
            exit;
        }
        
    }else{
       if(isset($_SESSION["agree"]))
        {
           $agree = $_SESSION["agree"];
        } 
    }
    
?>
 <div class="container"> 
    <h1>Terms and Conditions</h1>
    <hr class="solid">
    <p>I agree to abide by the Bank's Terms and Conditions and rules in force and the changes thereto in Terms and Conditions from time to time relating to my account as communicated and made available on the Bank's website</p>
    <p>I agree that the bank before opening any deposit account. will carry out a due diligence as required under Know Your Customer guidelines of the bank I would be required to submit necessary documents or proofs such as identity, address, photograph and any such information, I agree to submit the above documents against at periodic intervals, as may be required by the Bank.</p>
    <p>I agree that the bank can at its sole discretion, amend any or the services/facilities given in my account either wholly or partially at any time by giving me at least 30 days notice and/or provide an option to me to switch to other services/facilities</p>
    <form  action="Disclaimer.php" method="POST" class="">
        <div class="form-group row col-sm-12">
            <p class='text-danger'>
            <?php echo $errorMessage?>
            </p>
        </div>
        <div class="form-group row col-sm-12">
                <input type="checkbox" id="AgreewithTerms" name="AgreewithTerms" value="AgreewithTerms">
                <label for="Morning" class="ml-4">I have read and agree with the terms and conditions</label>
        </div>
        <!-- a submit button -->
        <div class="form-group row">   
            <div class="col-sm-2">
                <input type = "submit" name="start" value = "Start" class="btn btn-primary" />
            </div>
        </div>
    </form>
 </div> 
<?php include('./common/footer.php'); ?>
