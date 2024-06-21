<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>DS Estate</title>
    <link rel="icon" type="image/x-icon" href="../assets/logo/main_circle.png">
    <link rel="stylesheet" href="styles/menu.css">
    <link rel="stylesheet" href="styles/logout.css">
    <link rel="stylesheet" href="styles/footer.css">
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

            .msg {
                width: 90%;
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
                <a class="navButtons" href="create.html">Create Listing</a>
                <a class="navButtons" href="feed.php">Feed</a>
                <?php
                    if (isset($_SESSION['userID'])) {
                        echo "<a class='navButtons' id='logButton' href='logout.php'>Logout</a>";
                    } else {
                        echo "<a class='navButtons' id='logButton' href='login.php'>Login</a>";
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
                                    echo "<a class='navButtons' id='sLogButton' href='logout.php'>Logout</a>";
                                } else {
                                    echo "<a class='navButtons' id='sLogButton' href='login.php'>Login</a>";
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
    <div class="logoutDiv">
        <div class="msg">
            <br>
            <h2>You have been logged out successfully</h2>
            <h2>and can now exit this tab</h2>
            <br>
            <h2>See you back soon</h2>
            <br>
        </div>
        <?php
            session_unset();
            session_destroy();
        ?>
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

        // Check session state and update the menu buttons
        window.onload = function() {
            // Update the button on page load
            updateLogButton();
        };

        function updateLogButton() {
            var logButton = document.getElementById('logButton');
            var sLogButton = document.getElementById('sLogButton');

            <?php if (isset($_SESSION['userID'])): ?>
                logButton.textContent = 'Logout';
                logButton.href = 'logout.php';
                sLogButton.textContent = 'Logout';
                sLogButton.href = 'logout.php';
            <?php else: ?>
                logButton.textContent = 'Login';
                logButton.href = 'login.php';
                sLogButton.textContent = 'Login';
                sLogButton.href = 'login.php';
            <?php endif; ?>
        }
    </script>
</body>
</html>
