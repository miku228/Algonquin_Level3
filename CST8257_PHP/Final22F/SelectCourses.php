<?php
	session_start( );
        $dbConnection = parse_ini_file("Final.ini");
        extract($dbConnection);
        $pdo = new PDO($dsn, $user, $password);    
        $courseError = "";       
        $drpProgram = "";
        
        extract($_POST);  
              
        //Add your code here to impletement the functionalities as required
        
        include_once "EntityClassLib.php";
        include_once "Functions.php";
        
        session_start();
        $courseError = "";
        
        // ** Get programs data from database
        $programs = getPrograms();
        
        // ** When semester is selected
        if(isset($_POST['btnProgramSelectionSubmit'])){
            
            // ** Set the selected Program value to SESSION
            $_SESSION['selectedProgram'] = null;
            if (!empty($drpProgram)) {
                $_SESSION['selectedProgram'] = $drpProgram;  
                
                // ** GET the available courses from the database
                $availableCourses = getAvailableCoursesByProgramCode($drpProgram);
            }
            
        }
        
        
        // ** When Enroll button is clicked - Courses are registered
        if(isset($_POST['btnCourseSelectionSubmit'])) {
            // echo 'selectedProgram : ';
            // echo $_SESSION['selectedProgram'];
            // echo '<br> ------ <br>';

            // *** Get data from the database
            $availableCourses = getAvailableCoursesByProgramCode($drpProgram);
            // ** When the user doesn't check any courses
            if(!isset($selectedCourses)){
                $courseError = 'You need to select at least one course!';
            } else {
                // *** Get total hours from selected Courses 
                // *** Calculate selected course hours
                foreach ($selectedCourses as $selectedCourseCode) {
                    foreach ($availableCourses as $ac) {
                       if($ac->getCode() == $selectedCourseCode)  {
                           $totalSelectedWeeklyHours += (int)$ac->getHoursPerWeek();
                        }
                     }
                }
                
                // ** Set selected courses to SESSION
                $_SESSION['selectedCourses'] = $selectedCourses;
                // ** When the selected courses hours total exceed 16 hours
                if($totalSelectedWeeklyHours > 16 ){
                    $keepselection = true;
                    $errorMessage = 'The total weekly hours of the selected courses exceed the max allowed 16 hours!';
                } else {
                    header("Location: CourseDetails.php");
                    exit();
                }
            }
        }
        
?>
<html>
<head>
    <title>Select Courses</title>
</head>
<body style='margin-left: 20px'>
    <h1>Course Registrations</h1>
    
    <form action="SelectCourses.php" method="post">
        <p style='color: red'><?php echo $programError ?></p>
        <label> Program:<label> 
            <select name="drpProgram" style="width: 300px" >
                <option value="-1">Select a program ... </option>
                <?php

                     //Add your code here to impletement the functionalities as required 
                
                     $programDropDown = "";
                     
                     foreach ($programs as $key => $program) {
                         // ** set user selected value to dropdown from session data
                         if(isset($_SESSION['selectedProgram'])) {
                             // *************
                             // this part doesn't work
                             // **************
                            if($_SESSION['selectedProgram'] == $program->getProgramCode()) {
                                // $programDropDown .= '<option value="'.$semseter->getProgramCode().'" selected="selected">'.$semseter->getProgramTitle().'</option>';
                                // continue;
                            }
                            $programDropDown .= '<option value="'.$program->getProgramCode().'">'.$program->getProgramTitle().'</option>';
                        }
                         
                     }
                     
                     echo $programDropDown;
                 
    
                ?>
            </select>
            <input type='submit' name='btnProgramSelectionSubmit' value='Get Courses'/>
        
       <p style='color: red' ><?php echo $courseError;?></p>   
       <h3>The following courses are available in your selected program</h3>
       <table border='1'>
       <tr><th width='100px'>Course Code</th><th width='400px'>Course Title</th><th width='100px'>Hours/Week</th><th width='100px'>Select</th></tr>
       
        <?php
        if($drpProgram == "")
        {
            print("<tr><td colspan='4' style='text-align: center; color: red; font-weight: bold'>No program selected</td></tr>");
        }
        else
        {   
           //Add your code here to impletement the functionalities as required
            
            $tableData = "<tr>";
            foreach ($availableCourses as $key => $course) {
                $tableData .= '<td>'.$course->getCode() .'</td>'
                                . '<td>'.$course->getTitle() .'</td>'
                                . '<td>'.$course->getHoursPerWeek() .'</td>';
                
                // ** set selected item is checked
                if($keepselection) {
                    if(in_array($course->getCode(), $selectedCourses)) {
                        $tableData .= '<td><input type="checkbox" checked id="'.$course->getCode().'" name="selectedCourses[]" value="'.$course->getCode().'"></td></tr>';    
                    }else{
                        $tableData .= '<td><input type="checkbox" id="'.$course->getCode().'" name="selectedCourses[]" value="'.$course->getCode().'"></td></tr>';
                    }
                    
                }else{
                    $tableData .= '<td><input type="checkbox" id="'.$course->getCode().'" name="selectedCourses[]" value="'.$course->getCode().'"></td></tr>';
                }
            }
            
            echo $tableData;
            
        }
        ?>
        </table>
        </br>
        <input type='submit' name='btnCourseSelectionSubmit' value='Enroll into Checked Courses'/> 
       </form>
</body>
</html>