<?php include('connect.php')?>
<?php
function clean($str) {
   $str = @trim($str);
   if(get_magic_quotes_gpc()) {
     $str = stripslashes($str);
   }
   return mysql_real_escape_string($str);
 }

$likeType = clean($_GET['likeType']);
$comment_id = clean($_GET['comment_id']);
$member_id = clean($_GET['member_id']);
$sql = "SELECT * FROM comment WHERE comment_id=".$comment_id;
$like=mysql_query($sql);
$row=mysql_fetch_array($like);
$str = "";
if($row['likes']){
  //echo $row['likes'];
  $str = $row['likes'];
}
$str = $str.$member_id."-".$likeType.",";

$sql = "UPDATE comment SET likes='".$str."' WHERE comment_id=".$comment_id;

mysql_query($sql);
$array = explode(",",$row['likes']);
$jso="[";
for($i=0;$i<count($array);$i++){
  $jso=$jso.'{comment_id:'.$comment_id.',likeType:'.$likeType.',member_id:'.$member_id.'},';
}
$jso.=']';
echo $jso;
?>
