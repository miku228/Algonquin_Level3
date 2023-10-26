<?php 
	session_start(); 	

	//Add your code here
        include_once 'CourseList.php';
        
        // when couse is not selected -> redirect to SelectProgram.php
        if(!isset($_SESSION["selectedCourses"])){
            header("Location: SelectProgram.php");
            exit( );
        }
        
        $selectedCourses = $_SESSION["selectedCourses"];
        $selectedProgram = $_SESSION["selectedProgram"];
        switch ($selectedProgram){
            case "compAndMath":
                $inCourses = $computerAndMathProgramCourseList;
                break;
            case "construction":
                $inCourses = $constructionProgramCourseList;
                break;
            case "heathCare":
                $inCourses = $healthCareProgramCourseList;
                break;
        }
        
	
?>
<html>
<head>
    <title>Course Selection Result</title>
</head>
<body style='margin-left: 20px'>  
<h1>Course Registrations</h1>
<h3>You have enrolled in the following course(s)</h3>

        <?php
           //Add your code here
           $selectedCoursesResult = "<ul>";
           foreach ($selectedCourses as $i => $course) {
               $selectedCoursesResult .= "<li>$course - $inCourses[$course]</li>";
               
            }
            $selectedCoursesResult .= "</ul>";
            echo $selectedCoursesResult;
        ?>
       
</body>
</html>