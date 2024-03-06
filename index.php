<?php

include 'connection.php';


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (isset($_SESSION['username'])) {
    // Redirect to menu.php if the user is logged in
    header("Location: menu.php");
    exit();
}


$errorMsg = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $username = $_POST["username"];
    $password = $_POST["password"];

  
    $sql = "SELECT * FROM login WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
     
        $row = $result->fetch_assoc();
        $username = $row['username'];

        
        $_SESSION['username'] = $username;


    
        header("Location: menu.php");
        exit();
    } else {
      
        $errorMsg = "Invalid username or password.";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Login Form</title>
    <link rel="stylesheet" href="./CSS/bootstrap/css/bootstrap.min.css">
    <script src="./CSS/bootstrap/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container d-flex flex-column justify-content-between align-items-center py-3 rounded">
        <img class="w-50" src="img/logokapistahan.jpg" alt="Logo">
        <div class="w-100">
            <form action="" method="post">
                <h2 class="mb-3 fw-bold fs-1 text-center">Login</h2>
                <?php if (!empty($errorMsg)) {
                    echo "<span style='color:red;'>$errorMsg</span>";
                }
                ?>
                <div class="mb-3">
                    <label for="username">Username:</label>
                    <input name="username" type="text" class="form-control py-3" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <label for="password">Password:</label>
                    <div class="password-container">
                        <input type="password" name="password" id="password" class="form-control py-3" placeholder="Password" required>
                        <div class="show-password-container">
                            <input type="checkbox" id="showPassword" onclick="showHidePassword()">
                            <label class="checkbox-label" for="showPassword">Show Password</label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success form-control py-3">Login</button><br>
            </form>
        </div>
        <!-- <footer>
            <p>&copy;2023 Property Management System of Kapistahan Lodge and Suites.All rights</p>
        </footer> -->
    </div>

    <script>
        function showHidePassword() {
            var passwordField = document.getElementById("password");
            var showPasswordCheckbox = document.getElementById("showPassword");

            if (showPasswordCheckbox.checked) {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }
    </script>
      <script src="js/script.js"></script>
</body>

</html>
