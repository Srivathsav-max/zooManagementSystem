-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.4.0.6659
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for zoo_management
CREATE DATABASE IF NOT EXISTS `zoo_management` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `zoo_management`;

-- Dumping structure for table zoo_management.animal
CREATE TABLE IF NOT EXISTS `animal` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Status` varchar(255) NOT NULL,
  `BirthYear` year(4) NOT NULL,
  `SpeciesID` int(11) DEFAULT NULL,
  `EnclosureID` int(11) DEFAULT NULL,
  `BuildingID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `BuildingID` (`BuildingID`),
  KEY `SpeciesID` (`SpeciesID`),
  KEY `EnclosureID` (`EnclosureID`),
  CONSTRAINT `animal_ibfk_1` FOREIGN KEY (`BuildingID`) REFERENCES `building` (`ID`),
  CONSTRAINT `animal_ibfk_2` FOREIGN KEY (`SpeciesID`) REFERENCES `species` (`ID`),
  CONSTRAINT `animal_ibfk_3` FOREIGN KEY (`EnclosureID`) REFERENCES `enclosure` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table zoo_management.animal: ~3 rows (approximately)
INSERT INTO `animal` (`ID`, `Status`, `BirthYear`, `SpeciesID`, `EnclosureID`, `BuildingID`) VALUES
	(5, 'Active', '2023', 1, 1, 3),
	(6, 'Active', '2023', 2, 2, 1),
	(7, 'Active', '2023', 2, 2, 1);

