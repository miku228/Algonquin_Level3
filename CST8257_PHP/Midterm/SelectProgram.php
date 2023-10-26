<?php
	session_start( );
        $programError = "";

	//Add your code here
        //
        // extract($_POST);
        // and use $drpProgram as a received value from the submitted form
        
        if(isset($_POST["btnProgramSelectionSubmit"])){
            // when program is not selected
            if($_POST["drpProgram"] == "-1"){
                $programError = "You must select a program!";
                
            }else{
                $_SESSION["selectedProgram"] = $_POST["drpProgram"];
                header("Location: SelectCourses.php");
                exit();
            }
        };
?>
<html>
<head>
	<title>Select Program</title>
</head>
<body style='margin-left: 20px'>
    <h1>Course Registrations</h1>
    <h3>Select a program to see available courses</h3>
    <form action="SelectProgram.php" method="post">
        <label> Program:<label> <select name="drpProgram" style="width: 250px" >
                <option value="-1">Select a program ... </option>
                <option value="compAndMath">Computer and Mathematics</option>
                <option value="construction">Construction</option>
                <option value="heathCare">Health Care</option>
            </select>
                <input type='submit' name='btnProgramSelectionSubmit' value='Submit'/>
       <p style='color: red'><?php echo $programError ?></p>
    </form>
</body>
</html>