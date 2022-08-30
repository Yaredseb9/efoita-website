<?php
session_start();
if(isset($_SESSION['employeeID'])){
    
    if(!$con = mysqli_connect("localhost","root","root","mbcs")){
        $error = "DB connection error";
        $errorMessage = "Error : can't connect to the Database.";
    }
    $sql = "SELECT * FROM `members` WHERE `employeeID`='".$_SESSION['employeeID']."';";
    if(!$memberRecored = mysqli_query($con,$sql)){
        $error = 'fetch Error';
        $errorMessage = "Error : can't fetch members record";
    }else if($row=mysqli_num_rows($memberRecored) == 1){
        $memberRecored = mysqli_fetch_assoc($memberRecored);
        $_SESSION['employeeID'] = $memberRecored['employeeID'];
       // $_SESSION['photo'] = $memberRecored['photo'];
        $_SESSION['name'] = $memberRecored['firstName'];
    }
    else{
        $errorMessage = "No record found in members table";
    }
}

?>