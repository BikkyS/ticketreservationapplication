<?php
session_start();
$_SESSION['notification'] = "ok";
$from = $_POST['from'];
$to = $_POST['to'];
$busft = $_POST['bus'];

if (isset($_COOKIE['cseat'])) {
    setcookie('cseat', false);
}
if (isset($_COOKIE['camount'])) {
    setcookie('camount', false);
}

if ($from == "Select From" || $to == "Select To" || $busft == "No Bus Available" || $busft == "Select Bus") {
    header("location:index.php");
    exit();
}

$_SESSION["busft"] = $busft;
$bus = strtolower($busft . $from . $to);

// Create connection
$conn = mysqli_connect('db', 'root', 'example', $bus);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



if (isset($_POST["search"])) {
    $month = $_POST['month'];
    $months = ["Baishakh", "Jestha", "Ashadh", "Shrawan", "Bhadau", "Ashwin", "Kartik", "Mangsir", "Poush", "Magh", "Falgun", "Chaitra"];
    
    foreach ($months as $x => $m) {
        if ($month == $m) {
            $_SESSION['month'] = $m;
        }
    }

    $day = $_POST['day'];
    $_SESSION['day'] = $day;
    $year = $_POST['year'];
    $_SESSION['year'] = $year;
    $date = $day . "_" . $month . "_" . $year;
    
    $_SESSION["date"] = $date;
    $_SESSION["bus"] = $bus;
    $_SESSION["from"] = $from;
    $_SESSION["to"] = $to;

    // Create table if it doesn't exist
    $createTableQuery = "CREATE TABLE IF NOT EXISTS `$date` (
        `Seatno` VARCHAR(500) NOT NULL,
        `TicketID` VARCHAR(255) NOT NULL,
        `FullName` TEXT NOT NULL,
        `Gender` TEXT NOT NULL,
        `MobileNumber` TEXT NOT NULL,
        `BoardingAddress` TEXT NOT NULL,
        `DepartureAddress` TEXT NOT NULL,
        `From` TEXT NOT NULL,
        `To` TEXT NOT NULL,
        `BookedBy` VARCHAR(255) NOT NULL,
        `TotalAmount` INT(255) NOT NULL,
        `AdvanceAmount` INT(255) NOT NULL,
        `DueAmount` INT(255) NOT NULL,
        `Status` TEXT NOT NULL,
        `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`TicketID`),
        FOREIGN KEY (TicketID) REFERENCES allbooking(TicketID) ON UPDATE CASCADE
    )";

    if (!mysqli_query($conn, $createTableQuery)) {
        die("Error creating table: " . mysqli_error($conn));
    }

    // Fetch data from the table
    $sql = "SELECT * FROM `$date`";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $x = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $_SESSION['row_counts_' . ++$x] = $row['Seatno'];
        }
        $_SESSION['num'] = $x;
    } else {
        echo "Error fetching data: " . mysqli_error($conn);
    }

    mysqli_close($conn);

    // Redirect back to index.php
    header("Location: index.php");
    exit();
}
?>
