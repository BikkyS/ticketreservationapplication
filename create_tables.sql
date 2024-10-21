USE registration;
CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    number BIGINT(20) NOT NULL,
    fname TEXT NOT NULL,
    lname TEXT NOT NULL,
    password VARCHAR(15000) NOT NULL
);

USE allbooking;
CREATE TABLE IF NOT EXISTS allbookings (
    Bus VARCHAR(255),
    Seatno VARCHAR(500),
    TicketID VARCHAR(255) PRIMARY KEY,
    FullName TEXT,
    Gender TEXT,
    MobileNumber TEXT,
    BoardingAddress TEXT,
    DepartureAddress TEXT,
    `From` TEXT,
    `To` TEXT,
    BookedBy VARCHAR(255),
    TotalAmount INT(255),
    AdvanceAmount INT(255),
    DueAmount INT(255),
    `Status` TEXT,
    bookingdate VARCHAR(255)
);

USE sangrilamalangwakathmandu;
CREATE TABLE IF NOT EXISTS allbooking (
    Seatno VARCHAR(500) NOT NULL,
    TicketID VARCHAR(255) PRIMARY KEY,
    FullName TEXT NOT NULL,
    Gender TEXT NOT NULL,
    MobileNumber TEXT NOT NULL,
    BoardingAddress TEXT NOT NULL,
    DepartureAddress TEXT NOT NULL,
    `From` TEXT NOT NULL,
    `To` TEXT NOT NULL,
    BookedBy VARCHAR(255) NOT NULL,
    TotalAmount INT(255) NOT NULL,
    AdvanceAmount INT(255) NOT NULL,
    DueAmount INT(255) NOT NULL,
    Status TEXT NOT NULL,
    `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);
