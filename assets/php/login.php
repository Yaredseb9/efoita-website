<?php
    $host='127.0.0.1';
	$uname='root';
	$pwd='root';
	$db='mbcs';
	
function createSession($empId ) 
 {
	session_start();
	if(isset( $_SESSION['employeeID'] ) )
	{
		$_SESSION['employeeID']=$empId;
	}else
	{
		$_SESSION['employeeID'] =$empId;
	}
    session_write_close();
}
function destroySession()
{
	session_start();
    session_destroy();
	session_write_close();
}
	
$uN="";
$passW="";

$con=mysqli_connect($host,$uname,$pwd,$db) or die("Connection failed Please Try Again!");
 //mysqli_select_db($con,$db) or die("Selection  failed Try Again!");
			
$uN=$_REQUEST['user_name'];
$passW=$_REQUEST['pass'];
			
$r=mysqli_query($con, "select * from user");
				
while($row=mysqli_fetch_array($r))
{
	if($row['1']== $uN && $row['3']==$passW )
	{
		createSession($uN);
		header('Location:../../home.php');  // after success login....
		//echo "Login Success!";

		}
		else
		{
         header('Location:../../index.php');  //login failed/////////		 
	 }
}

	?>