<?php
include_once 'EntityClassLib.php';


function getPDO() {
    $dbConnection = parse_ini_file("Lab5.ini");
    extract($dbConnection);
    return new PDO($dsn, $scriptUser, $scriptPassword);
}

function getStudentByIdAndPassword($studentId, $password) {
    $pdo = getPDO();
    
    $sql = "SELECT StudentId, Name, Phone FROM Student WHERE StudentId = '$studentId' AND Password = '$password'";
    
    $resultSet = $pdo->query($sql);
    
    if($resultSet) {
       $row = $resultSet->fetch(PDO::FETCH_ASSOC);
        if ($row)
        {
           return new Student($row['StudentId'], $row['Name'], $row['Phone'] );            
        }
        else
        {
            return null;
        }
    }
    else
    {
        throw new Exception("Query failed! SQL statement: $sql");
    }
}


function addNewUser($studentId, $name, $phone, $password)
{
    $pdo = getPDO();
     
    $sql = "INSERT INTO Student (StudentId, Name, Phone, Password) VALUES( '$studentId', '$name', '$phone', '$password')";
    $pdoStmt = $pdo->query($sql);
}