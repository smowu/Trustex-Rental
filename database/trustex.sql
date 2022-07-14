-- phpMyAdmin SQL Dump
-- version 5.3.0-dev+20220702.4e19a88a1e
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jul 14, 2022 at 06:37 AM
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
(1, 1),
(2, 19);

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `applicationID` int(6) NOT NULL,
  `applicationTimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `userID` int(10) NOT NULL,
  `userFName` varchar(32) NOT NULL,
  `userLName` varchar(32) NOT NULL,
  `userIC` varchar(12) NOT NULL,
  `userGender` char(1) NOT NULL,
  `userAddress` varchar(512) NOT NULL,
  `userPhoneNo` varchar(12) NOT NULL,
  `applicationStatus` varchar(32) NOT NULL DEFAULT 'Pending',
  `administratorID` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`applicationID`, `applicationTimestamp`, `userID`, `userFName`, `userLName`, `userIC`, `userGender`, `userAddress`, `userPhoneNo`, `applicationStatus`, `administratorID`) VALUES
(1, '2022-07-14 01:42:28', 12, 'Trustex', 'User', '998877665544', 'M', 'Addresss', '0123456789', 'Rejected', 1),
(2, '2022-07-14 01:42:28', 8, 'Durrani Afiq', 'Saidin', '990509145655', 'M', '162-G, Jalan Raja Abdullah, 50300 Kampung Baru Kuala Lumpur', '0125153410', 'Approved', 1),
(3, '2022-07-14 01:42:28', 12, 'TRUSTEX', 'User', '980123145678', 'M', 'Some really really really really really really really really really really really really really really really really really long address', '0123456789', 'Rejected', 1),
(4, '2022-07-14 01:42:28', 2, 'User', 'Two', '991111115555', 'M', 'Pretend this is a long and legitimate address', '01122334455', 'Rejected', 1),
(5, '2022-07-14 01:42:28', 17, 'First', 'Last', '998877665544', 'M', 'asfsdagdsagearged', '0123456789', 'Rejected', 1),
(6, '2022-07-14 01:42:28', 17, 'First', 'Last', '998877665544', 'M', 'asfsdagdsagearged', '0123456789', 'Approved', 1),
(7, '2022-07-14 01:42:28', 12, 'TRUSTEX', 'User', '980123145678', 'M', 'Some really really really really really really really really really really really really really really really really really long address', '0123456789', 'Rejected', 1),
(8, '2022-07-14 01:42:28', 18, 'User', 'Demo', '998877665544', 'M', 'Address', '0123456789', 'Approved', 1),
(9, '2022-07-14 01:42:28', 12, 'Aiman', 'Khairuddin', '980123145678', 'M', 'No. 3, Jalan Serunai 7, Taman Desa Utama, Klang, Selangor', '0123456789', 'Rejected', 1),
(10, '2022-07-14 03:06:02', 26, 'Azizan', 'Amar Johan', '891209115965', 'M', '138-D, Jalan Hang Lekir 1Q, Taman Casa, 13048 Gelugor, Pulau Pinang', '0152650313', 'Approved', 2),
(11, '2022-07-14 01:42:28', 25, 'Lai Bai', 'Chon', '871228055689', 'M', 'B-58-65, Jln 2/1, Bandar Seri Impian, 70392 Port Dickson, Negeri Sembilan Darul Khusus', '0191757004', 'Pending', NULL),
(12, '2022-07-14 01:42:28', 24, 'Francis Yen', 'Tong', '930705105699', 'M', '4, Jln Sentul, Kondominium Kiara, 01339 Beseri, Perlis', '0184613378', 'Pending', NULL),
(13, '2022-07-14 01:46:46', 22, 'Azhan', 'Kamaruzzaman', '861105073555', 'M', 'No.6, Jalan 8/3, Taman Maxwell, 81706 Johor Bahru, Johor', '0180688755', 'Approved', 1),
(14, '2022-07-14 03:05:46', 21, 'S.', 'Theiviya', '900203143466', 'F', '11, Lorong 3/5, Desa Sentosa, 15165 Kuala Krai, Kelantan Darul Naim', '0142187126', 'Approved', 2),
(15, '2022-07-14 03:05:43', 20, 'Nasliha', 'Azlim', '900102145476', 'F', '5, Jln Kebun Bunga 8/98, Bandar Keramat, 89057 Tambunan, Sabah', '0159073828', 'Approved', 2);

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `ticketNo` int(8) NOT NULL,
  `userID` int(10) NOT NULL,
  `listingID` int(12) NOT NULL,
  `requestTimestamp` timestamp NULL DEFAULT NULL,
  `rentStartDate` date NOT NULL,
  `rentEndDate` date NOT NULL,
  `rentDuration` int(2) NOT NULL,
  `rentNumTenants` int(2) NOT NULL,
  `propertyID` int(6) NOT NULL,
  `landlordRegNo` int(6) NOT NULL,
  `propertyName` varchar(256) NOT NULL,
  `propertyAddress` varchar(512) NOT NULL,
  `propertyCity` varchar(64) NOT NULL,
  `propertyPoscode` varchar(5) NOT NULL,
  `propertyState` varchar(64) NOT NULL,
  `propertyType` varchar(32) NOT NULL,
  `propertyFloorLevel` int(2) NOT NULL,
  `propertyFloorSize` int(6) NOT NULL,
  `propertyNumRooms` int(2) NOT NULL,
  `propertyBathrooms` int(2) NOT NULL,
  `propertyFurnishing` varchar(32) NOT NULL,
  `propertyFacilities` varchar(128) NOT NULL,
  `propertyDesc` varchar(2048) NOT NULL,
  `rentPrice` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`ticketNo`, `userID`, `listingID`, `requestTimestamp`, `rentStartDate`, `rentEndDate`, `rentDuration`, `rentNumTenants`, `propertyID`, `landlordRegNo`, `propertyName`, `propertyAddress`, `propertyCity`, `propertyPoscode`, `propertyState`, `propertyType`, `propertyFloorLevel`, `propertyFloorSize`, `propertyNumRooms`, `propertyBathrooms`, `propertyFurnishing`, `propertyFacilities`, `propertyDesc`, `rentPrice`) VALUES
(8, 12, 1, '2022-07-13 21:53:28', '2020-01-21', '2020-07-21', 6, 1, 1, 1, 'M Condominium @ Larkin Johor Bahru', 'No.46, Jalan Dewata Off Susur Larkin Perdana 2, 80350 Larkin, Johor Bahru, Johor', 'Johor Bahru', '80350', 'Johor', 'Condominium', 16, 1200, 3, 2, 'Fully Furnished', '', '', '2000.00'),
(10, 27, 47, '2020-07-14 03:47:20', '2020-07-22', '2021-07-22', 12, 4, 72, 7, 'Bukit Impian Residence', '2 Jalan Bukit Impian, Skudai, 81300 Johor Bahru, Johor', 'Johor Bahru', '81300', 'Johor', 'Terrace', 0, 3600, 4, 4, '', 'Parking,Security,', 'Remarks : Owner will install lighting, ceiling fans, curtain track. If want partially / fully furnished can discuss\r\nAsking rental : RM 2300 / month', '2300.00'),
(11, 27, 36, '2022-07-14 04:00:49', '2021-09-20', '2022-03-20', 6, 3, 62, 12, 'Taman HeliConia Tapah Road Perak', 'Jalan HeliConia 7, Batang Padang, Tapah, Perak', 'Batang Padang', '35000', 'Perak', 'Terrace', 0, 900, 3, 2, 'Partially Furnished', '', 'Rumah Sewa di Tapah PerakTaman HeliConia, Tapah Road, PerakHarga Sewa : RM700 Sebulan', '700.00');

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
(10, 18, 1),
(11, 22, 1),
(12, 26, 2),
(13, 20, 2),
(14, 21, 2);

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
(13, 12, '2022-07-02 13:37:41'),
(14, 8, '2022-07-02 18:19:04'),
(19, 47, '2022-07-04 22:24:24'),
(34, 60, '2022-07-14 02:11:38'),
(35, 61, '2022-07-14 02:19:38'),
(36, 62, '2022-07-14 02:28:56'),
(37, 63, '2022-07-14 02:38:33'),
(38, 64, '2022-07-14 02:42:52'),
(39, 65, '2022-07-14 02:47:32'),
(40, 66, '2022-07-14 02:51:58'),
(41, 67, '2022-07-14 02:59:07'),
(42, 68, '2022-07-14 03:04:09'),
(43, 69, '2022-07-14 03:12:03'),
(44, 70, '2022-07-14 03:16:19'),
(45, 71, '2022-07-14 03:21:01'),
(47, 72, '2022-07-14 03:29:15'),
(48, 73, '2022-07-14 03:32:28');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `transactionID` int(12) NOT NULL,
  `ticketNo` int(8) NOT NULL,
  `paymentTimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `rentPrice` decimal(8,2) NOT NULL,
  `paymentDuration` int(2) NOT NULL,
  `paymentAmount` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`transactionID`, `ticketNo`, `paymentTimestamp`, `rentPrice`, `paymentDuration`, `paymentAmount`) VALUES
