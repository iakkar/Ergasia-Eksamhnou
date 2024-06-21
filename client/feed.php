<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>DS Estate</title>
    <link rel="icon" type="image/x-icon" href="../assets/logo/main_circle.png">
    <link rel="stylesheet" href="styles/menu.css">
    <link rel="stylesheet" href="styles/listings.css">
    <link rel="stylesheet" href="styles/footer.css">
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @media (max-width: 4000px) {
            .listingBox {
                width: 50%;
            }

            .listingDetails {
                flex-direction: column;
                align-items: flex-start;
            }

            .listingTitle {
                flex: 1;
            }

            .listingData {
                flex: 1;
                justify-content: center;
            }
        }

        @media (max-width: 988px) {
            .listingBox {
                width: 70%;
            }

            .navButtons {
                flex-basis: 100%;
            }

            .listingDetails {
                flex-direction: row;
                align-items: center;
            }

            .listingTitle {
                flex: 2;
            }

            .listingData {
                flex: 3;
                justify-content: flex-start;
            }
        }

        @media (max-width: 768px) {
            .foot {
                grid-template-columns: 1fr;
            }

            .listingDetails {
                flex-direction: column;
                align-items: flex-start;
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

            .listingBox {
                width: 90%;
            }
        }

        /* Back to top button */
        #backToTopBtn {
            display: none; /* Hidden by default */
            position: fixed; /* Fixed/sticky position */
            bottom: 20px; /* Place the button at the bottom of the page */
            right: 30px; /* Place the button 30px from the right */
            z-index: 99; /* Make sure it does not overlap */
            border: none; /* Remove borders */
            outline: none; /* Remove outline */
            background-color: rgba(255, 200, 87, 0.5); /* Set a semi-transparent background color */
            color: white; /* Text color */
            cursor: pointer; /* Add a mouse pointer on hover */
            padding: 15px; /* Some padding */
            border-radius: 10px; /* Rounded corners */
            font-size: 18px; /* Increase font size */
        }

        #backToTopBtn:hover {
            background-color: #ffc857; /* Add a dark-grey background on hover */
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
                        <a class="navButtons" href="create.php">Create Listing</a>
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
    <div class="listings">
        <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "ds_estate";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn -> connect_error) {
                die("Connection Failed: " . $conn -> connect_error);
            }

            $sql = "SELECT * FROM listings";
            $result = $conn->query($sql);

            $json_array = [];
            if ($result -> num_rows > 0){
                while($row = $result -> fetch_assoc()) {
                    $json_array[] = $row;
                }
            }

            if(!empty($json_array)) {
                if (isset($_SESSION['userID'])) {
                    echo "<h2>Welcome back {$_SESSION['username']}!<br><br>View our current Listings</h2>";
                } else {
                    echo "<h2>View our current Listings</h2>";
                }
                foreach($json_array as $data) {
                    echo "<div class=\"listingBox\">";
                        echo "<img class=\"listingImg\" alt=\"House {$data["listingID"]} \" src=\"{$data["photoLocation"]}/1.jpg\"/>";
                        echo "<div class=\"listingInfo\">";
                            echo "<div class=\"listingDetails\">";
                                echo "<div class=\"listingTitle\">";
                                    echo "<h3> {$data["title"]} </h3>";
                                    $usersql = "SELECT username FROM users WHERE userID = '{$data["userID"]}'";
                                    $userResult = $conn->query($usersql);
                                    if ($userResult->num_rows > 0) {
                                        $json_user_array = array();
                                        while ($row = $userResult->fetch_assoc()) {
                                            $json_user_array[] = $row;
                                        }
                                        foreach ($json_user_array as $userData) {
                                            echo "<p style=\"font-size: small;\">Posted by {$userData["username"]}</p>";
                                        }
                                    } else {
                                        echo "<p style=\"font-size: small;\">Error getting the user</p>";
                                    }
                                echo "</div>";
                                echo "<ul class=\"listingData\">";
                                    echo "<li> Area: {$data["area"]} </li>";
                                    echo "<li> Rooms: {$data["rooms"]} </li>";
                                    echo "<li> Price: {$data["price"]} € /day </li>";
                                echo "</ul>";
                            echo "</div>";
                            echo "<div class=\"extraImages\">";
                                echo "<img class=\"extraImg\" alt=\"House {$data["listingID"]} \" src=\"{$data["photoLocation"]}/2.jpg\"/>";
                                echo "<img class=\"extraImg\" alt=\"House {$data["listingID"]} \" src=\"{$data["photoLocation"]}/3.jpg\"/>";
                            echo "</div>";
                                echo "<div class=\"listingButton\">";
                                echo "<a class = \"reserveButton\" href=\"book.php?listingID={$data["listingID"]}\">";
                                    echo "<img style=\"height: 50px;\" src=\"../assets/button/arrow.png\"/>";
                                    echo "Make Reservation";
                                echo "</a>";
                            echo "</div>";
                        echo "</div>";    
                    echo "</div>";
                }
            } else {
                if (isset($_SESSION['userID'])) {
                    echo "<h2>Welcome back {$_SESSION['username']}!<br><br>Currently there are no listings<br><br>Why don't you create one?</h2>";
                } else {
                    echo "<h2>Currently there are no listings</h2>";
                }
            }
            
            $conn -> close();
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
    <button onclick="topFunction()" id="backToTopBtn" title="Back on top">&#11165;</button>
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

        // Get the button
        var mybutton = document.getElementById("backToTopBtn");

        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {
            scrollFunction();
        };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }

        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>
</body>
</html>
