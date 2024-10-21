<?php
session_start();
$number = $_SESSION['number'] ?? 'Guest';
$fname = $_SESSION['fname'] ?? 'First Name';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="navigation.css">
    <link rel="stylesheet" href="main.css">
</head>
<body>
<header class="header" id="header">
  <nav class="nav containernav">
  <a href="index.php" class="nav__logo"><img id="logo"src="images/logo.png" alt="LOGO"></a>
  <div class="nav__menu" id="nav-menu">
    <ul class="nav__list">
      <li class="nav__item">
        <a href="index.php" class="nav__link">
        <i class='bx bx-home-alt nav__icon'></i>
        <span class="nav__name">Home</span>
        </a>
      </li>
      <li class="nav__item">
        <a href="profile.php" class="nav__link">
        <i class='bx bx-user nav__icon' ></i>
        <span class="nav__name">Profile</span>
        </a>
      </li>
      <?php if ($_SESSION['number']== '9815842010'): ?>
                <li class="nav__item">
                    <a href="chart.php" class="nav__link">
                        <i class='bx bx-notepad nav__icon'></i>
                        <span class="nav__name">Chart</span>
                    </a>
                </li>
                <?php endif; ?>
      <li class="nav__item">
        <a href="yourbookings.php" class="nav__link">
        <i class='bx bxs-plane-alt nav__icon'></i>
        <span class="nav__name">Bookings</span>
        </a>
      </li>
      <li class="nav__item">
                    <a href="logout.php" class="nav__link">
                        <i class='bx bx-log-out nav__icon'></i>
                        <span class="nav__name">Logout</span>
                    </a>
                </li>
    </ul>
  </div>
  </nav>
</header>
    <div class="profile-container">
        <h1>Profile</h1>
        <p><strong>Number:</strong> <?php echo $number; ?></p>
        <p><strong>First Name:</strong> <?php echo $fname; ?></p>
    </div>
</body>
</html>
