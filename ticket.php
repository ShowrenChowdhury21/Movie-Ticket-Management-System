<?php 

require_once __DIR__ . '/vendor/autoload.php';

$movie = $_POST["movie"];
$date  = $_POST["date"];
$time = $_POST["time"];
$hall = $_POST["seattype"];
$noofs = $_POST["noofseats"];


$mpdf = new \Mpdf\Mpdf();

$data = "";

$data .= " <div class='box' style='margin:0px auto;margin-top:80px;background:#FFF9EE url(https://subtlepatterns.com/patterns/lightpaperfibers.png);color:#333;text-transform:uppercase;padding:8px;width:1200px;font-weight:bold;text-shadow:0px 1px 0px #fff;font-family:'arvo';font-size: 11px;border-left: 1px dashed rgba(51, 51, 51, 0.5);-webkit-filter: drop-shadow(0 5px 18px #000);'>
        <div class='inner' style='border: 2px dashed rgba(51, 51, 51, 0.5); height:200px; padding:8px; '>
        <h1 style='padding:5px 0px;margin:0px;font-size:18px;border-bottom: 1px solid rgba(51, 51, 51, 0.3);text-align:center;background: yellow;'>Movie Club</h1>
        <div class='info clearfix' style='width:100%;margin-top:5px; content: '.';display: block;height: 0;clear: both;visibility: hidden;margin-right: 50px;'>
            <div class='wp' style='float: left;padding: 5px;width: 83px;text-align: center;margin-right: 50px;'>Movie: <h2>".$movie."</h2></div>
            <div class='wp' style='float: right;padding: 5px;width: 83px;text-align: center;margin-right: 50px;'>Date:<h2>".$date."</h2></div>
            <div class='wp' style='float: right;padding: 5px;width: 83px;text-align: center;margin-right: 50px;'>Time: <h2>".$time. "</h2></div>
            <div class='wp' style='float: right;padding: 5px;width: 83px;text-align: center;margin-right: 50px;'>Hall: <h2>".$hall."</h2></div>
            <div class='wp' style='float: right;padding: 5px;width: 83px;text-align: center;'>Total Seats: <h2>".$noofs."</h2></div>
            <div class='wp' style='float: right;padding: 5px;width: 83px;text-align: center;'>PAID</div>
        </div>
        </div>
    </div>";

$mpdf->WriteHTML($data);
$mpdf->Output('ticket.pdf','D');

?>


 
 