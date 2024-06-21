<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>DS Estate</title>
    <link rel="icon" type="image/x-icon" href="../assets/logo/main_circle.png">
    <link rel="stylesheet" href="styles/menu.css">
    <link rel="stylesheet" href="styles/footer.css">
    <link rel="stylesheet" href="styles/login.css">
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <style>

        @media (max-width: 988px) {
            
            .navButtons {
                flex-basis: 100%;
            }
        }

        @media (max-width: 768px) {
            .foot {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 665px) {
            .navBar {
                display: none;
            }

            .divLogoButton {
                justify-content: start;
                flex: 1 1 30%;
                order: 1;
            }

            .smallNavBar {
                justify-content: flex-end;
                flex: 1 1 60%;
                text-align: center;
                order: 2;
                display: flex;
            }

            .menuTitle {
                order: 3;
            }

            .menu {
                height: auto;
            }
            
            .navButtons {
                flex-basis: 100%;
            }
        }

    </style>
</head>
<body>
    <header>
        <div class="menu">
            <div class="divLogoButton">
                <a class="logoButton" href="feed.php">
                    <img style="height: 80px;" alt="DS Logo" src="../assets/logo/main2.png"/>
                </a>
            </div>
            <div class="menuTitle">
                <h2>Digital Systems Estate <br>
                    <i>Redefining the meaning of home</i>
                </h2>
            </div>
            <div class="navBar">
                <a class="navButtons" href="create.php">Create Listing</a>
                <a class="navButtons" href="feed.php">Feed</a>
                <?php
                    if (isset($_SESSION['userID'])) {
                        echo "<a class='navButtons' href='logout.php'>Logout</a>";
                    } else {
                        echo "<a class='navButtons' href='login.php'>Login</a>";
                    }
                ?>
            </div>
            <div class="smallNavBar">
                <div class="mobile-container">
                    <div class="topnav">
                    <div id="myLinks">
                        <a class="navButtons" href="create.html">Create Listing</a>
                        <a class="navButtons" href="feed.php">Feed</a>
                        <?php
                            if (isset($_SESSION['userID'])) {
                                echo "<a class=\"navButtons\" href='logout.php'>Logout</a>";
                            } else {
                                echo "<a class=\"navButtons\" href='login.php'>Login</a>";
                            }
                        ?>
                    </div>
                    <a class="icon" onclick="toggleLinks()">
                        <img style="height: 50px;" src="../assets/hamburger menu/button.png"/>
                    </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="loginDiv">
        <form id="loginForm" action="login.php" method="POST">
            <h2>Login Form</h2>
            <input type="text" name="username" placeholder="Username / email" required></input>
            <input type="password" name="password" placeholder="Password" required></input><br>
            <button type="submit" onclick="updateLogButton()" name="login">Log In</button>
        </form>
        <form id="registerForm" action="login.php" method="POST">
            <h2>Register Form</h2>
            <input type="text" name="name" placeholder="Name" required></input>
            <input type="text" name="surname" placeholder="Surame" required></input>
            <input type="text" name="username" placeholder="Username" required></input>
            <input type="text" name="email" placeholder="Email" required></input>
            <input type="password" name="password" placeholder="Password" required></input><br>
            <button type="submit" name="register">Register</button>
        </form>
        <button id="toggleButton" onclick="toggleForm()"></button>
    </div>
    <footer>
        <div class="foot">
            <div class="contactDetails">
                <h2>Contact Information</h2>
                Phone:<br>
                <div class="footLinks">
                    <a href="tel:+302104142235">+302104142235</a>
                </div>
                Mail:<br>
                <div class="footLinks">
                    <a href="mailto:ds@estate.gr">ds@estate.gr</a>
                </div>
            </div>
            <div class="location">
                <h2>Our Location</h2>
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2645.91144598671!2d23.653626652654477!3d37.94125218289069!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14a1bbe5bb8515a1%3A0x3e0dce8e58812705!2zzqDOsc69zrXPgM65z4PPhM6uzrzOuc6_IM6gzrXOuc-BzrHOuc-Oz4I!5e0!3m2!1sel!2sgr!4v1718317167969!5m2!1sel!2sgr" 
                    width="auto" 
                    height="80%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>
    </footer>
    <script>
        function toggleLinks() {
            var x = document.getElementById("myLinks");
            if (x.style.display === "block") {
                x.style.width = "50px";
                x.style.display = "none";
            } else {
                x.style.display = "block";
                x.style.width = "500px";
            }
        }

        function toggleForm() {
            var lform = document.getElementById("loginForm");
            var rform = document.getElementById("registerForm");
            var button = document.getElementById("toggleButton");


            if (rform.style.display === "none"){
                rform.style.display = "block";
                lform.style.display = "none";
                button.textContent = "Already have an account?";
            } else {
                rform.style.display = "none";
                lform.style.display = "block";
                button.textContent = "Don't have an account?";
            }
        }

        window.onload = function() {
            document.getElementById("registerForm").style.display = "none";
            document.getElementById("loginForm").style.display = "block";
            document.getElementById("toggleButton").textContent = "Don't have an account?";
        };

        function gotoFeed() {
            window.location.href = "feed.php";
        }
    </script>
    <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "ds_estate";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn -> connect_error) {
                die("Failed to connect on the Server. " . $conn -> connect_error);
            }

            //print_r($json_array);

            if (isset($_POST['login']) && isset($_POST['username']) && isset($_POST['password'])) {
                $sql = "SELECT * FROM users";
                $result = $conn->query($sql);

                $json_array = [];
                if ($result -> num_rows > 0){
                    while($row = $result -> fetch_assoc()) {
                        $json_array[] = $row;
                    }
                }

                $username = trim($_POST['username']);
                $password = trim($_POST['password']);
                $userFound = false;
                foreach($json_array as $user) {
                    if(($user["username"] === $username || $user["mail"] === $username) && ($user["password"] === $password)){
                        $userFound = true;
                        break;
                    }
                }

                if($userFound == false){
                    echo "<script type='text/javascript'>alert(\"Wrong Credentials! Try again.\");</script>";
                } else {
                    echo "<script type='text/javascript'>alert(\"Login Successful! You will be redirected to the Feed page.\");gotoFeed();</script>";

                    $_SESSION['userID'] = $user['userID'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['name'] = $user['name'];
                }
            }

            if (isset($_POST['register']) && isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])){
                
                
                if(!preg_match('/^[a-zA-Z]+$/', $_POST['name'])) {
                    echo "<script type='text/javascript'>alert(\"Name should only consist of characters.\");</script>";    
                }else if(strlen($_POST['name']) > 15) {
                    echo "<script type='text/javascript'>alert(\"Name should consist of 15 or less characters.\");</script>";    
                } else if (!preg_match('/^[a-zA-Z]+$/', $_POST['surname'])) {
                    echo "<script type='text/javascript'>alert(\"Surname should only consist of characters.\");</script>";    
                } else if(strlen($_POST['surname']) > 20) {
                    echo "<script type='text/javascript'>alert(\"Surname should consist of 20 or less characters.\");</script>";    
                } else if (strlen($_POST['username']) > 20) {
                    echo "<script type='text/javascript'>alert(\"Username should consist of 20 or less characters.\");</script>";    
                } else if ((strlen($_POST['password']) < 4) || (strlen($_POST['password']) > 10) ) {
                    echo "<script type='text/javascript'>alert(\"Password length should be between 4 and 10 characters.\");</script>";    
                } else if (!preg_match('/\d/', $_POST['password'])) {
                    echo "<script type='text/javascript'>alert(\"Password should contain at least one number.\");</script>";    
                } else if (!(substr_count($_POST['email'], '@') === 1)) {
                    echo "<script type='text/javascript'>alert(\"Email is not valid.\");</script>";    
                } else {
                    $sql = "SELECT * FROM users";
                    $result = $conn->query($sql);

                    $json_array = [];
                    if ($result -> num_rows > 0){
                        while($row = $result -> fetch_assoc()) {
                            $json_array[] = $row;
                        }
                    }

                    $username = trim($_POST['username']);
                    $email = trim($_POST['email']);
                    $usernameFound = false;
                    $emailFound = false;
                    foreach($json_array as $user) {
                        if($user["username"] === $username){
                            $usernameFound = true;
                            break;
                        } else if ($user["mail"] === $email){
                            $emailFound = true;
                            break;
                        }
                    }


                    if (($usernameFound == false) && ($emailFound == false)){
                        $name = trim($_POST['name']);
                        $surname = trim($_POST['surname']);
                        $password = trim($_POST['password']);

                        $query = $conn -> prepare("INSERT INTO users (name, surname, username, password , mail) VALUES (?,?,?,?,?)");
                        $query -> bind_param("sssss", $name, $surname, $username, $password, $email);
                        if ($query -> execute() === TRUE) {
                            echo "<script type=\"text/javascript\">alert(\"Registered successfully!\");</script>";
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                    } else if ($usernameFound == true){
                        echo "<script type=\"text/javascript\">alert(\"Username already in use! Try another one.\");</script>";
                    } else if ($emailFound == true){
                        echo "<script type=\"text/javascript\">alert(\"Email already in use! Try another one.\");</script>";
                    }
                }
            }

            $conn -> close();
        }
    ?>
</body>
</html>