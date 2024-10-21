<?php
session_start();

$buscn = $_POST['busdb'];
$bookingdate = $_POST['bookingdate'];
$seatno = $_POST['seatno'];
$cancelid = $_POST['tktid'];
$canceli = strtolower($cancelid);

// Connect to the main database
$db = mysqli_connect("db", "root", "example", "allbooking");

if (!$db) {
    die("Connection to main database failed: " . mysqli_connect_error());
}

// Delete from the 'allbookings' table
$sql = "DELETE FROM `allbookings` WHERE `TicketID` = ?";
$stmt = mysqli_prepare($db, $sql);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $param_tktid);
    $param_tktid = $canceli;
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
} else {
    die("Error preparing delete query: " . mysqli_error($db));
}
mysqli_close($db);

// Remove spaces from bus table name
$busdd = strtolower(str_replace(' ', '', $buscn));

// Connect to the bus-specific database
$conni = mysqli_connect("db", "root", "example", $busdd);
if (!$conni) {
    die("Connection to bus-specific database failed: " . mysqli_connect_error());
}

// Update the 'allbooking' table in the bus-specific database
$sql = "UPDATE `allbooking` SET `Seatno` = CONCAT(?, '(canceled)') WHERE `TicketID` = ?";
$stmt = mysqli_prepare($conni, $sql);
if ($stmt) {
    $param_seatno = $seatno;
    $param_tktid = $canceli;
    mysqli_stmt_bind_param($stmt, "ss", $param_seatno, $param_tktid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
} else {
    die("Error preparing update query for allbooking: " . mysqli_error($conni));
}

// Update the `$bookingdate` table in the bus-specific database
$sql = "UPDATE `$bookingdate` SET `Seatno` = CONCAT(?, '(canceled)') WHERE `TicketID` = ?";
$stmt = mysqli_prepare($conni, $sql);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ss", $param_seatno, $param_tktid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
} else {
    die("Error preparing update query for bookingdate: " . mysqli_error($conni));
}

mysqli_close($conni);

// Set session variable to indicate successful cancellation
$_SESSION["canceltkt"] = "ok";

// Redirect to the bookings page
header("Location: yourbookings.php");
exit();
?>
