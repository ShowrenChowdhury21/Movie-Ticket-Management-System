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
  	    header("location: logout.php");
     }
     else
     {
        $_SESSION['last_time'] = time();
     }
  }
?>


<html>

<head>
    <title>Home Admin</title>
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
                $er_id = "";
                $id = "";
                $er_fname = "";
                $fname = "";
                $er_lname = "";
                $lname = "";
                $er_email = "";
                $email = "";
                $er_phone = "";
                $phone = "";
                $gender = "";
                $er_gender= "";
                $designation = $_POST["designation"];
                $address = $_POST["address"];
                $er_salary = "";
                $salary = "";
                $boolean = false;
                $errors = array();
                $searchemp = $_POST["search"];
                $er_searchemp="";
                $row = array();
    
    
                if(isset($_POST['addemployee']))
                {
                    if(empty($_POST["id"]))
                    {
                        $er_id = "Id required";
                        $boolean = false;
                        array_push($errors, "Id required");
                    }
                    else
                    {
                        if(!is_numeric($_POST["id"]))
                        {
                             $er_id = "Invalid id";
                             $boolean = false;
                             array_push($errors, "Invalid id");
                        }
                        else
                        {
                            $id = validate_input($_POST["id"]);
                            $boolean = true;
                        }
                    }
                    
                    if(empty($_POST["fname"]))
                    {
                        $er_fname = "First name required";
                        $boolean = false;
                        array_push($errors, "First name required");
                    }
                    else
                    {
                       
                        if (!preg_match("/^[a-zA-Z ]*$/",$_POST["fname"]))
                        {
                            $er_fname = "letters and white space allowed";
                            $boolean = false;
                            array_push($errors, "letters and white space allowed");
                        }
                        else
                        {
                            $fname =validate_input($_POST["fname"]);
                            $boolean = true;
                        }
                    }

                    if(empty($_POST["lname"]))
                    {
                        $er_lname = "Last name required";
                         $boolean = false;
                         array_push($errors, "Last name required");
                        
                    }
                    else
                    {
                        if (!preg_match("/^[a-zA-Z ]*$/",$_POST["lname"]))
                        {
                            $er_lname = "letters and white space allowed";
                            $boolean = false;
                            array_push($errors, "letters and white space allowed");
                        }
                        else
                        {
                            $lname = validate_input($_POST["lname"]);
                            $boolean = true;
                        }
                    }
                    if(empty($_POST["email"]))   
                    {
                        $er_email = "Email requirted";
                        array_push($errors, "Email requirted");
                    }
                    else
                    {
                        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
                        {
                          $er_email = "Invalid email format";
                          $boolean = false;
                          array_push($errors, "Invalid email format");
                        }
                        else
                        {
                            $email = validate_input($_POST["email"]);
                            $boolean = true;
                        }
                    }

                    if(empty($_POST["phone"]))
                    {
                        $er_phone = "Phone required";
                        $boolean = false;
                        array_push($errors, "Phone required");
                    }
                    else
                    {
                        
                        if(!preg_match('/^[0]{1}[1]{1}[1-9]{1}[0-9]{8}$/', $_POST["phone"]))
                        {
                             $er_phone = "Invalid Phone";
                             $boolean = false;
                             array_push($errors, "Invalid Phone");
                        }
                        else
                        {
                            $phone = validate_input($_POST["phone"]);
                            $boolean = true;
                        }
                    }
                    if(empty($_POST["gender"]))
                    {
                        $er_gender = "Field required";
                        $boolean = false;
                        array_push($errors, "Field required");
                    }
                    else
                    {
                        $gender = $_POST["gender"];

                    }
                    if(empty($_POST["salary"]))
                    {
                        $er_salary = "Declare Salary";
                         $boolean = false;
                         array_push($errors, "Declare Salary");
                    }
                    else
                     {
                         
                        if(!preg_match('/^[1-9]{1}[0-9]{3,5}$/', $_POST["salary"]))
                        {
                             $er_salary = "Invalid salry";
                             $boolean = false;
                             array_push($errors, "Invalid Salary");
                        }
                        else
                        {
                            $salary = validate_input($_POST["salary"]);
                            $boolean = true;
                        }
                     }
                    
                    
                        $user_check_query = "SELECT * FROM employee WHERE id='$id' OR email='$email' OR phone='$phone'";
                        $result = mysqli_query($db, $user_check_query);
                        $employee = mysqli_num_rows($result);

                        if ($employee) 
                        {
                            $existid = "ID or Email or Phone already exists";
                            array_push($errors);
                            echo "<script type='text/javascript'>alert('$existid');</script>";
                        }
                        else
                        {   
                            $numErrors = count($errors);
                            
                            if ($numErrors == 0) 
                            {
                                $query = "INSERT INTO employee(id,fname,lname,email,phone,gender,designation,address,salary) VALUES('$id','$fname','$lname','$email','$phone','$gender','$designation','$address','$salary')";  
                                $firstquery = mysqli_query($db, $query); 
                                
                                if($firstquery)
                                {
                                    if($designation == "manager")
                                    {   
                                        $pass = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);
                                        $password = md5($pass);
                                        $role = 2;
                                        
                                        $querynew = "INSERT INTO login (id,fname,email,password,role) VALUES('$id','$fname','$email','$password','$role')";
                                        mysqli_query($db, $querynew);
                                        
                                        $n = "Password: ".$pass;
                                        echo "<script type='text/javascript'>alert('$n');</script>"; 
                                    }    
                                }
                                
                                $not = "Employee added";
                                array_push($errors);
                                echo "<script type='text/javascript'>alert('$not');</script>"; 
                            }               
                        }
                    }
    
                    if(isset($_POST['findemployee']))
                    {
                        if(empty($_POST["search"]))
                        {
                            $er_searchemp = "Enter a valid id!";
                        }
                        else
                        {
                            $search_Query = "SELECT * FROM employee WHERE id = '$searchemp'";
                            $search_Result = mysqli_query($db, $search_Query);

                            if($search_Result)
                            {
                                if(mysqli_num_rows($search_Result))
                                {
                                    while($row = mysqli_fetch_array($search_Result))
                                    {
                                        $id = $row['id'];
                                        $fname = $row['fname'];
                                        $lname = $row['lname'];
                                        $email = $row['email'];
                                        $phone = $row['phone'];
                                        $gender = $row['gender'];
                                        $designation = $row['designation'];
                                        $address = $row['address'];
                                        $salary = $row['salary'];
                                    }
                                }
                                else
                                {
                                   $er11 = "No Data For This Id!";
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
                    
                    if(isset($_POST['updateemployee']))
                    {
                        $data = getPosts();
                        $update_Query = "UPDATE `employee` SET `fname`='$data[1]',`lname`='$data[2]',`email`='$data[3]',`phone`='$data[4]',`gender`='$data[5]',`designation`='$data[6]',`address`='$data[7]',`salary`='$data[8]' WHERE `id` = $data[0]";
                         $update_Result = mysqli_query($db, $update_Query);
                            
                         if($update_Result)
                         {
                             $update_Query2 = "UPDATE `login` SET `email`='$data[3]' WHERE `id` = $data[0]";
                             $update_Result2 = mysqli_query($db, $update_Query2);
                             
                                 $notif = "Employee updated";
                                 echo "<script type='text/javascript'>alert('$notif');</script>"; 
                         }
                         else
                         {
                                 $notif2 = "Employee update failed";
                                 echo "<script type='text/javascript'>alert('$notif2');</script>"; 
                         }
                    }
    
                    if(isset($_POST['deleteemployee']))
                    {
                        $data = getPosts();
                        $delete_Query = "DELETE FROM `employee` WHERE `id` = $data[0]";
                        $delete_Result = mysqli_query($db, $delete_Query);

                            if($delete_Result)
                            {
                                if(mysqli_affected_rows($db) > 0)
                                 {
                                     $notif3 = "Employee removed";
                                     echo "<script type='text/javascript'>alert('$notif3');</script>"; 
                                 }
                                 else
                                 {
                                    $notif4 = "Employee remove failed";
                                    echo "<script type='text/javascript'>alert('$notif4');</script>"; 
                                 }
                            }
                    }
  
                if(isset($_POST['ChangePassowrd']))
                {
                    $oldpass = md5($_POST['opwd']);
                    $useremail = $_SESSION['email'];
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
                   
                   if(empty($_POST["id"]))
                        {
                            $er_id = "Id required";
                            $boolean = false;
                            array_push($errors, "Id required");
                        }
                        else
                        {
                            if(!is_numeric($_POST["id"]))
                            {
                                 $er_id = "Invalid id";
                                 $boolean = false;
                                 array_push($errors, "Invalid id");
                            }
                            else
                            {
                                $id = validate_input($_POST["id"]);
                                $boolean = true;
                            }
                        }

                        if(empty($_POST["fname"]))
                        {
                            $er_fname = "First name required";
                            $boolean = false;
                            array_push($errors, "First name required");
                        }
                        else
                        {

                            if (!preg_match("/^[a-zA-Z ]*$/",$_POST["fname"]))
                            {
                                $er_fname = "letters and white space allowed";
                                $boolean = false;
                                array_push($errors, "letters and white space allowed");
                            }
                            else
                            {
                                $fname =validate_input($_POST["fname"]);
                                $boolean = true;
                            }
                        }

                        if(empty($_POST["lname"]))
                        {
                            $er_lname = "Last name required";
                             $boolean = false;
                             array_push($errors, "Last name required");

                        }
                        else
                        {
                            if (!preg_match("/^[a-zA-Z ]*$/",$_POST["lname"]))
                            {
                                $er_lname = "letters and white space allowed";
                                $boolean = false;
                                array_push($errors, "letters and white space allowed");
                            }
                            else
                            {
                                $lname = validate_input($_POST["lname"]);
                                $boolean = true;
                            }
                        }
                        if(empty($_POST["email"]))   
                        {
                            $er_email = "Email requirted";
                            array_push($errors, "Email requirted");
                        }
                        else
                        {
                            if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
                            {
                              $er_email = "Invalid email format";
                              $boolean = false;
                              array_push($errors, "Invalid email format");
                            }
                            else
                            {
                                $email = validate_input($_POST["email"]);
                                $boolean = true;
                            }
                        }

                        if(empty($_POST["phone"]))
                        {
                            $er_phone = "Phone required";
                            $boolean = false;
                            array_push($errors, "Phone required");
                        }
                        else
                        {

                            if(!preg_match('/^[0]{1}[1]{1}[1-9]{1}[0-9]{8}$/', $_POST["phone"]))
                            {
                                 $er_phone = "Invalid Phone";
                                 $boolean = false;
                                 array_push($errors, "Invalid Phone");
                            }
                            else
                            {
                                $phone = validate_input($_POST["phone"]);
                                $boolean = true;
                            }
                        }
                        if(empty($_POST["gender"]))
                        {
                            $er_gender = "Field required";
                            $boolean = false;
                            array_push($errors, "Field required");
                        }
                        else
                        {
                            $gender = $_POST["gender"];

                        }
                        if(empty($_POST["salary"]))
                        {
                            $er_salary = "Declare Salary";
                             $boolean = false;
                             array_push($errors, "Declare Salary");
                        }
                        else
                         {

                            if(!preg_match('/^[1-9]{1}[0-9]{3,5}$/', $_POST["salary"]))
                            {
                                 $er_salary = "Invalid salry";
                                 $boolean = false;
                                 array_push($errors, "Invalid Salary");
                            }
                            else
                            {
                                $salary = validate_input($_POST["salary"]);
                                $boolean = true;
                            }
                         }
                   
                    $posts = array();
                   
                    $posts[0] = $id;
                    $posts[1] = $fname;
                    $posts[2] = $lname;
                    $posts[3] = $email;
                    $posts[4] = $phone;
                    $posts[5] = $gender;
                    $posts[6] = $_POST["designation"];
                    $posts[7] = $_POST["address"];
                    $posts[8] = $salary;

                    return $posts;
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
            <li><a href="#employee"><i class="fas fa-users-cog"></i>Employee</a>
                <ul>
                    <li><a href="#manageemployee"><i class="fas fa-calendar-plus"></i>Manage</a></li>
                    <li><a href="#employeedetails"><i class="fas fa-users"></i>Employee Details</a></li>
                </ul>
            </li>
            <li><a href="#movieshowdetails"><i class="fas fa-ticket-alt"></i>Shows</a></li>
            <li><a href="#profile"><i class="fas fa-id-card"></i>Profile</a></li>
            <li><a href="#settings"><i class="fas fa-cogs"></i>Settings</a></li>
        </ul>
        <br><br><br><br>
        <ul id="ul2">
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
        </ul>
    </div>
    <section>
        <form name="admin" method="post" action="#">
            <div id="home">
                <h4 style="margin-top: 250px;">Welcome <br> <strong><?php echo $_SESSION['fname']; ?></strong> </h4>
            </div>
            <div id="employee">
                <div id="manageemployee">
                    <table id="manageemployeetable" style="margin-top: 120px; margin-left: 150px;">
                        <tr>
                            <td>
                                <h1 style="color: white;margin-top: 20px; margin-bottom: 20px;margin-left: 30px;">Employees</h1>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="searchbox">
                                    <input style="padding: 10px;font-size: 17px;border: none;float: left;width: 173%;color: black;background-color: #FEE12B;" type="text" id="textbox2" placeholder="Search using Employee Id" name="search">
                                </div>
                                <span id="span1" style="color: white;"><?php echo $er_searchemp;?></span>
                            </td>
                            <td>
                                <input style="cursor: pointer; margin-bottom: 5px; margin-left: 260px;" type="submit" id="findemployee" name="findemployee" value="Find Employee">
                            </td>
                        </tr>
                        <tr></tr>
                        <tr></tr>
                        <tr>
                            <td>
                                <div class="textbox1">
                                    <input type="text" name="id" value="<?php echo $id;?>" placeholder="Id">
                                </div>
                                <span id="span1" style="color: white;"><?php echo $er_id;?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="textbox1">
                                    <input type="text" name="fname" value="<?php echo $fname;?>" placeholder="First Name">
                                </div>
                                <span id="span1" style="color: white;"><?php echo $er_fname;?></span>
                            </td>
                            <td>
                                <input type="submit" id="addemployee" name="addemployee" value="Add Employee">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="textbox1">
                                    <input type="text" name="lname" value="<?php echo $lname;?>" placeholder="Last Name">
                                </div>
                                <span id="span1" style="color: white;"><?php echo $er_lname;?></span>
                            </td>
                            <td>
                                <input type="submit" id="updateemployee" name="updateemployee" value="Update Employee">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="textbox1">
                                    <input type="text" name="email" value="<?php echo $email;?>" placeholder="E-mail">
                                </div>
                                <span id="span1" style="color: white;"><?php echo $er_email;?></span>
                            </td>
                            <td>
                                <input type="submit" id="deleteemployee" name="deleteemployee" value="Delete Employee">
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="textbox1">
                                    <input type="text" name="phone" value="<?php echo $phone;?>" placeholder="Phone Number">
                                </div>
                                <span id="span1" style="color: white;"><?php echo $er_phone;?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="radio1">
                                    <ul>
                                        <li style="list-style:none;">
                                            <input style="margin-left: 50px;" type="radio" name="gender" value="male" <?php if ($gender == 'male') echo 'checked="checked"'; ?>><span style="color: yellow">Male</span>
                                            <input style="margin-left: 50px;" type="radio" name="gender" value="female" <?php if ($gender == 'female') echo 'checked="checked"'; ?>><span style="color: yellow">Female</span>
                                            <input style="margin-left: 50px;" type="radio" name="gender" value="other" <?php if($row['gender']=='other'){?> checked="true" <?php } ?>><span style="color: yellow">Others</span>
                                        </li>
                                    </ul>
                                    <span id="span1" style="color: white;"><?php echo $er_gender;?></span>
                                </div>
                            </td>
                            <td>
                                <div class="radio1">
                                    <ul>
                                        <li style="list-style:none;">
                                            <input style="width: 5%; height: 1.3em;margin-left: 280px; " type="checkbox" name="designation" value="manager" <?php if ($designation == 'manager') echo 'checked="checked"'; ?>>
                                            <span style="font-size: 25px; color: yellow">Manager</span>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="textbox1">
                                    <input type="text" name="address" value="<?php echo $address;?>" placeholder="Address">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="textbox1">
                                    <input type="text" name="salary" value="<?php echo $salary;?>" placeholder="Salary(TK)">
                                </div>
                                <span id="span1" style="color: white;"><?php echo $er_salary;?></span>
                            </td>
                        </tr>
                    </table>
                </div>

                <div id="employeedetails">
                    <div>
                        <input type="text" style="padding: 10px;font-size: 17px;border: none;float: left; color: black;background-color: #FEE12B; margin-top: 180px; margin-left: 62px; width: 93%; border-radius: 25px; border-bottom-width: 15px;" name="search_text" id="search_text" placeholder="Search by Employee Details" />
                    </div>
                    <br />
                    <div>
                        <div id="result"></div>
                    </div>
                </div>
            </div>
            <div id="movieshowdetails">
                    <div>
                        <input type="text" style="padding: 10px;font-size: 17px;border: none;float: left; color: black;background-color: #FEE12B; margin-top: 180px; margin-left: 62px; width: 93%; border-radius: 25px; border-bottom-width: 15px;" name="search_show" id="search_show" placeholder="Search by Show Details" />
                    </div>
                    <br />
                    <div>
                        <div id="resultshow"></div>
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
    
</script>

<script>
    function validatePassword() 
    {
        var oldPassword, newPassword, confirmPassword, output = true;

        oldPassword = document.admin.opwd;
        newPassword = document.admin.npwd;
        confirmPassword = document.admin.cpwd;

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