-- Dumping structure for table zoo_management.animalshow
CREATE TABLE IF NOT EXISTS `animalshow` (
  `AnimalShowID` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) DEFAULT NULL,
  `Name` varchar(255) NOT NULL,
  `ShowsPerDay` int(11) NOT NULL,
  `SeniorPrice` int(11) NOT NULL,
  `AdultPrice` int(11) NOT NULL,
  `ChildPrice` int(11) NOT NULL,
  PRIMARY KEY (`AnimalShowID`) USING BTREE,
  UNIQUE KEY `Name` (`Name`),
  KEY `fk_revenuetype` (`id`) USING BTREE,
  CONSTRAINT `fk_revenuetype` FOREIGN KEY (`id`) REFERENCES `revenuetype` (`ID`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table zoo_management.animalshow: ~2 rows (approximately)
INSERT INTO `animalshow` (`AnimalShowID`, `id`, `Name`, `ShowsPerDay`, `SeniorPrice`, `AdultPrice`, `ChildPrice`) VALUES
	(1, 1, 'Circus', 11, 12, 11, 5),
	(3, 1, 'show2', 10, 11, 12, 11);

-- Dumping structure for table zoo_management.animalshowtickets
CREATE TABLE IF NOT EXISTS `animalshowtickets` (
  `TicketID` int(11) NOT NULL AUTO_INCREMENT,
  `AnimalShowID` int(11) DEFAULT NULL,
  `AdultTickets` int(11) NOT NULL,
  `ChildTickets` int(11) NOT NULL,
  `SeniorTickets` int(11) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Attendance` int(11) NOT NULL,
  `Revenue` decimal(10,2) NOT NULL,
  `CheckoutTime` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`TicketID`),
  KEY `AnimalShowID` (`AnimalShowID`),
  CONSTRAINT `animalshowtickets_ibfk_1` FOREIGN KEY (`AnimalShowID`) REFERENCES `animalshow` (`AnimalShowID`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table zoo_management.animalshowtickets: ~3 rows (approximately)
INSERT INTO `animalshowtickets` (`TicketID`, `AnimalShowID`, `AdultTickets`, `ChildTickets`, `SeniorTickets`, `Price`, `Attendance`, `Revenue`, `CheckoutTime`) VALUES
	(26, 1, 1, 1, 1, 28.00, 3, 28.00, '2023-12-13 02:15:31'),
	(27, 3, 1, 1, 1, 34.00, 3, 34.00, '2023-12-13 02:32:48'),
	(28, 3, 1, 1, 1, 34.00, 3, 34.00, '2023-12-13 02:34:58');

-- Dumping structure for table zoo_management.building
CREATE TABLE IF NOT EXISTS `building` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Type` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table zoo_management.building: ~3 rows (approximately)
INSERT INTO `building` (`ID`, `Name`, `Type`) VALUES
	(1, 'Jungle House', 'Safari Exhibit U'),
	(2, 'Concession Building', 'Concession '),
	(3, 'Ticket Counter ', 'Counter');

-- Dumping structure for table zoo_management.caresfor
CREATE TABLE IF NOT EXISTS `caresfor` (
  `EmployeeID` int(11) NOT NULL,
  `SpeciesID` int(11) NOT NULL,
  PRIMARY KEY (`EmployeeID`,`SpeciesID`),
  KEY `SpeciesID` (`SpeciesID`),
  CONSTRAINT `caresfor_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `employee` (`EmployeeID`),
  CONSTRAINT `caresfor_ibfk_2` FOREIGN KEY (`SpeciesID`) REFERENCES `species` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table zoo_management.caresfor: ~1 rows (approximately)
INSERT INTO `caresfor` (`EmployeeID`, `SpeciesID`) VALUES
	(15, 1);

-- Dumping structure for table zoo_management.concession
CREATE TABLE IF NOT EXISTS `concession` (
  `ID` int(11) NOT NULL,
  `Product` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`),
  CONSTRAINT `concession_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `revenuetype` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table zoo_management.concession: ~1 rows (approximately)
INSERT INTO `concession` (`ID`, `Product`) VALUES
	(2, 'Ornaments 1');

-- Dumping structure for table zoo_management.dailyconcessionrevenue
CREATE TABLE IF NOT EXISTS `dailyconcessionrevenue` (
  `RecordID` int(11) NOT NULL AUTO_INCREMENT,
  `ConcessionID` int(11) DEFAULT NULL,
  `Revenue` decimal(10,2) NOT NULL,
  `SaleDate` date NOT NULL DEFAULT curdate(),
  PRIMARY KEY (`RecordID`),
  KEY `ConcessionID` (`ConcessionID`),
  CONSTRAINT `dailyconcessionrevenue_ibfk_1` FOREIGN KEY (`ConcessionID`) REFERENCES `concession` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table zoo_management.dailyconcessionrevenue: ~4 rows (approximately)
INSERT INTO `dailyconcessionrevenue` (`RecordID`, `ConcessionID`, `Revenue`, `SaleDate`) VALUES
	(1, 2, 100.00, '2023-12-11'),
	(2, 2, 1000.00, '2023-12-12'),
	(3, 2, 100.00, '2023-12-12'),
	(4, 2, 11111.00, '2023-12-12');

-- Dumping structure for table zoo_management.employee
CREATE TABLE IF NOT EXISTS `employee` (
  `EmployeeID` int(11) NOT NULL AUTO_INCREMENT,
  `StartDate` varchar(255) NOT NULL,
  `JobType` varchar(255) DEFAULT NULL,
  `FirstName` varchar(255) NOT NULL,
  `MiddleName` varchar(255) DEFAULT NULL,
  `LastName` varchar(255) NOT NULL,
  `Street` varchar(255) NOT NULL,
  `City` varchar(255) NOT NULL,
  `State` varchar(255) NOT NULL,
  `Zip` varchar(255) NOT NULL,
  `SuperID` int(11) DEFAULT NULL,
  `HourlyRateID` int(11) DEFAULT NULL,
  `ConcessionID` int(11) DEFAULT NULL,
  `ZooAdmissionID` int(11) DEFAULT NULL,
  PRIMARY KEY (`EmployeeID`),
  KEY `SuperID` (`SuperID`),
  KEY `HourlyRateID` (`HourlyRateID`),
  KEY `ConcessionID` (`ConcessionID`),
  KEY `ZooAdmissionID` (`ZooAdmissionID`),
  CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`SuperID`) REFERENCES `employee` (`EmployeeID`),
  CONSTRAINT `employee_ibfk_2` FOREIGN KEY (`HourlyRateID`) REFERENCES `hourlyrate` (`ID`),
  CONSTRAINT `employee_ibfk_3` FOREIGN KEY (`ConcessionID`) REFERENCES `concession` (`ID`),
  CONSTRAINT `employee_ibfk_4` FOREIGN KEY (`ZooAdmissionID`) REFERENCES `zooadmission` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table zoo_management.employee: ~2 rows (approximately)
INSERT INTO `employee` (`EmployeeID`, `StartDate`, `JobType`, `FirstName`, `MiddleName`, `LastName`, `Street`, `City`, `State`, `Zip`, `SuperID`, `HourlyRateID`, `ConcessionID`, `ZooAdmissionID`) VALUES
	(15, '2023-12-12', 'Veterinarian', 'Jaya Raj Srivathsav', 'Test', 'Adari', '150 Belmont Ave APT 202', 'Jersey City', 'New Jersey', '7304', NULL, 1, 2, 3),
	(16, '2023-12-13', 'Maintenance', 'Janardhan', 'Test', 'K', '150 Belmont Ave APT 202', 'Jersey City', 'New Jersey', '7304', 15, 2, 2, 3);

-- Dumping structure for table zoo_management.enclosure
CREATE TABLE IF NOT EXISTS `enclosure` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `BuildingID` int(11) NOT NULL,
  `SqFt` int(11) NOT NULL,
  PRIMARY KEY (`ID`,`BuildingID`),
  KEY `BuildingID` (`BuildingID`),
  CONSTRAINT `enclosure_ibfk_1` FOREIGN KEY (`BuildingID`) REFERENCES `building` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table zoo_management.enclosure: ~3 rows (approximately)
INSERT INTO `enclosure` (`ID`, `BuildingID`, `SqFt`) VALUES
	(1, 1, 1000),
	(2, 2, 1500),
	(3, 3, 2500);

-- Dumping structure for table zoo_management.hourlyrate
CREATE TABLE IF NOT EXISTS `hourlyrate` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `HourlyRate` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table zoo_management.hourlyrate: ~1 rows (approximately)
INSERT INTO `hourlyrate` (`ID`, `HourlyRate`) VALUES
	(1, '10'),
	(2, '11'),
	(3, '13'),
	(4, '15');

-- Dumping structure for table zoo_management.participatesin
CREATE TABLE IF NOT EXISTS `participatesin` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SpeciesID` int(11) DEFAULT NULL,
  `AnimalShowID` int(11) DEFAULT NULL,
  `Reqd` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `SpeciesID` (`SpeciesID`),
  KEY `AnimalShowID` (`AnimalShowID`),
  CONSTRAINT `participatesin_ibfk_1` FOREIGN KEY (`SpeciesID`) REFERENCES `species` (`ID`),
  CONSTRAINT `participatesin_ibfk_2` FOREIGN KEY (`AnimalShowID`) REFERENCES `animalshow` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table zoo_management.participatesin: ~1 rows (approximately)
INSERT INTO `participatesin` (`ID`, `SpeciesID`, `AnimalShowID`, `Reqd`) VALUES
	(6, 2, 1, 1);

-- Dumping structure for table zoo_management.revenueevents
CREATE TABLE IF NOT EXISTS `revenueevents` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DateTime` date NOT NULL,
  `Revenue` int(11) NOT NULL,
  `TicketsSold` int(11) NOT NULL,
  PRIMARY KEY (`ID`,`DateTime`),
  CONSTRAINT `revenueevents_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `revenuetype` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table zoo_management.revenueevents: ~2 rows (approximately)
INSERT INTO `revenueevents` (`ID`, `DateTime`, `Revenue`, `TicketsSold`) VALUES
	(1, '2023-12-13', 28, 3),
	(3, '2023-12-13', 68, 6);

-- Dumping structure for table zoo_management.revenuetype
CREATE TABLE IF NOT EXISTS `revenuetype` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `BuildingID` int(11) DEFAULT NULL,
  `Name` varchar(255) NOT NULL,
  `Type` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `BuildingID` (`BuildingID`),
  CONSTRAINT `revenuetype_ibfk_1` FOREIGN KEY (`BuildingID`) REFERENCES `building` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table zoo_management.revenuetype: ~3 rows (approximately)
INSERT INTO `revenuetype` (`ID`, `BuildingID`, `Name`, `Type`) VALUES
	(1, 1, 'Animal Show', 'Animal Show'),
	(2, 2, 'Consession', 'Concession'),
	(3, 3, 'Ticket Counter', 'Zoo Admission');

-- Dumping structure for table zoo_management.species
CREATE TABLE IF NOT EXISTS `species` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `FoodCost` int(11) NOT NULL,
  `updated_date` date DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table zoo_management.species: ~1 rows (approximately)
INSERT INTO `species` (`ID`, `Name`, `FoodCost`, `updated_date`) VALUES
	(1, 'Tiger', 150, '2023-12-12'),
	(2, 'Lion', 120, '2023-12-12');

-- Dumping structure for table zoo_management.users
CREATE TABLE IF NOT EXISTS `users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` varchar(50) NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table zoo_management.users: ~3 rows (approximately)
INSERT INTO `users` (`UserID`, `Username`, `Password`, `Role`) VALUES
	(1, 'admin', 'admin123', 'Admin'),
	(2, 'jaya raj srivathsavadari', 'Jaya Raj SrivathsavAdari', 'Veterinarian'),
	(3, 'janardhank', 'JanardhanK', 'Maintenance');

-- Dumping structure for table zoo_management.zooadmission
CREATE TABLE IF NOT EXISTS `zooadmission` (
  `ID` int(11) NOT NULL,
  `SeniorPrice` int(11) NOT NULL,
  `AdultPrice` int(11) NOT NULL,
  `ChildPrice` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  CONSTRAINT `zooadmission_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `revenuetype` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table zoo_management.zooadmission: ~1 rows (approximately)
INSERT INTO `zooadmission` (`ID`, `SeniorPrice`, `AdultPrice`, `ChildPrice`) VALUES
	(3, 9, 10, 8);

-- Dumping structure for table zoo_management.zooadmissiontickets
CREATE TABLE IF NOT EXISTS `zooadmissiontickets` (
  `TicketID` int(11) NOT NULL AUTO_INCREMENT,
  `ZooAdmissionID` int(11) DEFAULT NULL,
  `AdultTickets` int(11) NOT NULL,
  `ChildTickets` int(11) NOT NULL,
  `SeniorTickets` int(11) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Attendance` int(11) NOT NULL,
  `Revenue` decimal(10,2) NOT NULL,
  `CheckoutTime` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`TicketID`),
  KEY `ZooAdmissionID` (`ZooAdmissionID`),
  CONSTRAINT `zooadmissiontickets_ibfk_1` FOREIGN KEY (`ZooAdmissionID`) REFERENCES `zooadmission` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table zoo_management.zooadmissiontickets: ~12 rows (approximately)
INSERT INTO `zooadmissiontickets` (`TicketID`, `ZooAdmissionID`, `AdultTickets`, `ChildTickets`, `SeniorTickets`, `Price`, `Attendance`, `Revenue`, `CheckoutTime`) VALUES
	(1, 3, 1, 1, 1, 27.00, 3, 27.00, '2023-12-12 04:48:12'),
	(2, 3, 1, 1, 1, 27.00, 3, 27.00, '2023-12-12 06:13:12'),
	(3, 3, 1, 1, 1, 27.00, 3, 27.00, '2023-12-12 06:13:58'),
	(4, 3, 1, 0, 0, 10.00, 1, 10.00, '2023-12-12 06:14:04'),
	(5, 3, 1, 1, 1, 27.00, 3, 27.00, '2023-12-12 20:15:35'),
	(6, 3, 1, 1, 1, 27.00, 3, 27.00, '2023-12-12 20:44:44'),
	(7, 3, 1, 0, 0, 10.00, 1, 10.00, '2023-12-12 21:38:08'),
	(8, 3, 1, 0, 0, 10.00, 1, 10.00, '2023-12-12 21:49:20'),
	(9, 3, 1, 0, 0, 10.00, 1, 10.00, '2023-12-12 21:49:28'),
	(10, 3, 1, 0, 0, 10.00, 1, 10.00, '2023-12-12 21:51:23'),
	(11, 3, 2, 0, 0, 20.00, 2, 20.00, '2023-12-12 22:40:51'),
	(12, 3, 1, 1, 1, 27.00, 3, 27.00, '2023-12-12 22:52:02');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
