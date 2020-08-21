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
    #removeshow:hover {
    transform: scale(1.1);
}
    
    #customerbookings {
    height: 790px;
    top: 165px;
    display: inline-block;
    width: 100%;
}
    #runningshows {
    height: 790px;
    top: 165px;
    display: inline-block;
    width: 100%;
} 
</style>

<head>
    <title>Home Manager</title>
    <link rel="stylesheet" href="styleuser.css">
    <link href="https://fonts.googleapis.com/css?family=Mukta|Roboto|Trade+Winds|Rubik&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body style="overflow:hidden">

    <?php
            ob_start();
            $db = mysqli_connect('localhost', 'root', '', 'movieticket');
               
            
                error_reporting(0);
                
                $img = "";
                $er_img = "";
                $er_mname = "";
                $mname = "";
                $er_dir = "";
                $dir = "";
                $er_genre = "";
                $genre = "";
                $duration = "";
                $er_duration= "";
                $description = $_POST["descriptionnp"];
    
    
                $imgcs = "";
                $er_imgcs = "";
                $er_mnamecs = "";
                $mnamecs = "";
                $er_dircs = "";
                $dircs = "";
                $er_genrecs = "";
                $genrecs = "";
                $durationcs = "";
                $er_durationcs= "";
                $descriptioncs = $_POST["descriptioncs"];
                
                $er_sid = "";
                $showid = "";
                $er_movie = "";
                $movie = "";
                $er_date = "";
                $date = "";
                $er_time = "";
                $time = "";
                $er_seats = "";
                $seats = "";
                $er_type = "";
                $type = "";
                $price = "";
                $er_price = "";
    
                $boolean = false;
                $errors = array();
                $searchmovienp = $_POST["searchmovienowplaying"];
                $searchmoviecs = $_POST["searchmoviecomingsoon"];
                $er_searchmoviecs ="";
                //$row = array();
    
    
                if(isset($_POST['addmovienowplaying']))
                {
                    if($_FILES['movieposternowplaying']['name'] == "")
                    {
                        $er_img = "Movie poster required";
                        $boolean = false;
                        array_push($errors, "Movie poster required");
                    }
                    else
                    {
                        $posternp = $_FILES["movieposternowplaying"]["name"];
                        $target_dir = "images/";
                        $target_file = $target_dir . basename($posternp);
                        
                        if($_FILES['movieposternowplaying']['size'] > 5242880)
                        {
                          $er_img = "Image size should not be greated than 5mb";
                          array_push($errors, "Image size should not be greated than 5mb");
                        }
                        if(file_exists($target_file)) 
                        {
                          $er_img = "File already exists";
                          array_push($errors, "File already exists");
                        }
                        else
                        {
                          if(move_uploaded_file($_FILES["movieposternowplaying"]["tmp_name"], $target_file)) 
                          {
                            $img = $posternp;
                          } 
                          else 
                          {
                            $er_img = "Please try again";
                            array_push($errors, "Please try again");
                          }
                        }
                    }
                    
                    if(empty($_POST["mnamenp"]))
                    {
                        $er_mname = "Movie name required";
                        $boolean = false;
                        array_push($errors, "Movie name required");
                    }
                    else
                    {

                         $mname =validate_input($_POST["mnamenp"]);
                         $boolean = true;
                    }

                    if(empty($_POST["directornp"]))
                    {
                         $er_dir = "Director name required";
                         $boolean = false;
                         array_push($errors, "Director name required");
                        
                    }
                    else
                    {
                        if (!preg_match('/^[\w .,!?()]+$/', $_POST["directornp"]))
                        {
                          $er_dir = "Invalid name";
                          $boolean = false;
                          array_push($errors, "Invalid name");
                        }
                        else
                        {
                            $dir = validate_input($_POST["directornp"]);
                            $boolean = true;
                        }
                         
                    }
                    
                    if(empty($_POST["genrenp"]))   
                    {
                        $er_genre = "Genre requirted";
                        array_push($errors, "Genre requirted");
                    }
                    else
                    {
                        if (!preg_match('/^[\w .,!?()]+$/', $_POST["genrenp"]))
                        {
                          $er_genre = "Invalid genre";
                          $boolean = false;
                          array_push($errors, "Invalid genre");
                        }
                        else
                        {
                            $genre = validate_input($_POST["genrenp"]);
                            $boolean = true;
                        }
                    }

                    if(empty($_POST["durationnp"]))
                    {
                        $er_duration = "Duration required";
                        $boolean = false;
                        array_push($errors, "Duration required");
                    }
                    else
                    {
                        
                        if(!is_numeric($_POST["durationnp"]))
                        {
                             $er_duration = "Invalid input";
                             $boolean = false;
                             array_push($errors, "Invalid input");
                        }
                        else
                        {
                            $duration = validate_input($_POST["durationnp"]);
                            $boolean = true;
                        }
                    }
                    
                    $movienp_query = "SELECT * FROM movie WHERE mname='$mname'";
                    $movienpr = mysqli_query($db, $movienp_query);
                    $movienp = mysqli_num_rows($movienpr);

                        if ($movienp) 
                        {
                            $existmovienp = "Movie already exists";
                            array_push($errors);
                            echo "<script type='text/javascript'>alert('$existmovienp');</script>";
                        }
                        else
                        {   
                            $numErrors = count($errors);
                            
                            if ($numErrors == 0) 
                            {
                                $querynp = "INSERT INTO movie(image,mname,director,genre,duration,description) VALUES('$img','$mname','$dir','$genre','$duration','$description')";  
                                
                                $movienpq = mysqli_query($db, $querynp); 
                                
                                $not1 = "Movie added";
                                echo "<script type='text/javascript'>alert('$not1');</script>"; 
                            }
                            else
                            {
                                $not1 = "Movie adding failed";
                                echo "<script type='text/javascript'>alert('$not1');</script>";
                            }
                        }
                    }
    
                    if(isset($_POST['findmovienowplaying']))
                    {
                        if(empty($_POST["searchmovienowplaying"]))
                        {
                            $er_searchmovienp = "Enter a valid id!";
                        }
                        else
                        {
                            $search_Query = "SELECT * FROM movie WHERE mname = '$searchmovienp'";
                            $search_Result = mysqli_query($db, $search_Query);

                            if($search_Result)
                            {
                                if(mysqli_num_rows($search_Result))
                                {
                                    while($row = mysqli_fetch_array($search_Result))
                                    {
                                        $img = $row['img'];
                                        $mname = $row['mname'];
                                        $dir = $row['director'];
                                        $genre = $row['genre'];
                                        $duration = $row['duration'];
                                        $description = $row['description'];
                                    }
                                }
                                else
                                {
                                   $er11 = "No Data For This Name!";
                                   echo "<script type='text/javascript'>alert('$er11');</script>"; 
                                }
                            }
                            else
                            {
                                $er12 = "Try again!";
                                echo "<script type='text/javascript'>alert('$er12');</script>"; 
                            }
                        }
                        
                    }    
                    
                    if(isset($_POST['deletemovienowplaying']))
                    {
                        $data = getPosts();
                        $deletemovienp = "DELETE FROM `movie` WHERE `mname` = '$data[1]'";
                        $deleteResultnp = mysqli_query($db, $deletemovienp);
                                                
                        if($deleteResultnp)
                        {
                            if(mysqli_affected_rows($db) > 0)
                            {
                                $not3 = "Movie removed";
                                echo "<script type='text/javascript'>alert('$not3');</script>"; 
                            }
                            else
                             {
                                $not3 = "Movie remove failed";
                                echo "<script type='text/javascript'>alert('$not3');</script>"; 
                             }
                        }
                    }
  /*
                if(isset($_POST['ChangePassowrd']))
                {
                    $oldpass = md5($_POST['opwd']);
                    $useremail = $_SESSION['email'];
                    $newpassword = md5($_POST['cpwd']);
                    
                    $sqlcp=mysqli_query($db,"SELECT password FROM login where password='$oldpass' && email='$useremail'");
                    $numcp=mysqli_fetch_array($sqlcp);
                    
                    if($numcp > 0)
                    {
                        $sqlcp2=mysqli_query($db,"update login set password='$newpassword' where email='$useremail'");
                        session_destroy();
                        header('location: logout.php');
                    }
                    else
                    {
                         $notif2cp = "Old Password not match !!Try again!!";
                         echo "<script type='text/javascript'>alert('$notif2cp');</script>"; 
                    }
                }*/
                
    
    
    
    
                if(isset($_POST['addmoviecomingsoon']))
                {
                    if($_FILES['moviepostercomingsoon']['name'] == "")
                    {
                        $er_imgcs = "Movie poster required";
                        $boolean = false;
                        array_push($errors, "Movie poster required");
                    }
                    else
                    {
                        $postercs = $_FILES["moviepostercomingsoon"]["name"];
                        $target_dir = "images/";
                        $target_file = $target_dir . basename($postercs);
                        
                        if($_FILES['moviepostercomingsoon']['size'] > 5242880)
                        {
                          $er_imgcs = "Image size should not be greated than 5mb";
                          array_push($errors, "Image size should not be greated than 5mb");
                        }
                        if(file_exists($target_file)) 
                        {
                          $er_imgcs = "File already exists";
                          array_push($errors, "File already exists");
                        }
                        else
                        {
                          if(move_uploaded_file($_FILES["moviepostercomingsoon"]["tmp_name"], $target_file)) 
                          {
                            $imgcs = $postercs;
                          } 
                          else 
                          {
                            $er_imgcs = "Please try again";
                            array_push($errors, "Please try again");
                          }
                        }
                    }
                    
                    if(empty($_POST["mnamecs"]))
                    {
                        $er_mnamecs = "Movie name required";
                        $boolean = false;
                        array_push($errors, "Movie name required");
                    }
                    else
                    {

                         $mnamecs =validate_input($_POST["mnamecs"]);
                         $boolean = true;
                    }

                    if(empty($_POST["directorcs"]))
                    {
                         $er_dircs = "Director name required";
                         $boolean = false;
                         array_push($errors, "Director name required");
                        
                    }
                    else
                    {
                        if (!preg_match('/^[\w .,!?()]+$/', $_POST["directorcs"]))
                        {
                          $er_dircs = "Invalid name";
                          $boolean = false;
                          array_push($errors, "Invalid name");
                        }
                        else
                        {
                            $dircs = validate_input($_POST["directorcs"]);
                            $boolean = true;
                        }
                         
                    }
                    
                    if(empty($_POST["genrecs"]))   
                    {
                        $er_genrecs = "Genre requirted";
                        array_push($errors, "Genre requirted");
                    }
                    else
                    {
                        if (!preg_match('/^[\w .,!?()]+$/', $_POST["genrecs"]))
                        {
                          $er_genrecs = "Invalid genre";
                          $boolean = false;
                          array_push($errors, "Invalid genre");
                        }
                        else
                        {
                            $genrecs = validate_input($_POST["genrecs"]);
                            $boolean = true;
                        }
                    }
                    
                    $moviecs_query = "SELECT * FROM comingsoon WHERE mname='$mnamecs'";
                    $moviecsr = mysqli_query($db, $moviecs_query);
                    $moviecs = mysqli_num_rows($moviecsr);

                        if ($moviecs) 
                        {
                            $existmoviecs = "Movie already exists";
                            array_push($errors);
                            echo "<script type='text/javascript'>alert('$existmoviecs');</script>";
                        }
                        else
                        {   
                            $numErrorscs = count($errors);
                            
                            if ($numErrorscs == 0) 
                            {
                                $querycs = "INSERT INTO comingsoon(image,mname,director,genre,description) VALUES('$imgcs','$mnamecs','$dircs','$genrecs','$descriptioncs')";  
                                
                                $moviecsq = mysqli_query($db, $querycs); 
                                
                                $not1cs = "Movie added";
                                echo "<script type='text/javascript'>alert('$not1cs');</script>"; 
                            }
                            else
                            {
                                $not1cs = "Movie adding failed";
                                echo "<script type='text/javascript'>alert('$not1cs');</script>";
                            }
                        }
                    }
    
                    if(isset($_POST['findmoviecomingsoon']))
                    {
                        if(empty($_POST["searchmoviecomingsoon"]))
                        {
                            $er_searchmoviecs = "Enter a valid id!";
                        }
                        else
                        {
                            $search_Querycs = "SELECT * FROM comingsoon WHERE mname = '$searchmoviecs'";
                            $search_Resultcs = mysqli_query($db, $search_Querycs);

                            if($search_Resultcs)
                            {
                                if(mysqli_num_rows($search_Resultcs))
                                {
                                    while($row = mysqli_fetch_array($search_Resultcs))
                                    {
                                        $imgcs = $row['img'];
                                        $mnamecs = $row['mname'];
                                        $dircs = $row['director'];
                                        $genrecs = $row['genre'];
                                        $descriptioncs = $row['description'];
                                    }
                                }
                                else
                                {
                                   $er11cs = "No Data For This Name!";
                                   echo "<script type='text/javascript'>alert('$er11cs');</script>"; 
                                }
                            }
                            else
                            {
                                $er12cs = "Try again!";
                                echo "<script type='text/javascript'>alert('$er12cs');</script>"; 
                            }
                        }
                        
                    }    
                    
                    if(isset($_POST['deletemoviecomingsoon']))
                    {
                        $data = getPostscs();
                        $deletemoviecs = "DELETE FROM `comingsoon` WHERE `mname` = '$data[1]'";
                        $deleteResultcs = mysqli_query($db, $deletemoviecs);
                                                
                        if($deleteResultcs)
                        {
                            if(mysqli_affected_rows($db) > 0)
                            {
                                $not3 = "Movie removed";
                                echo "<script type='text/javascript'>alert('$not3');</script>"; 
                            }
                            else
                             {
                                $not3 = "Movie remove failed";
                                echo "<script type='text/javascript'>alert('$not3');</script>"; 
                             }
                        }
                    }
    
    
    
                if(isset($_POST['createshow']))
                {
                    if(empty($_POST["showid"]))
                    {
                         $er_sid = "Show id required";
                         $boolean = false;
                         array_push($errors, "Show id required");
                        
                    }
                    else
                    {
        
                         $showid = validate_input($_POST["showid"]);
                         $boolean = true;
                    }
                    
                    if($_POST["movie"] == "Select Movie")
                    {
                        $er_movie = "Movie name required";
                        $boolean = false;
                        array_push($errors, "Movie name required");
                    }
                    else
                    {
                         $movie = validate_input($_POST["movie"]);
                         $boolean = true;
                    }

                    if(empty($_POST["date"]))
                    {
                         $er_date = "Show date required";
                         $boolean = false;
                         array_push($errors, "Show date required");
                        
                    }
                    else
                    {
        
                         $date = date('d-m-y', strtotime($_POST["date"]));
                         $boolean = true;
                    }
                    
                    if($_POST["time"] == "Select showtime")
                    {
                        $er_time = "Show time requirted";
                        array_push($errors, "Show time requirted");
                    }
                    else
                    {
                        $time =  validate_input($_POST["time"]);
                        $boolean = true;

                    }
                    
                    if(empty($_POST["availableseats"]))
                    {
                         $er_seats = "Field required";
                         $boolean = false;
                         array_push($errors, "Field required");
                    }
                    else
                    {
                         if(!is_numeric($_POST["availableseats"]))
                         {
                             $er_seats = "Invalid input";
                             $boolean = false;
                             array_push($errors, "Invalid input");
                         }
                         else
                         {
                            $seats = validate_input($_POST["availableseats"]);
                            $boolean = true;
                         }
                    }
                    
                    if(empty($_POST["type"]))
                    {
                         $er_type = "Field required";
                         $boolean = false;
                         array_push($errors, "Field required");
                    }
                    else
                    {
                        $type = $_POST["type"];

                    }
                    
                    if(empty($_POST["price"]))
                        {
                            $er_price = "Declare price";
                             $boolean = false;
                             array_push($errors, "Declare price");
                        }
                        else
                         {

                            if(!preg_match('/^[1-9]{1}[0-9]{2,3}$/', $_POST["price"]))
                            {
                                 $er_price = "Invalid price";
                                 $boolean = false;
                                 array_push($errors, "Invalid price");
                            }
                            else
                            {
                                $price = validate_input($_POST["price"]);
                                $boolean = true;
                            }
                         }
                    
                    $show_query = "SELECT * FROM shows WHERE mname='$movie' AND date = '$date' AND time = '$time' AND type = '$type'" ;
                    $showrs = mysqli_query($db, $show_query);
                    $res = mysqli_num_rows($showrs);
                    
                    $show_query3 = "SELECT * FROM shows WHERE date = '$date' AND time = '$time'" ;
                    $showrs3 = mysqli_query($db, $show_query3);
                    $res3 = mysqli_num_rows($showrs3);
                    
                    $show_query2 = "SELECT * FROM shows WHERE id='$showid'";
                    $showrs1 = mysqli_query($db, $show_query2);
                    $res1 = mysqli_num_rows($showrs1);

                        if ($res)
                        {
                            $existshow = "Same show already exists";
                            array_push($errors);
                            echo "<script type='text/javascript'>alert('$existshow');</script>";
                        }
                        else if($res1)
                        {
                            $existshow2 = "Show ID already exists";
                            array_push($errors);
                            echo "<script type='text/javascript'>alert('$existshow2');</script>";
                        }
                        else if($res3)
                        {
                            $existshow3 = "Show already exists in this period!!";
                            array_push($errors);
                            echo "<script type='text/javascript'>alert('$existshow3');</script>";
                        }
                        else
                        {   
                            $numErrors = count($errors);
                            
                            if ($numErrors == 0) 
                            {
                                $querysh = "INSERT INTO shows(id,mname,date,time,seats,type,price) VALUES('$showid','$movie','$date','$time','$seats','$type','$price')";  
                                
                                $moviesh = mysqli_query($db, $querysh); 
                                
                                $notsh = "Show added";
                                echo "<script type='text/javascript'>alert('$notsh');</script>"; 
                            }
                            else
                            {
                                $notsh = "Show adding failed";
                                echo "<script type='text/javascript'>alert('$notsh');</script>"; 
                            }
                        }
                    }
                        
                    if(isset($_POST['removeshow']))
                    {
                        if(empty($_POST["showid"]))
                        {
                             $er_sid = "Show id required to remove show";
                             $boolean = false;
                             array_push($errors, "Show id required to remove show");

                        }
                        else
                        {
                             $showid = validate_input($_POST["showid"]);
                             $boolean = true;
                        }
                        
                        $deleteshow = "DELETE FROM `shows` WHERE `id` = '$showid'";
                        $deletes = mysqli_query($db, $deleteshow);
                                                
                        if($deletes)
                        {
                            if(mysqli_affected_rows($db) > 0)
                            {
                                $not3 = "Show removed";
                                echo "<script type='text/javascript'>alert('$not3');</script>"; 
                            }
                            else
                             {
                                $not3 = "Show remove failed";
                                echo "<script type='text/javascript'>alert('$not3');</script>"; 
                             }
                        }
                    }
    
                
                if(isset($_POST['ChangePassowrd']))
                {
                    $oldpass = md5($_POST['opwd']);
                    $newpassword = md5($_POST['cpwd']);
                    
                    $sqlcp=mysqli_query($db,"SELECT * FROM login where fname='" . $_SESSION["fname"] . "'");
                    $rowc = mysqli_fetch_array($sqlcp);
                    
                    if ($oldpass == $rowc["password"])
                    {
                        mysqli_query($db, "UPDATE login set password ='$newpassword' WHERE fname = '" . $_SESSION["fname"] . "'");
                        $notip = "Password Changed";
                        echo "<script type='text/javascript'>alert('$notip');</script>";
                        header('location: logout.php');
                    } 
                    else
                    {
                       $notip = "Current password in not currect!";
                       echo "<script type='text/javascript'>alert('$notip');</script>";
                    
                    }
                }
    
    
    
			   function validate_input($data)
               {
                  $data = trim($data);
                  $data = stripslashes($data);
                  $data = htmlspecialchars($data);
                  return $data;
               }
    
               function getPosts()
                {
                    if($_FILES['movieposternowplaying']['name'] == "")
                    {
                        $er_img = "Movie poster required";
                        $boolean = false;
                        array_push($errors, "Movie poster required");
                    }
                    else
                    {
                        $posternp = $_FILES["movieposternowplaying"]["name"];
                        $target_dir = "images/";
                        $target_file = $target_dir . basename($posternp);
                        
                        if($_FILES['movieposternowplaying']['size'] > 5242880)
                        {
                          $er_img = "Image size should not be greated than 5mb";
                          array_push($errors, "Image size should not be greated than 5mb");
                        }
                        if(file_exists($target_file)) 
                        {
                          $er_img = "File already exists";
                          array_push($errors, "File already exists");
                        }
                        else
                        {
                          if(move_uploaded_file($_FILES["movieposternowplaying"]["tmp_name"], $target_file))
                          {
                            $img = $posternp;
                          } 
                          else 
                          {
                            $er_img = "Please try again";
                            array_push($errors, "Please try again");
                          }
                        }
                    }
                    
                    if(empty($_POST["mnamenp"]))
                    {
                        $er_mname = "Movie name required";
                        $boolean = false;
                        array_push($errors, "Movie name required");
                    }
                    else
                    {

                         $mname =validate_input($_POST["mnamenp"]);
                         $boolean = true;
                    }

                    if(empty($_POST["directornp"]))
                    {
                         $er_dir = "Director name required";
                         $boolean = false;
                         array_push($errors, "Director name required");
                        
                    }
                    else
                    {
                        if (!preg_match('/^[\w .,!?()]+$/', $_POST["directornp"]))
                        {
                          $er_dir = "Invalid name";
                          $boolean = false;
                          array_push($errors, "Invalid name");
                        }
                        else
                        {
                            $dir = validate_input($_POST["directornp"]);
                            $boolean = true;
                        }
                         
                    }
                    
                    if(empty($_POST["genrenp"]))   
                    {
                        $er_genre = "Genre requirted";
                        array_push($errors, "Genre requirted");
                    }
                    else
                    {
                        if (!preg_match('/^[\w .,!?()]+$/', $_POST["genrenp"]))
                        {
                          $er_genre = "Invalid genre";
                          $boolean = false;
                          array_push($errors, "Invalid genre");
                        }
                        else
                        {
                            $genre = validate_input($_POST["genrenp"]);
                            $boolean = true;
                        }
                    }

                    if(empty($_POST["durationnp"]))
                    {
                        $er_duration = "Duration required";
                        $boolean = false;
                        array_push($errors, "Duration required");
                    }
                    else
                    {
                        
                        if(!is_numeric($_POST["durationnp"]))
                        {
                             $er_duration = "Invalid input";
                             $boolean = false;
                             array_push($errors, "Invalid input");
                        }
                        else
                        {
                            $duration = validate_input($_POST["durationnp"]);
                            $boolean = true;
                        }
                    }
                   
                    $posts = array();
                   
                    $posts[0] = $img;
                    $posts[1] = $mname;
                    $posts[2] = $dir;
                    $posts[3] = $genre;
                    $posts[4] = $duration;
                    $posts[6] = $_POST["descriptionnp"];

                    return $posts;
                }
    
                function getPostscs()
                {
                    if($_FILES['moviepostercomingsoon']['name'] == "")
                    {
                        $er_imgcs = "Movie poster required";
                        $boolean = false;
                        array_push($errors, "Movie poster required");
                    }
                    else
                    {
                        $postercs = $_FILES["moviepostercomingsoon"]["name"];
                        $target_dir = "images/";
                        $target_file = $target_dir . basename($postercs);
                        
                        if($_FILES['moviepostercomingsoon']['size'] > 5242880)
                        {
                          $er_imgcs = "Image size should not be greated than 5mb";
                          array_push($errors, "Image size should not be greated than 5mb");
                        }
                        if(file_exists($target_file)) 
                        {
                          $er_imgcs = "File already exists";
                          array_push($errors, "File already exists");
                        }
                        else
                        {
                          if(move_uploaded_file($_FILES["moviepostercomingsoon"]["tmp_name"], $target_file)) 
                          {
                            $imgcs = $postercs;
                          } 
                          else 
                          {
                            $er_imgcs = "Please try again";
                            array_push($errors, "Please try again");
                          }
                        }
                    }
                    
                    if(empty($_POST["mnamecs"]))
                    {
                        $er_mnamecs = "Movie name required";
                        $boolean = false;
                        array_push($errors, "Movie name required");
                    }
                    else
                    {

                         $mnamecs =validate_input($_POST["mnamecs"]);
                         $boolean = true;
                    }

                    if(empty($_POST["directorcs"]))
                    {
                         $er_dircs = "Director name required";
                         $boolean = false;
                         array_push($errors, "Director name required");
                        
                    }
                    else
                    {
                        if (!preg_match('/^[\w .,!?()]+$/', $_POST["directorcs"]))
                        {
                          $er_dircs = "Invalid name";
                          $boolean = false;
                          array_push($errors, "Invalid name");
                        }
                        else
                        {
                            $dircs = validate_input($_POST["directorcs"]);
                            $boolean = true;
                        }
                         
                    }
                    
                    if(empty($_POST["genrecs"]))   
                    {
                        $er_genrecs = "Genre requirted";
                        array_push($errors, "Genre requirted");
                    }
                    else
                    {
                        if (!preg_match('/^[\w .,!?()]+$/', $_POST["genrecs"]))
                        {
                          $er_genrecs = "Invalid genre";
                          $boolean = false;
                          array_push($errors, "Invalid genre");
                        }
                        else
                        {
                            $genrecs = validate_input($_POST["genrecs"]);
                            $boolean = true;
                        }
                    }

                   
                    $postscs = array();
                   
                    $postscs[0] = $imgcs;
                    $postscs[1] = $mnamecs;
                    $postscs[2] = $dircs;
                    $postscs[3] = $genrecs;
                    $postscs[6] = $_POST["descriptioncs"];

                    return $postscs;
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
    <nav class="sidebar">
        <header class="dashboard">Dashboard</header>
        <ul>
            <li><a href="#home"><i class="fas fa-qrcode"></i>Home</a></li>
            <li><a href="#movie"><i class="fas fa-ticket-alt"></i>Movies</a>
                <ul>
                    <li><a href="#managemovienowplaying"><i class="fas fa-calendar-plus"></i>Now playing</a></li>
                    <li><a href="#managemoviecomingsoon"><i class="fas fa-calendar-plus"></i>Coming soon</a></li>
                    <li><a href="#moviedetails"><i class="fas fa-ticket-alt"></i>Movie Details</a></li>
                </ul>
            </li>
            <li><a href="#createshowtime"><i class="fas fa-calendar-plus"></i>Create Showtime</a></li>
            <li><a href="#runningshows"><i class="fas fa-calendar-plus"></i>Running Shows</a></li>
            <li><a href="#customerbookings"><i class="fas fa-users"></i>Customer Bookings</a></li>
            <li><a href="#profile"><i class="fas fa-id-card"></i>Profile</a></li>
            <li><a href="#settings"><i class="fas fa-cogs"></i>Settings</a></li>
        </ul>
        <br>
        <ul id="ul2">
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
        </ul>
    </nav>
    <section>
        <form action="#" method="post" name="manager" enctype="multipart/form-data">
            <div id="home">
                <h4 style="margin-top: 250px;">Welcome <br><strong><?php echo $_SESSION['fname']; ?></strong></h4>
            </div>
            <div id="movie">
                <div id="managemovienowplaying">
                    <table id="managemovienowplayingtable" style="margin-top: 110px; margin-left: 250px; margin-bottom: 10px;">
                        <tr>
                            <td>
                                <h1 style="color: white;margin-top: 20px; margin-bottom: 25px;margin-left: 30px;">Movies(Now Playing)</h1>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="searchbox">
                                    <input style="padding: 10px;font-size: 17px;border: none;float: left;width: 165%;color: black;background-color: #FEE12B;" type="text" id="textbox2" placeholder="Search using Movie name" name="searchmovienowplaying">
                                </div>
                            </td>
                            <td>
                                <input style="width: 50%;padding: 10px;font-size: 17px;cursor: pointer;" type="submit" id="findmovienowplaying" name="findmovienowplaying" value="Find Movie">
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <div class="form-group" style="position: relative;">
                                <span class="img-div">
                                    <div class="img-placeholder" onClick="triggerClick()" style="width: 13%; height: 100%; background: black; opacity: .7; height: 150px; border-radius: 40%; z-index: 2; position: absolute; transform: translateX(-50%); display: none;">
                                    </div>
                                    <img src="images/avatar.png" onClick="triggerClick()" id="posterdisplaynp" style="display: block; height: 150px; width: 13%; margin-left: 400px; border-radius: 40%;">
                                </span>
                                <input type="file" id="movieposternowplaying" name="movieposternowplaying" onChange="displayImage(this)" class="form-control" style="display: none;">
                            </div>
                            <span id="span1" style="color: white; margin-left:430px; "><?php echo $er_img;?></span>
                        </tr>
                    </table>
                    <table id="managemovienowplayingtable" style="margin-top: 10px; margin-left: 250px;">
                        <tr>
                            <td>
                                <div class="textbox1">
                                    <input type="text" name="mnamenp" placeholder="Movie Name" value="<?php echo $mname;?>">
                                </div>
                                <span id="span1" style="color: white;"><?php echo $er_mname;?></span>
                            </td>
                            <td>
                                <input type="submit" id="addmovienowplaying" name="addmovienowplaying" value="Add Movie">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="textbox1">
                                    <input type="text" name="directornp" placeholder="Movie Director" value="<?php echo $dir;?>">
                                </div>
                                <span id="span1" style="color: white;"><?php echo $er_dir;?></span>
                            </td>
                            <td>
                                <input type="submit" id="deletemovienowplaying" name="deletemovienowplaying" value="Delete Movie">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="textbox1">
                                    <input type="text" name="genrenp" placeholder="Genre" value="<?php echo $genre;?>">
                                </div>
                                <span id="span1" style="color: white;"><?php echo $er_genre;?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="textbox1">
                                    <input type="text" name="durationnp" placeholder="Duration" value="<?php echo $duration;?>">
                                </div>
                                <span id="span1" style="color: white;"><?php echo $er_duration;?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="textbox1">
                                    <input type="text" name="descriptionnp" placeholder="Describe about movie" value="<?php echo $description;?>">
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="managemoviecomingsoon">
                    <table id="managemoviecomingssontable" style="margin-top: 110px; margin-left: 250px; margin-bottom: 10px;">
                        <tr>
                            <td>
                                <h1 style="color: white;margin-top: 20px; margin-bottom: 25px;margin-left: 30px;">Movies(Coming soon)</h1>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="searchbox">
                                    <input style="padding: 10px;font-size: 17px;border: none;float: left;width: 165%;color: black;background-color: #FEE12B;" type="text" id="textbox2" placeholder="Search using Movie name" name="searchmoviecomingsoon">
                                </div>
                            </td>
                            <td>
                                <input style="width: 50%;padding: 10px;font-size: 17px;cursor: pointer;" type="submit" id="findmoviecomingsoon" name="findmoviecomingsoon" value="Find Movie">
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <div class="form-group" style="position: relative;">
                                <span class="img-div">
                                    <div class="img-placeholder" onClick="triggerClickcs()" style="width: 13%; height: 100%; background: black; opacity: .7; height: 150px; border-radius: 40%; z-index: 2; position: absolute; transform: translateX(-50%); display: none;">
                                    </div>
                                    <img src="images/avatar.png" onClick="triggerClickcs()" id="posterdisplaycs" style="display: block; height: 150px; width: 13%; margin-left: 400px; border-radius: 40%;">
                                </span>
                                <input type="file" id="moviepostercomingsoon" name="moviepostercomingsoon" onChange="displayImagecs(this)" class="form-control" style="display: none;">
                            </div>
                            <span id="span1" style="color: white; margin-left:430px; "><?php echo $er_imgcs;?></span>
                        </tr>
                    </table>
                    <table id="managemoviecomingssontable" style="margin-top: 10px; margin-left: 250px;">
                        <tr>
                            <td>
                                <div class="textbox1">
                                    <input type="text" name="mnamecs" placeholder="Movie Name" value="<?php echo $mnamecs;?>">
                                </div>
                                <span id="span1" style="color: white; "><?php echo $er_mnamecs;?></span>
                            </td>
                            <td>
                                <input type="submit" id="addmoviecomingsoon" name="addmoviecomingsoon" value="Add Movie">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="textbox1">
                                    <input type="text" name="directorcs" placeholder="Movie Director" value="<?php echo $dircs;?>">
                                </div>
                                <span id="span1" style="color: white; "><?php echo $er_dircs;?></span>
                            </td>
                            <td>
                                <input type="submit" id="deletemoviecomingsoon" name="deletemoviecomingsoon" value="Delete Movie">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="textbox1">
                                    <input type="text" name="genrecs" placeholder="Genre" value="<?php echo $genrecs;?>">
                                </div>
                                <span id="span1" style="color: white; "><?php echo $er_genrecs;?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="textbox1">
                                    <input type="text" name="descriptioncs" placeholder="Describe about movie" value="<?php echo $descriptioncs;?>">
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="moviedetails">
                        <div>
                          <table id='moviedetailstablenowplaying' align='center' border='0px' width='1100px' height='200' style='margin-left:90px; margin-top: 150px'>
                              <tr>
                                <td style="border: none;">
                                    <h1><span style="color: yellow; font-size: 25px; margin-left: 300px; margin-bottom: 150px;">Movie(Now Playing)</span></h1>
                                </td>
                              </tr>
                              <tr align="center" bgcolor="#FEE12B">
                                <td>Movie Name</td>
                                <td>Director</td>
                                <td>Genre</td>
                                <td>Duration</td>
                                <td>Description</td>

                              </tr>
                                <?php
                                        $shownp = "select mname,director,genre,duration,description from movie";
                                        $resnp = $db->query($shownp);
                                        while ($rownps = $resnp->fetch_row()) {
                                            echo "<tr align='center' style='color: yellow;font-family: Mukta;background-color:black;border-color: white;'>";
                                            for($i = 0; $i < $resnp->field_count; $i++){
                                                echo "<td>$rownps[$i]</td>";
                                            }
                                            echo "</tr>";
                                        }
                                ?>
                            </table>
                        </div>
                                             
                       <div>
                          <table id='moviedetailstablecomingsoon' align='center' border='0px' width='1100px' height='200' style='margin-left:90px;margin-top: 100px'>
                              <tr>
                                <td style="border: none;">
                                    <h1><span style="color: yellow; font-size: 25px; margin-left: 300px; margin-bottom: 150px;">Movie(Coming Soon)</span></h1>
                                </td>
                              </tr>
                              <tr align="center" bgcolor="#FEE12B">
                                <td>Movie Name</td>
                                <td>Director</td>
                                <td>Genre</td>
                                <td>Description</td>

                              </tr>
                                <?php
                                        $showcs = "select mname,director,genre,description from comingsoon";
                                        $rescs = $db->query($showcs);
                                        while ($rowcss = $rescs->fetch_row()) 
                                        {
                                            echo "<tr align='center' style='color: yellow;font-family: Mukta;background-color:black;border-color: white;'>";
                                            for($i = 0; $i < $rescs->field_count; $i++){
                                                echo "<td>$rowcss[$i]</td>";
                                            }
                                            echo "</tr>";
                                        }
                                ?>
                            </table>
                        </div>
                </div>
            </div>
            <div id="createshowtime">
                <h1>Show Time</h1>
                <table id="showtime" style="margin-top: 140px;" cellspacing=8px;>
                   <tr>
                      <td>
                            <label for="text" style="float: right; font-family: Mukta;font-size: 25px; color: yellow; margin-left: 200px;letter-spacing: 5px;">Show id:</label>
                        </td>
                       <td>
                           <div class="textbox1">
                               <input type="text" name="showid" placeholder="Show ID" value="<?php echo $showid;?>">
                           </div>
                           <span id="span1" style="color: white; "><?php echo $er_sid;?></span>
                       </td>
                   </tr>
                    <tr>
                        <td>
                            <label for="text" style="float: right; font-family: Mukta;font-size: 25px; color: yellow; margin-left: 200px;letter-spacing: 5px;">Movie Name:</label>
                        </td>
                        <td>  
                         <div class="select">
                             <select name='movie' id='movie'>
                              <?php 
                                $cshow = "select mname from movie";
                                $rcshow =  $db->query($cshow);
                                    echo "<option value='Select Movie'>Select Movie</option>";
                             
                                    while ($createshow = $rcshow->fetch_row())
                                    {
                                        for($i = 0; $i < $rcshow->field_count; $i++)
                                        {
                                             echo '<option value="'.$createshow[$i].'">'.$createshow[$i].'</option>';
                                        }
                                    }                          
                              ?>
                              </select>
                        </div>
                        <span id="span1" style="color: white; "><?php echo $er_movie?></span>
                       </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="date" style="float: right; margin-left:250px;font-family:'Mukta'; font-size:25px;color: yellow;letter-spacing: 5px;">Date:</label>
                        </td>
                        <td>
                            <div class="date">
                                <input id="date" type="date" name="date" value="<?php echo date('d-m-y')?>">
                            </div>
                            <span id="span1" style="color: white; "><?php echo $er_date;?></span>
                        </td>
                        <td>
                            <input type="submit" id="createshow" name="createshow" value="Create Show" style="margin-left: 190px;">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="text" style="float: right; font-family: Mukta;font-size: 25px; color: yellow; margin-left: 200px;letter-spacing: 5px;">Time:</label>
                        </td>
                        <td>
                            <div class="select">
                                <select id="time" name="time">
                                    <option value="">Select showtime</option>
                                    <option value="11am">11am</option>
                                    <option value="3am">3am</option>
                                    <option value="6am">6am</option>
                                </select>
                            </div>
                            <span id="span1" style="color: white; "><?php echo $er_time;?></span>
                        </td>
                        <td>
                            <input type="submit" id="removeshow" name="removeshow" value="Remove Show" style="background-color: #FEE12B; border: none; color: black;font-family: Mukta;font-weight: bold;padding: 10px 40px;text-align: center;text-decoration: none;display: inline-block;font-size: 18px;margin-left: 190px;">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="text" style="float: right; font-family: Mukta;font-size: 25px; color: yellow; margin-left: 200px;letter-spacing: 5px;">Available Seats:</label>
                        </td>
                        <td>
                            <div class="textbox1">
                                <input type="text" name="availableseats" placeholder="Available seats">
                            </div>
                            <span id="span1" style="color: white; "><?php echo $er_seats;?></span>
                        </td>
                    </tr>
                    <tr>
                     <td>
                        <label for="text" style="float: right; font-family: Mukta;font-size: 25px; color: yellow; margin-left: 200px;letter-spacing: 5px;">Show Type:</label>
                      </td>
                      <td>
                          <div class="radio1">
                                <ul>
                                    <li style="list-style:none; margin-top: 20px;">
                                           <input style="margin-left: 50px;" type="radio" name="type" value="vip"><span style="color: yellow">VIP</span>
                                           <input style="margin-left: 50px;" type="radio" name="type" value="nonvip"><span style="color: yellow">Non-VIP</span>
                                        </li>
                                    </ul>
                                </div>
                               <span id="span1" style="color: white; "><?php echo $er_type;?></span>
                         </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="text" style="float: right; font-family: Mukta;font-size: 25px; color: yellow; margin-left: 200px;letter-spacing: 5px;">Ticket Price:</label>
                        </td>
                        <td>
                            <div class="textbox1">
                                <input type="text" name="price" placeholder="Ticket price">
                            </div>
                            <span id="span1" style="color: white; "><?php echo $er_price;?></span>
                        </td>
                    </tr>
                </table>
            </div>
             <div id="runningshows">
                <div>
                    <input type="text" style="padding: 10px;font-size: 17px;border: none;float: left; color: black;background-color: #FEE12B; margin-top: 180px; margin-left: 62px; width: 93%; border-radius: 25px; border-bottom-width: 15px;" name="search_show" id="search_show" placeholder="Search by Show Details" />
                </div>
                <br />
                <div>
                    <div id="resultshowMAN"></div>
                </div>
            </div>
            <div id="customerbookings">
                <div>
                        <input type="text" style="padding: 10px;font-size: 17px;border: none;float: left; color: black;background-color: #FEE12B; margin-top: 180px; margin-left: 62px; width: 93%; border-radius: 25px; border-bottom-width: 15px;" name="search_show" id="search_show" placeholder="Search by Show Details" />
                        </div>
                        <br />
                        <div>
                            <div id="bookingshow"></div>
                        </div>
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
                        <br><br>
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
    function triggerClick(e) {
        document.querySelector('#movieposternowplaying').click();
    }

    function displayImage(e) {
        if (e.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('#posterdisplaynp').setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(e.files[0]);
        }
    }


    function triggerClickcs(e) {
        document.querySelector('#moviepostercomingsoon').click();
    }

    function displayImagecs(e) {
        if (e.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('#posterdisplaycs').setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(e.files[0]);
        }
    }
</script>


<script>
    $(document).ready(function()
    {
        load_data();

            function load_data(query)
            {
                $.ajax({
                url:"fetch.php",
                method:"POST",
                data:{query:query},
                success:function(data)
                {
                    $('#result').html(data);
                }
                });
                }
                $('#search_text').keyup(function(){
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
    
</script>

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
                    $('#resultshowMAN').html(data);
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
</script>

<script>
    $(document).ready(function()
    {

        load_data();

            function load_data(query)
            {
                $.ajax({
                url:"booking.php",
                method:"POST",
                data:{query:query},
                success:function(data)
                {
                    $('#bookingshow').html(data);
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
    
</script>


<script>
    function validatePassword() 
    {
        var oldPassword, newPassword, confirmPassword, output = true;

        oldPassword = document.manager.opwd;
        newPassword = document.manager.npwd;
        confirmPassword = document.manager.cpwd;

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