<html>
    <head>
        <title>User Panel</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=100%, initial-scale=3">
		<link href="user.css"  rel="stylesheet">
    </head>
	<body>

<?php

$ip = $_SERVER['REMOTE_ADDR'];
$sq = mysqli_connect("localhost", "root","serwer12345*","boncard");
if (!$sq)

{
  echo 'Could not connect to database';
}
$res = mysqli_query($sq,"SELECT login FROM actives WHERE ip='$ip';");
if(mysqli_num_rows($res) < 1) { 
  echo "There was a problem with the database";
  mysqli_close($sq);
}
if(mysqli_num_rows($res) > 0) { 
  $user = mysqli_fetch_array($res)['login'];

  echo '<H1><center>',$user,' cards</center><H1><BR>';
}
$res1 = mysqli_query($sq,"SELECT * FROM cards WHERE login='$user';");
 
echo "<table border='1' id='table'>

<tr style= 'background-color:#d2d2d2'>

<th>Lp.</th>

<th>Card name</th>

<th>Card number</th>

<th>PIN</th>

<th>Activate date</th>

<th>Valid Date</th>

<th>Saldo</th>

</tr>";

 $i = 1;

while($row = mysqli_fetch_array($res1))

  {
  echo "<tr>";

  echo "<td>". $i ."</td>";

  echo "<td><div>". $row['name'] ."</div></td>";
  
  echo "<td><div>". $row['number'] ."</div></td>";

  echo "<td><div>". $row['pin'] ."</div></td>";
  
  echo "<td><div>". $row['activate'] ."</div></td>";
  
  echo "<td><div>". $row['valid'] ."</div></td>";
  
  echo "<td><div>". $row['saldo'] ."</div></td>";
  
  echo "</tr>";
  $i = $i +1;
  }


echo "</table>";

echo '<div style="position: absolute; left: 30.5cm; top: 19.9cm; font-size: 24px; color: red">';

