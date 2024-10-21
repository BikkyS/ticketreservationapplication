<?php
// If the user is already logged in, redirect to index.php
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header('Location: index.php');
    exit();
}

require_once './db/config.php';

// Initialize variables
$number = $password = $fname = '';
$err = '';

// If the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if number and password are entered
    if (empty(trim($_POST['number'])) || empty(trim($_POST['password']))) {
        $err = "Please enter number and password.";
    } else {
        $number = trim($_POST['number']);
        $password = trim($_POST['password']);
    }

    // If no errors, proceed to check in the database
    if (empty($err)) {
        $sql = "SELECT id, number, fname, lname, password FROM users WHERE number=?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_number);
            $param_number = $number;

            // Execute the query
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                // Check if the number exists in the database
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind the result to variables
                    mysqli_stmt_bind_result($stmt, $id, $number, $fname, $lname, $hashed_password);

                    if (mysqli_stmt_fetch($stmt)) {
                        // Verify the password
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, set session variables
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["number"] = $number;
                            $_SESSION["fname"] = $fname;
                            $_SESSION["login"] = "ok";

                            // Set cookie for number (optional)
                            setcookie('number', $_SESSION["loggedin"], time() + (86400 * 30)); // 30 days expiry

                            // Redirect to index.php
                            header("Location: index.php");
                            exit();
                        } else {
                            $err = "Invalid password.";
                        }
                    }
                } else {
                    $err = "No account found with that number.";
                }
            } else {
                $err = "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="login.css">
    <script>
        function preventBack() { window.history.forward(); }
        setTimeout("preventBack()", 0);
        window.onunload = function() { null; }
    </script>
</head>
<body>
    <div class="bg-modal">
        <div class="modal-content">
            <div class="close">+</div>
            <h2>LOGIN</h2>
            <form method="post">
                <label>Mobile Number</label>
                <select>
                    <option>+977</option>
                </select>
                <input type="text" placeholder="Mobile Number" name="number" required>
                <label>Password</label>
                <input type="password" placeholder="Password" name="password" required>
                <button type="submit">Login</button>
            </form>
            <div>Not Registered?<a href="signup_form.php"><b> Signup</b></a></div>

            <!-- Display error if exists -->
            <?php if (!empty($err)): ?>
                <div style="color:red;"><?php echo $err; ?></div>
            <?php endif; ?>
        </div>
    </div>
    <script type="text/javascript" src="login.js"></script>
</body>
</html>
