<?php include('connect.php')?>
<?php
function clean($str) {
   $str = @trim($str);
   if(get_magic_quotes_gpc()) {
     $str = stripslashes($str);
   }
   return mysql_real_escape_string($str);
 }

$comment_id = clean($_GET['comment_id']);
$member_id = clean($_GET['member_id']);
$sql = "SELECT * FROM comment WHERE comment_id=".$comment_id;
$like=mysql_query($sql);
$row=mysql_fetch_array($like);
$listOfLikes = explode(",",$row["likes"]);
$arrOuter = [];
$condition = true;
$num = sizeof($listOfLikes);
for($i=0;$i<$num-1;$i++){
	$val = $listOfLikes[$i];
	$oneLike = explode("-",$val);
	$sql = "SELECT * FROM members WHERE member_id=".$oneLike[0];
	$like=mysql_query($sql);
	$row=mysql_fetch_array($like);
	$name = $row['FirstName'].' '.$row['LastName'];

	$arrInner = array('member_id'=>$oneLike[0],'likeType'=>$oneLike[1],'memberName'=>$name);
	if($condition)
		array_push($arrOuter,$arrInner);
}
echo json_encode($arrOuter);
?>
