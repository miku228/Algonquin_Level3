<?php
include_once 'EntityClassLib.php';

function getPDO() {
    $dbConnection = parse_ini_file("Final.ini");
    extract($dbConnection);
    return new PDO($dsn, $user, $password);
}


function getPrograms() {
    $pdo = getPDO();
    
    // from "Use these SQL Statements in Test.txt" file
    $sql = "SELECT ProgramCode, ProgramTitle FROM Program";
    
    
    $pstmt = $pdo->prepare($sql);
    $pstmt->execute();
    if($pstmt){
        foreach($pstmt as $row) {
            $program = new Program($row['ProgramCode'], $row['ProgramTitle'], $row['ProgramDescription'] );       
            /*
            echo '$row : ';
            var_dump($row);
            echo '<br> ------ <br>';
             * 
             */
            $programs[] = $program;
        }
        return $programs;
        
    }else
    {
        throw new Exception("Query failed! SQL statement: $sql");
    }
    
}

function getAvailableCoursesByProgramCode($selectedProgram) {
    $pdo = getPDO();
    
    // from "Use these SQL Statements in Test.txt" file
    $sql = "SELECT Code, Title, Description, HoursPerWeek FROM Course WHERE ProgramCode = :program";
    
    $pstmt = $pdo->prepare($sql);
    $pstmt->execute(['program' => $selectedProgram]);
    
    if($pstmt){
        foreach($pstmt as $row) {
            $course = new Course($row['Code'], $row['Title'], $row['Description'], $row['HoursPerWeek'], $row['ProgramCode'] );       
            /*
            echo '$row : ';
            var_dump($row);
            echo '<br> ------ <br>';
            */
            $courses[] = $course;
        }
        return $courses;
        
    }else
    {
        throw new Exception("Query failed! SQL statement: $sql");
    }
    
}