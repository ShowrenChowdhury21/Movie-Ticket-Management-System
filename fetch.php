<?php
//fetch.php
$db = mysqli_connect('localhost', 'root', '', 'movieticket');
$output = '';

if(isset($_POST["query"]))
{
     $search = mysqli_real_escape_string($db, $_POST["query"]);
     $query = "SELECT * FROM employee WHERE fname LIKE '%".$search."%' OR lname LIKE '%".$search."%'  OR id LIKE '%".$search."%' OR email LIKE '%".$search."%' OR phone LIKE '%".$search."%' OR gender LIKE '%".$search."%' OR salary LIKE '%".$search."%' OR address LIKE '%".$search."%'";
}
else
{
	$query = "SELECT * FROM employee";
}

$result = mysqli_query($db, $query);

if(mysqli_num_rows($result) > 0)
{
 $output .= '
    <div class="table-responsive">
     <table class="table table bordered" align="center" border="0px" width="1200px" height="200" style="margin-left:60px;">
         <tr align="center" bgcolor="#FEE12B">
             <th>Id</th>
             <th>First name</th>
             <th>Last name</th>
             <th>E-mail</th>
             <th>Phone Number</th>
             <th>Gender</th>
             <th>Designation</th>
             <th>Address</th>
             <th>Salary</th>
         </tr>
    ';
	
	while($row = mysqli_fetch_array($result))
	 {
	  $output .= '
	   <tr style="color: #FEE12B; background: black; text-align: center; 
    vertical-align: middle;">
		<td>'.$row["id"].'</td>
		<td>'.$row["fname"].'</td>
		<td>'.$row["lname"].'</td>
		<td>'.$row["email"].'</td>
		<td>'.$row["phone"].'</td>
		<td>'.$row["gender"].'</td>
		<td>'.$row["designation"].'</td>
		<td>'.$row["address"].'</td>
		<td>'.$row["salary"].'</td>
	   </tr>
	  ';
	}
	echo $output;
}
else
{
    $notif5 = "Data Not Found";
}
?>
