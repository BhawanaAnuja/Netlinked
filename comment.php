<?php include('connect.php')?>
<?php


 
 function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}

$messages = clean($_POST['message']);
$poster =clean($_POST['poster']);
$receiver = clean($_POST['receiver']);

$sql="INSERT INTO comment (comment,date_created, member_id_sender, member_id)
VALUES
('$messages','".strtotime(date("Y-m-d H:i:s"))."','$poster','$receiver')";

if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }
header("location: Home.php");
exit();



?>
