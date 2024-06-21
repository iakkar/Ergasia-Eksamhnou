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
    <div class="createDiv">
        <?php
            if (isset($_SESSION['userID'])) {
                echo "<form id='listForm' action='create.php' method='POST' enctype='multipart/form-data'>";
                    echo "<h2 style=\"text-align: center;\">Let's create a listing {$_SESSION['username']}!</h2>";
                    echo "<input type='text' name='title' placeholder='Listing Title' required></input>";
                    echo "<input type='text' name='area' placeholder='Area' required></input>";
                    echo "<input type='number' name='rooms' placeholder='Rooms' required></input>";
                    echo "<input type='number' name='price' placeholder='Price (€)' required></input>";
                    echo "<div id='dropBox' class='dropBox'>";
                        echo "<p>Drag & Drop or click to select 3 .jpg images.</p>";
                        echo "<input type='file' id='photos' accept='image/jpeg' name='photos[]' multiple style='display:none;'></input>";
                        echo "<div id='preview'></div>";
                    echo "</div>";
                    echo "<button type='submit' name='create'>Create Listing</button>";
                echo "</form>";
            } else {
                echo "<h2>You need to be logged in to create a listing</h2><h2>Click <a onclick='gotoLogin()'>here</a> to get redirected <br> to the Login page</h2>";
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

        function gotoLogin() {
            window.location.href = "login.php";
        }

        function gotoFeed() {
            window.location.href = "feed.php";
        }

        document.addEventListener("DOMContentLoaded", function() {
            var dropBox = document.getElementById('dropBox');
            var photos = document.getElementById('photos');
            var preview = document.getElementById('preview');

            dropBox.addEventListener('click', function() {
                photos.click();
            });

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropBox.addEventListener(eventName, preventDefaults, false);
                document.body.addEventListener(eventName, preventDefaults, false);
            });

            ['dragenter', 'dragover'].forEach(eventName => {
                dropBox.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropBox.addEventListener(eventName, unhighlight, false);
            });

            dropBox.addEventListener('drop', handleDrop, false);
            photos.addEventListener('change', function() {
                handleFiles(photos.files);
            }, false);

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            function highlight() {
                dropBox.classList.add('over');
            }

            function unhighlight() {
                dropBox.classList.remove('over');
            }

            function handleDrop(e) {
                var dt = e.dataTransfer;
                var files = dt.files;

                handleFiles(files);
            }

            function handleFiles(files) {
                files = [...files];
                files = files.filter(file => file.type === 'image/jpeg');
                files.forEach(previewFile);

                // Create a new DataTransfer object and append the new files
                var dataTransfer = new DataTransfer();
                [...photos.files].forEach(file => dataTransfer.items.add(file));
                files.forEach(file => dataTransfer.items.add(file));

                // Set the files to the input
                photos.files = dataTransfer.files;
            }

            function previewFile(file) {
                let reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onloadend = function() {
                    let img = document.createElement('img');
                    img.src = reader.result;
                    preview.appendChild(img);
                }
            }
        });

        document.getElementById('listForm').addEventListener('submit', function(event) {
            let title = document.querySelector('input[name="title"]').value;
            let area = document.querySelector('input[name="area"]').value;
            let rooms = document.querySelector('input[name="rooms"]').value;
            let price = document.querySelector('input[name="price"]').value;

            // Regex for checking if the input contains only characters and spaces
            let textRegex = /^[a-zA-Z ]+$/;

            // Check for Title: only characters and max length 30
            if (!textRegex.test(title)) {
                alert("Title should only consist of characters.");
                event.preventDefault(); // Prevent form submission
            } else if (title.length > 30) {
                alert("Title should consist of 30 or less characters.");
                event.preventDefault(); // Prevent form submission
            }

            // Check for Area: only characters and max length 30
            else if (!textRegex.test(area)) {
                alert("Area should only consist of characters.");
                event.preventDefault(); // Prevent form submission
            } else if (area.length > 30) {
                alert("Area should consist of 30 or less characters.");
                event.preventDefault(); // Prevent form submission
            }

            // Check for Number of Rooms: must be an integer
            else if (!Number.isInteger(parseInt(rooms))) {
                alert("Number of rooms should be an integer.");
                event.preventDefault(); // Prevent form submission
            }

            // Check for Price: must be an integer
            else if (!Number.isInteger(parseInt(price))) {
                alert("Price should be an integer.");
                event.preventDefault(); // Prevent form submission
            }
        });

    </script>
    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['create']) && isset($_FILES['photos'])) {
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "ds_estate";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // SQL query to get the maximum listingID
                $sql = "SELECT MAX(listingID) AS maxListingID FROM listings";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Fetch the result row
                    $row = $result->fetch_assoc();
                    $maxListingID = $row['maxListingID'];
                } else {
                    $maxListingID = 0;
                }

                $maxListingID += 1;
                $dir = "../assets/houses/house{$maxListingID}";

                if (!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                }

                $fileCount = count($_FILES['photos']['name']);
                $uploadedFiles = [];

                for ($i = 0; $i < $fileCount; $i++) {
                    $fileName = ($i + 1) . '.jpg'; // Generate filename like 1.jpg, 2.jpg, 3.jpg
                    $fileTmpName = $_FILES['photos']['tmp_name'][$i];
                    $fileType = $_FILES['photos']['type'][$i];
                    $fileError = $_FILES['photos']['error'][$i];
                    $fileSize = $_FILES['photos']['size'][$i];

                    // Check if file is a valid JPEG and there is no upload error
                    if ($fileType === 'image/jpeg' && $fileError === UPLOAD_ERR_OK) {
                        $destination = $dir . '/' . $fileName;

                        // Move uploaded file to the destination directory
                        if (move_uploaded_file($fileTmpName, $destination)) {
                            $uploadedFiles[] = $destination;
                        }
                    }
                }

                if(!preg_match('/^[a-zA-Z ]+$/', $_POST['title'])) {
                    echo "<script type='text/javascript'>alert(\"Title should only consist of characters.\");</script>";    
                }else if(strlen($_POST['title']) > 30) {
                    echo "<script type='text/javascript'>alert(\"Title should consist of 30 or less characters.\");</script>";    
                } else if (!preg_match('/^[a-zA-Z ]+$/', $_POST['area'])) {
                    echo "<script type='text/javascript'>alert(\"Area should only consist of characters.\");</script>";    
                } else if(strlen($_POST['area']) > 30) {
                    echo "<script type='text/javascript'>alert(\"Area should consist of 30 or less characters.\");</script>";    
                } else if (!filter_var($_POST['rooms'], FILTER_VALIDATE_INT)) {
                    echo "<script type='text/javascript'>alert(\"Number of rooms should be an integer.\");</script>";    
                } else if (!filter_var($_POST['price'], FILTER_VALIDATE_INT)) {
                    echo "<script type='text/javascript'>alert(\"Price should be an integer.\");</script>";    
                }  else {

                    $title = trim($_POST['title']);
                    $area = trim($_POST['area']);
                    $rooms = trim($_POST['rooms']);
                    $price = trim($_POST['price']);
                    $user = $_SESSION['userID'];

                    $query = $conn -> prepare("INSERT INTO listings (photoLocation, title, area, rooms, price , userID) VALUES (?,?,?,?,?,?)");
                    $query -> bind_param("ssssss", $dir, $title, $area, $rooms, $price, $user);
                    
                    if ($query -> execute() === TRUE) {
                        echo "<script type=\"text/javascript\">alert(\"Listing uploaded successfully! You will be redirected to the Feed page.\");gotoFeed();\");</script>";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }

                    // Close database connection
                    $conn->close();
                }
            }
        }
    ?>
</body>
</html>
