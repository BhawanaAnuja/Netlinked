<?php
	require('session.php');
	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
?>
<html>
<script type="text/javascript">
<!--
var post_id;
var post_like_type;
var post_id_privacy;
var member_id;
<?php
	echo "member_id=".$_SESSION['SESS_MEMBER_ID'].";";
	$member_id = $_SESSION['SESS_MEMBER_ID'];
?>

var timeout         = 500;
var closetimer		= 0;
var ddmenuitem      = 0;

// open hidden layer
function mopen(id)
{
	// cancel close timer
	mcancelclosetime();

	// close old layer
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';

	// get new layer and show it
	ddmenuitem = document.getElementById(id);
	ddmenuitem.style.visibility = 'visible';

}
// close showed layer
function mclose()
{
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';
}

// go close timer
function mclosetime()
{
	closetimer = window.setTimeout(mclose, timeout);
}

// cancel close timer
function mcancelclosetime()
{
	if(closetimer)
	{
		window.clearTimeout(closetimer);
		closetimer = null;
	}
}

// close layer when click-out
document.onclick = mclose;
// -->
</script>
<head>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">

	<!-- Jquery -->
	<script src="js/jquery-3.2.0.min.js"></script>

	<!-- Latest compiled and minified JavaScript -->
	<script src="js/bootstrap.min.js"></script>
	<title>Profile</title>

	<script>
	function like(num){
		post_like_type = num;
		console.log("set the post like type to "+post_like_type);
	}
	function set_post_id(num){
		post_id = num;
		post_like_type = 17;
		console.log("set the post id to "+post_id);
	}
	function submit_like() {
			console.log("working");
	        if (window.XMLHttpRequest) {
	            // code for IE7+, Firefox, Chrome, Opera, Safari
	            xmlhttp = new XMLHttpRequest();
	        } else {
	            // code for IE6, IE5
	            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	        }
	        xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
									var res = this.responseText;
	                //document.getElementById("commentlike-"+comment_id).innerHTML = this.responseText;
	            }
	        };
	        xmlhttp.open("GET","likes.php?likeType="+post_like_type+"&comment_id="+post_id+"&member_id="+member_id,true);
	        xmlhttp.send();
			var cid = "lb"+post_id;
			document.getElementById(cid).classList.remove("btn-default");
			document.getElementById(cid).classList.add("btn-primary");
	}
	function showLikes(id) {
			console.log("working");
	        if (window.XMLHttpRequest) {
	            // code for IE7+, Firefox, Chrome, Opera, Safari
	            xmlhttp = new XMLHttpRequest();
	        } else {
	            // code for IE6, IE5
	            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	        }
	        xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
									var res = $.parseJSON(this.responseText);
					var str = '<a class="list-group-item active">People who liked this post</a>';
					console.log(res.length);

					for(var i = 0;i<res.length;i++){
						var imgvar = '<img src="img/emoticons/'+res[i].likeType+'.gif" height=30px>&nbsp;';
						str+= '<a href="friendprofile.php?id='+res[i].member_id+'" class="list-group-item">'+imgvar+res[i].memberName+'</a>';
					}
	                document.getElementById("listLikeModel").innerHTML = str;
	            }
	        };
	        xmlhttp.open("GET","returnLikes.php?comment_id="+id+"&member_id="+member_id,true);
	        xmlhttp.send();

	}
	</script>

</head>

<link href="home.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="img/icon.png" type="image" />

	<link href="facebox1.2/src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
			<link href="../css/example.css" media="screen" rel="stylesheet" type="text/css" />
			<script src="facebox1.2/src/facebox.js" type="text/javascript"></script>
			<script type="text/javascript">

jQuery(document).ready(function($) {
  $('a[rel*=facebox]').facebox()
  	closeImage   : " ../src/closelabel.png"
})
</script>
<script>
		!window.jQuery && document.write('<script src="jquery-1.4.3.min.js"><\/script>');
	</script>
	<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />
 	<link rel="stylesheet" href="style.css" />
	<script type="text/javascript">
		$(document).ready(function() {


			$("a[rel=example_group]").fancybox({
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'titlePosition' 	: 'over',
				'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
				}
			});


		});
	</script>

<style type="text/css">
<!--
body {
	background-image: url(images/New%20Picture.jpg);
	background-repeat: repeat-x;
}
.style1 {font-weight: bold}
-->
</style>
<div class="main">


