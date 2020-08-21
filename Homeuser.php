<!DOCTYPE html>
<?php
session_start(); 
  if (!isset($_SESSION['fname'])) 
  {
  	header('location: login.php');
  }
  if (isset($_GET['Logout'])) 
  {
  	session_destroy();
  	unset($_SESSION['fname']);
  	header("location: login.php");
  }
  if(isset($_SESSION["fname"]))
  {
     if((time() - $_SESSION['last_time']) > 180) // Time in Seconds
     {
        session_destroy();
  	    unset($_SESSION['fname']);
  	    header("location: login.php");
     }
     else
     {
        $_SESSION['last_time'] = time();
     }
  }
?>
<html>
<style>
    #runningshows {
    height: 790px;
    top: 165px;
    display: inline-block;
    width: 100%;
}  
    
    #bookseat {
    background-color: #FEE12B;
    border: none;
    color: black;
    font-family: Mukta;
    font-weight: bold;
    padding: 10px 30px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 18px;
    margin-left: 450px;
    margin-top: 80px;  
}

#bookseat:hover {
    transform: scale(1.1);
}
    
   #confirm {
    background-color: #FEE12B;
    border: none;
    color: black;
    font-family: Mukta;
    font-weight: bold;
    padding: 10px 30px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 18px;
    margin-top: 30px;
    margin-left: 350px;
    width: 42%;
}

#confirm:hover {
    transform: scale(1.1);
} 
    
.poster img
{
    transition: .5s;
    cursor: pointer;
    box-shadow: 0px 0px 20px #fff;
} 
    
.seatcontainer {
  perspective: 1000px;
  margin-bottom: 30px;
}

.seatbook {
  background-color: #444451;
  height: 25px;
  width: 38px;
  margin: 3px;
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
}

.seatbook.selected {
  background-color: yellow;
}

.seatbook.occupied {
  background-color: #fff;
}

.seatbook:not(.occupied):hover {
  cursor: pointer;
  transform: scale(1.2);
}

.seatbook:nth-of-type(2) {
  margin-right: 25px;
}

.seatbook:nth-last-of-type(2) {
  margin-left: 25px;
}
.seatshowcase .seatbook:not(.occupied):hover {
  cursor: default;
  transform: scale(1);
}
  
 input[type=checkbox] 
  {
    position: absolute;
    opacity: 0;
  }
    
  input[type=checkbox]:checked {
      background: yellow;      
    }
    
  input[type=checkbox]:disabled {
      background: #fff;
      overflow: hidden;
      &:after {
        content: "X";
        text-indent: 0;
        position: absolute;
        top: 4px;
        left: 50%;
        transform: translate(-50%, 0%);
      }
      &:hover {
        box-shadow: none;
        cursor: not-allowed;
      }
  }
    
.row {
  display: flex;
  background: none;
  padding: 0 10px;
  margin-left: 140px;
}
   
.seatshowcase {
  background: rgba(0, 0, 0, 0.1);
  padding: 5px 10px;
  border-radius: 5px;
  color: #777;
  list-style-type: none;
  display: flex;
  justify-content: space-between;
}

.seatshowcase li {
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 10px;
}

.seatshowcase li small {
  margin-left: 2px;
}


.showscreen {
  background-color: #D3D3D3;
  height: 70px;
  width: 100%;
  margin: 15px 0;
  transform: rotateX(-45deg);
  box-shadow: 0 3px 10px rgba(255, 255, 255, 0.7);
}

p.text {
    
  margin: 5px 0;
  color: white;
  margin-left: 180px;
}

p.text span {
  color: yellow;
}
 
.seatpattern {
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  height: 100%;
  width: 80%;
  overflow: auto;
  margin-left: 200px;
  margin-top: 120px;
    
}
    
.paymentpop {
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  height: 100%;
  width: 80%;
  overflow: auto;
  margin-left: 150px;
  margin-top: 120px;
    
}