if (isset($_POST['add']))
{
 $name = $_POST['name'];
 $number = $_POST['number'];
 $pin = $_POST['pin'];
 $activate="{$_POST['activate']} {$_POST['activate1']}";
 $valid = $_POST['valid'];
 $saldo = $_POST['saldo'];
 if ($name == "" || $number == "" || $pin == "" || $activate == "" || $valid == "" || $saldo == "") {
  echo "All fields must be filled<BR>";
  
}
 if (strlen($number) < 20 || strlen($number) > 20 || strlen($pin) < 4 || strlen($pin) > 4 || $saldo < 0) {
  echo "The form was filled in incorrectly<BR> ";
  
}
if (strlen($number) == 20|| strlen($pin) == 4 || $saldo > 0) {
  $res2 = mysqli_query($sq,"SELECT * FROM cards WHERE number='$number' and pin='$pin';");
  if(mysqli_num_rows($res2) > 0) { 
    echo "card with this data exists<BR>";
  }
  if(mysqli_num_rows($res2) < 1) { 
    $res3 = mysqli_query($sq,"SELECT id FROM cards ORDER BY id DESC LIMIT 1;");
    if(mysqli_num_rows($res3) < 1) { 
	   mysqli_query($sq,"Insert into cards SET id=1, name='$name', number='$number', pin='$pin', activate='$activate', valid='$valid', saldo='$saldo', login='$user';");
	   header("Refresh:0");
	}
	if(mysqli_num_rows($res3) > 0) { 
	  $id=mysqli_fetch_array($res3)['id'] + 1;
	  mysqli_query($sq,"Insert into cards SET id='$id', name='$name', number='$number', pin='$pin', activate='$activate', valid='$valid', saldo='$saldo', login='$user';");
	  header("Refresh:0");
	}
    
  }
 }

  mysqli_close($sq);
}
if (isset($_POST['edit']))
{
 $id = $_POST['id'];
 $name = $_POST['name'];
 $number = $_POST['number'];
 $pin = $_POST['pin'];
 $activate="{$_POST['activate']} {$_POST['activate1']}";
 $valid = $_POST['valid'];
 $saldo = $_POST['saldo'];
 if ($id == "" || $name == "" || $number == "" || $pin == "" || $activate == "" || $valid == "" || $saldo == "") {
  echo "All fields must be filled<BR> ";
  
}
 if (strlen($number) < 20 || strlen($number) > 20 || strlen($pin) < 4 || strlen($pin) > 4 || $saldo < 0) {
  echo "The form was filled in incorrectly<BR> ";
  
}
 if (strlen($id) > 0 and strlen($number) == 20 and strlen($pin) == 4 and $saldo > 0) {
   
   mysqli_query($sq,"Update cards SET name='$name', number='$number', pin='$pin', activate='$activate', valid='$valid', saldo='$saldo', login='$user' Where id='$id';");
   header("Refresh:0");
 }
  mysqli_close($sq);
}
if (isset($_POST['delete']))
{
 $name = $_POST['name'];
 $number = $_POST['number'];
 $pin = $_POST['pin'];
 $activate="{$_POST['activate']} {$_POST['activate1']}";
 $valid = $_POST['valid'];
 $saldo = $_POST['saldo'];
 if ($name == "" || $number == "" || $pin == "" || $activate == "" || $valid == "" || $saldo == "") {
  echo "All fields must be filled<BR> ";
  
}
 if (strlen($number) < 20 || strlen($number) > 20 || strlen($pin) < 4 || strlen($pin) > 4 || $saldo < 0) {
  echo "The form was filled in incorrectly<BR> ";
  
}
 if (strlen($number) == 20|| strlen($pin) == 4 || $saldo > 0) {
  mysqli_query($sq,"DELETE FROM Cards WHERE name='$name'and number='$number' and pin='$pin' and activate='$activate' and valid='$valid' and saldo='$saldo' and login='$user';");
  header("Refresh:0");
 }
  mysqli_close($sq);
}
if (isset($_POST['logout']))
{
 $res4 = mysqli_query($sq,"SELECT * FROM actives WHERE ip='$ip';");
 if(mysqli_num_rows($res4) < 1) { 
  echo "There was a problem with the database";
}
 if(mysqli_num_rows($res4) > 0) {
  mysqli_query($sq,"DELETE FROM actives WHERE login ='{$user}';");
  header('Location: index.php');
}
}
echo "</div>";
?>
<div class="rectangle">
<form action="" method="POST">
 <H2>User panel<H2><BR>
 <label for="id" >Card id:</label><BR>
<select name="id" style="width: 40px; height: 25px;">
  <option value=""></option>
  <?php
  $sq = mysqli_connect("localhost", "root","serwer12345*","boncard");
  $res = mysqli_query($sq,"SELECT id FROM cards;");
  while($row = mysqli_fetch_array($res))
  {
   echo"<option value=".$row['id'].">". $row['id'] ."</option>";
  }
  ?>
</select>(Choose the card ID to edit)<BR><BR>
 <label for="name" >name:</label><BR>
 <input type="text" id="name" name="name"><BR><BR>
 <label for="number">number:</label><BR>
 <input type="number" id="number" name="number" min=0><BR><BR>
 <label for="PIN">pin:</label><BR>
 <input type="number" id="pin" name="pin" min=0><BR><BR>
 <label for="activate">activation date:</label><BR>
 <input type="date" id="activate" name="activate">
 <input type="time" id="activate1" name="activate1"><BR><BR>
 <label for="valid">valid date:</label><BR>
 <input type="date" id="valid" name="valid"><BR><BR>
 <label for="saldo" >saldo:</label><BR>
 <input type="number" id="saldo" name="saldo" min=0><BR><BR>
<input type = "Submit" style="width: 100px; height: 25px;" name="add" Value ="add" />
<input type = "Submit" style="width: 100px; height: 25px;"name="edit" Value ="edit" />
<input type = "Submit" style="width: 100px; height: 25px;" name="delete" Value ="delete" /><BR>
<input type = "Submit" style="width: 100px; height: 25px;" name="logout" value="logout" id='logout' />
</form>
</div>
</body>
</html>

