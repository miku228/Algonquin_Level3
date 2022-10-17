<?php error_reporting(E_ALL); ?>
<?php
        
        $submit = $_POST["submit"];
        $reset = $_POST["Reset"];

        $pAmount = $_POST["pAmount"];
        $iRate = $_POST["iRate"];
        $yDeposit = $_POST["yDeposit"];
        $Name = $_POST["Name"];
        $pCode = $_POST["pCode"];
        $pNumber = $_POST["pNumber"]; 
        $eAdress = $_POST["eAdress"];
        $pContactMethod = $_POST["pContactMethod"];
        $pContactTime[] = $_POST["Morning"];
        $pContactTime[] = $_POST["Afternoon"];
        $pContactTime[] = $_POST["Evening"];
        
        $resultTitleMsg = "";
        $pAmountEMessage = "";
        $iRateEMessage = "";
        $yDepositEMessage = "";
        $NameEMessage = "";
        $pCodeEMessage = "";
        $pNumberEMessage = "";
        $ContactTimeEMessage = "";
        $eAdressEMessage = "";
        
        $errorflag = false;
        
        $dropdownItem = "";
        
        // for keeping previous input data after subimt
        $pSelected = "";
        $eSelected = "";
        $mSelected = "";
        $aSelected = "";
        $evSelected = "";
        

        for ($i = 1; $i <= 20; $i++) {
            if($yDeposit == $i){
                $dropdownItem .= "<option value='$i' selected='selected'>$i</option>";
            }else{
                $dropdownItem .= "<option value='$i'>$i</option>";
            }
        }
        
        if ($reset == "Reset"){
            $pAmount = "";
            $iRate = "";
            $yDeposit = "";
            $Name = "";
            $pCode = "";
            $pNumber = "";
            $eAdress = "";
            $pContactMethod = "";
            $pContactTime = [];
            
            $dropdownItem  = "";
            for ($i = 1; $i <= 20; $i++) {
                $dropdownItem .= "<option value='$i'>$i</option>";
            };
            
        }else if(isset($submit) || $submit) {

            //******************************
            //***** error check *****
            //******************************
            
            
            // *** functions ****
            // Principal Amount
            function ValidatePrincipal($pAmount){
                if(!is_numeric($pAmount) || $pAmount < 0) 
                {
                    global $errorflag;
                    $errorflag = true;
                    return "The principal amount must be numeric and greater than 0.";
                   
                }  
            }
            // Interest Rate
            function ValidateRate($amount){
                if(!is_numeric($amount)|| $amount < 0)
                {
                    global $errorflag;
                    $errorflag = true;
                    return "The interest rate must be numeric and greater than 0.";
                }  
            }
            
            // Year of Deposit
            function ValidateYears($years){
                if(!isset($years))
                {
                    global $errorflag;
                    $errorflag = true;
                    return "The year of the deposit must be selected."; 
                } 
            }
            
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
            
            function ValidateContactTime($time) {
                global $errorflag;
                $errorflag = true;
                return "When prefer contact is a phone, you have to select one or more contact times."; 
            }
            
            
            
            // *** execute functions ****
            $pAmountEMessage = ValidatePrincipal($pAmount);
            $iRateEMessage = ValidateRate($iRate);
            $yDepositEMessage = ValidateYears($yDeposit);
            $NameEMessage = ValidateName($Name);
            $pNumberEMessage = ValidatePhone($pNumber);
            $eAdressEMessage = ValidateEmail($eAdress);
            $pCodeEMessage = ValidatePostalCode($pCode);
            
            // check contact time is selected
            $selected = false;
            foreach ($pContactTime as $i => $v) {
                    if(isset($v)){
                        $selected = true;
                        switch ($i){
                            case 0:
                                $mSelected = "checked";
                                break;
                            case 1:
                                $aSelected = "checked";
                                break;
                            case 2:
                                $evSelected = "checked";
                                break;       
                        }
                    }
            }
            
            // Contact time
            if($pContactMethod == "Phone" && !$selected)
            {
                $ContactTimeEMessage = ValidateContactTime($selected); 
            }
            if($pContactMethod == "Phone")
            {
               $pSelected = "checked"; 
            }else if($pContactMethod == "Email"){
                $eSelected = "checked";
            }
            
            

            //******************************
            //***** End of error check *****
            //******************************


            //******************************
            //***** Sumbit Result      *****
            //******************************
            
            if(!$errorflag) {
                echo '<!DOCTYPE html>
                        <!--
                        Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
                        Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
                        -->
                        <html>
                            <head>
                                <title>Deposit Calculator</title>
                                <meta charset="UTF-8">
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
                                <link href="Style.css" rel="stylesheet" />
                            </head>
                            <body class="bg-light bg-gradient text-secondary">';
                $resultTitleMsg .= "<div class='container'><h2 class='mt-4 mb-4'>Thank you, $Name, for using our deposit calculator!</h2>";
            
                echo $resultTitleMsg;
                //***** No error *****
                if($pContactMethod == "Phone") {
                    //***** Contact method : Phone *****
                    foreach ($pContactTime as $v) {
                        if(isset($v)){
                            $pcontact .=  $v." or ";
                        }
                    }
                    echo "<p>Our customer service department will call you tomorrow ". trim(rtrim(trim($pcontact), "or")) ." at ".$pNumber.".</p>";

                 }else{
                    //***** Contact method : Email *****
                    echo "<p>Our customer service department will email you tomorrow.</p>";
                 }
                 echo "<p>The following is the result of the calculation.</p>";

                //***** Result table *****
                $table = "<table class='table table-striped'>
                            <tr>
                              <th>Year</th>
                              <th>Principal at Year Start</th>
                              <th>Interest for the Year</th>
                            </tr>";
                            
                settype($pAmount, "integer");
                settype($iRate, "integer");
                settype($yDeposit, "integer");

                $principal = $pAmount;

                for($i=1; $i<=$yDeposit; $i++)
                {

                    $interest = $principal * ($iRate/100);

                     $table .= "<tr>
                                    <td>". $i ."</td>
                                    <td>$". sprintf('%.2f', $principal) ."</td>
                                    <td>$". sprintf('%.2f', $interest) ."</td>
                                </tr>";

                    // set new number
                    $principal = $principal + $interest; 
                }
                $table .= "</table></div></body></html>";
                echo $table;
            }
        }
        
