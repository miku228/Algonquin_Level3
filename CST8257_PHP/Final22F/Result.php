<?php 
	session_start(); 	
        $dbConnection = parse_ini_file("Final.ini");
        extract($dbConnection);
        $pdo = new PDO($dsn, $user, $password);
        
?>
<html>
<head>
    <title>Course Selection Result</title>
</head>
<body style='margin-left: 20px'>  
<h1>Course Registrations</h1>
<h3>You have enrolled in the following course(s)</h3>
<table border='1'>
<tr><th width='100px'>Course Code</th><th width='400px'>Course Title</th><th width='100px'>Hours/Week</th></tr>

    <?php

         //Add your code here to impletement the functionalities as required
       
    ?>
</table>
<br/>
<a href="SelectCourses.php">Back to Course Selection</a>
</body>
</html>