<div class="lefttop1">
  <div class="lefttopleft"> <a href="img/logo.jpg" rel="facebox"><img src="img/logo.png" width="150" height="40" /></a></div>
   <div class="propic">

	<?php
include('connect.php');
$id= $_SESSION['SESS_MEMBER_ID'];
$image=mysql_query("SELECT * FROM members WHERE member_id='$id'");
			$row=mysql_fetch_assoc($image);
			$_SESSION['image']= $row['profImage'];
			echo '<div id="pic">';
			echo "<a href=".$row['profImage']." rel=facebox;><img width=140 height=140 alt='Unable to View' src='" . $_SESSION['image'] . "'></a>";
			echo '</div>';

?>
</div>
<ul id="sddm1">
	<li><a href="editpic.php"><img src="img/pencil.png" width="17" height="17" border="0" /> &nbsp;Change Picture</a>
	</li>
	<li><a href="Home.php"><img src="img/wal.png" width="17" height="17" border="0" /> &nbsp;Wall</a>
	</li>
	<li><a href="info.php"><img src="img/message.png" width="16" height="12" border="0" /> &nbsp;Info</a>
	</li>
	<li><a href="photos.php"><img src="img/photos.png" width="16" height="12" border="0" /> &nbsp;Photos(<?php
$result = mysql_query("SELECT * FROM photos WHERE member_id='".$_SESSION['SESS_MEMBER_ID'] ."'");

	$numberOfRows = MYSQL_NUMROWS($result);

	echo '<font color="red">' . $numberOfRows . '</font>';
	?>)	</a>
	</li>
	<li><a href="request.php"><img src="img/friends.png" width="16" height="12" border="0" /> &nbsp;Friends Request
	(<?php

					$member_id=$_SESSION['SESS_MEMBER_ID'];
					$seeall=mysql_query("SELECT * FROM friends WHERE friends_with='$member_id' AND status='unconf'") or die(mysql_error());
					$numberOFRows=mysql_numrows($seeall);
					echo '<font color="red">'.$numberOFRows.'</font>';?>)
					</a>
	</li>
	<li><a href="message.php"><img src="img/m.png" width="16" height="12" border="0" /> &nbsp;Message&nbsp(<?php
$member_id = $_SESSION['SESS_MEMBER_ID'];
$received = mysql_query("SELECT * FROM messages WHERE recipient = '$member_id'")or die(mysql_error());
								$receiveda = mysql_numrows($received);
								echo '<font color="Red">'  .$receiveda .'</font>';


?>)
	</a>
	</li>

	<li><hr width="150"></li>
	<li>
	</ul>
	<div class="friend">
	<ul id="sddm1">
	<li><a href=""><img src="img/friends.png" width="16" height="12" border="0" /> &nbsp;Friends

	(<?php


$result = mysql_query("SELECT * FROM friends WHERE  friends_with = '$id' and  member_id!= '$id' and status = 'conf'    OR member_id = '$id' and friends_with != '$id' and status = 'conf' ");

	$numberOfRows = MYSQL_NUMROWS($result);
	echo '<font color="Red">' . $numberOfRows. '</font>';
	?>)
	</a>
	</li>
	</ul>
	<ul id="sddm1">
  <?php


								$member_id=$_SESSION['SESS_MEMBER_ID'];
								$post = mysql_query("SELECT * FROM friends WHERE friends_with = '$id' and  member_id!= '$id' and status = 'conf'    OR member_id = '$id' and friends_with != '$id' and status = 'conf'  ")or die(mysql_error());


								$num_rows  =mysql_numrows($post);

							if ($num_rows != 0 ){

								while($row = mysql_fetch_array($post)){

								$myfriend = $row['member_id'];
								$member_id=$_SESSION['SESS_MEMBER_ID'];

									if($myfriend == $member_id){

										$myfriend1 = $row['friends_with'];
										$friends = mysql_query("SELECT * FROM members WHERE member_id = '$myfriend1'")or die(mysql_error());
										$friendsa = mysql_fetch_array($friends);

										echo '<li> <a href=friendprofile.php?id='.$friendsa["member_id"].' style="text-decoration:none;"><img src="'. $friendsa['profImage'].'" height="50" width="50"></li><br><li>'.$friendsa['FirstName'].' '.$friendsa['LastName'].' </a> </li>';

									}else{

										$friends = mysql_query("SELECT * FROM members WHERE member_id = '$myfriend'")or die(mysql_error());
										$friendsa = mysql_fetch_array($friends);

									echo '<li> <a href=friendprofile.php?id='.$friendsa["member_id"].' style="text-decoration:none;"><img src="'. $friendsa['profImage'].'" height="50" width="50"></li><br><li>'.$friendsa['FirstName'].' '.$friendsa['LastName'].' </a> </li>';

									}
								}
								}else{
									echo 'You don\'t have friends </li>';
								}


							?>
							</ul>

							<ul id="sddm1">
							<li><hr width="150"></li>
							</ul>
