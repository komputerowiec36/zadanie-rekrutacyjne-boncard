<html>
    <head>
        <title>login</title>
        <meta charset="UTF-8">
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
	    <link href="index.css" rel="stylesheet">  
    </head>
    <body>
<div class="rectangle">
<div class="text">
<?php
if (isset($_POST['login']))
{
	
 $user = $_POST['user'];
 $password = $_POST['password'];
  if ($password == "" || $user == "") {
  echo "Incorrect username or password ";
}

 if ($password != "" && $user != "")
{
 $user = $_POST['user'];
 $password = $_POST['password'];
 $sq = mysqli_connect("localhost", "root","serwer12345*","boncard");
 if (!$sq)
 {
   echo 'Could not connect to database';
 }
 $res = mysqli_query($sq,"SELECT * FROM users WHERE login='$user';");
if (!$res) {
 echo "There was a problem with the database";
 mysqli_close($sq);
}

if(mysqli_num_rows($res) < 1) { 

 echo "Incorrect username or password";
 mysqli_close($sq);
 }
 
if(mysqli_num_rows($res) > 0) { 
$res1 = mysqli_query($sq,"SELECT * FROM users WHERE login='$user' and password='$password';");
if(mysqli_num_rows($res1) < 1) { 
 echo "Incorrect username or password";
 mysqli_close($sq);
}
if(mysqli_num_rows($res1) > 0) { 
$ip = $_SERVER['REMOTE_ADDR'];
$data = date('Y.m.d');
$godzina = date('H:i');
$res2 = mysqli_query($sq,"SELECT * FROM users WHERE login='$user';");
if(mysqli_num_rows($res2) < 1) { 
$res3 = mysqli_query($sq,"Insert into actives SET login='$user', ip='$ip', date='$data', time='$godzina';");
}
if(mysqli_num_rows($res2) > 0) {
$res4 = mysqli_query($sq,"DELETE FROM actives WHERE login ='{$user}';");
if($res4){
$res5 = mysqli_query($sq,"Insert into actives SET login='$user', ip='$ip', date='$data', time='$godzina';");
}
mysqli_close($sq);
header('Location: user.php');

}
} 
}
}
}

?>
</div>
  <form action="" method="POST" >
  <label for="login" >Login:</label><BR>
  <input type="text" id="user" name="user"><BR>
  <label for="password">Password:</label><BR>
  <input type="text" id="password" name="password"> <BR><BR>
  <input type = "Submit" name="login" Value ="login" />
 </form>
</div>
</body>
</html>