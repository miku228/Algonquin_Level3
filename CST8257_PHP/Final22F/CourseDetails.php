<?php
        session_start( );
        $dbConnection = parse_ini_file("Final.ini");
        extract($dbConnection);
        $pdo = new PDO($dsn, $user, $password);
?>
  
<html>
    <head><title>Course Details</title></head>
    <body style='margin-left: 20px'>
	<?php
            include_once "EntityClassLib.php";
            include_once "Functions.php";
        
           //Add your code here to impletement the functionalities as required

           if(isset($_SESSION['selectedCourses'])) {
               $rCourses = $_SESSION['selectedCourses'];
               $selectedProgram = $_SESSION['selectedProgram'];
               $aCourses = getAvailableCoursesByProgramCode($selectedProgram);
               
               echo "<table border='1'>";
               echo "<tr><th width='100px'>Course Code</th><th width='400px'>Course Title</th><th width='100px'>Hours/Week</th></tr>";
               
               $tableData = "<tr>";
               
                foreach ($rCourses as $key => $courseCode) {
                    foreach ($aCourses as $ac) {
                       if($ac->getCode() == $courseCode)  {
                           echo $course;
                            $tableData .= '<td>'.$ac->getCode() .'</td>'
                                            . '<td>'.$ac->getTitle() .'</td>'
                                            . '<td>'.$ac->getHoursPerWeek() .'</td></tr>';
                           
                        }
                     }
                    


                echo $tableData;
               }
           }
           
           // session_destroy();
	?>

        <br/>
        <a href="SelectCourses.php">Back to Course Selection</a>
    </body>
</html>