.modal-content {
  margin: 10% auto;
  width: 60%;
  height:  auto;
  animation-name: modalopen;
  animation-duration: var(--modal-duration);
}
    
.modal-header h2,
.modal-footer h3 {
  margin: 0;
}

.modal-header {
  background: black;
  padding: 15px;
  color: yellow;
  border-top-left-radius: 5px;
  border-top-right-radius: 5px;
}

.modal-body {
  padding: 10px 20px;
  background: black;
}

.close {
  color: #ccc;
  float: right;
  font-size: 40px;
  color: #fff;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
    
.closepayment {
  color: #ccc;
  float: right;
  font-size: 40px;
  color: #fff;
}

.closepayment:hover,
.closepayment:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

@keyframes modalopen {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

</style>

<head>
    <title>Home User</title>
    <link rel="stylesheet" href="styleuser.css">
    <link href="https://fonts.googleapis.com/css?family=Mukta|Roboto|Trade+Winds|Rubik&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body onload="onLoaderFunc()" style="overflow:hidden">
   
   <?php
            ob_start();
            $db = mysqli_connect('localhost', 'root', '', 'movieticket');
    
            error_reporting(0);
            $name = $_SESSION['fname'];
    
            $er_movie = "";
            $movie = "";
            $er_date = "";
            $date = "";
            $er_time = "";
            $time = "";
            $er_type = "";
            $type = "";
            $er_cphone = "";
            $cphone = "";
            $nofseats = "";
            $er_nofseats= "";
    
            $totalprice = 0;
            $seath = 0;
            $cost = 0;
    
            $errors = array();
            
                if(isset($_POST['confirm']))
                {
                    if(empty($_POST["movie"]))
                    {
                        $er_movie = "Movie name required";
                        array_push($errors, "Movie name required");
                    }
                    else
                    {
                        $movie = validate_input($_POST["movie"]);
                    }
                    
                    if(empty($_POST["date"]))
                    {
                        $er_date = "Date required";
                        array_push($errors, "Date required");
                    }
                    else
                    {
                            $date = validate_input($_POST["date"]);
                    }

                    if(empty($_POST["time"]))
                    {
                         $er_time = "Show Timee required";
                         array_push($errors, "Show Timee required");
                        
                    }
                    else
                    {
                        $time = validate_input($_POST["time"]);
                    }
                
                    if(empty($_POST["seattype"]))   
                    {
                        $er_type = "Type requirted";
                        array_push($errors, "Type requirted");
                    }
                    else
                    {
                        
                        $type = validate_input($_POST["seattype"]);
                    }

                    if(empty($_POST["phoneno"]))
                    {
                        $er_cphone = "Phone required";
                        array_push($errors, "Phone required");
                    }
                    else
                    {
                        
                        if(!preg_match('/^[0]{1}[1]{1}[1-9]{1}[0-9]{8}$/', $_POST["phoneno"]))
                        {
                             $er_cphone = "Invalid Phone";
                             array_push($errors, "Invalid Phone");
                        }
                        else
                        {
                            $cphone = validate_input($_POST["phoneno"]);
                        }
                    }
                    if(empty($_POST["noofseats"]))
                    {
                        $er_nofseats = "Field required";
                        array_push($errors, "Field required");
                    }
                    else
                    {
                        $nofseats = validate_input($_POST["noofseats"]);

                    }
                    
                    if(isset($_POST['confirmbooking']) && $_POST['confirmbooking']!="")
                    {
                        $e1 = 1; 
                    }
                    else
                    {
                        $check = "You must have to pay and confirm this booking !!";
                        echo "<script type='text/javascript'>alert('$check');</script>";
                        array_push($errors, "required");
                        
                    }

                        $check_query = "SELECT * FROM shows WHERE mname='$movie' AND date='$date' AND time='$time' AND type='$type'";
                        $resultb = mysqli_query($db, $check_query);
                        $bookings = mysqli_num_rows($resultb);
                        
                        if($resultb)
                        {
                            if(mysqli_num_rows($resultb))
                            {
                                while($row = mysqli_fetch_array($resultb))
                                {
                                     $seath = $row['seats'];
                                     $cost = $row['price'];
                                }
                            }
                        }
                    
                
                        $totalprice = $cost * $nofseats;
                        $remseats = $seath - $nofseats;

                        if ($bookings) 
                        {
                            $numErrorsh = count($errors);
                           
                            if ($numErrorsh == 0) 
                            {
                                if($remseats >= $nofseats)
                                {
                                     $insertbook = "INSERT INTO booking(fname,phone,mname,date,time,type,seats,price) VALUES('$name','$cphone','$movie','$date','$time','$type','$nofseats','$totalprice')";  
                                     $bquery = mysqli_query($db, $insertbook); 

                                     $b = "Congratulation!! Booking Complete";
                                     echo "<script type='text/javascript'>alert('$b');</script>";

                                        
                                
                                     $update_Query = "UPDATE `shows` SET `seats`= '$remseats' WHERE mname='$movie' AND date='$date' AND time='$time' AND type='$type'";
                                     $update_Result = mysqli_query($db, $update_Query);
                                }
                                else
                                {
                                    $notu = "Not Enough Seats!! Check Running Shows!!";
                                    echo "<script type='text/javascript'>alert('$notu');</script>";
                                }
                               
                            }
                        }
                        else
                        {   
                           $notsh = "Please check running shows and choose accordingly!!";
                           echo "<script type='text/javascript'>alert('$notsh');</script>"; 
                                
                        }
                    }
                
                if(isset($_POST['ChangePassowrd']))
                {
                    $oldpass = md5($_POST['opwd']);
                    $newpassword = md5($_POST['cpwd']);
                    
                    $sqlcp=mysqli_query($db,"SELECT * FROM login where fname='" . $_SESSION["fname"] . "'");
                    $rowcp = mysqli_fetch_array($sqlcp);
                    
                    if ($oldpass == $rowcp["password"])
                    {
                        mysqli_query($db, "UPDATE login set password ='$newpassword' WHERE fname = '" . $_SESSION["fname"] . "'");
                        
                        $notip2p = "Password Changed";
                        echo "<script type='text/javascript'>alert('$notip2p');</script>";
                    } 
                    else
                    {
                       $notip2p = "Current password in not currect!";
                       echo "<script type='text/javascript'>alert('$notip2p');</script>";
                    
                    }
                }
                
    
               function validate_input($data)
               {
                  $data = trim($data);
                  $data = stripslashes($data);
                  $data = htmlspecialchars($data);
                  return $data;
               }
    
    ?>
    
    <header class="showcase">
        <label class="logo">Movie Club </label>
    </header>
    <input type="checkbox" id="check">
    <label for="check">
        <i class="fas fa-bars" id="btn00"></i>
        <i class="fas fa-times" id="cancel"></i>
    </label>
    <div class="sidebar">
        <header class="dashboard">Dashboard</header>
        <ul>
            <li><a href="#home"><i class="fas fa-qrcode"></i>Home</a></li>
            <li><a href="#bookticket"><i class="fas fa-calendar-week"></i>Book Ticket</a></li>
            <li><a href="#runningshows"><i class="fas fa-calendar-week"></i>Running Shows</a></li>
            <li><a href="#about"><i class="far fa-question-circle"></i>About</a></li>
            <li><a href="#contact"><i class="far fa-envelope"></i>Contact</a></li>
            <li><a href="#profile"><i class="fas fa-id-card"></i>Profile</a></li>
            <li><a href="#settings"><i class="fas fa-cogs"></i>Settings</a></li>
        </ul>
        <br>
        <ul id="ul2">

               <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
        </ul>
    </div>
    <section>
        <form name="user" method="post" action="#" >
            
            <div id="home">
                <h4 style="margin-top: 250px;">Welcome <br><strong><?php echo $_SESSION['fname']; ?></strong></h4>
                <h4 style="font-size: 30px;">First Check Running Shows and then Book your seats accordingly.</h4>
            </div>
            <div id="bookticket">
                <table style="margin-top: 160px;" cellspacing=25px; id="inputtable">
                    <tr>
                        <td>
                            <h1 style="margin-left: 100px;color: yellow;letter-spacing: 5px;">Movie</h1>
                            <div class="select" style="margin-left: 260px; margin-top: -40px;">
                                <select name='movie' id='movie' onchange="getwords()">
                                      <?php 
                                        $sshow = "select DISTINCT mname from shows";
                                        $rsshow =  $db->query($sshow);
                                            echo "<option value=''>Select Movie</option>";

                                            while ($selectshow = $rsshow->fetch_row())
                                            {
                                                for($i = 0; $i < $rsshow->field_count; $i++)
                                                {
                                                     echo '<option value="'.$selectshow[$i].'">'.$selectshow[$i].'</option>';
                                                }
                                            }                          
                                      ?>
                                </select>
                            </div>
                            <span id="span1" style="color: white; margin-left: 250px;"><?php echo $er_movie;?></span>
                        </td>
                        <td>
                            <div class="date">
                                <label for="date" style="margin-left:50px;font-family:'Mukta'; font-size:30px;color: yellow;letter-spacing: 5px;">Date</label>                                
                                <div class="select" style="margin-left: 155px;margin-top: -50px; margin-bottom: 10px;">
                                    <select name='date' id='date'>
                                      <?php 
                                        $sdshow = "select DISTINCT date from shows";
                                        $rsdshow =  $db->query($sdshow);
                                            echo "<option value=''>Select Date</option>";

                                            while ($selectdshow = $rsdshow->fetch_row())
                                            {
                                                for($i = 0; $i < $rsdshow->field_count; $i++)
                                                {
                                                     echo '<option value="'.$selectdshow[$i].'">'.$selectdshow[$i].'</option>';
                                                }
                                            }                          
                                      ?>
                                  </select>
                                </div> 
                            </div>
                            <span id="span1" style="color: white; margin-left: 150px;"><?php echo $er_date;?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h1 style="margin-left: 100px;color: yellow;letter-spacing: 5px;">Time</h1>
                            <div class="select" style="margin-left: 260px;margin-top: -40px;">
                                <select name='time' id='time'>
                                      <?php 
                                        $stshow = "select DISTINCT time from shows";
                                        $rstshow =  $db->query($stshow);
                                            echo "<option value=''>Select Time</option>";

                                            while ($selecttshow = $rstshow->fetch_row())
                                            {
                                                for($i = 0; $i < $rstshow->field_count; $i++)
                                                {
                                                     echo '<option value="'.$selecttshow[$i].'">'.$selecttshow[$i].'</option>';
                                                }
                                            }                          
                                      ?>
                                  </select>
                            </div>
                            <span id="span1" style="color: white; margin-left: 250px;"><?php echo $er_time;?></span>
                        </td>
                        <td>
                            <h1 style="margin-left: 50px;color: yellow;letter-spacing: 5px;">Seats</h1>
                            <div class="select" style="margin-left: 155px;margin-top: -40px;">
                                <select id="seats" name="noofseats">
                                    <option value="">Select No of seats(Max: 5)</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <span id="span1" style="color: white; margin-left: 150px;"><?php echo $er_nofseats;?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h1 style="margin-left: 100px;color: yellow;letter-spacing: 5px;">Seat Type</h1>
                            <div class="select" style="margin-left: 260px;margin-top: -30px;">
                                <select name='seattype' id='seattype'>
                                      <?php 
                                        $sttype = "select DISTINCT type from shows";
                                        $rstshowt =  $db->query($sttype);
                                            echo "<option value=''>Select Seat Type</option>";

                                            while ($selecttstype = $rstshowt->fetch_row())
                                            {
                                                for($i = 0; $i < $rstshowt->field_count; $i++)
                                                {
                                                     echo '<option value="'.$selecttstype[$i].'">'.$selecttstype[$i].'</option>';
                                                }
                                            }                          
                                      ?>
                                  </select>
                            </div>
                            <span id="span1" style="color: white; margin-left: 250px;"><?php echo $er_type;?></span>
                    </tr>
                    <tr>
                      <td>
                          <h1 style="margin-left: 100px;color: yellow;letter-spacing: 5px;">Phone Number:</h1>
                        </td>
                           <td>
                            <div class="textbox1" style="width: 80%; margin-left: -180px;margin-top: 10px;">
                               <input type="text" name="phoneno" id="phoneno" placeholder="Enter your valid phone number" value="<?php //echo $showid;?>">
                           </div>
                           <span id="span1" style="color: white;"><?php echo $er_cphone;?></span>
                      </td>
                    </tr>
                </table>
                  <div id="seatpattern" class="seatpattern">
                      <div class="modal-content">
                          <div class="modal-header">
                              <span class="close">&times;</span>
                              <h2>Book Seat</h2>
                          </div>
                          <div class="modal-body">
                              <ul class="seatshowcase">
                                  <li>
                                      <div class="seatbook"></div>
                                      <small>Available</small>
                                  </li>
                                  <li>
                                      <div class="seatbook selected"></div>
                                      <small>Selected</small>
                                  </li>
                                  <li>
                                      <div class="seatbook occupied"></div>
                                      <small>Occupied</small>
                                  </li>
                              </ul>
                              <div class="seatcontainer" >
                                  <div class="showscreen"></div>
                                  <div class="row">
                                       <li class="seatbook" >
                                          <input type="checkbox" id="1A" />
                                      </li>
                                      <li class="seatbook">
                                          <input type="checkbox" id="1B" />
                                      </li>
                                      <li class="seatbook">
                                          <input type="checkbox" id="1C" />
                                      </li>
                                      <li class="seatbook">
                                          <input type="checkbox" id="1D" />
                                      </li>
                                      <li class="seatbook">
                                          <input type="checkbox" id="1E" />
                                      </li>
                                      <li class="seatbook">
                                          <input type="checkbox" id="1F" />
                                      </li>
                                      <li class="seatbook">
                                          <input type="checkbox" id="1G" />
                                      </li>
                                      <li class="seatbook">
                                          <input type="checkbox" id="1H" />
                                      </li>
                                  </div>
                                  
                                  <div class="row">
                                          <li class="seatbook">
                                              <input type="checkbox" id="2A" />
                                          </li>
                                          <li class="seatbook">
                                              <input type="checkbox" id="2B" />
                                          </li>
                                          <li class="seatbook">
                                              <input type="checkbox" id="2C" />
                                          </li>
                                          <li class="seatbook">
                                              <input type="checkbox" id="2D" />
                                          </li>
                                          <li class="seatbook">
                                              <input type="checkbox" id="2E" />
                                          </li>
                                          <li class="seatbook">
                                              <input type="checkbox" id="2F" />
                                          </li>
                                          <li class="seatbook">
                                              <input type="checkbox" id="2G" />
                                          </li>
                                          <li class="seatbook">
                                              <input type="checkbox" id="2H" />
                                          </li>
                                  </div>
                                  <div class="row">
                                          <li class="seatbook">
                                              <input type="checkbox" id="3A" />
                                          </li>
                                          <li class="seatbook">
                                              <input type="checkbox" id="3B" />
                                          </li>
                                          <li class="seatbook">
                                              <input type="checkbox" id="3C" />
                                          </li>
                                          <li class="seatbook">
                                              <input type="checkbox" id="3D" />
                                          </li>
                                          <li class="seatbook">
                                              <input type="checkbox" id="3E" />
                                          </li>
                                          <li class="seatbook">
                                              <input type="checkbox" id="3F" />
                                          </li>
                                          <li class="seatbook">
                                              <input type="checkbox" id="3G" />
                                          </li>
                                          <li class="seatbook">
                                              <input type="checkbox" id="3H" />
                                          </li>
                                  </div>
                                  <div class="row">
                                          <li class="seatbook">
                                              <input type="checkbox" id="4A" />
                                          </li>
                                          <li class="seatbook">
                                              <input type="checkbox" id="4B" />
                                          </li>
                                          <li class="seatbook">
                                              <input type="checkbox" id="4C" />
                                          </li>
                                          <li class="seatbook">
                                              <input type="checkbox" id="4D" />
                                          </li>
                                          <li class="seatbook">
                                              <input type="checkbox" id="4E" />
                                          </li>
                                          <li class="seatbook">
                                              <input type="checkbox" id="4F" />
                                          </li>
                                          <li class="seatbook">
                                              <input type="checkbox" id="4G" />
                                          </li>
                                          <li class="seatbook">
                                              <input type="checkbox" id="4H" />
                                          </li>
                                  </div>
                                  <div class="row">
                                          <li class="seatbook">
                                              <input type="checkbox" id="5A" />
                                          </li>
                                          <li class="seatbook">
                                              <input type="checkbox" id="5B" />
                                          </li>
                                          <li class="seatbook">
                                              <input type="checkbox" id="5C" />
                                          </li>
                                          <li class="seatbook">
                                              <input type="checkbox" id="5D" />
                                          </li>
                                          <li class="seatbook">
                                              <input type="checkbox" id="5E" />
                                          </li>
                                          <li class="seatbook">
                                              <input type="checkbox" id="5F" />
                                          </li>
                                          <li class="seatbook">
                                              <input type="checkbox" id="5G" />
                                          </li>
                                          <li class="seatbook">
                                              <input type="checkbox" id="5H" />
                                          </li>
                                  </div>
                              </div>
                              <p class="text">
                                  You have selected <span id="noofseats">0</span> seats.
                              </p>
                          </div>
                      </div>
                  </div>
                  <div id="payment" class="paymentpop" >
                      <div class="modal-content">
                          <div class="modal-header">
                              <span class="closepayment">&times;</span>
                              <div>
                                 <h3 style="color: white; margin-left: 50px;">Please pay required amount through bKash to confirm Booking!!</h3>
                             </div>
                             <br><br>
                             <span> <input type="radio" name="confirmbooking" value="confirmed" style="margin-left:220px;">I Confirm My booking</span>
                          </div>
                          <div class="modal-body">
                              <div class="poster" style=" height: 250px; width: 250px; margin-left: 200px; object-fit: fill;">
                                  <img src="images/payment.png" alt="" style='width:100%'>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="buttonsforbook">
                     <input type="button" id="bookseat" name="bookseat" value="Book Seats" onclick="takeData()">
                     <input type="button" id="makepayment" style="margin-left : 20px; " name="makepayment" value="Make Payment"> 
                  </div>
                  
                  <input type="submit" id="confirm" name="confirm" value="Confirm">
            </div>                  
                
            <div id="runningshows">
                <div>
                        <input type="text" style="padding: 10px;font-size: 17px;border: none;float: left; color: black;background-color: #FEE12B; margin-top: 180px; margin-left: 62px; width: 93%; border-radius: 25px; border-bottom-width: 15px;" name="search_show" id="search_show" placeholder="Search by Show Details" />
                    </div>
                    <br />
                    <div>
                        <div id="resultshow"></div>
                    </div>
            </div>
            <div id="about">
                <p style="margin-top: 280px; margin-left: 150px; margin-right: 150px; align=center">What we do is make people happy, but who we are is a small team of curious people. Curious about your happiness, what makes you special, what you’re experts in. We want to know the what, the why, the how–pick your brain and turn the findings into happiness.<br><br>
                    We’ve spent the past five years learning about movies and happiness, new and old, local and abroad. Our passion is to take what we earn from you happiness and turn that into our goal that can accomplish anything.</p>
            </div>
            <div id="contact">
                <h4>
                    <div class="card">
                        <br><br>
                        <h1><i class="far fa-envelope w3-text-teal" style="font-size:60px"></i></h1>
                        <br><br>
                        <hr color="black" style="width: 100%">
                        <br><br><br><br>
                        <table style="width:100%; font-size:17px; text-align: left;letter-spacing: 2px;margin-left: 20px;" cellspacing="12">
                            <tr>
                                <tH>E-mail:</tH>
                                <td>Info.mclub.com</td>
                            </tr>
                            <tr>
                                <tH>Phone:</tH>
                                <td>+01800000000</td>
                            </tr>
                            <tr>
                                <tH>Location:</tH>
                                <td>Dhaka Bangladesh</td>
                            </tr>
                            <tr>
                                <tH>Facebook:</tH>
                                <td>facebook.com/movieclub</td>
                            </tr>
                            <tr>
                                <tH>LinkedIn:</tH>
                                <td>Movie Club</td>
                            </tr>
                        </table>
                    </div>
                </h4>
            </div>
            <div id="profile">
                <h4>
                    <div class="card">
                        <br><br>
                        <h1><i class="fas fa-id-card w3-text-teal" style="font-size:50px"></i></h1>
                        <br><br>
                        <hr color="black" style="width: 100%">
                        <table style="width:100%; font-size:17px; text-align: left;letter-spacing: 2px;margin-left: 20px;">
                            <tr>
                                <tH>Id:</tH>
                                <td>
                                    <div class="textbox"><input type="text" value="<?php echo $_SESSION['id']; ?>" name="profileid" disabled></div>
                                </td>
                            </tr>
                            <br>
                            <tr>
                                <tH>Name:</tH>
                                <td>
                                    <div class="textbox"><input type="text" value="<?php echo $_SESSION['fname']; ?>" name="profilename" disabled></div>
                                </td>
                            </tr>
                            <br>
                            <tr>
                                <tH>E-mail:</tH>
                                <td>
                                    <div class="textbox"><input type="text" value="<?php echo $_SESSION['email']; ?>" name="profileemail" disabled></div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </h4>
            </div>
            <div id="settings">
                <h4>
                    <div class="card">
                        <br><br>
                        <h1><i class="fas fa-cogs w3-text-teal" style="font-size:50px"></i></h1>
                        <br><br>
                        <hr color="black" style="width: 100%">
                        <table style="width:100%; font-size:17px; text-align: left;letter-spacing: 2px;margin-left: 20px;">
                            <tr>
                                <tH style="font-size: 13px;">Current Password:</tH>
                                <td>
                                    <div class="textbox"><input style="font-size: 13px;" type="text" placeholder="Current Password" name="opwd" id="opwd"></div>
                                </td>
                            </tr>
                            <br>
                            <tr>
                                <tH style="font-size: 13px;">New Password:</tH>
                                <td>
                                    <div class="textbox"><input style="font-size: 13px;" type="text" placeholder="New Password" name="npwd" id="npwd"></div>
                                </td>
                            </tr>
                            <br>
                            <tr>
                                <tH style="font-size: 13px;">Confirm Password:</tH>
                                <td>
                                    <div class="textbox"><input style="font-size: 13px;" type="text" placeholder="Confirm Password" name="cpwd" id="cpwd"></div>
                                </td>
                            </tr>
                        </table>
                        <br><br><br>
                        <tr>
                            <input type="submit" name="ChangePassowrd" value="Change Passowrd" id="btneditpass" onClick="return validatePassword()">
                        </tr>
                    </div>
                </h4>
            </div>
        </form>
    </section>
</body>

</html>

<script>
    $(document).ready(function()
    {
        load_data();

            function load_data(query)
            {
                $.ajax({
                url:"show.php",
                method:"POST",
                data:{query:query},
                success:function(data)
                {
                    $('#resultshow').html(data);
                }
                });
                }
                $('#search_show').keyup(function(){
                var search = $(this).val();
                if(search != '')
                {
                    load_data(search);
                }
                else
                {
                    load_data();
                }
            });
    });
    
const modal = document.querySelector('#seatpattern');
const modalBtn = document.querySelector('#bookseat');
const closeBtn = document.querySelector('.close');

// Events
modalBtn.addEventListener('click', openModal);
closeBtn.addEventListener('click', closeModal);
window.addEventListener('click', outsideClick);

// Open
function openModal() {
  modal.style.display = 'block';
}

// Close
function closeModal() {
  modal.style.display = 'none';
}

// Close If Outside Click
function outsideClick(e) {
  if (e.target == modal) {
    modal.style.display = 'none';
  }
}
</script>



<script>
const modalpm = document.querySelector('#payment');
const modalBtnpm = document.querySelector('#makepayment');
const closeBtnpm = document.querySelector('.closepayment');

// Events
modalBtnpm.addEventListener('click', openModalpm);
closeBtnpm.addEventListener('click', closeModalpm);
window.addEventListener('click', outsideClickpm);

// Open
function openModalpm() {
  modalpm.style.display = 'block';
}

// Close
function closeModalpm() {
  modalpm.style.display = 'none';
}

// Close If Outside Click
function outsideClickpm(e) {
  if (e.target == modalpm) {
    modalpm.style.display = 'none';
  }
}
</script>


<!--seat book-->

<script>
const container = document.querySelector('.seatcontainer');
const seats = document.querySelectorAll('.row .seatbook:not(.occupied)');
const count = document.getElementById('noofseats');
const price = document.getElementById('seatprice');


const populateUI = () => {
  const selectedSeats = JSON.parse(localStorage.getItem('selectedSeats'));

  if (selectedSeats !== null && selectedSeats.length > 0) {
    seats.forEach((seat, index) => {
      if (selectedSeats.indexOf(index) > -1) {
        seat.classList.add('selected');
      }
    });
  }

  const selectedMovieIndex = localStorage.getItem('selectedMovieIndex');
  const selectedMoviePrice = localStorage.getItem('selectedMoviePrice');

  if (selectedMovieIndex !== null) {
    movieSelect.selectedIndex = selectedMovieIndex;
  }

  if (selectedMoviePrice !== null) {
    count.innerText = selectedSeats.length;
    price.innerText = selectedSeats.length * +selectedMoviePrice;
  }
};


const updateSelectedSeatsCount = () => {
const selectedSeats = document.querySelectorAll('.row .selected');

  const seatsIndex = [...selectedSeats].map(seat => [...seats].indexOf(seat));

  localStorage.setItem('selectedSeats', JSON.stringify(seatsIndex));

  const selectedSeatsCount = selectedSeats.length;

  count.innerText = selectedSeatsCount;
  price.innerText = selectedSeatsCount * ticketPrice;
};

    
    
// Seat select event
container.addEventListener('click', e => {
  if (
    e.target.classList.contains('seatbook') &&
    !e.target.classList.contains('occupied')
  ) {
    e.target.classList.toggle('selected');

    updateSelectedSeatsCount();
  }
});
</script>



<script>
    function validatePassword() 
    {
        var oldPassword, newPassword, confirmPassword, output = true;

        oldPassword = document.user.opwd;
        newPassword = document.user.npwd;
        confirmPassword = document.user.cpwd;

        if(!oldPassword.value) {
        oldPassword.focus();
        alert("Current Password Required");
        output = false;
        }
        else if(!newPassword.value) {
        newPassword.focus();
        alert("New Password Required");
        output = false;
        }
        else if(!confirmPassword.value) {
        confirmPassword.focus();
        alert("Confirm Password Required");
        output = false;
        }
        if(newPassword.value != confirmPassword.value) {
        newPassword.value = "";
        confirmPassword.value = "";
        newPassword.focus();
        alert("Password has to be same");
        output = false;
        } 	
        return output;
    }
    
    
</script>