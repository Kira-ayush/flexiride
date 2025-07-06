-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2025 at 05:30 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flexiride`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$du72ZPp/Xb2B4nySuwodzOy.uyssVw.MRzzbUD5FzlNbAZvSsdsRW');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `status` enum('Pending','Confirmed','Cancelled') DEFAULT 'Pending',
  `pickup_location` varchar(255) DEFAULT NULL,
  `extra_helmet` tinyint(1) DEFAULT 0,
  `driver_option` enum('Self-drive','With driver') NOT NULL DEFAULT 'Self-drive',
  `pickup_time` varchar(10) DEFAULT NULL,
  `driver_fee` decimal(10,2) DEFAULT 0.00,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `vehicle_id`, `start_date`, `end_date`, `total_price`, `status`, `pickup_location`, `extra_helmet`, `driver_option`, `pickup_time`, `driver_fee`, `created_at`) VALUES
(22, 1, 10, '2025-06-20', '2025-06-23', 6795.00, 'Confirmed', 'hinoo chow ranchi', 0, 'With driver', '09:25', 799.00, '2025-06-19 21:44:40'),
(23, 1, 10, '2025-06-20', '2025-06-21', 3797.00, 'Confirmed', 'karamtoli', 0, 'With driver', '08:20', 799.00, '2025-06-19 21:44:40'),
(24, 1, 18, '2025-06-20', '2025-06-22', 7696.00, 'Confirmed', 'firaya lal chowk ', 0, 'With driver', '08:30', 799.00, '2025-06-19 21:44:40'),
(25, 1, 36, '2025-06-20', '2025-06-21', 1497.00, 'Confirmed', 'Morabadi', 1, 'Self-drive', '09:30', 0.00, '2025-06-19 21:44:40'),
(26, 1, 12, '2025-06-21', '2025-06-23', 5296.00, 'Confirmed', 'hinoo chowk ranchi', 0, 'With driver', '06:30', 799.00, '2025-06-20 12:30:29');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `message`, `submitted_at`) VALUES
(1, 'Sumit Kumar Yadav', 'sumit.gope.yadav@gmail.com', 'inquery', '2025-06-18 10:10:09'),
(2, 'Sumit Kumar Yadav', 'sumit.gope.yadav@gmail.com', 'inquery', '2025-06-18 10:10:44'),
(3, 'Sumit Kumar Yadav', 'sumit.gope.yadav@gmail.com', 'inquery', '2025-06-18 10:13:27'),
(4, 'Aayush Kumar', 'aayush.kr.gope@gmail.com', 'fert4', '2025-06-18 10:17:46');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `profile_picture`) VALUES
(1, 'Aayush Kumar', 'aayush.kr.gope@gmail.com', '9110160470', '$2y$10$z4HQ5ae8d2xndmJtan.dj.CAKRn9J3xDPFjCPaSU5fghGOXlQX1GO', '1750058829_m1-icon-removebg-preview.png');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` enum('car','bike') NOT NULL,
  `subcategory` varchar(50) DEFAULT NULL,
  `price_per_day` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `features` text DEFAULT NULL,
  `key_specifications` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `name`, `category`, `subcategory`, `price_per_day`, `description`, `image_path`, `features`, `key_specifications`) VALUES