</div>
  </div>
  <div class="righttop1">
       <div class="search">
       <form action="search.php" method="POST">
        <input name="search" type="text" maxlength="30" class="textfield"  value="search"/>

      </form>
</div>
    <div class="nav">
      <ul id="sddm">
        <li><a href="profile.php" ><?php


$result = mysql_query("SELECT * FROM members WHERE member_id='".$_SESSION['SESS_MEMBER_ID'] ."'");
while($row = mysql_fetch_array($result))
  {
  echo "<img width=20 height=15 alt='Unable to View' src='" . $row["profImage"] . "'>";
echo"  ";
  echo $row["FirstName"];
  echo"  ";
  echo $row["LastName"];
  }

?></a></li>
      <li><a href="Home.php">Home</a></li>
               <li><a  href="#"onmouseover="mopen('m5')" onmouseout="mclosetime()">Account</a>
          <div id="m5" onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
</a>

		<a href="logout.php"><font size="2" class="font1">Logout</font></a>
        </li>
      </ul>
      <div style="clear:both"></div>
      <div style="clear:both"></div>
    </div>
  </div>

  </div>

<div class="right">
	<div class="rightright">
	<form method="post">
	 <a href ="editprofile.php" class="a">Edit Profile</a>

	 </form>
	 <div class="colorless"><b>People You May Know</b></div>
	 <hr width="200">

	<div class="bkb"></div>

			<?php

						$id = $_SESSION['SESS_MEMBER_ID'];
						$post = mysql_query("SELECT * FROM members WHERE member_id != '$id' LIMIT 0,3")or die(mysql_error());
						while($row = mysql_fetch_array($post)){
							echo '
							<ul id="sddm11">
							<li>
								<a href="friendprofile.php?id='.$row['member_id'].'"><img class="img" src="'.$row['profImage'].'" alt="" height="40" width="40" " />
								<font color="#1d3162">'.$row['FirstName']." ".$row['LastName'].'</font>
								</br>

								<a href="addfriend.php?id='.$row['member_id'].'" rel="facebox"style="text-decoration:none;"  >Add as Friend</a></p>
								<hr width=200>
								</ul>
							</li>';

						}
					?>

	 </div>


	   <div class="shout">

<h2><div class="color"><?php
$result = mysql_query("SELECT * FROM members WHERE member_id='".$_SESSION['SESS_MEMBER_ID'] ."'");
while($row = mysql_fetch_array($result))
  {
  echo  $row["FirstName"];
  echo"  ";
  echo $row["LastName"];

  }
?>
</div>
</h2>
<hr align="left" width="420">
	   <?php
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$result = mysql_query("SELECT * FROM photos WHERE member_id='".$_SESSION['SESS_MEMBER_ID'] ."'  ORDER BY photo_id DESC LIMIT 0,4");


while($row = mysql_fetch_array($result))
  {



 echo "<a href=".$row['location']." rel=example_group><img class=img width=70 height=70 alt='Unable to View' src='". $row["location"] . "'>" . '</a>';


  echo"";



  }


?>
<hr align="left" width="420">
<div class="information">
<?php

if ($row['gender'] == "0")
		$var = "Female";
else
		$var = "Male";

$result = mysql_query("SELECT * FROM members WHERE member_id='".$_SESSION['SESS_MEMBER_ID'] ."'");
while($row = mysql_fetch_array($result))
  {
  echo "Lives in: "."".$row['Address']. " | " ."Gender: ".$var. " | " ."Born on: ".$row['Birthdate'];
  echo "</br>";
  echo "Contact No: "."".$row['ContactNo']. " | " ."Email: ".$row['Url'];
  echo "</br>";
   echo "Status: "."".$row['Stats'];

  }
