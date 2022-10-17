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
                        <input type="text" id="pAmount" name="pAmount" class="form-control" autocomplete="off" placeholder="Enter Principal Amount"/>
                    </div>
                    <div class="col-sm-4">
                        <?php echo "<p>test before if </p>"; if(isset($pAmountEMessage)){echo "<p>test inside if</p>";}; ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="iRate"  class="control-label col-sm-4">Interest Rate(%):</label>
                    <div class="col-sm-6">
                        <input type="text" id="iRate" name="iRate"  class="form-control" autocomplete="off" placeholder="Enter Interest Rate(%)"/> 
                    </div>
                </div>
                <div class="form-group row">
                    <label  class="control-label col-sm-4">Years to Deposit:</label>
                    <div class="col-sm-6">
                        <select name = "yDeposit" class="form-control">
                            <option selected="selected" disabled>--- please select a year ---</option>
                            <?php
                                for ($i = 1; $i <= 20; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                    
                                }
                            ?>
                        </select>
                    </div>
                </div>
                
                <!-- divider -->
                <hr class="solid">
                
                <!-- User Information -->
                <div class="form-group row">
                    <label for="Name" class="control-label col-sm-4">Name:</label>
                    <div class="col-sm-6">
                        <input type="text" id="Name" name="Name" class="form-control" autocomplete="off" placeholder="Enter Your Name"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pCode" class="control-label col-sm-4">Postal Code:</label>
                    <div class="col-sm-6">
                        <input type="text" id="pCode" name="pCode" class="form-control" autocomplete="off" placeholder="Enter Postal Code"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pNumber" class="control-label col-sm-4">Phone Number:</label>
                    <div class="col-sm-6">
                        <input type="text" id="pNumber" name="pNumber" class="form-control" autocomplete="off" placeholder="Enter Phone Number"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="eAdress" class="control-label col-sm-4">Email Adress:</label>
                    <div class="col-sm-6">
                        <input type="text" id="eAdress" name="eAdress" class="form-control" autocomplete="off" placeholder="Enter Email Adress"/>
                    </div>
                </div>
                
                <!-- divider -->
                <hr class="solid">
                
                <!-- Contact Preference -->
                <div class="form-group row">
                    <label for="Name" class="control-label col-sm-4">Prefered Contact Method:</label>
                    <div class="col-sm-6">
                        <input type="radio" id="Phone" name="pContactMethod" value="Phone">
                        <label for="Phone">Phone</label>
                        <input type="radio" id="Email" name="pContactMethod" value="Email">
                        <label for="Email">Email</label> 
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="Name" class="control-label col-sm-4">If phone is selected, when can we contact you? (check all applicable) :</label>
                    <div class="col-sm-6">
                        <input type="checkbox" id="Morning" name="Morning" value="Morning">
                        <label for="Morning"> Morning</label>
                        <input type="checkbox" id="Afternoon" name="Afternoon" value="Afternoon">
                        <label for="Afternoon"> Afternoon</label>
                        <input type="checkbox" id="Evening" name="Evening" value="Evening">
                        <label for="Evening"> Evening</label>
                    </div>
                </div>
                
                <!-- create a submit button -->
                <div class="form-group row">   
                    <div class="col-sm-2 m-4">
                        <input type = "submit" value = "Caluculate" class="btn btn-primary" name="submit" />
                    </div>
                    <div class=" col-sm-2 m-4">
                        <input type = "reset" value = "Clear"class="btn btn-secondary" name="clear" />
                    </div>
                </div>
            </form>
            
            
            <!-- ********************* -->
            <!-- after submit the form -->
            <!-- ********************* -->
            <?php
                $submit = $_POST["submit"];
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
            ?>
            
            <?php if(isset($submit)) { ?>
                
                <h2 class="mt-4 mb-4">Thank you,
                    <?php print( "$Name" ); ?>
                    , for using our deposit calculator!
                </h2>

                <!-- Check the input -->
                <?php
                    
                    $errormessage = "<ul>";
                    $errorflag = false;
                    $pAmountEMessage = "AA";

                    //******************************
                    //***** error check *****
                    //******************************

                    // Principal Amount
                    function ValidatePrincipal($pAmount){
                        if(!is_numeric($pAmount) || $pAmount < 0) 
                        {
                           $errorflag = true;
                           $pAmountEMessage .= "<p class='text-danger'>The principal amount must be numeric and greater than 0.</p>";
                           echo 'inside IF:'.$pAmountEMessage;
                        }  
                    }
                    
                    ValidatePrincipal($pAmount);
                    echo $pAmountEMessage;
                    
                    if(!is_numeric($pAmount) || $pAmount < 0) 
                    {
                       $errorflag = true;
                       $errormessage .= "<li>The principal amount must be numeric and greater than 0.</li>"; 
                    }
                    // Interest Rate
                    if(!is_numeric($iRate)|| $iRate < 0)
                    {
                        $errorflag = true;
                        $errormessage .= "<li>The interest rate must be numeric and greater than 0.</li>"; 
                    }
                    // Year of Deposit
                    if(!isset($yDeposit))
                    {
                        $errorflag = true;
                        $errormessage .= "<li>The year of deposit must be selected.</li>"; 
                    }

                    // check contact time is selected
                    $selected = false;
                    foreach ($pContactTime as $v) {
                            if(isset($v)){
                                $selected = true;
                            }
                    }
                    // Contact time
                    if($pContactMethod == "Phone" && !$selected)
                    {
                        $errorflag = true;
                        $errormessage .= "<li>When prefer contact is phone, you have to select one or more contact time.</li>"; 
                    }

                    // any blank item
                    $blankCheck = array("Principal Amount" => $pAmount, "Interest Rate" => $iRate, 
                                        "Name" => $Name, "Postal Code" => $pCode, 
                                        "Phone Number" => $pNumber, "Email Adress" => $eAdress, 
                                        "Preferred Contact Method" => $pContactMethod);

                    foreach($blankCheck as $key => $va)
                    {
                        if(!isset($va) || !$va)
                        {
                            $errorflag = true;
                            $errormessage .= "<li>". $key . " cannot be blank.</li>"; 
                        }
                    }
                    $errormessage .= "</ul>";

                    //******************************
                    //***** End of error check *****
                    //******************************


                    //******************************
                    //***** Sumbit Result      *****
                    //******************************

                    if(!$errorflag) {
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
                        $table .= "</table>";
                        echo $table;


                    }else{
                        // there is some error
                        echo "<p>However we cannot process your request because of the following input errors.</p>";
                        echo $errormessage;
                    }
                ?>
            <?php } ?>
            

            
        </div>
        
    </body>
</html>