(1, 'Tata Altroz', 'car', 'hatchback', 999.00, 'A striking design, upmarket cabin and some segment-exclusive features define the 2025 Tata Altroz facelift. It also remains the only model in its segment to offer an expansive list of engine options, including petrol, diesel and CNG.', '1750062867_tata_altroz.png', 'Automatic Climate Control ,Android Auto/Apple CarPlay, Rear Camera Engine, Start/Stop Button ,Rear AC Vents ,Sunroof ,Wireless Charger', 'Fuel Type - Petrol , Engine Displacement - 1199 cc ,No. of Cylinders - 3,Max Power - 86.79bhp@6000rpm , Max Torque - 115Nm@3250rpm ,Seating Capacity - 5 , Transmission Type - Automatic , Boot Space - 345 Litres , Fuel Tank Capacity - 37 Litres , Ground Clearance Unladen - 165 mm'),
(2, 'Maruti Swift', 'car', 'hatchback', 999.00, 'The Maruti Swift is a midsize hatchback in India which offers a good balance of features, performance, and fuel efficiency. It is available with Suzuki’s new 1.2-litre Z series 3- cylinder petrol engine in both 5-speed manual or 5-speed AMT transmission. The Swift is now also available in CNG offering a claimed fuel efficiency of 32.85 km/kg.', '1750063480_MarutiSwift_hatchback.png', 'Power Steering , Power Windows Front, Anti-lock Braking System (ABS) , Air Conditioner , Driver Airbag , Passenger Airbag , Automatic Climate Control , Alloy Wheels , Multi-function Steering Wheel', 'ARAI Mileage - 25.75 kmpl , Fuel Type - Petrol , Engine Displacement - 1197 cc , No. of Cylinders - 3 , Max Power - 80.46bhp@5700rpm , Max Torque -111.7Nm@4300rpm , Seating Capacity - 5 , Transmission Type - Automatic , Boot Space265 Litres , Fuel Tank Capacity - 37 Litres , Ground Clearance Unladen - 163 mm'),
(3, 'Maruti Baleno', 'car', 'hatchback', 999.00, 'The Maruti Baleno has 1 Petrol Engine and 1 CNG Engine on offer. The Petrol engine is 1197 cc while the CNG engine is 1197 cc . It is available with Manual & Automatic transmission.Depending upon the variant and fuel type the Baleno has a mileage of 22.35 to 22.94 kmpl. The Baleno is a 5 seater 4 cylinder car and has length of 3990 mm, width of 1745 mm and a wheelbase of 2520 mm.', '1750064015_baleno.png', 'Power Steering ,Power Windows Front ,Anti-lock Braking System (ABS) ,Air Conditioner ,Driver Airbag ,Passenger Airbag ,Automatic Climate Control ,Alloy Wheels ,Multi-function Steering Wheel', 'ARAI Mileage - 22.94 kmpl ,City Mileage - 19 kmpl ,Fuel Type - Petrol ,Engine Displacement - 1197 cc ,No. of Cylinders - 4 ,Max Power - 88.50bhp@6000rpm ,Max Torque - 113Nm@4400rpm ,Seating Capacity - 5 ,Transmission Type - Automatic , Boot Space - 318 Litres ,Fuel Tank Capacity -37 Litres'),
(4, 'Maruti Wagon R', 'car', 'hatchback', 999.00, 'The Maruti Wagon R has 2 Petrol Engine and 1 CNG Engine on offer. The Petrol engine is 998 cc and 1197 cc while the CNG engine is 998 cc . It is available with Manual & Automatic transmission. Depending upon the variant and fuel type the Wagon R has a mileage of 23.56 to 25.19 kmpl. The Wagon R is a 5 seater 4 cylinder car and has length of 3655 mm, width of 1620 mm and a wheelbase of 2435 mm', '1750081067_wagonr.png', 'Power Steering ,Power Windows Front ,Anti-lock Braking System (ABS) ,Air Conditioner ,Driver Airbag ,Passenger Airbag ,Alloy Wheels ,Multi-function Steering Wheel', 'ARAI Mileage - 24.43 kmpl ,Fuel Type - Petrol ,Engine Displacement - 1197 cc ,No. of Cylinders - 4 ,Max Power - 88.50bhp@6000rpm ,Max Torque113Nm@4400rpm ,Seating Capacity - 5 ,Transmission Type - Automatic ,Boot Space - 341 Litres ,Fuel Tank Capacity - 32 Litres'),
(5, 'Hyundai i20', 'car', 'hatchback', 999.00, 'The Hyundai i20 has 1 Petrol Engine on offer. The Petrol engine is 1197 cc . It is available with Manual & Automatic transmission. Depending upon the variant and fuel type the i20 has a mileage of 16 to 20 kmpl. The i20 is a 5 seater 4 cylinder car and has length of 3995 mm, width of 1775 mm and a wheelbase of 2580 mm.', '1750082600_i20.png', 'Power Steering ,Power Windows Front,Anti-lock Braking System (ABS),Air Conditioner,Driver Airbag,Passenger Airbag,Automatic Climate Control,Alloy Wheels,Multi-function Steering Wheel', 'ARAI Mileage - 20 kmpl,Fuel Type - Petrol,Engine Displacement - 1197 cc,No. of Cylinders - 4 ,Max Power - 87bhp@6000rpm , Max Torque - 114.7Nm@4200rpm,Seating Capacity - 5,Transmission Type - Automatic,Fuel Tank Capacity - 37 Litres'),
(6, 'Volkswagen Golf GTI', 'car', 'hatchback', 999.00, 'The Volkswagen Golf GTI has 1 Petrol Engine on offer. The Petrol engine is 1984 cc . It is available with Automatic transmission. The Golf GTI has Ground clearance of 136 mm. The Golf GTI is a 5 seater 4 cylinder car and has length of 4289 mm, width of 1789 mm and a wheelbase of 2627 mm.', '1750083029_Volkswagen.png', 'Power Steering ,Anti-lock Braking System (ABS) ,Air Conditioner ,Driver Airbag ,Passenger Airbag ,Automatic Climate Control ,Alloy Wheels ,Multi-function Steering Wheel ,Engine Start Stop Button', 'Fuel Type - Petrol ,Engine Displacement - 1984 cc ,No. of Cylinders - 4 ,Max Power - 261bhp@5250-6500rpm ,Max Torque - 370Nm@1600-4500rpm ,Seating Capacity - 5 ,Transmission Type - Automatic ,Boot Space - 380 Litres ,Fuel Tank Capacity - 45 Litres ,Ground Clearance Unladen -136 mm'),
(7, 'Maruti Suzuki Dzire', 'car', 'sedan', 1499.00, 'The new-gen Dzire has evolved into a modern design despite being a compact sedan. It continues to be known for its mature ride quality, comfort features, interior space for five people, and CNG compatibility.', '1750083682_MarutiSuzuki_Sedan.png', 'Dual Airbags ,ABS with EBD, Rear Parking Sensors ,Touchscreen Infotainment ,Steering Mounted Controls ,Rear AC Vents , Automatic Climate Control ,Push Button Start ,LED DRLs & Tail Lamps', 'ARAI Mileage: 23.26 kmpl ,Fuel Type: Petrol Engine, Displacement: 1197 cc ,No. of Cylinders: 4 ,Max Power: 88.5 bhp @ 6000 rpm ,Max Torque: 113 Nm @ 4400 rpm ,Seating Capacity: 5, Transmission Type: Automatic, Boot Space: 378 Litres ,Fuel Tank Capacity: 37 Litres , Ground Clearance: 163 mm'),
(8, 'Volkswagen Virtus', 'car', 'sedan', 1499.00, 'A premium mid-size sedan that combines elegant design, powerful performance, and modern tech — perfect for both city driving and long journeys.', '1750084069_VIRTUS.png', 'LED Headlamps with DRLs,10-Inch Touchscreen Infotainment,Wireless Android Auto & Apple CarPlay,Ventilated Front Seats,6 Airbags,ABS with EBD & ESC,Digital Cockpit,Rear Camera with Sensors ,Cruise Control', 'ARAI Mileage: 18.67 kmpl ,Fuel Type: Petrol, Engine Displacement: 1498 cc ,No. of Cylinders: 4 ,Max Power: 147.51 bhp @ 5000–6000 rpm ,Max Torque: 250 Nm @ 1600–3500 rpm ,Transmission: Manual/DSG ,Seating Capacity: 5 ,Boot Space: 521 Litres ,Fuel Tank Capacity: 45 Litres'),
(9, 'Hyundai Verna', 'car', 'sedan', 1499.00, 'A sleek and stylish sedan offering powerful performance, advanced safety, and a luxurious interior — ideal for modern city and highway travel.', '1750084213_Hyundai-Verna.png', 'LED Projector Headlamps ,10.25\" Touchscreen with Navigation, Ventilated Front Seats, 6 Airbags ,ABS with EBD & ESC, Wireless Phone Charger ,Sunroof ,Rear View Camera with Dynamic Guidelines ,Smart Key with Push Button Start ,BlueLink Connected Car Technology', 'ARAI Mileage: 20.6 kmpl, Fuel Type: Petrol ,Engine Displacement: 1497 cc ,No. of Cylinders: 4 ,Max Power: 113.45 bhp @ 6300 rpm, Max Torque: 144 Nm @ 4500 rpm ,Transmission: Manual/CVT ,Seating Capacity: 5 ,Boot Space: 528 Litres, Fuel Tank Capacity: 45 Litres'),
(10, 'Skoda Slavia', 'car', 'sedan', 1499.00, 'A refined and stylish sedan with robust build quality, premium features, and powerful engine options — offering an excellent blend of comfort and performance.', '1750084352_skoda.png', 'LED Headlamps with DRLs ,10-Inch Touchscreen Infotainment ,Wireless Android Auto & Apple CarPlay, Ventilated Front Seats, 6 Airbags ,ABS with EBD & ESC ,Electric Sunroof ,Rear Parking Camera with Sensors ,Cruise Control, Skoda MyConnect Connected Car Tech', 'ARAI Mileage: 19.47 kmpl ,Fuel Type: Petrol, Engine Displacement: 1498 cc, No. of Cylinders: 4 ,Max Power: 147.51 bhp @ 5000–6000 rpm ,Max Torque: 250 Nm @ 1600–3500 rpm ,Transmission: Manual/DSG ,Seating Capacity: 5 ,Boot Space: 521 Litres, Fuel Tank Capacity: 45 Litres'),
(11, 'Honda Amaze', 'car', 'sedan', 1499.00, 'A compact sedan that offers a blend of stylish design, fuel efficiency, and practical features — perfect for city commutes and family rides.', '1750084481_Honda.png', 'LED DRLs and Projector Headlamps ,7-Inch Touchscreen Infotainment ,Android Auto & Apple CarPlay ,Rear Parking Camera & Sensors ,Dual Front Airbags ,ABS with EBD ,Push Button Start/Stop, Automatic Climate Control ,Smart Key Access ,Electrically Adjustable ORVMs', 'ARAI Mileage: 18.6 kmpl, Fuel Type: Petrol, Engine Displacement: 1199 cc ,No. of Cylinders: 4 ,Max Power: 88.50 bhp @ 6000 rpm ,Max Torque: 110 Nm @ 4800 rpm ,Transmission: Manual/CVT, Seating Capacity: 5 ,Boot Space: 420 Litres ,Fuel Tank Capacity: 35 Litres'),
(12, 'Honda City', 'car', 'sedan', 1499.00, 'The Honda City is a benchmark in mid-size sedans, offering premium comfort, cutting-edge technology, and legendary reliability — ideal for both urban and highway driving.', '1750084751_Honda.png', 'LED Headlamps with DRLs, 8-Inch Touchscreen with Android Auto & Apple CarPlay, LaneWatch Camera ,6 Airbags ,Electric Sunroof ,Honda Sensing ADAS Suite , Rear Camera & Parking Sensors, Automatic Climate Control ,Push Button Start/Stop, Cruise Control', 'ARAI Mileage: 18.4 kmpl ,Fuel Type: Petrol, Engine Displacement: 1498 cc ,No. of Cylinders: 4 ,Max Power: 119.35 bhp @ 6600 rpm ,Max Torque: 145 Nm @ 4300 rpm ,Transmission: Manual/CVT ,Seating Capacity: 5 ,Boot Space: 506 Litres ,Fuel Tank Capacity: 40 Litres'),
(13, 'Maruti Brezza', 'car', 'suv', 2299.00, 'A compact SUV that offers strong road presence, practical features, and reliable performance.', '1750085001_Brezza.png', 'Touchscreen Infotainment System ,Wireless Android Auto & Apple CarPlay, Dual Airbags ,ABS with EBD, LED Projector Headlamps ,Rear Parking Camera ,Electric Sunroof ,Automatic Climate Control ,Push Button Start/Stop', 'ARAI Mileage: 19.8 kmpl , Fuel Type: Petrol, Engine Displacement: 1462 cc ,No. of Cylinders: 4 ,Max Power: 102 bhp @ 6000 rpm ,Max Torque: 136.8 Nm @ 4400 rpm ,Transmission: 5-speed Manual ,Seating Capacity: 5 ,Boot Space: 328 Litres ,Fuel Tank Capacity: 48 Litres'),
(14, 'Hyundai Creta', 'car', 'suv', 2299.00, 'A premium mid-size SUV offering style, comfort, technology, and performance all in one package.', '1750085180_hyundai-creat.png', 'Panoramic Sunroof ,Ventilated Front Seats, 10.25-inch Touchscreen Infotainment ,BlueLink Connected Car Tech ,6 Airbags ,Electronic Stability Control ,Rear Camera with Guidelines ,Automatic Headlamps & Wipers ,Alloy Wheels ,Premium Leather Upholstery', 'ARAI Mileage: 17.4 to 21.8 kmpl, Fuel Type: Petrol / Diesel ,Engine Displacement: 1497–1493 cc ,No. of Cylinders: 4 ,Max Power: 113–138 bhp, Max Torque: 144–250 Nm ,Transmission: Manual / Automatic ,Seating Capacity: 5 ,Boot Space: 433 Litres ,Fuel Tank Capacity: 50 Litres'),
(15, 'Mahindra XUV700', 'car', 'suv', 2299.00, 'A bold and feature-packed SUV with powerful performance, advanced technology, and spacious comfort — perfect for adventurous getaways and premium travel.', '1750085316_Mahindra-XUV700-1-595xh.png', 'ADAS Level-2 (Adaptive Cruise, Lane Assist) ,Dual 10.25-Inch Digital Displays, Panoramic Skyroof ,Alexa Built-in Voice Commands, 360-Degree Camera ,7 Airbags ,ESP with Traction Control, Alloy Wheels & LED DRLs, Dual-zone Climate Control ,Connected Car Tech with Over-the-Air Updates', 'ARAI Mileage: 15.0 kmpl ,Fuel Type: Petrol, Engine Displacement: 1997 cc ,No. of Cylinders: 4 ,Max Power: 197.13 bhp @ 5000 rpm ,Max Torque: 380 Nm @ 1750–3000 rpm, Transmission: Manual/Automatic ,Seating Capacity: 5/7 ,Boot Space: 240 Litres (expandable), Fuel Tank Capacity: 60 Litres'),
(16, 'Mahindra Scorpio N', 'car', 'suv', 2299.00, 'The Mahindra Scorpio N redefines ruggedness with its commanding presence, powerful engine, and modern tech — ideal for off-road adventures and city dominance.', '1750085478_mahindra-scorpio.png', 'LED Projector Headlamps with DRLs ,8-Inch Touchscreen Infotainment ,Wireless Android Auto & Apple CarPlay ,Built-in Alexa with Voice Commands ,6 Airbags, Terrain Management System (4x4 variants), AdrenoX Connected Car Tech ,Dual-zone Climate Control, Rear Camera & Parking Sensors, Sunroof', 'ARAI Mileage: 14.0 kmpl, Fuel Type: Petrol/Diesel, Engine Displacement: 1997 cc (Petrol), No. of Cylinders: 4, Max Power: 200 bhp @ 5000 rpm ,Max Torque: 380 Nm @ 1750–3000 rpm ,Transmission: Manual/Automatic ,Seating Capacity: 6/7 ,Boot Space: Up to 460 Litres ,Fuel Tank Capacity: 57 Litres'),
(17, 'Tata Nexon', 'car', 'suv', 2299.00, 'A top-rated compact SUV known for its bold design, high safety ratings, and connected car features — perfect for urban commutes and weekend getaways.', '1750085586_Nexon_White.png', 'LED Projector Headlamps with DRLs, 10.25-Inch Touchscreen Infotainment ,Wireless Android Auto & Apple CarPlay ,Voice-Activated Controls, 6 Airbags ,Electronic Stability Program (ESP), Rear Parking Camera & Sensors ,Connected Car Technology (IRA 2.0), Sunroof (in higher variants) ,Cruise Control', 'ARAI Mileage: 17.4 kmpl, Fuel Type: Petrol, Engine Displacement: 1199 cc, No. of Cylinders: 3 ,Max Power: 118.35 bhp @ 5500 rpm ,Max Torque: 170 Nm @ 1750–4000 rpm ,Transmission: Manual/AMT/DCT ,Seating Capacity: 5 ,Boot Space: 382 Litres ,Fuel Tank Capacity: 44 Litres'),
(18, 'Mahindra Thar Roxx', 'car', 'suv', 2299.00, 'A rugged off-roader with a bold design and hardcore capabilities, the Mahindra Thar Roxx edition takes adventure to the next level with added styling and terrain performance.', '1750085709_thar.png', 'Black-Themed Roxx Edition Exterior Styling, 4x4 Drivetrain with Low Range Gearbox, Touchscreen Infotainment with Navigation, Android Auto & Apple CarPlay ,ESP with Roll-over Mitigation, Mechanical Locking Rear Differential ,All-Terrain Tyres & Alloy Wheels ,Hard Top Convertible Option ,Dual Front Airbags, Roof-Mounted Speakers', 'ARAI Mileage: 15.2 kmpl ,Fuel Type: Petrol/Diesel, Engine Displacement: 1997 cc (Petrol) / 2184 cc (Diesel), No. of Cylinders: 4 ,Max Power: 150 bhp (Petrol) / 130 bhp (Diesel) ,Max Torque: 320 Nm @ 1500–3000 rpm ,Transmission: Manual/Automatic ,Seating Capacity: 4 ,Boot Space: Limited (Rear seats foldable) ,Fuel Tank Capacity: 57 Litres'),
(19, 'TVS Jupiter', 'bike', 'basic', 399.00, 'A dependable and stylish scooter offering superior comfort, great mileage, and practical utility — perfect for daily city rides.', '1750086370_jupiter.png', 'LED Headlamp with DRL ,Eco/Power Mode Indicator, External Fuel Fill, Front Telescopic Suspension, Alloy Wheels, USB Mobile Charger Provision, Large Comfortable Seat ,IntelliGO Start-Stop Tech , Sync Braking System (SBS) ,Digital-Analog Instrument Cluster', 'ARAI Mileage: 62 kmpl ,Fuel Type: Petrol ,Engine Displacement: 109.7 cc, No. of Cylinders: 1, Max Power: 7.88 bhp @ 7500 rpm ,Max Torque: 8.8 Nm @ 5500 rpm ,Transmission: CVT ,Seating Capacity: 2 ,Boot Space: 21 Litres (under-seat) ,Fuel Tank Capacity: 6 Litres ,Body Type: Scooter'),
(20, 'Hero Splendor Plus', 'bike', 'basic', 399.00, 'A timeless commuter bike trusted for mileage, comfort, and low maintenance — Hero Splendor Plus is India’s most-loved two-wheeler for a reason.', '1750086667_hero-splendor-plus.png', 'i3S Start-Stop Technology ,Alloy Wheels with Tubeless Tyres, Integrated Braking System (IBS), Side Stand Engine Cut-off (in select variants) ,Classic Analog Instrument Cluster ,Simple and Reliable Carburetor Engine ,Comfortable Pillion Seat with Grab Rail, Excellent Mileage and Service Network ,Lightweight and Easy Handling, Black Alloy Wheels (in all-black edition)', 'ARAI Mileage: 80.6 kmpl, Fuel Type: Petrol ,Engine Displacement: 97.2 cc ,No. of Cylinders: 1 ,Max Power: 7.91 bhp @ 8000 rpm ,Max Torque: 8.05 Nm @ 6000 rpm, Transmission: 4-Speed Manual ,Seating Capacity: 2 ,Fuel Tank Capacity: 9.8 Litres ,Body Type: Commuter Bike'),
(21, 'Bajaj Platina 110', 'bike', 'basic', 399.00, 'Bajaj Platina 110 is a smart commuter bike with comfort-focused suspension and excellent mileage — ideal for daily riders seeking affordability and reliability.', '1750087139_platina.png', 'Comfortec Suspension Technology, Anti-Skid Braking with ABS ,Digital-Analog Instrument Cluster ,LED DRL & Halogen Headlamp ,Alloy Wheels with Tubeless Tyres ,Soft-Seat Cushioning ,Fuel Efficiency Indicator ,Grab Rail for Pillion Comfort, Lightweight & Easy to Handle, High Ground Clearance', 'ARAI Mileage: 70 kmpl ,Fuel Type: Petrol, Engine Displacement: 115.45 cc ,No. of Cylinders: 1 ,Max Power: 8.48 bhp @ 7000 rpm ,Max Torque: 9.81 Nm @ 5000 rpm, Transmission: 5-Speed Manual ,Seating Capacity: 2 ,Fuel Tank Capacity: 11 Litres ,Body Type: Commuter Bike'),
(22, 'TVS Scooty Pep+', 'bike', 'basic', 399.00, 'The lightweight and compact TVS Scooty Pep+ is the perfect choice for city travel — with vibrant colors, great mileage, and easy maneuverability.', '1750087365_pep+.png', 'Lightest Scooter in India, Easy Center Stand ,Mobile Charger Socket ,Bold Body Graphics, Telescopic Suspension ,EcoThrust Fuel Injection (ETFi) ,Large Under-seat Storage ,LED DRL & Multi-Reflector Headlamp ,Sync Braking System (SBS), Low Seat Height (768mm)', 'ARAI Mileage: 65 kmpl, Fuel Type: Petrol, Engine Displacement: 87.8 cc ,No. of Cylinders: 1, Max Power: 5.36 bhp @ 6500 rpm ,Max Torque: 6.5 Nm @ 3500 rpm ,Transmission: CVT, Seating Capacity: 2 ,Fuel Tank Capacity: 4.2 Litres, Body Type: Scooter'),
(23, 'Honda Dio', 'bike', 'basic', 399.00, 'A youthful and sporty scooter with aggressive design, great mileage, and reliable performance — the Honda Dio is a hit among the young and bold.', '1750087517_dio.png', 'LED Headlamp & Position Light, Digital Speedometer, Sporty Dual-Tone Design ,Silent Start with ACG ,eSP Technology for Enhanced Efficiency ,Side Stand Engine Cut-off, Under Seat Storage with Bottle Holder, Retractable Rear Hook, Combi Brake System (CBS) ,Telescopic Suspension & Alloy Wheels', 'ARAI Mileage: 55 kmpl ,Fuel Type: Petrol ,Engine Displacement: 109.51 cc ,No. of Cylinders: 1 ,Max Power: 7.65 bhp @ 8000 rpm, Max Torque: 9 Nm @ 4750 rpm, Transmission: CVT ,Seating Capacity: 2 ,Fuel Tank Capacity: 5.3 Litres, Body Type: Scooter'),
(24, 'Honda Activa 6G', 'bike', 'basic', 399.00, 'India’s most trusted scooter — the Honda Activa 6G offers unbeatable reliability, refined performance, and legendary mileage, making it the perfect daily companion.', '1750087666_activa.png', 'Silent Start with ACG ,Enhanced Smart Power (eSP) Technology ,External Fuel Fill with Premium Switch ,LED DC Headlamp ,Engine Start/Stop Switch ,Side Stand Engine Cut-off, Telescopic Front Suspension ,3-Step Adjustable Rear Suspension ,Multi-function Key Switch, Metal Body with Tubeless Tyres', 'ARAI Mileage: 50 kmpl ,Fuel Type: Petrol, Engine Displacement: 109.51 cc ,No. of Cylinders: 1 ,Max Power: 7.73 bhp @ 8000 rpm, Max Torque: 8.90 Nm @ 5500 rpm, Transmission: CVT ,Seating Capacity: 2, Fuel Tank Capacity: 5.3 Litres, Body Type: Scooter'),
(25, 'Bajaj Pulsar 150', 'bike', 'standard', 499.00, 'The Bajaj Pulsar 150 is a powerful and stylish commuter bike that combines performance with sporty design — a perfect choice for daily riders who seek thrill and economy.', '1750087893_bajaj_pulsar.png', 'Halogen Headlamp with Pilot Lamps ,Split Grab Rails ,Analog-Digital Instrument Console ,Single Channel ABS ,Sporty Graphics and Matte Color Options ,Telescopic Front Suspension ,Rear Twin Shock Absorbers ,Disc Brake at Front ,Alloy Wheels & Tubeless Tyres ,Electric Start & Engine Kill Switch', 'ARAI Mileage: 47 kmpl, Fuel Type: Petrol ,Engine Displacement: 149.5 cc, No. of Cylinders: 1 ,Max Power: 13.8 bhp @ 8500 rpm, Max Torque: 13.25 Nm @ 6500 rpm, Transmission: 5-Speed Manual ,Seating Capacity: 2 ,Fuel Tank Capacity: 15 Litres ,Body Type: Commuter/Sport Bike'),
(26, 'TVS Apache RTR 160', 'bike', 'standard', 499.00, 'A dynamic and powerful street bike that delivers performance, style, and agility — the Apache RTR 160 is designed for thrill-seekers and city racers alike.', '1750088158_rtr160.png', 'LED Headlamp with Signature DRL ,Fully Digital Instrument Console ,Glide Through Traffic (GTT) Technology ,Race Tuned Fuel Injection (RT-Fi) ,Single Channel ABS ,Split Grab Rails ,Sporty Tank Design & Graphics ,Double Cradle Frame for Stability ,Alloy Wheels with Tubeless Tyres ,Electric Start', 'ARAI Mileage: 47 kmpl ,Fuel Type: Petrol, Engine Displacement: 159.7 cc ,No. of Cylinders: 1 ,Max Power: 15.82 bhp @ 8750 rpm ,Max Torque: 13.85 Nm @ 7000 rpm, Transmission: 5-Speed Manual, Seating Capacity: 2 ,Fuel Tank Capacity: 12 Litres ,Body Type: Sports Commuter Bike'),
(27, 'Honda Unicorn 160', 'bike', 'standard', 499.00, 'The Honda Unicorn 160 is a refined and reliable commuter bike, offering smooth rides, impressive fuel efficiency, and a trusted performance legacy.', '1750088313_unicorn160.png', 'Monoshock Rear Suspension , Engine Start/Stop Switch ,Single Channel ABS ,Analog Speedometer & Tachometer ,Chrome-Tipped Exhaust ,Comfortable Long Seat ,Premium Matte Color Options ,Tubeless Tyres with Alloy Wheels, Low Maintenance Engine, Refined Performance with HET Technology', 'ARAI Mileage: 62 kmpl ,Fuel Type: Petrol, Engine Displacement: 162.7 cc ,No. of Cylinders: 1, Max Power: 12.73 bhp @ 7500 rpm, Max Torque: 14 Nm @ 5500 rpm ,Transmission: 5-Speed Manual ,Seating Capacity: 2 ,Fuel Tank Capacity: 13 Litres ,Body Type: Commuter Bike'),
(28, 'Yamaha FZ-S', 'bike', 'standard', 499.00, 'The Yamaha FZ-S is a muscular and stylish street bike built for performance, comfort, and control — ideal for city riding and highway fun.', '1750088836_fzs.png', 'LED Headlamp & Tail Lamp ,Bluetooth Connectivity via Yamaha Motorcycle Connect, Digital Instrument Console ,Single Channel ABS, Side Stand Engine Cut-Off ,Sporty Tank Design & Graphics ,Alloy Wheels with Tubeless Tyres, In-Built Engine Kill Switch ,Lightweight & Excellent Balance ,Comfortable Pillion Seat', 'ARAI Mileage: 50 kmpl ,Fuel Type: Petrol, Engine Displacement: 149 cc ,No. of Cylinders: 1 ,Max Power: 12.23 bhp @ 7250 rpm ,Max Torque: 13.3 Nm @ 5500 rpm ,Transmission: 5-Speed Manual ,Seating Capacity: 2 ,Fuel Tank Capacity: 13 Litres ,Body Type: Street Bike'),
(29, 'Suzuki Access 125', 'bike', 'standard', 499.00, 'The Suzuki Access 125 is a smooth and refined scooter offering comfort, excellent mileage, and great storage — perfect for everyday rides with a premium touch.', '1750088970_access125.png', 'LED Headlamp and Tail Lamp ,Chrome Finish Mirrors and Exhaust Cover ,Digital-Analog Meter Console, Bluetooth Connectivity (in Ride Connect variant), External Fuel Lid, Under-seat Storage with Light ,Longer Seat with Flat Footboard ,Alloy Wheels and Tubeless Tyres ,USB Mobile Charging Socket ,Eco Assist Illumination', 'ARAI Mileage: 52.45 kmpl ,Fuel Type: Petrol, Engine Displacement: 124 cc ,No. of Cylinders: 1 ,Max Power: 8.6 bhp @ 6750 rpm ,Max Torque: 10 Nm @ 5500 rpm, Transmission: CVT ,Seating Capacity: 2 ,Fuel Tank Capacity: 5 Litres, Body Type: Scooter'),
(30, 'Hero Glamour', 'bike', 'standard', 499.00, 'The Hero Glamour combines great mileage, modern design, and commuter-friendly performance — a perfect everyday bike for style and efficiency.', '1750089096_glamour.png', 'ARAI Mileage: 60 kmpl ,Fuel Type: Petrol, Engine Displacement: 124.7 cc ,No. of Cylinders: 1, Max Power: 10.72 bhp @ 7500 rpm, Max Torque: 10.6 Nm @ 6000 rpm, Transmission: 5-Speed Manual, Seating Capacity: 2 ,Fuel Tank Capacity: 10 Litres, Body Type: Commuter Bike', 'i3S (Idle Start-Stop System) ,Digital-Analog Instrument Cluster ,Modern Dual-Tone Body Graphics ,Integrated Braking System (IBS) ,Alloy Wheels with Tubeless Tyres, LED Headlamp (in disc variant) ,USB Charging Port ,Engine Cut-Off on Side Stand ,Telescopic Front Suspension ,Excellent Service Network'),
(31, 'Royal Enfield Classic 350', 'bike', 'adventurous', 699.00, 'Iconic design and thumping performance — built for long rides, comfort, and legacy on the road.', '1750089423_bullet.png', 'Iconic Retro Styling ,Dual Channel ABS, Digital-Analog Instrument Cluster ,Comfortable Seating Posture ,Telescopic Front Fork Suspension, Electric Start ,LED Tail Lamp ,Tripper Navigation', 'ARAI Mileage: 35 kmpl ,Fuel Type: Petrol, Engine Displacement: 349 cc, No. of Cylinders: 1 ,Max Power: 20.2 bhp @ 6100 rpm, Max Torque: 27 Nm @ 4000 rpm, Transmission: 5-speed Manual ,Fuel Tank Capacity: 13 Litres ,Kerb Weight: 195 kg ,Top Speed: ~115 km/h'),
(32, 'Yamaha MT-15', 'bike', 'adventurous', 699.00, 'Aggressive, compact, and loaded with power — the Yamaha MT-15 is a streetfighter that delivers thrilling performance, advanced tech, and unmatched style.', '1750089561_mt15.png', 'Projector LED Headlamp, VVA (Variable Valve Actuation) Engine ,Assist & Slipper Clutch ,Upside Down Front Forks (USD) ,Delta Box Frame for Agility ,Bluetooth Connectivity (Y-Connect) ,Digital LCD Instrument Cluster ,Single Channel ABS, Alloy Wheels with Radial Tyres, Sporty Styling with Bold Tank Shrouds', 'ARAI Mileage: 47 kmpl ,Fuel Type: Petrol, Engine Displacement: 155 cc ,No. of Cylinders: 1 ,Max Power: 18.1 bhp @ 10000 rpm ,Max Torque: 14.2 Nm @ 7500 rpm, Transmission: 6-Speed Manual ,Seating Capacity: 2 ,Fuel Tank Capacity: 10 Litres ,Body Type: Naked Street Bike'),
(33, 'Hero Xpulse 200', 'bike', 'adventurous', 699.00, 'The Hero Xpulse 200 is a lightweight adventure motorcycle designed for both urban streets and off-road trails — offering rugged durability with modern features.', '1750089675_xpulse.png', 'LED Headlamp with DRLs, Bluetooth Enabled Navigation, Long Travel Suspension, Spoke Wheels with Dual Purpose Tyres ,High Ground Clearance (220mm) ,Digital LCD Display with Gear Indicator ,Single Channel ABS ,Upswept Exhaust for Water Wading ,Engine Kill Switch ,Metal Bash Plate for Engine Protection', 'ARAI Mileage: 40 kmpl, Fuel Type: Petrol, Engine Displacement: 199.6 cc ,No. of Cylinders: 1 ,Max Power: 18.8 bhp @ 8500 rpm ,Max Torque: 17.35 Nm @ 6500 rpm, Transmission: 5-Speed Manual ,Seating Capacity: 2 ,Fuel Tank Capacity: 13 Litres, Body Type: Adventure Bike'),
(34, 'KTM Duke 200', 'bike', 'adventurous', 699.00, 'A fierce performer and head-turner, the KTM Duke 200 delivers aggressive styling, sharp handling, and powerful performance — ideal for thrill-seeking city riders.', '1750089813_ktm_duke.png', 'Aggressive LED Headlamp, Full Digital LCD Console ,Steel Trellis Frame ,Supermoto ABS (Switchable Rear ABS), WP Upside-Down Front Forks ,Split Seats and Grab Rails ,Alloy Wheels with Radial Tyres ,Sporty Tank Shrouds & Tail Design ,Lightweight and Agile Handling ,Performance-Oriented Gear Ratios', 'ARAI Mileage: 33 kmpl ,Fuel Type: Petrol ,Engine Displacement: 199.5 cc ,No. of Cylinders: 1 ,Max Power: 24.67 bhp @ 10000 rpm ,Max Torque: 19.3 Nm @ 8000 rpm ,Transmission: 6-Speed Manual ,Seating Capacity: 2 ,Fuel Tank Capacity: 13.4 Litres ,Body Type: Naked Bike'),
(35, 'Bajaj Dominar 400', 'bike', 'adventurous', 699.00, 'The Bajaj Dominar 400 is a powerful touring machine that blends muscular design, highway comfort, and performance — perfect for long-distance adventures and urban dominance.', '1750089925_dominar.png', 'LED Headlamp and Tail Lamp ,Dual-Channel ABS, USD Front Forks ,Full Digital Instrument Cluster ,Slipper Clutch ,Alloy Wheels with Radial Tyres ,Twin-Barrel Exhaust ,Dominar Touring Kit (Optional), Perimeter Frame for High-Speed Stability ,Strong Low-End and Mid-Range Torque', 'ARAI Mileage: 29 kmpl, Fuel Type: Petrol ,Engine Displacement: 373.3 cc ,No. of Cylinders: 1 ,Max Power: 39.4 bhp @ 8800 rpm, Max Torque: 35 Nm @ 6500 rpm, Transmission: 6-Speed Manual ,Seating Capacity: 2 ,Fuel Tank Capacity: 13 Litres ,Body Type: Sports Tourer'),
(36, 'Royal Enfield Himalayan', 'bike', 'adventurous', 699.00, 'Engineered for adventure, the Royal Enfield Himalayan is a rugged, capable motorcycle that thrives on rough terrains and long rides with unmatched comfort and endurance.', '1750090064_himalayan.avif', 'Long Travel Suspension, Dual Channel ABS, Spoke Wheels with Dual Purpose Tyres ,Half-Digital Instrument Cluster ,Windscreen and Rear Carrier ,High Ground Clearance (220 mm) ,Side Stand Engine Cut-Off ,Touring Comfort Seats, Navigation Assist (Tripper Pod Optional) ,Robust Frame for Extreme Terrain', 'ARAI Mileage: 32 kmpl, Fuel Type: Petrol, Engine Displacement: 411 cc ,No. of Cylinders: 1 ,Max Power: 24.3 bhp @ 6500 rpm, Max Torque: 32 Nm @ 4000-4500 rpm ,Transmission: 5-Speed Manual ,Seating Capacity: 2 ,Fuel Tank Capacity: 15 Litres ,Body Type: Adventure Bike');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `vehicle_id` (`vehicle_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
