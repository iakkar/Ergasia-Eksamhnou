<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>DS Estate</title>
    <link rel="icon" type="image/x-icon" href="../assets/logo/main_circle.png">
    <link rel="stylesheet" href="styles/menu.css">
    <link rel="stylesheet" href="styles/create.css">
    <link rel="stylesheet" href="styles/footer.css">
    <link rel="stylesheet" href="styles/book.css">
    <link rel="stylesheet" href="styles/listings.css">
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

        @media (max-width: 960px) {
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

        function toggleDivs() {
            var x = document.getElementById("datePicker");
            var y = document.getElementById("bookInfo");

            if (y.style.display === "none") {
                x.style.display = "none";
                y.style.display = "flex";
            } else {
                x.style.display = "none";
                y.style.display = "flex";
            }
        }

        function gotoLogin() {
            window.location.href = "login.php";
        }

        function gotoFeed() {
            window.location.href = "feed.php";
        }
    </script>
    <div class="listings">
        <?php
        if (isset($_SESSION['userID'])) {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "ds_estate";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn -> connect_error) {
                die("Connection Failed: " . $conn -> connect_error);
            }

            $listingID = htmlspecialchars($_GET['listingID']);
            $sql = "SELECT * FROM listings WHERE listingID='{$listingID}'";
            $result = $conn->query($sql);

            $json_array = [];

            if ($result -> num_rows > 0){
                while($row = $result -> fetch_assoc()) {
                    $json_array[] = $row;
                }
            }

            if(!empty($json_array)) {
                foreach($json_array as $data) {
                    echo "<div class=\"listingBox\">";
                        echo "<img class=\"listingImg\" alt=\"House {$data["listingID"]} \" src=\"{$data["photoLocation"]}/1.jpg\"/>";
                        echo "<div class=\"listingInfo\">";
                            echo "<div class=\"listingDetails\">";
                                echo "<div class=\"listingTitle\">";
                                    echo "<h3> {$data["title"]} </h3>";
                                    $usersql = "SELECT username FROM users WHERE userID = '{$data['userID']}'";
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
                            echo "<div id=\"datePicker\" class=\"datePicker\">";
                                echo "<form id=\"bookingForm\" action=\"book.php?listingID={$listingID}\" method=\"POST\">";
                                    echo "<div class=\"divStart\">";
                                        echo "<label for=\"startDate\">From:</label>";
                                        echo "<input type=\"date\" id=\"startDate\" name=\"startDate\" required>";                       
                                    echo "</div>";
                                    echo "<div class=\"divEnd\">";
                                        echo "<label for=\"endDate\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To:</label>";
                                        echo "<input type=\"date\" id=\"endDate\" name=\"endDate\" required>";
                                    echo "</div>";
                                    echo "<button type=\"submit\" name=\"book\" onclick=\"toggleDivs()\">Book Now</button>";
                                echo "</form>";
                            echo "</div>";

                            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                                
                                if (isset($_POST['book']) && isset($_POST['startDate']) && isset($_POST['endDate'])){    
                                    $sql2 = "SELECT * FROM reservations WHERE listingID='{$listingID}'";
                                    $result2 = $conn->query($sql2);
            
                                    $json_array2 = [];
            
                                    if ($result2 -> num_rows > 0){
                                        while($row = $result2 -> fetch_assoc()) {
                                            $json_array2[] = $row;
                                        }
                                    }
            
                                    $reqStart = $_POST['startDate'];
                                    $reqEnd = $_POST['endDate'];

                                    $today = date('Y-m-d');
            
                                    if (($reqStart > $reqEnd) || ($reqStart < $today)) {
                                        echo "<script type='text/javascript'>alert(\"The dates you entered are wrong! Please try again.\");</script>";
                                    } else if(empty($json_array2)) {
                                        $userID = $_SESSION['userID'];
            
                                        $sql3 = "SELECT * FROM users WHERE userID='{$userID}'";
                                        $result3 = $conn->query($sql3);
            
                                        $json_array3 = [];
            
                                        if ($result3 -> num_rows > 0){
                                            while($row = $result3 -> fetch_assoc()) {
                                                $json_array3[] = $row;
                                            }
                                        }
            
                                        if(!empty($json_array3)){
            
                                            foreach($json_array3 as $user) {
                                                $dateStart = new DateTime($reqStart);
                                                $dateEnd = new DateTime($reqEnd);

                                                $interval = $dateStart->diff($dateEnd);
                                                $days = 1 + $interval->days;

                                                $discount = rand(10, 30);
                                                $price = $data['price'] * $days - $data['price'] * $days * ($discount / 100);
                                                echo "<div id=\"bookInfo\" class=\"bookInfo\">";
                                                    echo "<h3>The total will be {$price}€</h3>";
                                                    echo "<h3>We've added a discount of {$discount}%</h3>";
                                                    echo "<h3>Please fill in the booking info</h3>";
                                                    echo "<form id=\"bookInfoForm\" action=\"book.php?listingID={$listingID}\" method=\"POST\">";
                                                        echo "<div class=\"divBookName\">";
                                                            echo "<label for=\"divBookName\">Name:</label>";
                                                            echo "<input type=\"text\" id=\"divBookName\" name=\"BookName\" value=\"{$user['name']}\" required>";                       
                                                        echo "</div>";
                                                        echo "<div class=\"divBookSurname\">";
                                                            echo "<label for=\"divBookSurname\">Surname:</label>";
                                                            echo "<input type=\"text\" id=\"divBookSurname\" name=\"BookSurname\" value=\"{$user['surname']}\" required>";                       
                                                        echo "</div>";
                                                        echo "<div class=\"divBookEmail\">";
                                                            echo "<label for=\"divBookEmail\">Email:</label>";
                                                            echo "<input type=\"text\" id=\"divBookEmail\" name=\"BookEmail\" value=\"{$user['mail']}\" required>";                       
                                                        echo "</div>";
                                                        echo "<input type=\"hidden\" name=\"reqStart\" value=\"{$reqStart}\">";
                                                        echo "<input type=\"hidden\" name=\"reqEnd\" value=\"{$reqEnd}\">";
                                                        echo "<input type=\"hidden\" name=\"price\" value=\"{$price}\">";

                                                        echo "<button type=\"submit\" name=\"bookInfo\">Confirm Information</button>";
                                                    echo "</form>";
                                                echo "</div>";
                                            }
                                            echo "<script>toggleDivs();</script>";

                                            
                                        } else {
                                            echo "<h2 style=\"color: white;\">Error getting user's data.</h2>";
                                        }
            
                                    } else {

                                        $userID = $_SESSION['userID'];
            
                                        $sql3 = "SELECT * FROM users WHERE userID='{$userID}'";
                                        $result3 = $conn->query($sql3);
            
                                        $json_array3 = [];
            
                                        if ($result3 -> num_rows > 0){
                                            while($row = $result3 -> fetch_assoc()) {
                                                $json_array3[] = $row;
                                            }
                                        }
            
                                        if(!empty($json_array3)){
                                            
                                            $available = true;
                                            foreach ($json_array2 as $reservation) {
                                                if (($reservation['fromDate'] >= $reqStart && $reservation['fromDate'] <= $reqEnd) ||
                                                    ($reservation['toDate'] >= $reqStart && $reservation['toDate'] <= $reqEnd) ||
                                                    ($reservation['fromDate'] >= $reqStart && $reservation['toDate'] <= $reqEnd) ||
                                                    ($reservation['fromDate'] <= $reqStart && $reservation['toDate'] >= $reqEnd)) {
                                                    $available = false;
                                                    $reservedFrom = $reservation['fromDate'];
                                                    $reservedTo = $reservation['toDate'];
                                                    break;
                                                }
                                            }

                                            if ($available) {
                                                foreach($json_array3 as $user) {
                                                    $dateStart = new DateTime($reqStart);
                                                    $dateEnd = new DateTime($reqEnd);

                                                    $interval = $dateStart->diff($dateEnd);
                                                    $days = 1 + $interval->days;

                                                    $discount = rand(10, 30);
                                                    $price = $data['price'] * $days - $data['price'] * $days * ($discount / 100);
                                                    echo "<div id=\"bookInfo\" class=\"bookInfo\">";
                                                        echo "<h3>The total will be {$price}€</h3>";
                                                        echo "<h3>We've added a discount of {$discount}%</h3>";
                                                        echo "<h3>Please fill in the booking info</h3>";
                                                        echo "<form id=\"bookInfoForm\" action=\"book.php?listingID={$listingID}\" method=\"POST\">";
                                                            echo "<div class=\"divBookName\">";
                                                                echo "<label for=\"divBookName\">Name:</label>";
                                                                echo "<input type=\"text\" id=\"divBookName\" name=\"BookName\" value=\"{$user['name']}\" required>";                       
                                                            echo "</div>";
                                                            echo "<div class=\"divBookSurname\">";
                                                                echo "<label for=\"divBookSurname\">Surname:</label>";
                                                                echo "<input type=\"text\" id=\"divBookSurname\" name=\"BookSurname\" value=\"{$user['surname']}\" required>";                       
                                                            echo "</div>";
                                                            echo "<div class=\"divBookEmail\">";
                                                                echo "<label for=\"divBookEmail\">Email:</label>";
                                                                echo "<input type=\"text\" id=\"divBookEmail\" name=\"BookEmail\" value=\"{$user['mail']}\" required>";                       
                                                            echo "</div>";
                                                            echo "<input type=\"hidden\" name=\"reqStart\" value=\"{$reqStart}\">";
                                                            echo "<input type=\"hidden\" name=\"reqEnd\" value=\"{$reqEnd}\">";
                                                            echo "<input type=\"hidden\" name=\"price\" value=\"{$price}\">";

                                                            echo "<button type=\"submit\" name=\"bookInfo\">Confirm Information</button>";
                                                        echo "</form>";
                                                    echo "</div>";
                                                }
                                                echo "<script>toggleDivs();</script>";
                                            } else {
                                                echo "<script type='text/javascript'>alert(\"The Listing is reserved from {$reservedFrom} to {$reservedTo}! Please try a different period.\");</script>";
                                            }
                                            
                                        } else {
                                            echo "<h2 style=\"color: white;\">Error getting user's data.</h2>";
                                        }
                                    }
                                } 

                                if(isset($_POST['bookInfo']) && isset($_POST['BookName']) && isset($_POST['BookSurname']) && isset($_POST['BookEmail'])){
                                    $userID = $_SESSION['userID'];
                                    $price = $_POST['price'];
                                    $reqStart = $_POST['reqStart'];
                                    $reqEnd= $_POST['reqEnd'];
                                    $name = $_POST['BookName'];
                                    $surname = $_POST['BookSurname'];
                                    $email = $_POST['BookEmail'];

                                    if(!preg_match('/^[a-zA-Z]+$/', $name)) {
                                        echo "<script type='text/javascript'>alert(\"Name should only consist of characters.\");</script>";    
                                    }else if(strlen($name) > 15) {
                                        echo "<script type='text/javascript'>alert(\"Name should consist of 15 or less characters.\");</script>";    
                                    } else if (!preg_match('/^[a-zA-Z]+$/', $surname)) {
                                        echo "<script type='text/javascript'>alert(\"Surname should only consist of characters.\");</script>";    
                                    } else if(strlen($surname) > 20) {
                                        echo "<script type='text/javascript'>alert(\"Surname should consist of 20 or less characters.\");</script>";    
                                    } else if (!(substr_count($email, '@') === 1)) {
                                        echo "<script type='text/javascript'>alert(\"Email is not valid.\");</script>";    
                                    } else {
                                        $query = $conn -> prepare("INSERT INTO reservations (listingID, cost, fromDate, toDate, name, surname, mail, userID) VALUES (?,?,?,?,?,?,?,?)");
                                        $query -> bind_param("ssssssss", $listingID, $price, $reqStart, $reqEnd, $name, $surname, $email, $userID);
                                        if ($query -> execute() === TRUE) {
                                            echo "<script>alert(\"Reservation Completed! You will be redirected to the Feed page.\");gotoFeed();</script>";
                                        } else {
                                            echo "Error: " . $sql . "<br>" . $conn->error;
                                        }
                                    }
                                }
                            }

                            $conn->close();
                        echo "</div>";    
                    echo "</div>";
                }
            } else {
                echo "<h2 style=\"color: white;\">Error getting Listing.</h2>";
            }
        } else {
            echo "<h2 style=\"color: white;\">You need to be logged in to make a Reservation</h2><h2 style=\"color: white;\">Click <a onclick='gotoLogin()'>here</a> to get redirected to the Login page</h2>";
        }
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
    
    
</body>
</html>