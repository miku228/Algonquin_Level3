<?php
	session_start( );
        include_once 'CourseList.php';
        $courseError = "";

	//Add your code here
        //
        // when couse is not selected -> redirect to SelectProgram.php
        if(!isset($_SESSION["selectedProgram"])){
            header("Location: SelectProgram.php");
            exit( );
        }
        
        $selectedProgram = $_SESSION["selectedProgram"];
        switch ($selectedProgram){
            case "compAndMath":
                echo "compAndMath is selected";
                $courses = $computerAndMathProgramCourseList;
                
                break;
            case "construction":
                echo "construction is selected";
                $courses = $constructionProgramCourseList;
                break;
            case "heathCare":
                echo "heathCare is selected";
                $courses = $healthCareProgramCourseList;
                break;
        }
        
        
        // after a user clicked enroll btn
        if(isset($_POST["btnCourseSelectionSubmit"])){
            //if no course is selected the array/courses will be not defined -> isset() can be used here
            //if(isset($_POST["courses"])){
            if(count($_POST["courses"])<=0){
                $courseError = "You must select at least one course!";
            }else{
                $_SESSION["selectedCourses"] = $_POST["courses"];
                header("Location: Result.php");
                exit( );
            }
        }
        
        
        
        
        


?>
<html>
<head>
    <title>Select Courses</title>
</head>
<body style='margin-left: 20px'>
    <h1>Course Registrations</h1>
    <h3>The following courses are available in your selected program</h3>
    <form action="SelectCourses.php" method="post">
       <p style='color: red' ><?php echo $courseError;?></p>    
        <?php 
            //Add your code here
        
            $checkbox = "";
            foreach($courses as $index => $course){
                // checkbox is recommended to have a label in terms of user aspects, so that user can click the label to check the checkbox
                $checkbox .= "<input type=\"checkbox\" id=\"$index\" name=\"courses[]\" value=\"$index\" ><label for=\"$index\">$index - $course </label></br>";
            };
            echo $checkbox;

        ?>
       </br>
       <input type='submit' name='btnCourseSelectionSubmit' value='Enroll into Checked Courses'  class='button'/>
    </form>
</body>
</html>