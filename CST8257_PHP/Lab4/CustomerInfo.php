<?php 
    include("./common/header.php"); 
    session_start();
    // redirect to Disclaimer.php
    if(!isset($_SESSION["agree"]))
    {
        header("Location: Disclaimer.php");
        exit( );
    }
    
    //**********************
    //******* values *******
    //**********************
    $pSelected = "";
    $eSelected = "";
    $mSelected = "";
    $aSelected = "";
    $evSelected = "";
  
    
    //*******************************
    //***** validation functions*****
    //*******************************
    $NameEMessage = "";
    $pCodeEMessage = "";
    $pNumberEMessage = "";
    $eAdressEMessage = "";
    $ContactMethodEMessage = "";
    $ContactTimeEMessage = "";
    $errorflag = false;
    
    // Name
    function ValidateName($name) { 
        if(!isset($name) || !$name)
        {
            global $errorflag;
            $errorflag = true;
            return "Name is required."; 
        } 
    }
    
    // Postal Code Regular Expression Check
    function ValidatePostalCode($postalCode) {
        $postalCodeRegex = "/^[a-z]\d[a-z]\s*\d[a-z]\d$/i";
        if(!preg_match($postalCodeRegex, $postalCode)){
            global $errorflag;
            $errorflag = true;
            return "Incorrect Postal Code";
        }
    } 

    // Phone Regular Expression Check
    function ValidatePhone($phone) {
        $phoneNumberRegex = "/^[1-9]\d{2}-[1-9]\d{2}-\d{4}\z/";
        if(!preg_match($phoneNumberRegex, $phone)){
            global $errorflag;
            $errorflag = true;
            return "Incorrect Phone Number";
        }
    } 

    // Email Regular Expression Check
    function ValidateEmail($email) { 
        $eAdressRegex = "/^[a-z-+.']+@[a-z]+\.[a-z]{2,4}/i";
        if(!preg_match($eAdressRegex, $email)){
            global $errorflag;
            $errorflag = true;
            return "Incorrect Email Adress";
        }
    } 
    
    function ValidateContactMethod(){
        global $errorflag;
        $errorflag = true;
        
        return "Please select Phone or Email.";
    }
    
    function ValidateContactTime() {
        global $errorflag;
        $errorflag = true;
        return "When prefer contact is a phone, you have to select one or more contact times."; 
    }
    
    
    
    if(isset($_POST["next"])){
        
        $Name = $_POST["Name"];
        $pCode = $_POST["pCode"];
        $pNumber = $_POST["pNumber"]; 
        $eAdress = $_POST["eAdress"];
        $pContactMethod = $_POST["pContactMethod"];
        $pContactTime = $_POST["cTime"];
        
        $NameEMessage = ValidateName($Name);
        $pNumberEMessage = ValidatePhone($pNumber);
        $eAdressEMessage = ValidateEmail($eAdress);
        $pCodeEMessage = ValidatePostalCode($pCode);

        // Contact time
        if($pContactMethod == "Phone" && !isset($pContactTime))
        {
            $ContactTimeEMessage = ValidateContactTime(); 
        }
        
        if(isset($pContactMethod)){
            if($pContactMethod == "Phone")
            {
               $pSelected = "checked"; 
            }else if($pContactMethod == "Email"){
                $eSelected = "checked";
            }
        }else{
            $ContactMethodEMessage = ValidateContactMethod();
        }

        // check contact time
        if(count($pContactTime) > 0){
            foreach($pContactTime as $i => $v){

                switch ($v) {
                    case "morning":
                        $mSelected = "checked";
                        break;
                    case "afternoon":
                        $aSelected = "checked";
                        break;
                    case "evening":
                        $evSelected = "checked";
                        break;
                }
            }
        }
        
        
        // When there is no error
        if(!$errorflag){
            
            $_SESSION["name"] = $Name;
            $_SESSION["pCode"] = $pCode;
            $_SESSION["pNumber"] = $pNumber;
            $_SESSION["eAdress"] = $eAdress;
            $_SESSION["pContactMethod"] = $pContactMethod;
            if(count($pContactTime) > 0){
                $_SESSION["pContactTime"] = implode(",", $pContactTime);
            }
            
            header("Location: DepositCalculator.php");
            exit();
        }
        
    }else{
        
        if(isset($_SESSION["name"])){
            $Name = $_SESSION["name"];
            $pCode = $_SESSION["pCode"];
            $pNumber = $_SESSION["pNumber"];
            $eAdress = $_SESSION["eAdress"];
            $pContactMethod = $_SESSION["pContactMethod"];
            if($pContactMethod == "Phone") {
                $pContactTime = explode(',', $_SESSION["pContactTime"]);
            }
            /*
            echo '****************';
            echo '</br>$pContactTime: ';
            var_dump($pContactTime);
            echo '</br>****************';
            */
            if(isset($pContactMethod)){
                if($pContactMethod == "Phone")
                {
                   $pSelected = "checked"; 
                }else if($pContactMethod == "Email"){
                    $eSelected = "checked";
                }
            }
            
            // check contact time
            if(count($pContactTime) > 0){
                foreach($pContactTime as $i => $v){
                    
                    switch ($v) {
                        case "morning":
                            $mSelected = "checked";
                            break;
                        case "afternoon":
                            $aSelected = "checked";
                            break;
                        case "evening":
                            $evSelected = "checked";
                            break;
                    }
                }
            }
            
        }
    }
    
    
    
