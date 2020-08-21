<html>

<head>
    <title>MovieTicket</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Mukta|Roboto|Trade+Winds|Rubik&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<body>
       
   <?php
            error_reporting(0);
            ob_start();
            $db = mysqli_connect('localhost', 'root', '', 'movieticket');
            
    
            $imagefromdb = array();
            $sql = "SELECT * FROM movie";
            $result = mysqli_query($db,$sql);
            while($row = mysqli_fetch_array($result))
            {
               $imagefromdb[] =  $row['image'];
            }
    
    
            $sqlcs = "SELECT * FROM comingsoon";
            $resultcs = mysqli_query($db,$sqlcs);
            while($rowcs = mysqli_fetch_array($resultcs))
            {
               $imagefromdbcs[] =  $rowcs['image'];
            }
    
    ?>
    <form>
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
                <li><a href="#followus">Follow us</a></li>
                <li><a href="login.php">Sign In</a></li>
            </ul>
        </header>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <section>
            <div class="slidershow">
                <div class="slides">
                    <input type="radio" name="r" id="r1" checked>
                    <input type="radio" name="r" id="r2">
                    <input type="radio" name="r" id="r3">
                    <input type="radio" name="r" id="r4">
                    <input type="radio" name="r" id="r5">
                    <div class="slide s1">
                        <img src="images/img1.jpg" alt="">
                    </div>
                    <div class="slide">
                        <img src="images/img2.jpg" alt="">
                    </div>
                    <div class="slide">
                        <img src="images/img3.jpg" alt="">
                    </div>
                    <div class="slide">
                        <img src="images/img4.jpg" alt="">
                    </div>
                    <div class="slide">
                        <img src="images/img5.jpg" alt="">
                    </div>
                </div>

                <div class="navigation">
                    <label for="r1" class="bar"></label>
                    <label for="r2" class="bar"></label>
                    <label for="r3" class="bar"></label>
                    <label for="r4" class="bar"></label>
                    <label for="r5" class="bar"></label>
                </div>
            </div>

            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <div ID="home">
                <div class="nowplaying">
                    <h1 style="color: white">&nbsp &nbsp &nbsp Now Playing</h1>
                    <br><br>
                    <div class="nowplayingposters">
                        <div class="poster">
                           <?php 
                                echo "<img src='images/".$imagefromdb[0]."'  alt='' style='width:100%'>";
                            ?>
                        </div>
                        <div class="poster">
                            <?php 
                                echo "<img src='images/".$imagefromdb[1]."'  alt='' style='width:100%'>";
                            ?>
                        </div>
                        <div class="poster">
                            <?php 
                                echo "<img src='images/".$imagefromdb[2]."'  alt='' style='width:100%'>";
                            ?>
                        </div>
                        <div class="poster">
                            <?php 
                                echo "<img src='images/".$imagefromdb[3]."'  alt='' style='width:100%'>";
                            ?>
                        </div>
                        <div class="poster">
                            <?php 
                                echo "<img src='images/".$imagefromdb[4]."'  alt='' style='width:100%'>";
                            ?>
                        </div>
                    </div>
                </div>
                <br><br><br><br><br><br><br><br>
                <div class="comingsoon">
                    <h1 style="color: white">&nbsp &nbsp &nbsp Coming Soon</h1>
                    <br><br>
                    <div class="comingsoonposters">
                        <div class="poster">
                            <?php 
                                echo "<img src='images/".$imagefromdbcs[0]."'  alt='' style='width:100%'>";
                            ?>
                        </div>
                        <div class="poster">
                            <?php 
                                echo "<img src='images/".$imagefromdbcs[1]."'  alt='' style='width:100%'>";
                            ?>
                        </div>
                        <div class="poster">
                            <?php 
                                echo "<img src='images/".$imagefromdbcs[2]."'  alt='' style='width:100%'>";
                            ?>
                        </div>
                        <div class="poster">
                            <?php 
                                echo "<img src='images/".$imagefromdbcs[3]."'  alt='' style='width:100%'>";
                            ?>
                        </div>
                        <div class="poster">
                            <?php 
                                echo "<img src='images/".$imagefromdbcs[4]."'  alt='' style='width:100%'>";
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <br><br> <br><br><br><br> <br><br>
            <div class="partners">
                <h1 style="color: white">&nbsp &nbsp &nbsp Partners </h1> <br><br><br><br>
                <div class="ppartner">
                    <img src="images/partner1.jpg" alt="" style="width:100%">
                </div>
                <div class="ppartner">
                    <img src="images/partner2.jpg" alt="" style="width:100%">
                </div>
            </div>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <div class="about">
                <h1 style="font-size: 30px; text-shadow: 1px 2px 5px yellow; color: white"> &nbsp &nbsp &nbsp About</h1>
                <div id="about">
                    <br><br>
                    <p align="center">What we do is make people happy, but who we are is a small team of curious people. Curious about your happiness, what makes you special, what you’re experts in. We want to know the what, the why, the how–pick your brain and turn the findings into happiness.<br><br>
                        We’ve spent the past five years learning about movies and happiness, new and old, local and abroad. Our passion is to take what we earn from you happiness and turn that into our goal that can accomplish anything.</p>
                </div>
            </div>
            <br><br><br><br>
            <h1 style="font-size: 30px; text-shadow: 1px 2px 5px yellow; color: white"> &nbsp &nbsp &nbsp Follow Us</h1><br><br><br><br>
            <div id="followus">
                <div class="card">
                    <i class="card-icon fab fa-facebook-square"></i>
                    <p id="1">&nbsp &nbsp &nbsp fb.com<br>/movieclub</p>
                </div>

                <div class="card">
                    <i class="card-icon fab fa-instagram-square"></i>
                    <p id="1"> &nbsp &nbsp movieclub</p>
                </div>

                <div class="card">
                    <i class="card-icon fab fa-snapchat-square"></i>
                    <p id="1">&nbsp &nbsp movieclub9</p>
                </div>
                <div class="card">
                    <i class="card-icon fab fa-linkedin"></i>
                    <p id="1">&nbsp &nbsp Movie club</p>
                </div>
                <div class="card">
                    <i class="card-icon fab fa-twitter-square"></i>
                    <p id="1">&nbsp &nbsp Movie_club</p>
                </div>
            </div>
            <br><br> <br><br>
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
            <br><br><br><br><br><br><br>
            <h6 style="text-align: center; color: yellow; letter-spacing: 2px">© 2020 Webtech sec: A</h6>
            <br><br><br>
        </section>
    </form>
</body>

</html>
