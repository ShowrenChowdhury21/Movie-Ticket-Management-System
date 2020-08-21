<html>

<head>
    <title>Sign in</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Mukta|Roboto|Trade+Winds|Rubik&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<body>

    <?php
                
                ob_start();
                session_start();

                $db = mysqli_connect('localhost', 'root', '', 'movieticket');
    
                error_reporting(0);
                $email = $_POST['email'];
                $password = $_POST['password'];
                $er_email = " ";
                $er_password = " ";
                $_SESSION['last_time'] = time();
    
                if(isset($_POST["submit"]))
                {
                    if (count($errors) == 0) 
                    {
                        $password = md5($password);
                        
                        $query = "SELECT * FROM login WHERE email='$email' AND password='$password'";
                                                
                        
                        if ($result = $db->query($query)) 
                        {    
                             while ($row = $result->fetch_object())
                             {
                                $id = $row->id;
                                $fname = $row->fname;
                                $demail = $row->email;
                                $dpass = $row->password;
                                $role =$row->role;                                           
                             }
                            $result->close();
                            
                            if($demail == $email)
                            {
                                if($dpass == $password)
                                {
                                    if($role == 3)
                                    {
                                        $_SESSION['fname'] = $fname;
                                        $_SESSION['id'] = $id;
                                        $_SESSION['email'] = $demail;                                       
                                        header('location: Homeuser.php');
                                    }
                                    if($role == 2)
                                    {
                                        $_SESSION['fname'] = $fname;
                                        $_SESSION['id'] = $id;
                                        $_SESSION['email'] = $demail;
                                        header('location: Homemanager.php');
                                    }
                                    if($role == 1)
                                    {
                                        $_SESSION['fname'] = $fname;
                                        $_SESSION['id'] = $id;
                                        $_SESSION['email'] = $demail;
                                        header('location: Homeadmin.php');
                                    }
                                }
                                else 
                                {
                                    $er_email = "Wrong email/password combination";
                                    array_push($errors);
                                }
                            }
                            else 
                            {
                                $er_email = "Wrong email/password combination";
                                array_push($errors);
                            }
                        }            
                    }
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
            <li><a href="#login">Sign In</a></li>
        </ul>
    </header>
    <section>
        <form method="post">
            <div id="login">
                <h1>Sign in</h1>

                <div class="textbox">
                    <i class="fas fa-user"></i>
                    <input type="text" name="email" value="<?php echo $email;?>" placeholder="E-mail" required>
                </div>
                <span id="span1" style="color: white;"><?php echo $er_email;?></span>
                <div class="textbox">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="password" required>
                </div>
                <span id="span1" style="color: white;"><?php echo $er_password;?></span>
                <br>

                <input class="btn" type="submit" name="submit" value="Sign In">
                <h5 align="center">Don't have an account?</h5>
                <input class="btn" type="button" name="signup" value="Sign Up" onclick="window.location.href = 'signup.php'">
            </div>
        </form>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
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
        <br><br><br><br>
        <h6 style="text-align: center; color: yellow; letter-spacing: 2px">© 2020 Webtech sec: A</h6><br><br>
    </section>
</body>

</html>
