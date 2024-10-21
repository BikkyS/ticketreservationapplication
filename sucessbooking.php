<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$bus = $_SESSION["bus"];
$_SESSION["booked"] = "ok";
$date = $_SESSION["date"];
$busftt = $_SESSION["busft"];
$cookie = $_COOKIE["cseat"];
$Final_amount = $_COOKIE["camount"];
$seat = explode(",", $cookie);
$len = sizeof($seat);
$mainnumber = $_SESSION['number'];
$from = $_SESSION['from'];
$to = $_SESSION['to'];
$Final_amount = (int)$Final_amount;
$discount = isset($_POST['discount']) ? (int)$_POST['discount'] : 0;
$advance = isset($_POST['advance']) ? (int)$_POST['advance'] : 0;
$status = $_SESSION['booking'];
$total_amount_per_person = ($Final_amount - $discount) / $len;
$advance_amount_perperson = $advance / $len;
$due_amount = $total_amount_per_person - $advance_amount_perperson;

if (isset($_SESSION['date'])) {
    $seat = $_POST['seat'];
    $fname = $_POST['fname'];
    $gender = $_POST['gender'];
    $number = $_POST['number'];
    $boaddress = $_POST['boaddress'];
    $depaddress = $_POST['depaddress'];
    
    $db = mysqli_connect("db", "root", "example", "allbooking");
    $conn = mysqli_connect("db", "root", "example", $bus);

    if (!$db) {
        die("Error: Could not connect to allbooking database. " . mysqli_connect_error());
    }
    if (!$conn) {
        die("Error: Could not connect to bus database. " . mysqli_connect_error());
    }

    foreach ($seat as $index => $seats) {
        $last = rand(11111, 99999);
        $uniqticketno = uniqid("T") . $last;

        $sql1 = "INSERT INTO `allbookings` (`Bus`, `Seatno`, `TicketID`, `FullName`, `Gender`, `MobileNumber`, `BoardingAddress`, `DepartureAddress`, `From`, `To`, `BookedBy`, `TotalAmount`, `AdvanceAmount`, `DueAmount`, `bookingdate`, `Status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt1 = mysqli_prepare($db, $sql1);
        if ($stmt1) {
            mysqli_stmt_bind_param($stmt1, "ssssssssssddddss", $busftt, $seats, $uniqticketno, $fname[$index], $gender[$index], $number[$index], $boaddress[$index], $depaddress[$index], $from, $to, $mainnumber, $total_amount_per_person, $advance_amount_perperson, $due_amount, $date, $status);
            if (!mysqli_stmt_execute($stmt1)) {
                die("Error executing query: " . mysqli_stmt_error($stmt1));
            }
            mysqli_stmt_close($stmt1);
        } else {
            die("Error preparing query: " . mysqli_error($db));
        }

        $sql2 = "INSERT INTO `allbooking` (`Seatno`, `TicketID`, `FullName`, `Gender`, `MobileNumber`, `BoardingAddress`, `DepartureAddress`, `From`, `To`, `BookedBy`, `TotalAmount`, `AdvanceAmount`, `DueAmount`, `Status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt2 = mysqli_prepare($conn, $sql2);
        if ($stmt2) {
            mysqli_stmt_bind_param($stmt2, "ssssssssssdsss", $seats, $uniqticketno, $fname[$index], $gender[$index], $number[$index], $boaddress[$index], $depaddress[$index], $from, $to, $mainnumber, $total_amount_per_person, $advance_amount_perperson, $due_amount, $status);
            if (!mysqli_stmt_execute($stmt2)) {
                die("Error executing query: " . mysqli_stmt_error($stmt2));
            }
            mysqli_stmt_close($stmt2);
        } else {
            die("Error preparing query: " . mysqli_error($conn));
        }

        $sql3 = "INSERT INTO `$date` (`Seatno`, `TicketID`, `FullName`, `Gender`, `MobileNumber`, `BoardingAddress`, `DepartureAddress`, `From`, `To`, `BookedBy`, `TotalAmount`, `AdvanceAmount`, `DueAmount`, `Status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt3 = mysqli_prepare($conn, $sql3);
        if ($stmt3) {
            mysqli_stmt_bind_param($stmt3, "ssssssssssdsss", $seats, $uniqticketno, $fname[$index], $gender[$index], $number[$index], $boaddress[$index], $depaddress[$index], $from, $to, $mainnumber, $total_amount_per_person, $advance_amount_perperson, $due_amount, $status);
            if (!mysqli_stmt_execute($stmt3)) {
                die("Error executing query: " . mysqli_stmt_error($stmt3));
            }
            mysqli_stmt_close($stmt3);
        } else {
            die("Error preparing query: " . mysqli_error($conn));
        }
    }

    mysqli_close($db);
    mysqli_close($conn);
}

header("Location: index.php");
exit();
?>
