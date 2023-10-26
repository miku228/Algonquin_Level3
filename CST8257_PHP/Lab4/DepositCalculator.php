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
    
    
    $pAmountEMessage = "";
    $iRateEMessage = "";
    $yDepositEMessage = "";
    $errorflag = false;
        
    $dropdownItem = "";
    
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
    // making a dropdown list for the year of deposit
    function iniDropdown($yDeposit = 0){
        for ($i = 1; $i <= 20; $i++) {
            if($yDeposit == $i){
                $dropdownItem .= "<option value='$i' selected='selected'>$i</option>";
            }else{
                $dropdownItem .= "<option value='$i'>$i</option>";
            }
        }
        return $dropdownItem; 
    }
    
    $dropdownItem = iniDropdown();
    
    if(isset($_POST["calculate"])){
        $pAmount = $_POST["pAmount"];
        $iRate = $_POST["iRate"];
        $yDeposit = $_POST["yDeposit"];
        
        
        $pAmountEMessage = ValidatePrincipal($pAmount);
        $iRateEMessage = ValidateRate($iRate);
        $yDepositEMessage = ValidateYears($yDeposit);
        
         // When there is no error
        if(!$errorflag){
            $_SESSION["pAmount"] = $pAmount;
            $_SESSION["iRate"] = $iRate;
            $_SESSION["yDeposit"] = $yDeposit;
            $dropdownItem = iniDropdown($yDeposit);
        }
        
        
    }else{
        
        if(isset($_SESSION["pAmount"])){
            $pAmount = $_SESSION["pAmount"];
            $iRate = $_SESSION["iRate"];
            $yDeposit = $_SESSION["yDeposit"];
        }
        $dropdownItem = iniDropdown($yDeposit);
        
    }
    
    if(isset($_POST["previous"])){
        $_SESSION["pAmount"] = $_POST["pAmount"];
        $_SESSION["iRate"] = $_POST["iRate"];
        $_SESSION["yDeposit"] = $_POST["yDeposit"];
        /*
         * echo 'privious clicked ****************';
         * echo '</br>$_SESSION["pAmount": ';
         * var_dump($_SESSION["pAmount"]);
        echo '</br>****************';
         */
        
        header("Location: CustomerInfo.php");
        exit();
    }
    
    if(isset($_POST["complete"])){
        header("Location: Complete.php");
        exit();
    }
    
    
    
?>
<div class="container"> 
    <h1>Deposit Calculator</h1>
    <hr class="solid">
    <p>Enter a principal amount, and interest rate and a select number of years to deposit. </p>
    
    
    <form method = "post" action = "DepositCalculator.php" class="">
        <div class="form-group row">
            <label for="pAmount" class="control-label col-sm-4">Principal Amount:</label>
            <div class="col-sm-4">
                <input type="text" id="pAmount" name="pAmount" class="form-control" autocomplete="off" value="<?php echo $pAmount;?>"/>
            </div>
            <div class="col-sm-4">
                <p class='text-danger'>
                    <?php echo $pAmountEMessage; ?>
                </p>
            </div>
        </div>
        <div class="form-group row">
            <label for="iRate"  class="control-label col-sm-4">Interest Rate(%):</label>
            <div class="col-sm-4">
                <input type="text" id="iRate" name="iRate"  class="form-control" autocomplete="off" value="<?php echo $iRate;?>"/> 
            </div>
            <div class="col-sm-4">
                <p class='text-danger'>
                    <?php echo $iRateEMessage; ?>
                </p>
            </div>  
        </div>
        <div class="form-group row">
            <label  class="control-label col-sm-4">Years to Deposit:</label>
            <div class="col-sm-4">
                <select name = "yDeposit" class="form-control">
                    <option value="-1">--- please select a year ---</option>
                    <?php echo $dropdownItem; ?>
                </select>
            </div>
            <div class="col-sm-4">
                <p class='text-danger'>
                    <?php echo $yDepositEMessage; ?>
                </p>
            </div>
        </div>

        <!-- buttons -->
        <div class="form-group row"> 
            <div class=" col-sm-2 m-4">
                <input type = "submit" value = "< Previous" class="btn btn-secondary" name="previous" />
            </div>
            <div class="col-sm-2 m-4">
                <input type = "submit" value = "Calculate" class="btn btn-primary" name="calculate" />
            </div>
            <div class=" col-sm-2 m-4">
                <input type = "submit" value = "Complete >" class="btn btn-secondary" name="complete" />
            </div>
        </div>
    </form>

<?php 
    
    
    if(isset($_POST["calculate"]) && !$errorflag) {
        
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
        
        echo "<p>Following is the result of the calculation:</p>";
        echo $table;
        
     }
    
?>
 </div> 
<?php include('./common/footer.php'); ?>
