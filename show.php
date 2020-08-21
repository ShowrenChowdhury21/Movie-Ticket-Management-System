<?php
//show.php
$db = mysqli_connect('localhost', 'root', '', 'movieticket');
$output = '';

if(isset($_POST["query"]))
{
     $search = mysqli_real_escape_string($db, $_POST["query"]);
     $query = "SELECT * FROM shows WHERE mname LIKE '%".$search."%' OR date LIKE '%".$search."%' OR time LIKE '%".$search."%' OR id LIKE '%".$search."%' OR type LIKE '%".$search."%' OR price LIKE '%".$search."%'";
}
else
{
	$query = "SELECT * FROM shows";
}

$result = mysqli_query($db, $query);

if(mysqli_num_rows($result) > 0)
{
 $output .= '
    <div class="table-responsive">
     <table class="table table bordered" align="center" border="0px" width="1200px" height="200" style="margin-left:60px;">
         <tr align="center" bgcolor="#FEE12B">
             <th>Show ID</th>
             <th>Movie name</th>
             <th>Date</th>
             <th>Time</th>
             <th>Available Seats</th>
             <th>Type</th>
             <th>Ticket Price</th>
         </tr>
    ';
	
	while($row = mysqli_fetch_array($result))
	 {
	  $output .= '
	   <tr style="color: #FEE12B; background: black; text-align: center; 
    vertical-align: middle;">
		<td>'.$row["id"].'</td>
		<td>'.$row["mname"].'</td>
		<td>'.$row["date"].'</td>
		<td>'.$row["time"].'</td>
		<td>'.$row["seats"].'</td>
		<td>'.$row["type"].'</td>
		<td>'.$row["price"].'</td>
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
