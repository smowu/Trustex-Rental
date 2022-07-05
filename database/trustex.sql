-- phpMyAdmin SQL Dump
-- version 5.3.0-dev+20220702.4e19a88a1e
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jul 05, 2022 at 07:47 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trustex`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `administratorID` int(4) NOT NULL,
  `userID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`administratorID`, `userID`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `applicationID` int(6) NOT NULL,
  `userID` int(10) NOT NULL,
  `userFName` varchar(32) NOT NULL,
  `userLName` varchar(32) NOT NULL,
  `userIC` varchar(12) NOT NULL,
  `userAddress` varchar(512) NOT NULL,
  `userPhoneNo` varchar(12) NOT NULL,
  `applicationStatus` varchar(32) NOT NULL DEFAULT 'Pending',
  `administratorID` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`applicationID`, `userID`, `userFName`, `userLName`, `userIC`, `userAddress`, `userPhoneNo`, `applicationStatus`, `administratorID`) VALUES
(1, 12, 'Trustex', 'User', '998877665544', 'Addresss', '0123456789', 'Rejected', 1),
(2, 8, 'Durrani Afiq', 'Saidin', '990509145655', '162-G, Jalan Raja Abdullah, 50300 Kampung Baru Kuala Lumpur', '0125153410', 'Approved', 1),
(3, 12, 'TRUSTEX', 'User', '980123145678', 'Some really really really really really really really really really really really really really really really really really long address', '0123456789', 'Rejected', 1),
(4, 2, 'User', 'Two', '991111115555', 'Pretend this is a long and legitimate address', '01122334455', 'Pending', NULL),
(5, 17, 'First', 'Last', '998877665544', 'asfsdagdsagearged', '0123456789', 'Rejected', 1),
(6, 17, 'First', 'Last', '998877665544', 'asfsdagdsagearged', '0123456789', 'Approved', 1),
(7, 12, 'TRUSTEX', 'User', '980123145678', 'Some really really really really really really really really really really really really really really really really really long address', '0123456789', 'Pending', NULL),
(8, 18, 'User', 'Demo', '998877665544', 'Address', '0123456789', 'Approved', 1);

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `ticketNo` int(8) NOT NULL,
  `bookingStatus` varchar(32) NOT NULL,
  `bookingExpiryDate` date NOT NULL,
  `bookingDeposit` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `landlord`
--