?>
 <div class="container"> 
    <h1>Customer Information</h1>
    <hr class="solid">
    
    <form method = "post" action = "CustomerInfo.php" class="">
        <div class="form-group row">
            <label for="Name" class="control-label col-sm-4">Name:</label>
            <div class="col-sm-4">
                <input type="text" id="Name" name="Name" class="form-control" autocomplete="off" value="<?php echo $Name;?>"/>
            </div>
            <div class="col-sm-4">
                <p class='text-danger'>
                    <?php
                    echo $NameEMessage;
                    ?>
                </p>
            </div>
        </div>
        <div class="form-group row">
            <label for="pCode" class="control-label col-sm-4">Postal Code:</label>
            <div class="col-sm-4">
                <input type="text" id="pCode" name="pCode" class="form-control" autocomplete="off" value="<?php echo $pCode;?>"/>
            </div>
            <div class="col-sm-4">
                <p class='text-danger'>
                    <?php
                    echo $pCodeEMessage;
                    ?>
                    
                </p>
            </div>
        </div>
        <div class="form-group row">
            <label for="pNumber" class="control-label col-sm-4">Phone Number:</br>(nnn-nnn-nnnn)</label>
            <div class="col-sm-4">
                <input type="text" id="pNumber" name="pNumber" class="form-control" autocomplete="off" value="<?php echo $pNumber;?>"/>
            </div>
            <div class="col-sm-4">
                <p class='text-danger'>
                    <?php
                    echo $pNumberEMessage;
                    ?>
                    
                </p>
            </div>
        </div>
        <div class="form-group row">
            <label for="eAdress" class="control-label col-sm-4">Email Adress:</label>
            <div class="col-sm-4">
                <input type="text" id="eAdress" name="eAdress" class="form-control" autocomplete="off" value="<?php echo $eAdress;?>"/>
            </div>
            <div class="col-sm-4">
                <p class='text-danger'>
                    <?php
                    echo $eAdressEMessage;
                    ?>
                    
                </p>
            </div>
        </div>

        <!-- divider -->
        <hr class="solid">

        <!-- Contact Preference -->
        <div class="form-group row">
            <label for="Name" class="control-label col-sm-4">Prefered Contact Method:</label>
            <div class="col-sm-4">
                <input type="radio" id="Phone" name="pContactMethod" value="Phone" <?php echo $pSelected;?>>
                <label for="Phone">Phone</label>
                <input type="radio" id="Email" name="pContactMethod" value="Email" <?php echo $eSelected;?>>
                        <label for="Email">Email</label> 
            </div>
            <div class="col-sm-4">
                <p class='text-danger'>
                    <?php
                    echo $ContactMethodEMessage;
                    ?>
                    
                </p>
            </div>
        </div>

        <div class="form-group row">
            <label for="Name" class="control-label col-sm-4">If phone is selected, when can we contact you? (check all applicable) :</label>
            <div class="col-sm-4">
                <input type="checkbox" id="Morning" name="cTime[]" value="morning" <?php echo $mSelected;?>>
                <label for="Morning"> Morning</label>
                <input type="checkbox" id="Afternoon" name="cTime[]" value="afternoon"  <?php echo $aSelected;?>>
                <label for="Afternoon"> Afternoon</label>
                <input type="checkbox" id="Evening" name="cTime[]" value="evening" <?php echo $evSelected;?>>
                <label for="Evening"> Evening</label>
            </div>
            <div class="col-sm-4">
                <p class='text-danger'>
                    <?php
                    echo $ContactTimeEMessage;
                    ?>
                    
                </p>
            </div>
        </div>

        <!-- create a submit button -->
        <div class="form-group row">   
            <div class="col-sm-2 m-4">
                <input type = "submit" value = "Next >" class="btn btn-primary" name="next" />
            </div>
        </div>
    </form>  
 </div> 
<?php include('./common/footer.php'); ?>