(11, 5, '2022-07-11 18:18:40', '2600.00', 2, '5200.00'),
(12, 5, '2022-07-11 18:23:16', '2600.00', 1, '2600.00'),
(13, 5, '2022-07-13 19:12:52', '2600.00', 1, '2600.00'),
(15, 11, '2022-07-14 03:59:25', '700.00', 6, '4200.00'),
(18, 10, '2022-07-14 04:23:57', '2300.00', 12, '27600.00');

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
  `rentPrice` decimal(8,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`propertyID`, `landlordRegNo`, `propertyName`, `propertyAddress`, `propertyCity`, `propertyPoscode`, `propertyState`, `propertyType`, `propertyFloorLevel`, `propertyFloorSize`, `propertyNumRooms`, `propertyBathrooms`, `propertyFurnishing`, `propertyFacilities`, `propertyDesc`, `rentPrice`) VALUES
(1, 1, 'M Condominium @ Larkin Johor Bahru', 'No.46, Jalan Dewata Off Susur Larkin Perdana 2, 80350 Larkin, Johor Bahru, Johor', 'Johor Bahru', '80350', 'Johor', 'Condominium', 16, 1200, 3, 2, 'Fully Furnished', '', '', '2000.00'),
(2, 2, 'Desa Mentari PJS 2', 'Jalan PJS 2, 46000 Petaling Jaya, Selangor', 'Petaling Jaya', '46000', 'Selangor', 'Flat', NULL, 650, 3, 2, 'Unfurnished', '', '', '1500.00'),
(3, 3, 'United Point Residence @ North Kiara', 'Jalan Lang Emas North Kiara, 50150 Segambut, Kuala Lumpur', 'Segambut', '50150', 'Kuala Lumpur', 'Service Residence', NULL, 958, 3, 2, 'Partially Furnished', NULL, 'United Point Residence partly furnished to RENT\r\n\r\n- 958sf', '1500.00'),
(4, 4, 'R&F Princess Cove', 'Jalan Sultan Ibrahim Off Lebuhraya Sultan Iskandar, Tanjung Puteri, Johor Bahru, Johor', 'Johor Bahru', '80300', 'Johor', 'Service Residence', NULL, 1052, 3, 2, 'Fully Furnished', NULL, 'For Rent\r\nR&F Princess Cove, Johor Bahru@ link bridge to CIQ', '2500.00'),
(8, 7, 'Legasi Kampung Bharu', 'No.25, Jalan Raja Muda Musa, 50300 Kampung Bharu, Kuala Lumpur', 'Kampung Bharu', '50300', 'Kuala Lumpur', 'Apartment', 17, 950, 3, 2, 'Fully Furnished', 'Pool,Wifi,Parking', 'Near LRT Kampung Bharu', '2500.00'),
(11, 7, 'Plaza Rah', 'Jalan Raja Abdullah, 50300 Kampung Baru, Kuala Lumpur', 'Kampung Baru', '50300', 'W.P. Kuala Lumpur', 'Apartment', 13, 900, 3, 2, 'Unfurnished', 'Parking,Pool,Wifi', 'Near KLCC', '2000.00'),
(12, 7, 'KL Eco City Vogue Suites 1', 'KL Eco City, Jalan Bangsar, 59000 Bangsar, Kuala Lumpur', 'Bangsar', '59000', 'W.P. Kuala Lumpur', 'Apartment', 20, 797, 2, 1, 'Fully Furnished', 'Wifi,Parking,Gym,Pool,Security,', 'Short Walk To LRT & Mid Valley Garden Mall. Always Shown 3 Unit Vogue Suites One is high-rise residential property situated within MidValley City. It boasts to be Malaysia\'s tallest luxury residential condominium. Vogue Suites One is A 60-storey residential tower housing 708 residential suites. The place offers you the beautiful panoramic view of Kuala Lumpur City Centre and Bangsar.  Accessibility wise, the place is nearby major highways that has made it easier to travel to Petaling Jaya and other parts of Kuala Lumpur. If you prefer to commute, the nearest public transport would be LRT Abdullah Hukum, which is 5 minute away by foot. As for amenities, residents can easily access to many things due to its strategic location. With The Gardens and Mid Valley located opposite, residents can use the pedestrian bridge to visit the retail hub for food, entertainment, groceries and more. They can also go to Bangsar for some night life or foodie adventure.  Easy Access Major highway including -Federal Highway to PJ, Sunway, Subang, Shah Alam , Klang - New Pantai Expressway (NPE) connecting to Sunway , Subang Jaya, LDP highway as well -Kerinchi Link connecting to Sri Hartamas , Mont Kiara & Damansara and Penchala link as well.  Property Details: Limited Fully furnished unit 1bedroom and 1 study room come with bathroom. this unit come with 1 covered carpark. 2 tier security from the main lobby or from carpark entrance.  more than 1 unit can show you in one shot viewing .  Name: Vogue Suites One Address: Jalan Bangsar, KL Eco City Developer: SP Setia Type: Condominium Completion: 2017 Tenure: Leasehold Total Blocks: 2 (A&B) Total Storey: 60 Total Units: 708 Built up: 657 - 3993 sqft Layout: 1 Bedroom : 657sqft – 710sqft 1+1 Bedroom : 732sqft – 797sqft 2 Bedroom : 915sqft – 1,119sqft Loft units : 1,647sqft – 3,993sqft  Facilities: Sky gymnasium Meditation pavillion 50 metres olympic length pool Playground Al-fresco cafe deck Submerged cabana deck Jogging track Sauna Steam bath Business lounge Mini theatre 24 hours security', '2500.00'),
(13, 8, 'New Property', 'Address', 'Tapah', '40000', 'Perak', 'Terrace', 0, 900, 3, 2, 'Fully Furnished', 'Wifi,Parking,Security,', 'ghdfshfsdhrtsh', '1500.00'),
(47, 7, 'Parc 3', 'Lot 20006 Jalan Pudu Perdana, Cheras, Kuala Lumpur', 'Cheras', '55200', 'W.P. Kuala Lumpur', 'Service Residence', 0, 977, 3, 2, 'Fully Furnished', 'Wifi,Parking,Gym,Pool,Security,', '*Condo Name : Parc 3*Unit level:*Sqft : 977*Bedroom : 3*Bathroom : 2*Furnished : fully furnishes*Water Heater : yes*Air-cond : yes*Carpark Slot : 2*Rental: RM 2600I\'m Wendy Wong from The Roof Realty.We specialist in helping landlords to manage, rent, and sale their properties.We are cover area Cheras, Ampang, KLCC, Mont Kiara, Bangsar.All landlords, tenants, buyers are welcome!', '2600.00'),
(60, 11, 'South View Serviced Apartments', '2 Jalan Kerinchi, Kerinchi, Bangsar South, Kuala Lumpur', 'Bangsar South', '50614', 'W.P. Kuala Lumpur', 'Service Residence', 0, 861, 2, 2, 'Fully Furnished', 'Wifi,Parking,Gym,Pool,Security,', 'Located at a prestigious address, South View Serviced Apartments is a residential enclave designed for urban professionals. Well connected to major expressways and public transport, it offers exceptionally convenient city living, where shopping, dining, healthcare and educational institutions are literally just steps away.', '2300.00'),
(61, 11, 'Atlantis Residences', 'Jalan Kota Laksamana Off Jalan Syed Abdul Aziz, Kota Laksamana, Klebang, Melaka', 'Melaka', '75300', 'Melaka', 'Service Residence', 0, 689, 1, 1, 'Fully Furnished', 'Wifi,Parking,Gym,Pool,Security,', '[ RUMAH UNTUK DISEWA AREA KOTA LAKSAMANA , MELAKA ]\r\n\r\nFully furnished\r\nMinimum sewaan 12 bulan', '1300.00'),
(62, 12, 'Taman HeliConia Tapah Road Perak', 'Jalan HeliConia 7, Batang Padang, Tapah, Perak', 'Batang Padang', '35000', 'Perak', 'Terrace', 0, 900, 3, 2, 'Partially Furnished', '', 'Rumah Sewa di Tapah PerakTaman HeliConia, Tapah Road, PerakHarga Sewa : RM700 Sebulan', '700.00'),
(63, 13, 'Taman Rose Garden Kinarut', 'Taman Rose Garden Kinarut, 88200 Kota Kinabalu, Sabah', 'Kota Kinabalu', '88200', 'Sabah', 'Semi-D', 0, 4550, 4, 4, 'Unfurnished', 'Parking,Security,', 'For Rent:-\r\nProperty : Taman Rose Garden\r\nSemi D Corner\r\nMonthly Rental Fee: RM 3,000.00\r\nLocation : Kinarut\r\nBuild up Sqft : 4,550 Sq Ft\r\nLand Area Sqft: 4,450 Sq Ft\r\nBedroom : 4\r\nBathroom : 4\r\nUnfurnished', '3000.00'),
(64, 13, 'Studio Type LD Lagenda Apartment', 'LD Lagenda, 93050 Kuching, Sarawak', 'Kuching', '93050', 'Sarawak', 'Others', 0, 247, 1, 1, 'Fully Furnished', 'Gym,Pool,', 'Located just besides Sarawak General HospitalSize 247sftFully Furnished New UnitFacilities such as Gymnasium access and Swimming Pool includedParking Spot is NOT (subject to rental addition)Minimum rent tenure : 1year', '1100.00'),
(65, 12, 'Wave Marina Cove', 'Taman Iskandar, Taman Sri Intan, 80050 Johor Bahru, Johor', 'Johor Bahru', '80050', 'Johor', 'Apartment', 0, 795, 2, 2, 'Fully Furnished', 'Wifi,Parking,Gym,Pool,Security,', 'Apartment For RentWave Marina CoveJb town area, 5min to Ciq2 bedroom 2 bathroom795sqfAlmost fully furnish (dont have TV, Wardrobe, stove)Asking Price RM1600*', '1600.00'),
(66, 12, 'Dfestivo Condo Ipoh Perak', 'Ipoh Garden, 30594 Ipoh, Perak', 'Ipoh', '30594', 'Perak', 'Condominium', 0, 1070, 3, 2, 'Fully Furnished', 'Wifi,Parking,Gym,Pool,Security,', 'FOR RENT @ Ipoh D’Festivol Condo\r\n\r\n1070 sq.ft\r\nMid Floor\r\n3 carpark (indoor cover)\r\n3 bedrooms\r\n2 bathrooms\r\nRenovated & Fully Furnished\r\nWith 5 Stars Facilities\r\nSwimming pool, gym, sauna, Tennis Court, Squash Court, Play Ground, Jogging Track\r\nAlarm system with intercom system to guard house\r\n24hours Security\r\nJust few steps to Mini mart & car wash area\r\nLocated in a strategic area in Ipoh close to Jusco, Tesco, Tambun Sunway City & all daily amenities.\r\n\r\nMonthly : (Rm2500) (included maintainance & security fee)', '2500.00'),
(67, 14, 'Eco Grandeur, Puncak Alam', 'Jalan Eco Grandeur, 40594 Shah Alam, Selangor', 'Shah Alam', '40594', 'Selangor', 'Terrace', 0, 1634, 4, 3, 'Unfurnished', 'Parking,Security,', '*** Eco Grandeur is a new development for ECO WORLD in near by Puncak alam , Neighbour hood such as Hill Park, Bandar Seri Coalfields, LBS all is developing nearby. will be a new big township for sungai buloh in\r\nfuture ***\r\n', '1500.00'),
(68, 14, 'Bandar Puncak Alam', 'Lorong Gugusan Alam 7/5, 42300 Kuala Selangor, Selangor', 'Kuala Selangor', '42300', 'Selangor', 'Terrace', 0, 1090, 3, 3, 'Partially Furnished', 'Security,', 'WTL - To Let - Untuk Disewa\r\nBandar Puncak Alam, Fasa 12', '1000.00'),
(69, 13, 'ARIA Luxury Residence, KLCC', 'Jalan Tun Razak, 50088 KL City, Kuala Lumpur', 'KL City', '50088', 'W.P. Kuala Lumpur', 'Condominium', 0, 867, 2, 2, 'Fully Furnished', 'Wifi,Parking,Gym,Pool,Security,', 'High Floor & Ready to Move In', '3800.00'),
(70, 12, 'Ipoh Garden South', 'Lorong Hock Lee, Ipoh Garden, 30594 Ipoh, Perak', 'Ipoh', '30594', 'Perak', 'Terrace', 0, 1100, 3, 1, 'Partially Furnished', 'Wifi,', 'Ipoh Garden South is an ideal location for anyone wishing to be in a central location for easy access to all amenities or town. Within a close proximity to shopping centers and hypermarkets such as Jaya Jusco and Tesco , Hospitals (Pantai Hospital & Fatimah Hospital), Hotels, schools, stadium, banks, pharmacy, clinics, food courts and other daily convenience.\r\n\r\nEasy access to North-South Highway entry and exit point.', '1500.00'),
(71, 11, 'Eco Meadows – Northampton Terraces', 'Jalan Paboi, Simpang Ampat, Seberang Perai Selatan (Mainland - South), Penang', 'Seberang Perai Selatan', '13600', 'Pulau Pinang', 'Terrace', 0, 1400, 4, 3, 'Fully Furnished', 'Wifi,Parking,Security,', 'Eco Meadow 2 Storey Landed For Rent f\r\nFully Furnished for Rent\r\n', '2600.00'),
(72, 7, 'Bukit Impian Residence', '2 Jalan Bukit Impian, Skudai, 81300 Johor Bahru, Johor', 'Johor Bahru', '81300', 'Johor', 'Terrace', 0, 3600, 4, 4, '', 'Parking,Security,', 'Remarks : Owner will install lighting, ceiling fans, curtain track. If want partially / fully furnished can discuss\r\nAsking rental : RM 2300 / month', '2300.00'),
(73, 12, 'Eco Meadows – Northampton Terraces', 'Jalan Paboi, Simpang Ampat, Seberang Perai Selatan (Mainland - South), Penang', 'Seberang Perai Selatan', '13600', 'Pulau Pinang', 'Terrace', 0, 1600, 4, 3, 'Fully Furnished', 'Wifi,Parking,Security,', 'Double Storey Terrace Eco Meadow @ Simpang Ampat\r\nFully Furniture For Rent!\r\nRental RM2600', '2600.00');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `ticketNo` int(8) NOT NULL,
  `userID` int(10) NOT NULL,
  `listingID` int(12) NOT NULL,
  `requestTimestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `rentStartDate` date DEFAULT NULL,
  `rentEndDate` date DEFAULT NULL,
  `rentDuration` int(2) NOT NULL,
  `rentNumTenants` int(2) NOT NULL,
  `requestStatus` varchar(32) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`ticketNo`, `userID`, `listingID`, `requestTimestamp`, `rentStartDate`, `rentEndDate`, `rentDuration`, `rentNumTenants`, `requestStatus`) VALUES
(3, 12, 19, '2022-07-10 00:17:32', '2022-09-10', '0000-00-00', 6, 2, 'Archived'),
(4, 12, 19, '2022-07-10 00:17:38', '2022-09-10', '2023-03-10', 6, 1, 'Archived'),
(5, 12, 19, '2022-07-10 00:29:40', '2022-09-10', '2023-03-10', 6, 1, 'Upcoming'),
(6, 18, 1, '2022-07-13 16:40:17', '2022-07-20', '2023-07-20', 12, 1, 'Pending'),
(7, 12, 1, '2022-07-13 19:31:58', '2022-07-21', '2026-07-21', 48, 1, 'Archived'),
(8, 12, 1, '2022-07-13 22:40:30', '2020-01-21', '2020-07-21', 6, 1, 'Archived'),
(9, 27, 47, '2022-07-14 03:46:19', '2022-07-22', '2023-07-22', 12, 4, 'Archived'),
(10, 27, 47, '2022-07-14 03:51:27', '2020-07-22', '2021-07-22', 12, 4, 'Archived'),
(11, 27, 36, '2022-07-14 04:00:49', '2021-09-20', '2022-03-20', 6, 3, 'Archived');

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
(5, 'maxxy', 'maxyee@gmail.com', '$2y$10$zEt4DWW1JF/ywlbYr5aDEOpPS0j1r6ndtOmrFjqNWjm/c5mLs8czC', 'L', 'Max', 'Yee', '870215145758', 'F', 'No. 45 Jalan Setiawangsa 2A Taman Setiawangsa, W.P. Kuala Lumpur', '01110979689'),
(6, 'merul86', 'landlord2@gmail.com', '$2y$10$qSv/Vg9cPI75FI4AbFCRoeHVQEh8X7gvtqA5Tphqvnd2lH13YrGy.', 'L', 'Amerul', '', '930902055989', 'M', '', '0125925614'),
(7, 'joshuaT', 'joshuatee@gmail.com', '$2y$10$DghDFyVkOz0sQj2pEG7FyuXMmlq89IBldKeRtOqQmDi4bveXtCJUO', 'L', 'Joshua', 'Tee', '901124073465', 'M', '', '0122939599'),
(8, 'landlordDemo', 'landlorddemo@gmail.com', '$2y$10$6HY9qveE26CFnwOC4nTm0.W36fRCopa8WeJYskcwrOxVSad2.9NV2', 'L', 'Durrani Afiq', 'Saidin', '990509145655', 'M', '162-G, Jalan Raja Abdullah, 50300 Kampung Baru Kuala Lumpur', '0125153410'),
(10, 'rochy', 'rochyng@gmail.com', '$2y$10$iUUlbhaFJvue/hsiOjgeI.GRUqD7/i026lnukt7vcvOldDT9g6AY.', 'L', 'Rochy', 'Ng', '890405147366', 'F', '', '0166636011'),
(11, 'passwordtester', 'passwordtester@gmail.com', '$2y$10$R9qK7i9pn612W4J0GqDaQ.PrSK.C6kMgh7Kq1N2hj5i4JdQ/Szea.', 'T', '', '', '', '', '', ''),
(12, 'trustexuser', 'trustexuser@gmail.com', '$2y$10$vlhAMNeOYnWsB9bylQT39OXGBMYbpcN9RL1kkAklY91P/oANUx2Ui', 'T', 'Aiman', 'Khairuddin', '980123145678', 'M', 'No. 3, Jalan Serunai 7, Taman Desa Utama, Klang, Selangor', '0123456789'),
(14, 'kamarul', 'kama123@gmail.com', '$2y$10$VE4trj2c9iBbsVlxIB3YTeG8PHdiGuB1G0aPwA42aK6hF5cGHNEFK', 'T', 'Aiman', 'Kamarul', '', 'M', '', ''),
(15, 'fossabot', 'fossabot@gmail.com', '$2y$10$eV4bFdbfqo0MXOkeAYmnIuexP6EQkTd87kDg0vALU9BQ38pfKEYWK', 'T', '', '', '', '', '', ''),
(16, 'ayip', 'ayip020707@gmail.com', '$2y$10$oJyB9IRP0ItwluEKnojLnu6Gz7Z.xLj3NpwAKMIZl9CJKBmNqd.tG', 'T', 'Haris', 'Ikhwan', '020707080939', 'M', '203, Jalan Intan 2, Felda Trolak Timur', '0135272972'),
(17, 'user', 'usertest@gmail.com', '$2y$10$b1aFgMGxwageT2JVoJDiC.fg00./CRfabdDJ901K4IMm7qa8vLzoW', 'L', 'First', 'Last', '998877665544', 'M', 'asfsdagdsagearged', '0123456789'),
(18, 'demo', 'demo@gmail.com', '$2y$10$dNKh49AvOOYAS29XDyCWKeCdh4pZM7cN6HFTajLMseM8L1SYy9yTm', 'L', 'Cuba Try', 'Test', '998877665544', 'M', 'Address', '0123456789'),
(19, 'adminDemo', 'adminDemo@gmail.com', '$2y$10$B8IK1g0PDg4yGGuJ9WMFWuBxJHfw/WCu0S8qrFCtel8i9JSYjtrYm', 'A', 'Admin', 'Demo', '998877665544', 'M', 'Universiti Teknologi MARA (UiTM) Cawangan Perak, Kampus Tapah, 35400, Tapah Road, Perak', '0123456789'),
(20, 'nasllim', 'naslihaazlim@hotmail.com', '$2y$10$xiwFFLzt92JWwuhyo8xc9uLdvA0WgUUwGkRdw9OROmyNrXeCXNoDi', 'L', 'Nasliha', 'Azlim', '900102145476', 'F', '5, Jln Kebun Bunga 8/98, Bandar Keramat, 89057 Tambunan, Sabah', '0159073828'),
(21, 'stheiiya', 'sybil25@hotmail.com', '$2y$10$5WBSS4xjymXyKOHGLhe.PeYzbZ8EoEuLb8XEbh70r6MpVtO68VR6W', 'L', 'S.', 'Theiviya', '900203143466', 'F', '11, Lorong 3/5, Desa Sentosa, 15165 Kuala Krai, Kelantan Darul Naim', '0142187126'),
(22, 'mohdazadi', 'mohdazadi02@gmail.com', '$2y$10$fXxi/x4CyaQvZhqpGgKYkeb.xwKJly4JO8LqU0Yc1nWQBNUj.CNre', 'L', 'Azhan', 'Kamaruzzaman', '861105073555', 'M', 'No.6, Jalan 8/3, Taman Maxwell, 81706 Johor Bahru, Johor', '0180688755'),
(23, 'leonnme', 'leonnme@yahoo.com', '$2y$10$klc5ByBt/s7XIo2t.u95wuUZk4EanhGRR5QGYpcPrPaH0BeEWaqLq', 'T', 'Leong Shin', 'Me', '920502066434', 'F', 'No.5, Jln Syed Putra, PJS21L, 62584 Panching, Pahang', '0174133147'),
(24, 'francng', 'lseow@ramly.com', '$2y$10$Qoj3l0zh073fPJgXTvy0/Owoo6UxSVYqf1SXoteQegXEscS0y9iNS', 'T', 'Francis Yen', 'Tong', '930705105699', 'M', '4, Jln Sentul, Kondominium Kiara, 01339 Beseri, Perlis', '0184613378'),
(25, 'laibaihon', 'laibaihon@gmail.com', '$2y$10$rx4l73RiPH/rrzNnb9CRhua4JHMecmhTH0mQWNinq/Id30CbDLMkC', 'T', 'Lai Bai', 'Chon', '871228055689', 'M', 'B-58-65, Jln 2/1, Bandar Seri Impian, 70392 Port Dickson, Negeri Sembilan Darul Khusus', '0191757004'),
(26, 'muhamman', 'muhamman@zakwan.net', '$2y$10$sLLRz5M3vsV.oDiz27Ep4eRELCQKVtm1nWALCkRXqNkES4OurwT3u', 'L', 'Azizan', 'Amar Johan', '891209115965', 'M', '138-D, Jalan Hang Lekir 1Q, Taman Casa, 13048 Gelugor, Pulau Pinang', '0152650313'),
(27, 'userDemo', 'userdemo@gmail.com', '$2y$10$5MzEKJBwsgvsVVVlxEFbm.Sx2sXsPzmODYcT3ighQ534jbG8H4p/2', 'T', 'User', 'Demo', '991231149999', 'M', 'Universiti Teknologi MARA (UiTM) Cawangan Perak, Kampus Tapah, 35400, Tapah Road, Perak', '0123456789');

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
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`ticketNo`);

--
-- Indexes for table `landlord`
--
ALTER TABLE `landlord`
  ADD PRIMARY KEY (`landlordRegNo`) USING BTREE,
  ADD KEY `userID` (`userID`),
  ADD KEY `landlord_ibfk_2` (`administratorID`);

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
  MODIFY `administratorID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `applicationID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `landlord`
--
ALTER TABLE `landlord`
  MODIFY `landlordRegNo` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `listing`
--
ALTER TABLE `listing`
  MODIFY `listingID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `transactionID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `property`
--
ALTER TABLE `property`
  MODIFY `propertyID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `ticketNo` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

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
-- Constraints for table `landlord`
--
ALTER TABLE `landlord`
  ADD CONSTRAINT `landlord_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `landlord_ibfk_2` FOREIGN KEY (`administratorID`) REFERENCES `applications` (`administratorID`);

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
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `request_ibfk_2` FOREIGN KEY (`listingID`) REFERENCES `listing` (`listingID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



