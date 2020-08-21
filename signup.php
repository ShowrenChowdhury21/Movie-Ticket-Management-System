<html>

<head>
    <title>Sign up</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Mukta|Roboto|Trade+Winds|Rubik&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

<body>
    <?php    
            ob_start();
            session_start();
            
            $db = mysqli_connect('localhost', 'root', '', 'movieticket');

                error_reporting(0);
                $fname = validate_input($_POST["fname"]);
                $lname = validate_input($_POST["lname"]);
                $email = validate_input($_POST["email"]);
                $phone = validate_input($_POST["phone"]);
                $password = validate_input($_POST["password"]);
                $conpassword = validate_input($_POST["confirmpassword"]);
    
                $role = 3;
                $boolean = 0;
    
                if(isset($_POST['signup']))
                {                      
                        $user_check_query = "SELECT * FROM customer WHERE email='$email'";
                        $result = mysqli_query($db, $user_check_query);
                        $customer = mysqli_num_rows($result);

                        if ($customer) 
                        {
                            $existemail = "E-mail already exists";
                            array_push($errors);
                            echo "<script type='text/javascript'>alert('$existemail');</script>";
                        }
                        else
                        {   
                                $password1 = md5($conpassword);
                                $id = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);

                                $query = "INSERT INTO customer(id,fname,lname,email,phone,password) VALUES('$id','$fname','$lname','$email','$phone','$password1')";  

                                $firstquery = mysqli_query($db, $query); 
                                
                                if($firstquery)
                                {
                                    $querynew = "INSERT INTO login (id,fname,email,password,role) VALUES('$id','$fname','$email','$password1','$role')";
                                    mysqli_query($db, $querynew);
                                }

				                $_SESSION['fname'] = $fname;
                            	header('location: login.php');
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
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
            <i class="fas fa-bars"></i>
        </label>
        <label class="logo">Movie Club</label>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="#signup">Sign up</a></li>
        </ul>
    </header>
    <section>
        <form action="#" method="post" onSubmit="return validform()">
            <div id="signup">
                <h1>Sign Up here</h1>
                <div class="textbox">
                    <input type="text" name="fname" id="fname" value="<?php echo $fname;?>" placeholder="First Name" autocomplete="off">
                </div>
                 <span id="firstname" style="font-size: 10px;" class="text-danger font-weight-bold"> </span>
                <div class="textbox">
                    <input type="text" name="lname" id="lname" value="<?php echo $lname;?>" placeholder="Last Name" autocomplete="off">
                </div>
                <span id="lastname" style="font-size: 10px;" class="text-danger font-weight-bold"> </span>
                <div class="textbox">
                    <input type="text" name="email" id="email" value="<?php echo $email;?>" placeholder="E-mail" autocomplete="off">
                </div>
                <span id="emailer" style="font-size: 10px;" class="text-danger font-weight-bold"> </span>
                <div class="textbox">
                    <input type="text" name="phone" id="phone" value="<?php echo $phone;?>" placeholder="Phone Number" autocomplete="off">
                </div>
                <span id="phoneer" style="font-size: 10px;" class="text-danger font-weight-bold"> </span>
                <div class="textbox">
                    <input type="password" name="password" id="pass" placeholder="Password" autocomplete="off">
                </div>
                <span id="password1" style="font-size: 10px;" class="text-danger font-weight-bold"> </span>
                <div class="textbox">
                    <input type="password" name="confirmpassword" id="cpass" placeholder="Confirm Password" autocomplete="off">
                </div>
                <span id="password2" style="font-size: 10px;" class="text-danger font-weight-bold"> </span>
                <br>
                <div class="checkbox">
                    <input type="checkbox" name="acceptcondition" value="accepted" id="accept"> &nbsp <span style="font-size: 12px;">I accept the terms and conditions</span>
                </div>
                <span id="checkf" style="font-size: 10px;" class="text-danger font-weight-bold"> </span>
                <input class="btn" type="submit" name="signup" value="Sign Up" autocomplete="off">
                <br><br>
                <h5 align="center">Already have an account?</h5>
                <input class="btn" type="button" name="login" value="Sign In" onclick="window.location.href = 'login.php'">
            </div>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <div class="about">
                <h1 style="font-size: 30px; text-shadow: 1px 2px 5px yellow; color: white"> &nbsp &nbsp &nbsp About</h1>
                <div id="about">
                    <br><br>
                    <p align="center">What we do is make people happy, but who we are is a small team of curious people. Curious about your happiness, what makes you special, what you’re experts in. We want to know the what, the why, the how–pick your brain and turn the findings into happiness.<br>
                        We’ve spent the past five years learning about movies and happiness, new and old, local and abroad. Our passion is to take what we earn from you happiness and turn that into our goal that can accomplish anything.</p>
                </div>
            </div>
            <br><br><br><br><br><br><br>
            <h1 style="font-size: 30px; text-shadow: 1px 2px 5px yellow; color: white">&nbsp &nbsp &nbsp Contact us</h1>
            <br><br><br>

            <div id="contact">
                <div class="card">
                    <i class="card-icon far fa-envelope"></i>
                    <p>info@mclub.com</p>
                </div>

                <div class="card">
                    <i class="card-icon fas fa-phone"></i>
                    <p>+01800000000</p>
                </div>

                <div class="card">
                    <i class="card-icon fas fa-map-marker-alt"></i>
                    <p>Dhaka,Bangladesh</p>
                </div>
            </div>
            <br><br><br><br><br><br>
            <h6 style="text-align: center; color: yellow; letter-spacing: 2px">© 2020 Webtech sec: A</h6><br><br><br><br><br>
        </form>
    </section>
    <script type="text/javascript">

        function validform()
        {

                var fname = document.getElementById('fname').value;
                var lname = document.getElementById('lname').value;
                var phone = document.getElementById('phone').value;
                var email = document.getElementById('email').value;
                var pass = document.getElementById('pass').value;
                var confirmpass = document.getElementById('cpass').value;
                var checkbox = document.getElementById('accept').checked;


                if(fname == "")
                {
                    document.getElementById('firstname').innerHTML = " ** Please fill the first name field";
                    return false;
                }
                if((fname.length <= 2) || (fname.length > 20))
                {
                    document.getElementById('firstname').innerHTML = " ** Username lenght must be between 2 and 20";
                    return false;	
                }
                if(!isNaN(fname))
                {
                    document.getElementById('firstname').innerHTML = " ** only characters are allowed";
                    return false;
                }


                if(lname == "")
                {
                    document.getElementById('lastname').innerHTML = " ** Please fill the first name field";
                    return false;
                }
                if((lname.length <= 2) || (lname.length > 20))
                {
                    document.getElementById('lastname').innerHTML = " ** Username lenght must be between 2 and 20";
                    return false;	
                }
                if(!isNaN(lname))
                {
                    document.getElementById('lastname').innerHTML = " ** only characters are allowed";
                    return false;
                }

                
                if(email == "")
                {
                    document.getElementById('emailer').innerHTML = " ** Please fill the email field";
                    return false;
                }
                if(email.indexOf('@') <= 0 )
                {
                    document.getElementById('emailer').innerHTML = " ** Invalid email";
                    return false;
                }

                if((email.charAt(email.length-4) != '.') && (email.charAt(email.length-3) != '.')){
                    document.getElementById('emailer').innerHTML = " **  Invalid email";
                    return false;
                }

            
                if(phone == "")
                {
                    document.getElementById('phoneer').innerHTML = " ** Please fill the Phone Number field";
                    return false;
                }
                if(isNaN(phone)){
                    document.getElementById('phoneer').innerHTML = " ** write only digits, not characters";
                    return false;
                }
                if(phone.length != 11)
                {
                    document.getElementById('phoneer').innerHTML = " ** Mobile Number must be 11 digits only";
                    return false;
                }
            

                if(pass == "")
                {
                    document.getElementById('password1').innerHTML = " ** Please fill the password field";
                    return false;
                }
                if((pass.length <= 5) || (pass.length > 20)) {
                    document.getElementById('password1').innerHTML = " ** Passwords lenght must be between  5 and 20";
                    return false;	
                }

                if(confirmpass == "")
                {
                    document.getElementById('password2').innerHTML = " ** Please fill the confirmpassword field";
                    return false;
                }
                if(pass != confirmpass)
                {
                    document.getElementById('password2').innerHTML = " ** Password does not match the confirm password";
                    return false;
                }
            
                if(checkbox == false)
                {
                    document.getElementById('checkf').innerHTML = " ** must accept terms and conditions to signup";
                    return false;  
                }

            }

	</script>
</body>
</html>