?>
</div>
</div>
<div class="shoutout">

		<div  class="back"><h4><class="p"><div></h4></div>
		</br>
          <form  name="form1" method="post" action="comment1.php">
          <div class="comment">
            <textarea name="message" cols="45" rows="5" id="message" onclick="this.value='';"></textarea>
          </div>
          <input name="name" type="hidden" id="name" value="<?php echo $_SESSION['SESS_FIRST_NAME'];?>"/>
		  <input name="poster" type="hidden" id="name" value="<?php echo $_SESSION['SESS_MEMBER_ID'];?>"/>
          <input name="name1" type="hidden" id="name" value="<?php echo $_SESSION['SESS_LAST_NAME'];?>"/>
          <input type="submit" name="btnlog" value="Post" class="greenButton" />
          </div>
        </form>
		 <div class="s">
 <?php


  $query  = "SELECT *,UNIX_TIMESTAMP() - date_created AS TimeSpent FROM comment WHERE member_id='".$_SESSION['SESS_MEMBER_ID'] ."' ORDER BY comment_id DESC";
$result = mysql_query($query);
?>
<?php
while($row = mysql_fetch_assoc($result))
{
	$comment_id = $row['comment_id'];
	$comment = $row['comment'];
	$member_id = $row['member_id'];
	$member_id_sender = $row['member_id_sender'];
	$likes = $row['likes'];

	$result1 = mysql_query("SELECT * FROM members WHERE member_id='".$_SESSION['SESS_MEMBER_ID'] ."'");
	$row1 = mysql_fetch_array($result1);
   echo '<div class="panel panel-default" style="padding:10px">
     <div class="panel-body">';
	 echo '<div class="row">
  			<div class="col-xs-6 col-md-3">
    			<a href="#" class="thumbnail">';
	echo "<img width=100 height=100 alt='Unable to View' src='" . $row1["profImage"] . "'>";
	echo '</a>
  			</div>';
	$result1 = mysql_query("SELECT * FROM members WHERE member_id='".$_SESSION['SESS_MEMBER_ID'] ."'");
	$row1 = mysql_fetch_array($result1);
	$fname = $row1['FirstName'];
	$lname = $row1['LastName'];
	$id = $row['member_id'];
	echo "<div class='col-xs-6 colmd-8'><br><strong><a href='friendprofile.php?action=view&id={$id}'>{$fname}"."&nbsp;{$lname}</a> posted</strong></div>";
	echo '</div>';
	echo '<div class="row"><p>';
	echo "{$row['comment']}";
	echo '</p>';
	echo'</div>';

	echo '<div class="row">';
	$days = floor($row['TimeSpent'] / (60 * 60 * 24));
			$remainder = $row['TimeSpent'] % (60 * 60 * 24);
			$hours = floor($remainder / (60 * 60));
			$remainder = $remainder % (60 * 60);
			$minutes = floor($remainder / 60);
			$seconds = $remainder % 60;
	if($days > 0)
			echo date('F d Y', $row['date_created']);
			elseif($days == 0 && $hours == 0 && $minutes == 0)
			echo "few seconds ago";
			elseif($days == 0 && $hours == 0)
			echo $minutes.' minutes ago';
	echo '</div>';
	echo '<div class="row">';
	$listOfLikes = explode(",",clean($row['likes']));
	$num = sizeof($listOfLikes);
	$num--;

	$flag = 0;$i=0;
	foreach($listOfLikes as $value){
		//echo "+{$member_id}";
		$l = explode("-",$value);
		if($l[0] === $member_id){
			$flag = 1;
			break;
		}
		$i++;
	}
	if($num>0){
		$num1 = $num-1;
		//echo $i;
		if($flag == 1){
			if($num>1)
				echo "<a onclick='showLikes({$comment_id});' style='cursor:pointer' data-toggle='modal' data-target='#myModal2'>You and {$num1} others</a> have liked this";
			else
				echo "You have liked this";
		}
		else{
			$a = explode("-",$listOfLikes[0]);
			$result1 = mysql_query("SELECT * FROM members WHERE member_id={$a[0]}");
			$row1 = mysql_fetch_array($result1);
			$fname = $row1['FirstName'];
			$lname = $row1['LastName'];
			if($num>1)
				echo "<a onclick='showLikes({$comment_id});' style='cursor:pointer' data-toggle='modal' data-target='#myModal2'>{$fname} {$lname} and {$num1} others </a>have liked this";
			else
				echo "{$fname} {$lname} has liked this";
		}
	}
	echo '</div>';
	echo'<hr>';

	echo '<div class="row">';
	$classOfLike = "btn-default";
	if($flag == 1){
		$classOfLike = "btn-primary";
	}
	echo '
	<a id="lb'.$row["comment_id"].'" class="btn '.$classOfLike.'" type="button" onclick="set_post_id('.$row["comment_id"].')" style="outline:none" class="style" tabindex="0" class="btn btn-lg btn-danger" role="button" data-toggle="modal" data-target="#myModal">
		Like
	</a>
	<button class="btn btn-default" type="button">
  		Comment
	</button>
	<button class="btn btn-default" type="button">
	  	Share
	</button>
	';
	echo '</div>';

	echo '</div></div>';
	}


  echo'</br>';

  ?>

  <!-- Modal for liking-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Like a post</h4>
      </div>
      <div class="modal-body">
		  <div class="row">
			  <div class="col-xs-6">
            <img onclick="like(1)" src="img/emoticons/1.gif	" height=30px>&nbsp;
    		<img onclick="like(2)" src="img/emoticons/2.gif" height=30px>&nbsp;
    		<img onclick="like(3)" src="img/emoticons/3.gif" height=30px>&nbsp;
    		<img onclick="like(4)" src="img/emoticons/4.gif" height=30px>&nbsp;
    		<img onclick="like(5)" src="img/emoticons/5.gif" height=30px>&nbsp;
    		<img onclick="like(6)" src="img/emoticons/6.gif" height=30px>&nbsp;<br>
    		<img onclick="like(7)" src="img/emoticons/7.gif" height=30px>&nbsp;
    		<img onclick="like(8)" src="img/emoticons/8.gif" height=30px>&nbsp;
    		<img onclick="like(9)" src="img/emoticons/9.gif" height=30px>&nbsp;
    		<img onclick="like(10)" src="img/emoticons/10.gif" height=30px>&nbsp;
    		<img onclick="like(11)" src="img/emoticons/11.gif" height=30px>&nbsp;
    		<img onclick="like(12)" src="img/emoticons/12.gif" height=30px>&nbsp;<br>
    		<img onclick="like(13)" src="img/emoticons/13.gif" height=30px>&nbsp;
    		<img onclick="like(14)" src="img/emoticons/14.gif" height=30px>&nbsp;
    		<img onclick="like(15)" src="img/emoticons/15.gif" height=30px>&nbsp;
    		<img onclick="like(16)" src="img/emoticons/16.gif" height=30px>&nbsp;
    		<img onclick="like(17)" src="img/emoticons/17.gif" height=30px>&nbsp;
    		<img onclick="like(18)" src="img/emoticons/18.gif" height=30px>&nbsp;<br>
    		<img onclick="like(19)" src="img/emoticons/19.gif" height=30px>&nbsp;
    		<img onclick="like(20)" src="img/emoticons/20.gif" height=30px>&nbsp;
    		<img onclick="like(21)" src="img/emoticons/21.gif" height=30px>&nbsp;
    		<img onclick="like(22)" src="img/emoticons/22.gif" height=30px>&nbsp;
    		<img onclick="like(23)" src="img/emoticons/23.gif" height=30px>&nbsp;
    		<img onclick="like(24)" src="img/emoticons/24.gif" height=30px>&nbsp;
    	</div>
    	<div class="col-xs-6">
    		<div class="list-group">
    			<a href="#" class="list-group-item active">
    			  Privacy settings.
    			</a>
    			<a class="list-group-item"><input type="checkbox" id="privacy1"> Family</a>
    			<a class="list-group-item"><input type="checkbox" id="privacy2"> Close Friends</a>
    			<a class="list-group-item"><input type="checkbox" id="privacy3"> Normal Friends</a>
    		  </div>
    	</div>
		  </div>

      </div>
      <div class="modal-footer">
		  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button onclick="submit_like();" type="button" class="btn btn-primary" data-dismiss="modal">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for showing likes-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
  <div class="modal-content">
	<div class="modal-header">
	  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <h4 class="modal-title" id="myModalLabel">Like a post</h4>
	</div>
	<div class="modal-body">
		<div class="row">
			<div class="col-xs-2"></div>
			<div class="col-xs-8">
				<div class="list-group" id="listLikeModel">
				  <a class="list-group-item active">
				    Likes for this post
				  </a>
				  <a class="list-group-item">Dapibus ac facilisis in</a>
				  <a class="list-group-item">Morbi leo risus</a>
				  <a class="list-group-item">Porta ac consectetur ac</a>
				  <a class="list-group-item">Vestibulum at eros</a>
				</div>
			</div>
		</div>

	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	</div>
  </div>
</div>
</div>

	 </div>
	</div>
	<script>
	$('#myModal').on('shown.bs.modal', function () {
  $('#myInput').focus()
})
	</script>
</body>
</html>