if($errorflag || !isset($submit) || !$submit) {       
print <<<EOS
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <title>Deposit Calculator</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
        <link href="Style.css" rel="stylesheet" />
    </head>
    <body class="bg-light bg-gradient text-secondary">
        <div class="container">
            <h1 class="mt-4 mb-4">Deposit Calculator</h1>

            <!-- post form data to form.php -->
            <form method = "post" action = "DepositCalculator.php" class="form-horizontal">
                <div class="form-group row">
                    <label for="pAmount" class="control-label col-sm-4">Principal Amount:</label>
                    <div class="col-sm-4">
                        <input type="text" id="pAmount" name="pAmount" class="form-control" autocomplete="off" value="$pAmount"/>
                    </div>
                    <div class="col-sm-4">
                        <p class='text-danger'>$pAmountEMessage</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="iRate"  class="control-label col-sm-4">Interest Rate(%):</label>
                    <div class="col-sm-4">
                        <input type="text" id="iRate" name="iRate"  class="form-control" autocomplete="off" value="$iRate"/> 
                    </div>
                    <div class="col-sm-4">
                        <p class='text-danger'>$iRateEMessage</p>
                    </div>  
                </div>
                <div class="form-group row">
                    <label  class="control-label col-sm-4">Years to Deposit:</label>
                    <div class="col-sm-4">
                        <select name = "yDeposit" class="form-control">
                            <option value="-1">--- please select a year ---</option>
                            $dropdownItem
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <p class='text-danger'>$yDepositEMessage</p>
                    </div>
                </div>

                <!-- divider -->
                <hr class="solid">

                <!-- User Information -->
                <div class="form-group row">
                    <label for="Name" class="control-label col-sm-4">Name:</label>
                    <div class="col-sm-4">
                        <input type="text" id="Name" name="Name" class="form-control" autocomplete="off" value="$Name"/>
                    </div>
                    <div class="col-sm-4">
                        <p class='text-danger'>$NameEMessage</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pCode" class="control-label col-sm-4">Postal Code:</label>
                    <div class="col-sm-4">
                        <input type="text" id="pCode" name="pCode" class="form-control" autocomplete="off" value="$pCode"/>
                    </div>
                    <div class="col-sm-4">
                        <p class='text-danger'>$pCodeEMessage</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pNumber" class="control-label col-sm-4">Phone Number:</label>
                    <div class="col-sm-4">
                        <input type="text" id="pNumber" name="pNumber" class="form-control" autocomplete="off" value="$pNumber"/>
                    </div>
                    <div class="col-sm-4">
                        <p class='text-danger'>$pNumberEMessage</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="eAdress" class="control-label col-sm-4">Email Adress:</label>
                    <div class="col-sm-4">
                        <input type="text" id="eAdress" name="eAdress" class="form-control" autocomplete="off" value="$eAdress"/>
                    </div>
                    <div class="col-sm-4">
                        <p class='text-danger'>$eAdressEMessage</p>
                    </div>
                </div>

                <!-- divider -->
                <hr class="solid">

                <!-- Contact Preference -->
                <div class="form-group row">
                    <label for="Name" class="control-label col-sm-4">Prefered Contact Method:</label>
                    <div class="col-sm-6">
                        <input type="radio" id="Phone" name="pContactMethod" value="Phone" $pSelected>
                        <label for="Phone">Phone</label>
                        <input type="radio" id="Email" name="pContactMethod" value="Email" $eSelected>
                        <label for="Email">Email</label> 
                    </div>
                </div>

                <div class="form-group row">
                    <label for="Name" class="control-label col-sm-4">If phone is selected, when can we contact you? (check all applicable) :</label>
                    <div class="col-sm-4">
                        <input type="checkbox" id="Morning" name="Morning" value="Morning" $mSelected>
                        <label for="Morning"> Morning</label>
                        <input type="checkbox" id="Afternoon" name="Afternoon" value="Afternoon"  $aSelected>
                        <label for="Afternoon"> Afternoon</label>
                        <input type="checkbox" id="Evening" name="Evening" value="Evening" $evSelected>
                        <label for="Evening"> Evening</label>
                    </div>
                    <div class="col-sm-4">
                        <p class='text-danger'>$ContactTimeEMessage</p>
                    </div>
                </div>

                <!-- create a submit button -->
                <div class="form-group row">   
                    <div class="col-sm-2 m-4">
                        <input type = "submit" value = "Calculate" class="btn btn-primary" name="submit" />
                    </div>
                    <div class=" col-sm-2 m-4">
                        <input type = "submit" value = "Reset" class="btn btn-secondary" name="Reset" />
                    </div>
                </div>
            </form>  
        </div>
    </body>
</html>
EOS;     
}
?>

