<?php  
error_reporting(E_ALL ^ E_DEPRECATED);

$serv="localhost";
$user="root";
$pass="mysql";
$db="Packets";

//connect to the database 
$connect=mysqli_connect($serv,$user,$pass);

if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

  else
 {

   echo 'Connection Done';
  }
  mysqli_select_db($connect,$db);
  
  if($_SERVER['REQUEST_METHOD']=='POST'){
    
var_dump($_FILES);
var_dump($_POST);
#var_dump($_SERVER);
if ($_FILES['sam']['size'] > 0) { 

    //get the csv file 
    $file = $_FILES['sam']['tmp_name']; 
    $handle = fopen($file,"r"); 
     
    $output = shell_exec('tshark -r  $handle  -T fields -e frame.number -e frame.time -e eth.src -e eth.dst -e ip.src -e ip.dst -e ip.proto -e arp.src.proto_ipv4 -e arp.dst.proto_ipv4  -E header=y -E separator=, -E quote=d -E occurrence=f > sam.txt');
    //redirect 
    header('Location: import.php?success=1'); die; 

} 
}


mysqli_close($connect);
?> 
<!DOCTYPE html> 
<html> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
<title>Import a CSV File with PHP & MySQL</title> 
</head> 

<body> 

    
<?php
    if (!empty($_GET['success'])) { echo "<b>Your file has been imported.</b><br><br>"; } //generic success notice ?> 

<form action="import.php" method="POST" enctype="multipart/form-data"  > 
  Choose your file: <br /> 
  <input name="sam" type="file" id="sample" /> 
  <input type="submit" name="submit" value="Submit" /> 
</form> 

</body> 
</html> 