CREATE TABLE `landlord` (
  `landlordRegNo` int(6) NOT NULL,
  `userID` int(10) NOT NULL,
  `administratorID` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `landlord`
--

INSERT INTO `landlord` (`landlordRegNo`, `userID`, `administratorID`) VALUES
(1, 5, 1),
(2, 6, 1),
(3, 7, 1),
(4, 10, 1),
(7, 8, 1),
(8, 17, 1),
(10, 18, 1);

-- --------------------------------------------------------

--
-- Table structure for table `listing`
--

CREATE TABLE `listing` (
  `listingID` int(12) NOT NULL,
  `propertyID` int(6) NOT NULL,
  `listingTimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `listing`
--

INSERT INTO `listing` (`listingID`, `propertyID`, `listingTimestamp`) VALUES
(1, 1, '2022-06-20 06:12:12'),
(2, 2, '2022-06-20 06:55:20'),
(3, 3, '2022-06-20 06:55:20'),
(4, 4, '2022-06-20 08:52:17'),
(5, 1, '2022-06-20 06:12:12'),
(6, 2, '2022-06-20 06:55:20'),
(7, 1, '2022-06-21 13:03:13'),
(8, 2, '2022-06-21 13:03:18'),
(9, 3, '2022-06-21 13:03:33'),
(10, 4, '2022-06-21 13:03:33'),
(11, 1, '2022-06-21 13:03:33'),
(12, 2, '2022-06-21 13:03:33'),
(13, 12, '2022-07-02 13:37:41'),
(14, 8, '2022-07-02 18:19:04'),
(19, 47, '2022-07-04 22:24:24');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `transactionID` int(12) NOT NULL,
  `ticketNo` int(8) NOT NULL,
  `paymentTimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `paymentType` varchar(16) NOT NULL,
  `paymentAmount` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

CREATE TABLE `property` (
  `propertyID` int(6) NOT NULL,
  `landlordRegNo` int(6) NOT NULL,
  `propertyName` varchar(256) NOT NULL DEFAULT 'N/A',
  `propertyAddress` varchar(512) NOT NULL DEFAULT 'N/A',
  `propertyCity` varchar(64) NOT NULL DEFAULT 'N/A',
  `propertyPoscode` varchar(5) NOT NULL DEFAULT 'N/A',
  `propertyState` varchar(64) NOT NULL DEFAULT 'N/A',
  `propertyType` varchar(32) DEFAULT 'N/A',
  `propertyFloorLevel` int(2) DEFAULT NULL,
  `propertyFloorSize` int(6) DEFAULT NULL,
  `propertyNumRooms` int(2) NOT NULL,
  `propertyBathrooms` int(2) NOT NULL,
  `propertyFurnishing` varchar(32) DEFAULT 'N/A',
  `propertyFacilities` varchar(128) DEFAULT 'N/A',
  `propertyDesc` varchar(2048) DEFAULT 'N/A',
  `rentPrice` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`propertyID`, `landlordRegNo`, `propertyName`, `propertyAddress`, `propertyCity`, `propertyPoscode`, `propertyState`, `propertyType`, `propertyFloorLevel`, `propertyFloorSize`, `propertyNumRooms`, `propertyBathrooms`, `propertyFurnishing`, `propertyFacilities`, `propertyDesc`, `rentPrice`) VALUES
(1, 1, 'M Condominium @ Larkin Johor Bahru', 'No.46, Jalan Dewata Off Susur Larkin Perdana 2, 80350 Larkin, Johor Bahru, Johor', 'Johor Bahru', '80350', 'Johor', 'Condominium', 16, 1200, 3, 2, 'Fully Furnished', '', '', '2000.00'),
(2, 2, 'Desa Mentari PJS 2', 'Jalan PJS 2, 46000 Petaling Jaya, Selangor', 'Petaling Jaya', '46000', 'Selangor', 'Flat', NULL, 650, 3, 2, 'Unfurnished', '', '', '1500.00'),
(3, 3, 'United Point Residence @ North Kiara', 'Jalan Lang Emas North Kiara, 50150 Segambut, Kuala Lumpur', 'Segambut', '50150', 'Kuala Lumpur', 'Service Residence', NULL, 958, 3, 2, 'Partially Furnished', NULL, 'United Point Residence partly furnished to RENT\r\n\r\n- 958sf', '1500.00'),
(4, 4, 'R&F Princess Cove', 'Jalan Sultan Ibrahim Off Lebuhraya Sultan Iskandar, Tanjung Puteri, Johor Bahru, Johor', 'Johor Bahru', '80300', 'Johor', 'Service Residence', NULL, 1052, 3, 2, 'Fully Furnished', NULL, 'For Rent\r\nR&F Princess Cove, Johor Bahru@ link bridge to CIQ', '2500.00'),
(8, 7, 'Legasi Kampung Bharu', 'No.25, Jalan Raja Muda Musa, 50300 Kampung Bharu, Kuala Lumpur', 'Kampung Bharu', '50300', 'Kuala Lumpur', 'Apartment', 17, 950, 3, 2, 'Fully Furnished', 'Pool,Wifi,Parking', 'Near LRT Kampung Bharu', '2700.00'),
(11, 7, 'Plaza Rah', 'Jalan Raja Abdullah, 50300 Kampung Baru, Kuala Lumpur', 'Kampung Baru', '50300', 'W.P. Kuala Lumpur', 'Apartment', 13, 900, 3, 2, 'Unfurnished', 'Parking,Pool,Wifi', 'Near KLCC', '2000.00'),
(12, 7, 'KL Eco City Vogue Suites 1', 'KL Eco City, Jalan Bangsar, 59000 Bangsar, Kuala Lumpur', 'Bangsar', '59000', 'W.P. Kuala Lumpur', 'Apartment', 20, 797, 2, 1, 'Fully Furnished', 'Wifi,Parking,Gym,Pool,Security,Others,', 'Short Walk To LRT & Mid Valley Garden Mall. Always Shown 3 Unit Vogue Suites One is high-rise residential property situated within MidValley City. It boasts to be Malaysia\'s tallest luxury residential condominium. Vogue Suites One is A 60-storey residential tower housing 708 residential suites. The place offers you the beautiful panoramic view of Kuala Lumpur City Centre and Bangsar.  Accessibility wise, the place is nearby major highways that has made it easier to travel to Petaling Jaya and other parts of Kuala Lumpur. If you prefer to commute, the nearest public transport would be LRT Abdullah Hukum, which is 5 minute away by foot. As for amenities, residents can easily access to many things due to its strategic location. With The Gardens and Mid Valley located opposite, residents can use the pedestrian bridge to visit the retail hub for food, entertainment, groceries and more. They can also go to Bangsar for some night life or foodie adventure.  Easy Access Major highway including -Federal Highway to PJ, Sunway, Subang, Shah Alam , Klang - New Pantai Expressway (NPE) connecting to Sunway , Subang Jaya, LDP highway as well -Kerinchi Link connecting to Sri Hartamas , Mont Kiara & Damansara and Penchala link as well.  Property Details: Limited Fully furnished unit 1bedroom and 1 study room come with bathroom. this unit come with 1 covered carpark. 2 tier security from the main lobby or from carpark entrance.  more than 1 unit can show you in one shot viewing .  Name: Vogue Suites One Address: Jalan Bangsar, KL Eco City Developer: SP Setia Type: Condominium Completion: 2017 Tenure: Leasehold Total Blocks: 2 (A&B) Total Storey: 60 Total Units: 708 Built up: 657 - 3993 sqft Layout: 1 Bedroom : 657sqft – 710sqft 1+1 Bedroom : 732sqft – 797sqft 2 Bedroom : 915sqft – 1,119sqft Loft units : 1,647sqft – 3,993sqft  Facilities: Sky gymnasium Meditation pavillion 50 metres olympic length pool Playground Al-fresco cafe deck Submerged cabana deck Jogging track Sauna Steam bath Business lounge Mini theatre 24 hours security', '2500.00'),
(13, 8, 'New Property', 'Address', 'Tapah', '40000', 'Perak', 'Terrace', 0, 900, 3, 2, 'Fully Furnished', 'Wifi,Parking,Security,', 'ghdfshfsdhrtsh', '1500.00'),
(47, 7, 'Parc 3', 'Lot 20006 Jalan Pudu Perdana, Cheras, Kuala Lumpur', 'Cheras', '55200', 'W.P. Kuala Lumpur', 'Service Residence', 0, 977, 3, 2, 'Fully Furnished', 'Wifi,Parking,Gym,Pool,Security,Others,', '*Condo Name : Parc 3*Unit level:*Sqft : 977*Bedroom : 3*Bathroom : 2*Furnished : fully furnishes*Water Heater : yes*Air-cond : yes*Carpark Slot : 2*Rental: RM 2600I\'m Wendy Wong from The Roof Realty.We specialist in helping landlords to manage, rent, and sale their properties.We are cover area Cheras, Ampang, KLCC, Mont Kiara, Bangsar.All landlords, tenants, buyers are welcome!', '2600.00');

-- --------------------------------------------------------

--
-- Table structure for table `rent`
--

CREATE TABLE `rent` (
  `ticketNo` int(8) NOT NULL,
  `rentStartDate` date NOT NULL,
  `rentEndDate` date NOT NULL,
  `rentPrice` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `ticketNo` int(8) NOT NULL,
  `userID` int(10) NOT NULL,
  `listingID` int(12) NOT NULL,
  `requestTimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `requestType` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`ticketNo`, `userID`, `listingID`, `requestTimestamp`, `requestType`) VALUES
(2, 15, 1, '2022-06-29 08:47:12', 'R');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(10) NOT NULL,
  `userName` varchar(32) NOT NULL,
  `userEmail` varchar(256) NOT NULL,
  `userPassword` varchar(256) NOT NULL,
  `userType` char(1) NOT NULL DEFAULT 'T',
  `userFName` varchar(32) NOT NULL,
  `userLName` varchar(32) NOT NULL,
  `userIC` varchar(12) NOT NULL,
  `userGender` char(1) NOT NULL,
  `userAddress` varchar(512) NOT NULL,
  `userPhoneNo` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `userName`, `userEmail`, `userPassword`, `userType`, `userFName`, `userLName`, `userIC`, `userGender`, `userAddress`, `userPhoneNo`) VALUES
(1, 'durrani', 'durraniafiq@gmail.com', '$2y$10$Ajsk3XYWpuPOa.VxPPoBBe6NHV3rWrv2ho/hwKNBNB6MWgJr0YQo.', 'A', 'Durrani Afiq', 'Saidin', '990509145655', 'M', 'A-17-6, Legasi Kampung Bharu, No.25, Jalan Raja Muda Musa, 50300 Kampung Bharu, W.P. Kuala Lumpur', '0125153410'),
(2, 'user2', 'user2@gmail.com', '$2y$10$QQbJzH5h2X9oSVFYVULDeuFk8SnNA.4HkhZxpsodd7L33pvagt10u', 'T', 'User', 'Two', '991111115555', 'M', 'Pretend this is a long and legitimate address', '01122334455'),
(3, 'user3', 'user3@gmail.com', '$2y$10$xBdUXA95vU/yDpESMogiEuVwW/CCYusGgg4h1YBKIBgPizo4YQ8kG', 'T', 'User', 'Three', '930303033334', 'F', 'A very short address', '0198765432'),
(4, 'newTenant', 'sometenant@gmail.com', '$2y$10$B39kzf/iX0O0PWjLY/dlG.xUScjSZhhCBuMg1lFGl7Nst5UEpbZ5G', 'T', '', '', '', '', '', ''),
(5, 'maxxy', 'maxyee@gmail.com', '$2y$10$zEt4DWW1JF/ywlbYr5aDEOpPS0j1r6ndtOmrFjqNWjm/c5mLs8czC', 'L', 'Max', 'Yee', '870215145758', 'F', '', '01110979689'),
(6, 'merul86', 'landlord2@gmail.com', '$2y$10$qSv/Vg9cPI75FI4AbFCRoeHVQEh8X7gvtqA5Tphqvnd2lH13YrGy.', 'L', 'Amerul', '', '930902055989', 'M', '', '0125925614'),
(7, 'joshuaT', 'joshuatee@gmail.com', '$2y$10$DghDFyVkOz0sQj2pEG7FyuXMmlq89IBldKeRtOqQmDi4bveXtCJUO', 'L', 'Joshua', 'Tee', '901124073465', 'M', '', '0122939599'),
(8, 'durraniafiq', 'durrani@gmail.com', '$2y$10$6HY9qveE26CFnwOC4nTm0.W36fRCopa8WeJYskcwrOxVSad2.9NV2', 'L', 'Durrani Afiq', 'Saidin', '990509145655', 'M', '162-G, Jalan Raja Abdullah, 50300 Kampung Baru Kuala Lumpur', '0125153410'),
(9, '123456', '123456@gmail.com', '$2y$10$vTjVQ19.8wSbcKrkLfuikelHBpxbzHwAB1UcYFjmWJOixUqeSXNUq', 'T', '', '', '', '', '', ''),
(10, 'rochy', 'rochyng@gmail.com', '$2y$10$iUUlbhaFJvue/hsiOjgeI.GRUqD7/i026lnukt7vcvOldDT9g6AY.', 'L', 'Rochy', 'Ng', '890405147366', 'F', '', '0166636011'),
(11, 'passwordtester', 'passwordtester@gmail.com', '$2y$10$R9qK7i9pn612W4J0GqDaQ.PrSK.C6kMgh7Kq1N2hj5i4JdQ/Szea.', 'T', '', '', '', '', '', ''),
(12, 'trustexuser', 'trustexuser@gmail.com', '$2y$10$vlhAMNeOYnWsB9bylQT39OXGBMYbpcN9RL1kkAklY91P/oANUx2Ui', 'T', 'TRUSTEX', 'User', '980123145678', 'F', 'Some really really really really really really really really really really really really really really really really really long address', '0123456789'),
(13, 'mkdirtest', 'mkdir@gmail.com', '$2y$10$.icu9qL60c8j.52pb6a6.uI18F39x.DjmM9Nc5jUKd5OnUVBgQj1a', 'T', '', '', '', '', '', ''),
(14, 'kamarul', 'kama123@gmail.com', '$2y$10$VE4trj2c9iBbsVlxIB3YTeG8PHdiGuB1G0aPwA42aK6hF5cGHNEFK', 'T', '', '', '', '', '', ''),
(15, 'fossabot', 'fossabot@gmail.com', '$2y$10$eV4bFdbfqo0MXOkeAYmnIuexP6EQkTd87kDg0vALU9BQ38pfKEYWK', 'T', '', '', '', '', '', ''),
(16, 'ayip', 'ayip020707@gmail.com', '$2y$10$oJyB9IRP0ItwluEKnojLnu6Gz7Z.xLj3NpwAKMIZl9CJKBmNqd.tG', 'T', 'Haris', 'Ikhwan', '020707080939', 'M', '203, Jalan Intan 2, Felda Trolak Timur', '0135272972'),
(17, 'user', 'usertest@gmail.com', '$2y$10$b1aFgMGxwageT2JVoJDiC.fg00./CRfabdDJ901K4IMm7qa8vLzoW', 'L', 'First', 'Last', '998877665544', 'M', 'asfsdagdsagearged', '0123456789'),
(18, 'userdemo', 'userdemo@gmail.com', '$2y$10$dNKh49AvOOYAS29XDyCWKeCdh4pZM7cN6HFTajLMseM8L1SYy9yTm', 'L', 'User', 'Demo', '998877665544', 'M', 'Address', '0123456789');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`administratorID`,`userID`),
  ADD KEY `admin_ibfk_1` (`userID`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`applicationID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `administratorID` (`administratorID`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`ticketNo`);

--
-- Indexes for table `landlord`
--
ALTER TABLE `landlord`
  ADD PRIMARY KEY (`landlordRegNo`) USING BTREE,
  ADD KEY `userID` (`userID`),
  ADD KEY `administratorID` (`administratorID`);

--
-- Indexes for table `listing`
--
ALTER TABLE `listing`
  ADD PRIMARY KEY (`listingID`),
  ADD KEY `propertyID` (`propertyID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`transactionID`),
  ADD KEY `ticketNo` (`ticketNo`);

--
-- Indexes for table `property`
--
ALTER TABLE `property`
  ADD PRIMARY KEY (`propertyID`),
  ADD KEY `landlordRegNo` (`landlordRegNo`);

--
-- Indexes for table `rent`
--
ALTER TABLE `rent`
  ADD KEY `ticketNo` (`ticketNo`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`ticketNo`),
  ADD KEY `listingID` (`listingID`),
  ADD KEY `request_ibfk_1` (`userID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `administratorID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `applicationID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `ticketNo` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `landlord`
--
ALTER TABLE `landlord`
  MODIFY `landlordRegNo` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `listing`
--
ALTER TABLE `listing`
  MODIFY `listingID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `transactionID` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `property`
--
ALTER TABLE `property`
  MODIFY `propertyID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `ticketNo` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrator`
--
ALTER TABLE `administrator`
  ADD CONSTRAINT `administrator_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`administratorID`) REFERENCES `administrator` (`administratorID`);

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`ticketNo`) REFERENCES `request` (`ticketNo`);

--
-- Constraints for table `landlord`
--
ALTER TABLE `landlord`
  ADD CONSTRAINT `landlord_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `landlord_ibfk_2` FOREIGN KEY (`administratorID`) REFERENCES `administrator` (`administratorID`);

--
-- Constraints for table `listing`
--
ALTER TABLE `listing`
  ADD CONSTRAINT `listing_ibfk_1` FOREIGN KEY (`propertyID`) REFERENCES `property` (`propertyID`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`ticketNo`) REFERENCES `request` (`ticketNo`);

--
-- Constraints for table `property`
--
ALTER TABLE `property`
  ADD CONSTRAINT `property_ibfk_1` FOREIGN KEY (`landlordRegNo`) REFERENCES `landlord` (`landlordRegNo`);

--
-- Constraints for table `rent`
--
ALTER TABLE `rent`
  ADD CONSTRAINT `rent_ibfk_1` FOREIGN KEY (`ticketNo`) REFERENCES `request` (`ticketNo`);

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `request_ibfk_2` FOREIGN KEY (`listingID`) REFERENCES `listing` (`listingID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



