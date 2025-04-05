-- Create the database
CREATE DATABASE innerpeace;

-- Use the database
USE innerpeace;

-- Table: users
CREATE TABLE `users` (
  `SN` int PRIMARY KEY AUTO_INCREMENT,
  `First_Name` varchar(50),
  `Last_Name` varchar(50),
  `Email` varchar(100) UNIQUE,
  `Avatar` varchar(255) DEFAULT NULL,
  `User_Role` varchar(100) DEFAULT 'user',
  `Pass` varchar(255) DEFAULT NULL,
  `Reg_Date` datetime DEFAULT now()
);


CREATE TABLE user_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    token VARCHAR(255) NOT NULL,
    expires_at DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Table: appointments
CREATE TABLE appointment (
  id INT AUTO_INCREMENT PRIMARY KEY,
  fullname VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  address VARCHAR(255) NOT NULL,
  service VARCHAR(50) NOT NULL,
  date DATE NOT NULL,
  time TIME NOT NULL,
  notes TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
