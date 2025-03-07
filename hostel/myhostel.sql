-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2023 at 08:29 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myhostel`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(20) NOT NULL,
  `password` varchar(70) NOT NULL,
  `token` varchar(100) DEFAULT NULL,
  `salt` varchar(70) NOT NULL,
  `is_valid` tinyint(1) DEFAULT NULL,
  `id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`, `token`, `salt`, `is_valid`, `id`) VALUES
('admin', '7cbd7906b65e74dfa35aa6ad9b69fcaf09e05835c9fd1a808761728acb47db3e', '7cbd7906b65e74dfa35aa6ad9b69fcaf09e05835c9fd1a808761728acb47db3e', '2462164eaafeb878a2ae25d69dba699b', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `guest`
--

CREATE TABLE `guest` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `message` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `room_no` varchar(10) NOT NULL,
  `food` varchar(30) NOT NULL DEFAULT 'without food',
  `food_duration` varchar(5) DEFAULT NULL,
  `stay_from` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `duration` int(5) NOT NULL,
  `fees` varchar(10) NOT NULL,
  `rollno` varchar(20) NOT NULL,
  `gname` varchar(30) NOT NULL,
  `grelation` varchar(20) NOT NULL,
  `gnumber` varchar(15) NOT NULL,
  `emergency` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`room_no`, `food`, `food_duration`, `stay_from`, `duration`, `fees`, `rollno`, `gname`, `grelation`, `gnumber`, `emergency`) VALUES
('101', 'with', '1', '2023-03-17 04:55:33.403276', 1, '25500', '64746575647', 'Muthu', 'Father', '27448848663', '6747263725'),
('101B', 'with', '2', '2023-03-17 04:55:33.403276', 5, '25500', '820520047507', 'Anjali Maharaj', 'Father', '+20 7413788011', '+7 7698069222'),
('201A', 'with', '4', '2023-03-17 04:55:33.403276', 4, '25500', '820520063372', 'Ninad Sura', 'Father', '+52 7975515762', '+20 7190762246'),
('101A', 'with', '5', '2023-03-17 04:55:33.403276', 1, '25500', '820520084382', 'Nataraj Soman', 'Father', '+7 7372447143', '+61 9650265389'),
('101A', 'with', '3', '2023-03-17 04:55:33.403276', 3, '25500', '820520099334', 'Madhavi Tandon', 'Father', '+32 9618048102', '+91 9083459535'),
('201C', 'with', '3', '2023-03-17 04:55:33.403276', 5, '25500', '820520131746', 'Nirupama Chakraborty', 'Father', '+144 8927869140', '+61 8357272452'),
('201C', 'with', '1', '2023-03-17 04:55:33.403276', 3, '25500', '820520171369', 'Dharmaradj Tiwari', 'Father', '+20 7640660034', '+7 9100887815'),
('201', 'with', '1', '2023-03-17 04:55:33.403276', 1, '25500', '820520194402', 'Kalyani Tata', 'Father', '+144 7164107535', '+1 9010863526'),
('101', 'with', '3', '2023-03-17 04:55:33.403276', 3, '25500', '820520205002', 'Mohamed Sulthan', 'Father', '8899649298', '7394629689'),
('101', 'with', '3', '2023-03-17 04:55:33.403276', 2, '25500', '820520205013', 'gname', 'grelation', '6789035678', '1234578905'),
('201B', 'with', '4', '2023-03-17 04:55:33.403276', 5, '25500', '820520208760', 'Drupada Kapur', 'Father', '+81 8011949920', '+81 6557883069'),
('501', 'with', '5', '2023-03-17 04:55:33.403276', 3, '25500', '820520209344', 'Dhaval Padmanabhan', 'Father', '+91 7293085953', '+32 7869072394'),
('301', 'with', '5', '2023-03-17 04:55:33.403276', 4, '25500', '820520219494', 'Indira Patla', 'Father', '+20 7027396942', '+52 8688597745'),
('701', 'with', '1', '2023-03-17 04:55:33.403276', 1, '25500', '820520229873', 'Aditya Baral', 'Father', '+20 9462474586', '+33 6231403675'),
('901', 'with', '1', '2023-03-17 04:55:33.403276', 3, '25500', '820520235012', 'Lutchmayah Lad', 'Father', '+33 8890998431', '+81 7188811346'),
('501', 'with', '3', '2023-03-17 04:55:33.403276', 3, '25500', '820520280702', 'Aruna Khare', 'Father', '+141 9409051930', '+31 8637832317'),
('701', 'with', '4', '2023-03-17 04:55:33.403276', 5, '25500', '820520313436', 'Madhavi Jhaveri', 'Father', '+91 8912889514', '+86 6148509298'),
('101A', 'with', '4', '2023-03-17 04:55:33.403276', 3, '25500', '820520349178', 'Kessavamohane Chowdhury', 'Father', '+52 7124384529', '+32 9216545722'),
('201A', 'with', '3', '2023-03-17 04:55:33.403276', 2, '25500', '820520376293', 'Mohan Ramanathan', 'Father', '+91 9755269435', '+61 7065459627'),
('901', 'with', '1', '2023-03-17 04:55:33.403276', 3, '25500', '820520400298', 'Manickam Dey', 'Father', '+1 8673779514', '+91 8201887085'),
('501', 'with', '4', '2023-03-17 04:55:33.403276', 1, '25500', '820520401813', 'Jitinder Datta', 'Father', '+81 8583765201', '+1 7326077347'),
('801', 'with', '5', '2023-03-17 04:55:33.403276', 5, '25500', '820520508747', 'Jitender Ramaswamy', 'Father', '+20 6498144605', '+86 6450573894'),
('701', 'with', '5', '2023-03-17 04:55:33.403276', 5, '25500', '820520528901', 'Lallida Mannan', 'Father', '+62 8832328704', '+31 7890773608'),
('301', 'with', '5', '2023-03-17 04:55:33.403276', 5, '25500', '820520537696', 'Karishma Agarwal', 'Father', '+144 9979774566', '+31 8342383712'),
('101A', 'with', '5', '2023-03-17 04:55:33.403276', 5, '25500', '820520555162', 'Ganesh Kari', 'Father', '+62 8932806714', '+81 6761580700'),
('201B', 'with', '5', '2023-03-17 04:55:33.403276', 3, '25500', '820520567424', 'Gopal Om', 'Father', '+61 7326034543', '+44 8648801422'),
('201C', 'with', '3', '2023-03-17 04:55:33.403276', 1, '25500', '820520627672', 'Dipali Mangal', 'Father', '+20 7511405956', '+52 9545923729'),
('901', 'with', '3', '2023-03-17 04:55:33.403276', 2, '25500', '820520655408', 'Kalyani Batta', 'Father', '+33 9506040291', '+91 8687758476'),
('201B', 'with', '1', '2023-03-17 04:55:33.403276', 4, '25500', '820520665268', 'Gitika Sharma', 'Father', '+86 9368754044', '+32 7250129965'),
('201C', 'with', '5', '2023-03-17 04:55:33.403276', 4, '25500', '820520671026', 'Aishwarya Vig', 'Father', '+91 8506862885', '+1 9115392243'),
('201B', 'with', '4', '2023-03-17 04:55:33.403276', 1, '25500', '820520674576', 'Darshan Mannan', 'Father', '+62 7780020871', '+52 9455826550'),
('101A', 'with', '3', '2023-03-17 04:55:33.403276', 4, '25500', '820520677163', 'Nithya Kothari', 'Father', '+144 9237353725', '+86 8685283356'),
('801', 'with', '5', '2023-03-17 04:55:33.403276', 5, '25500', '820520701648', 'Nirav Saini', 'Father', '+33 7493024668', '+52 9060589737'),
('901', 'with', '1', '2023-03-17 04:55:33.403276', 1, '25500', '820520717658', 'Manisha Aurora', 'Father', '+20 6248905234', '+62 8500480638'),
('401', 'with', '5', '2023-03-17 04:55:33.403276', 4, '25500', '820520718145', 'Murali Balakrishnan', 'Father', '+7 9465488189', '+31 6824252818'),
('101C', 'with', '5', '2023-03-17 04:55:33.403276', 4, '25500', '820520721244', 'Damodara Sidhu', 'Father', '+141 9844841246', '+32 6628695573'),
('101A', 'with', '3', '2023-03-17 04:55:33.403276', 4, '25500', '820520738344', 'Karlaye Gole', 'Father', '+86 7594677221', '+62 7760708784'),
('201C', 'with', '4', '2023-03-17 04:55:33.403276', 2, '25500', '820520748469', 'Govinda Buch', 'Father', '+144 9813421426', '+33 8478213104'),
('501', 'with', '2', '2023-03-17 04:55:33.403276', 4, '25500', '820520805184', 'Kamala Keer', 'Father', '+91 9604057241', '+31 8120899008'),
('201', 'with', '3', '2023-03-17 04:55:33.403276', 4, '25500', '820520809146', 'Kariyamna Ben', 'Father', '+52 9713074659', '+81 9567340216'),
('701', 'with', '2', '2023-03-17 04:55:33.403276', 5, '25500', '820520845059', 'Chanda Oommen', 'Father', '+141 6557562941', '+61 7515802226'),
('101A', 'with', '3', '2023-03-17 04:55:33.403276', 5, '25500', '820520859586', 'Lavanya Jha', 'Father', '+81 8158089768', '+144 7028255845'),
('201B', 'with', '4', '2023-03-17 04:55:33.403276', 1, '25500', '820520897382', 'Nitia Sachdev', 'Father', '+44 9447615429', '+52 8754168534'),
('101A', 'with', '1', '2023-03-17 04:55:33.403276', 3, '25500', '820520965505', 'Jaidev Dewan', 'Father', '+33 9754140451', '+61 8641201686'),
('901', 'with', '2', '2023-03-17 04:55:33.403276', 3, '25500', '820520982468', 'Devaraja Gill', 'Father', '+20 6550039783', '+144 7053749426'),
('201C', 'with', '5', '2023-03-17 04:55:33.403276', 2, '25500', '820520990533', 'Bharat Pillay', 'Father', '+33 8197754499', '+144 7167811323');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `id` int(5) NOT NULL,
  `person` int(10) NOT NULL,
  `available` int(5) NOT NULL,
  `fees` int(10) NOT NULL,
  `room_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `person`, `available`, `fees`, `room_id`) VALUES
(1, 4, 4, 111000, '101'),
(2, 2, 6, 55000, '201'),
(3, 2, 6, 106000, '301'),
(4, 1, 7, 48500, '401'),
(5, 4, 4, 134000, '501'),
(8, 0, 8, 0, '601'),
(13, 4, 4, 174000, '701'),
(14, 8, 0, 319500, '101A'),
(15, 1, 7, 50000, '101B'),
(16, 1, 7, 48500, '101C'),
(17, 2, 6, 71500, '201A'),
(18, 5, 3, 171000, '201B'),
(19, 6, 2, 205500, '201C'),
(20, 2, 6, 115000, '801'),
(21, 5, 3, 128000, '901');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `position` varchar(20) NOT NULL,
  `hire_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `salary` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `name`, `email`, `phone`, `position`, `hire_date`, `salary`) VALUES
(1, 'Vijay', 'vijay@gmail.com', '9875628468', 'Hostel Manager', '2023-03-09 16:37:29', '40000'),
(2, 'Wilson', 'wilson2020@gmail.com', '9638364824', 'Receptionist ', '2023-03-09 16:47:50', '25000'),
(3, 'Abdullah', 'abdullah12@gmail.com', '9987462064', 'Housekeeper ', '2023-03-09 16:48:29', '25000'),
(4, 'Samir', 'samir1999@gmail.com', '96845187937', 'Kitchen Staff', '2023-03-09 16:48:30', '25000'),
(5, 'Muthu', 'muthu1998@gmail.com', '9580639461', 'Security Staff', '2023-03-09 16:48:30', '20000'),
(6, 'William', 'william@gmail.com', '7972640839', 'Security Staff', '2023-03-09 16:48:30', '20000'),
(7, 'Mohamed Jeabar', 'jabar@gmail.com', '9646296207', 'Security Staff', '2023-03-09 16:51:10', '20000');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(5) NOT NULL,
  `name` varchar(20) NOT NULL,
  `class` varchar(20) NOT NULL,
  `rollno` varchar(50) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `state` varchar(20) NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `city` varchar(100) NOT NULL,
  `address` varchar(500) NOT NULL,
  `genter` varchar(10) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(20) NOT NULL,
  `salt` varchar(70) NOT NULL,
  `password` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL,
  `profile` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `class`, `rollno`, `fname`, `state`, `zipcode`, `city`, `address`, `genter`, `phone`, `email`, `salt`, `password`, `token`, `profile`) VALUES
(38, 'Kalyana-ShraddhÃ¢', 'EEE', '820520735830', 'Chandan Edwin', 'Tamil Nadu', '406942', 'Thiruvarur', '1/132 kuvindakudi', 'female', '+52 9772719173', 'Kalyana-ShraddhÃ¢@gm', 'c4b3d7cff17ac51d4483ce37e01f7d02', '8d2f26ec823c8a1d8a06abc6dcb487be1b7bc54d5e830425f3dd0cbbd2930fa2', 'd8bc1f0372ccff7cf484e266c3c74fa7c70c688155da38df17db9f02c9ca4aed', ''),
(39, 'Kesavane', 'ECE', '820520415376', 'Kapil Chada', 'Tamil Nadu', '841900', 'Thiruvarur', '1/132 kuvindakudi', 'male', '+86 6581434752', 'Kesavane@gmail.com', '90eb71f61a937b1b99fd6ee5f5251e0d', 'fafb6f163b642652a193978c3d053f37b892bc03d003cd09d4aaad8eff534e53', '3642b09b2a602dea33e8c1034fbdca7e5bd08775ee113db1a6f32353f404ab39', ''),
(227, 'Aniruddha', 'EEE', '820520721244', 'Damodara Sidhu', 'Tamil Nadu', '389663', 'Thiruvarur', '1/132 kuvindakudi', 'male', '+20 8221449468', 'Aniruddha@gmail.com', '150d41f6416239bf449e33eba46a71bb', '01badac10042d5c83e5bfce599d517f6efc928a717cd3c7b4032e29109bee858', 'a6bb1c77516e646251c96b8ccd0b5906e2170e274fca65b899bf01b1a9027613', ''),
(228, 'Dilipa', 'CSE', '820520376293', 'Mohan Ramanathan', 'Tamil Nadu', '421085', 'Thiruvarur', '1/132 kuvindakudi', 'male', '+44 6515788799', 'Dilipa@gmail.com', 'd5b90994eeb1dfa97e6f0b90647d914c', 'af6231c8a8d29d8a87f6174b8c093046064c5346794c16f91b2e2822647bdcd1', 'e1f4ed288c5fd9cfd2257de496e74c9a776f98822904517c6c9adc1855a7fa24', ''),
(229, 'Inderjit', 'IT', '820520209344', 'Dhaval Padmanabhan', 'Tamil Nadu', '515237', 'Thiruvarur', '1/132 kuvindakudi', 'female', '+1 9251376926', 'Inderjit@gmail.com', '24da9e4d36ff3c3c58b14dae33e4811d', 'ded0e6c5809103b280771056b3ba2c42b3ee92c15239af94208e7f04871ce187', '79bdbd6344f2b0eab917ca4ab06a5260e2dabc2d4fc647cd7d8d9d3a9c9c2039', ''),
(230, 'Jyotsana', 'EEE', '820520718145', 'Murali Balakrishnan', 'Tamil Nadu', '272577', 'Thiruvarur', '1/132 kuvindakudi', 'female', '+141 7797747707', 'Jyotsana@gmail.com', '9398c0848f3f9c90774b915a6549c42f', '5d6c40d1f18cb2b0f1a7a9c1997b904f99db11fef49ea94e21003207605fb663', 'd0d19c481840737ae87d3da364fd5b2d946187462fa17928de8a28a36725b2e6', ''),
(231, 'Hamsa', 'Civil', '820520047507', 'Anjali Maharaj', 'Tamil Nadu', '314355', 'Thiruvarur', '1/132 kuvindakudi', 'female', '+86 6667721453', 'Hamsa@gmail.com', '4774ccca0256857d5de3686456c0479d', '0c0a81c2bf4d1602a056cfd9af02cb57dec237c2d287eeb3aeb8dc3c7db3dde5', '64e91794114f270d3adc428e67a629b06b618d316cfca0f220b7373c2729ea61', ''),
(232, 'Kavi', 'CSE', '820520099334', 'Madhavi Tandon', 'Tamil Nadu', '651120', 'Thiruvarur', '1/132 kuvindakudi', 'male', '+91 7865911313', 'Kavi@gmail.com', 'de8097de88538938cc4322c79599d690', 'e174bf810500d6e72565be4362fb9ed9ecee604980348fb1bcd9136f4ff7e5e4', 'f1da63067359323b3c0a7daab553ac658435af9e1e742c30aab039182983a6dc', ''),
(233, 'Leka', 'IT', '820520235012', 'Lutchmayah Lad', 'Tamil Nadu', '905212', 'Thiruvarur', '1/132 kuvindakudi', 'female', '+62 8687025277', 'Leka@gmail.com', '33855c854f4261b94a8b54fbf3734a34', '4dc3daec70f32b9461dfe347b8597c29af474b3b470221b9c9d0f9595f489659', '01ad29b460a024363f3316c250a94e7fbde7993c9cc2543cd030ba9f2d511737', ''),
(234, 'Kalidasa', 'Civil', '820520665268', 'Gitika Sharma', 'Tamil Nadu', '421099', 'Thiruvarur', '1/132 kuvindakudi', 'male', '+144 7462543702', 'Kalidasa@gmail.com', '6c76fc369915fb2bbdf141f9c508983c', 'af6647171492235bdeac9b0ebaf074e6ddaf5133134394096fa53722b5d66722', 'b3e6b8f3a0f826193f6e8ca0ee108766be4d8d4694c22e8ec8b4d0739f347be4', ''),
(235, 'Madhuri', 'Civil', '820520897382', 'Nitia Sachdev', 'Tamil Nadu', '444124', 'Thiruvarur', '1/132 kuvindakudi', 'female', '+32 9162133081', 'Madhuri@gmail.com', '02b8e72e6875ed937e181649a3c10005', 'e60454bf2190100065b53d6be5dbadfe5ce6019dce96b3a8f694c6755bc7db38', 'e8b8a99e2b09e17e8834ce9480d46418cb547b3abc03f0f6eb1b5f50d5ede519', ''),
(236, 'Minali', 'Civil', '820520627672', 'Dipali Mangal', 'Tamil Nadu', '917662', 'Thiruvarur', '1/132 kuvindakudi', 'female', '+86 9390922273', 'Minali@gmail.com', 'ef16e3e9490ec07f265adcb82ab53ebf', 'c0b01224abcabf66d52999232ad781b24a1c44ff77b6cb21d566644d026ff20b', '920895f12c428612b35f10d34ed313a20de431cc7ba3ea344f6f3e329c7ca9e9', ''),
(237, 'Mohinder', 'CSE', '820520528901', 'Lallida Mannan', 'Tamil Nadu', '730891', 'Thiruvarur', '1/132 kuvindakudi', 'male', '+32 6081079154', 'Mohinder@gmail.com', 'cd376833465326c17c7b7e68ad30a280', '4338aeced2883bd3e54410d4c9beb7c1d0e1454b3b37a674a506a38c3f4b2197', 'a09870067f47ee3559d44c6604e96ec0b9ee74b9a41b88650da5aaa26a9ee5f0', ''),
(238, 'Gotama', 'ECE', '820520805184', 'Kamala Keer', 'Tamil Nadu', '970776', 'Thiruvarur', '1/132 kuvindakudi', 'male', '+86 6352902984', 'Gotama@gmail.com', '8972e3afdde9b1f1f2e0e200d7121dfc', 'd54a52ae108f80edea2fe28c16f9fca7fa7e1ac64e2fb240ff2fc360f975ddd3', 'f5a175ee905dd2e66da7d065339b387d91a103cea407aa9ffdcd0a5ed93741b4', ''),
(239, 'Anupam', 'EEE', '820520965505', 'Jaidev Dewan', 'Tamil Nadu', '384637', 'Thiruvarur', '1/132 kuvindakudi', 'male', '+61 6408886259', 'Anupam@gmail.com', '343e51ea2642d445b385e902cea864c5', '4037629566bf6180d162c311f64909f9e7f46d099d3249714f5f993d9631782f', 'f3c0130eca058ed50cc74e5655e45a960888573ee90b96a42641616f68944caa', ''),
(240, 'Arun', 'IT', '820520982468', 'Devaraja Gill', 'Tamil Nadu', '975670', 'Thiruvarur', '1/132 kuvindakudi', 'male', '+61 9606114590', 'Arun@gmail.com', '77219f2b8ef571c70c313c5444fcecfc', '04bb1f4c85e6bcc568e76fdd6739496f2d671b30fbbbc0a1dfb4d1e166869103', '0284f2c268a5e371dcfdacac53f98929e2541eb1e0626d94781268806e54ad53', ''),
(241, 'Kessavamohane', 'EEE', '820520508747', 'Jitender Ramaswamy', 'Tamil Nadu', '776143', 'Thiruvarur', '1/132 kuvindakudi', 'male', '+62 8127118163', 'Kessavamohane@gmail.', 'b755b1127d1b131ac11f65f0e22aff09', '0a0b6eab5045da876c2a5291b96f76857fee668e9daa129b78d3b24bd26aa34e', '2900e67e4984b1f400f1f7790e843786fbf3ae2273810abf4b1ebbe947f08660', ''),
(242, 'Deva', 'CSE', '820520655408', 'Kalyani Batta', 'Tamil Nadu', '080540', 'Thiruvarur', '1/132 kuvindakudi', 'male', '+81 7063264318', 'Deva@gmail.com', '77ed55bf13dba3de6e1f3b54a67a5dc2', '93eba61f0c3cec3cd87200e6ec178f238e4bf2714594e40ae04525623e86ba98', 'f8dfad8f9260c429f7804cf4f7ab7335160c143da11af523503af7b4e2df71d1', ''),
(243, 'Hamsa', 'IT', '820520400298', 'Manickam Dey', 'Tamil Nadu', '979486', 'Thiruvarur', '1/132 kuvindakudi', 'female', '+61 7670569046', 'Hamsa@gmail.com', '7b87d35b59629718a03c386b1808198f', '5b7530c427c85573b5682501ac429261c1cb1310916168218fc0a63c73522bb5', '5fa81a12ccb43771d2f5acc08b236318c5fc553fc440dbde3dd24f5afb4c4e42', ''),
(244, 'Kapila', 'EEE', '820520194402', 'Kalyani Tata', 'Tamil Nadu', '656823', 'Thiruvarur', '1/132 kuvindakudi', 'male', '+31 9884202729', 'Kapila@gmail.com', '45bd5ebb03998ef73e1be1367f03de75', 'd8577831ad7bede31a1048489e92f61eee4f45a27ab2d5bc9783b896ec93afc6', '88c9cc22f7eb82ce3ae91da05b796d38c8662f4c09719cc5ecdd281b07e830d6', ''),
(245, 'Kalyan', 'EEE', '820520349178', 'Kessavamohane Chowdh', 'Tamil Nadu', '051447', 'Thiruvarur', '1/132 kuvindakudi', 'male', '+91 8549274130', 'Kalyan@gmail.com', 'a47b43fd78df6d1aded00e60d1686c0c', '292a527659a1a27470a96b0a21b8ad19e33192a848b7d18aca2ebeaaed03195d', '10c87e73626a6af5d9cb4da63459cce1ee168e0cab5997b6cbd2dc3c9f2386f0', ''),
(246, 'Mridula', 'ECE', '820520674576', 'Darshan Mannan', 'Tamil Nadu', '686411', 'Thiruvarur', '1/132 kuvindakudi', 'female', '+20 7878735244', 'Mridula@gmail.com', 'a02f4d0eb110bf71a83153d89426d6a7', '49a0aec2171e65a9f7fb7dc11955b420a47f41b0d8a746a7face0089af77b8fc', '0652c5f349c333b30f1a92001ed7697d84edc117bb744b572796e1fc7e986ae6', ''),
(247, 'Lochana', 'CSE', '820520748469', 'Govinda Buch', 'Tamil Nadu', '518998', 'Thiruvarur', '1/132 kuvindakudi', 'female', '+52 7206878352', 'Lochana@gmail.com', '3230e5fb827614563d4fb77971d1cc7f', 'c4c28ecac5947838414b3e9767275746c1e7bdfe065c5cf4b2069984d51daf4a', 'f327b3e294fe65c60d2e102086d89af87c7f9e3b5e3f834d2b58586940b8030c', ''),
(248, 'Dinesh', 'EEE', '820520809146', 'Kariyamna Ben', 'Tamil Nadu', '943418', 'Thiruvarur', '1/132 kuvindakudi', 'male', '+52 8896962300', 'Dinesh@gmail.com', '2dbd9b9dff6015add1dfb16780f0787f', 'b0f8901c0f9ce602a6562dc915f6c0c35acbed3dacdb56418ed82432178635d8', 'b26263689bd90d890c0302dbc2606c99df00365c147e465675403d63f2434709', ''),
(249, 'Mahendra', 'Civil', '820520280702', 'Aruna Khare', 'Tamil Nadu', '726194', 'Thiruvarur', '1/132 kuvindakudi', 'male', '+86 9564549906', 'Mahendra@gmail.com', '03436b9a5c2e370ba8e38367718d896a', '91ca2c0437aac6f6defe1e2c3c9d3954a6f91085884b1c291d8d7141c63ddd39', '363f2723095cb35ada40c971037922c812d7dd6ddfd2002e751bd20a112dc019', ''),
(250, 'Chandrakant', 'CSE', '820520990533', 'Bharat Pillay', 'Tamil Nadu', '047255', 'Thiruvarur', '1/132 kuvindakudi', 'male', '+86 7477245006', 'Chandrakant@gmail.co', '3242eb54951d97bbdd893e4832f6852b', '4060a07c532905a69776724406103bdbaa534888b423d8e6eafa53d5c02b3609', 'ff172bb73092fecffcd1f27274c3b06091403abdf87c66c7b8f0a0a39c7c2273', ''),
(251, 'Aradhana', 'Mech', '820520717658', 'Manisha Aurora', 'Tamil Nadu', '414751', 'Thiruvarur', '1/132 kuvindakudi', 'female', '+91 9514254772', 'Aradhana@gmail.com', '69596b2e2e737294bc60c899027c7f03', 'f44a4827c04e75c5903bebce4060b1352ac3548561db36af0f37e76ae07a6173', '07ccb6b9138fbee112f8ec9220bd9039f90188892325f82b94ab56ae3426a309', ''),
(252, 'Damayanti', 'IT', '820520313436', 'Madhavi Jhaveri', 'Tamil Nadu', '675330', 'Thiruvarur', '1/132 kuvindakudi', 'female', '+32 9981481715', 'Damayanti@gmail.com', '7948b0e660f39e1883ceaffcfbc19c46', '2e9146cd1595effe07952eb113e292c047a0f0644f7ed8d28081e23539f26628', 'c6ae8d6289f26b730b29b1d9bc2f142580cbaab924873199bc06f2d2141d4b27', ''),
(253, 'Keya', 'EEE', '820520219494', 'Indira Patla', 'Tamil Nadu', '367707', 'Thiruvarur', '1/132 kuvindakudi', 'male', '+44 6200820761', 'Keya@gmail.com', 'bdaff7d6c7e2817e4390bd0bc1fda846', '86df8e63c939108187d04c415dbd489822456bdddcfa41b9078b04885e9bc3a8', '08c192924bfd5b5016da01b2bd8184f3d3143b9c08b56af1b000413bbfc5bc64', ''),
(254, 'Nirupama', 'Mech', '820520537696', 'Karishma Agarwal', 'Tamil Nadu', '246076', 'Thiruvarur', '1/132 kuvindakudi', 'female', '+44 9173853220', 'Nirupama@gmail.com', 'af78953dceff59375da7bd30991cea26', '0ff3abb2c76df3aa0ed3a342a36723140ada016bf9493e87eafb9e361d325d18', '302ef5cb0557ca254f08891d82fea479c9b74b024717dbd7ccf470ff896cc6cc', ''),
(255, 'Kessavamohane', 'ECE', '820520401813', 'Jitinder Datta', 'Tamil Nadu', '492372', 'Thiruvarur', '1/132 kuvindakudi', 'male', '+20 7820514243', 'Kessavamohane@gmail.', '61b38314c5f6828f0a2cafef12fa6153', '24be7621ac9815eee34c481116c142337ec674d63fecebdc913abe58e2ba8438', 'b69be741653c4d9cd7ee7d1a2730f3f0c2272a5325f51194a6537ff88656198d', ''),
(256, 'Anila', 'Civil', '820520701648', 'Nirav Saini', 'Tamil Nadu', '185058', 'Thiruvarur', '1/132 kuvindakudi', 'female', '+52 8517977872', 'Anila@gmail.com', '82ddd3047df132be1e0138e463316085', '6b25cfe7d1c981b0703e889eda5491b39cb986a2400e05052daca7e2d1548559', '3b0ec9b2e216336216c071bad395cd7f0c52e34597ef27e9612366dd1c35e764', ''),
(257, 'Krishna', 'CSE', '820520738344', 'Karlaye Gole', 'Tamil Nadu', '582413', 'Thiruvarur', '1/132 kuvindakudi', 'male', '+52 8538062433', 'Krishna@gmail.com', 'a86dd705a3153c66f87dc53c47a05574', '4c31eb6705727099aa1d24825982bcf05f451ba10b33a7dc9a9a36be34e88ed8', '47a1a76305a0b01830acf2cdad314d03a87f6356eb4cf129a20d82c1faa115c5', ''),
(259, 'Deepak', 'Civil', '820520131746', 'Nirupama Chakraborty', 'Tamil Nadu', '262905', 'Thiruvarur', '1/132 kuvindakudi', 'male', '+144 8728139163', 'Deepak@gmail.com', 'ceeb873f7d22cc5ce00ef3259d37d3a6', '5d231ade6bf5481b4ed9a4ab8aec9e44623ef557862bffd0a128aa13b0633772', '88c8932b8decdb7c69da0eca9dd9fcb42be454d6db54582df472367d27067025', ''),
(260, 'Ilanila', 'ECE', '820520845059', 'Chanda Oommen', 'Tamil Nadu', '791488', 'Thiruvarur', '1/132 kuvindakudi', 'female', '+81 9165578183', 'Ilanila@gmail.com', 'ae5950f8ca2c096c29816a0075291df1', '28533914f8d92c1a46ac1439e36d6e10ddf58e3beed69bacd86602e98e1d1e33', '56fda1db4eef69c0c0599926c0c78ad710038ea6ad0a414e660e751ec8a86bab', ''),
(261, 'Murugan', 'EEE', '820520208760', 'Drupada Kapur', 'Tamil Nadu', '077582', 'Thiruvarur', '1/132 kuvindakudi', 'male', '+61 7092865291', 'Murugan@gmail.com', 'f8b647d8047f8faab8072ff3e53114a5', '840df53376532d77eb3c4c035f877ae97c357adcc87b4a93e274be690f03d4fb', 'baa6966d9b2ed31992fd78f9907134c622746c0bd416c813b88987e0e9678573', ''),
(262, 'Mahavira', 'CSE', '820520567424', 'Gopal Om', 'Tamil Nadu', '585407', 'Thiruvarur', '1/132 kuvindakudi', 'male', '+1 8628083260', 'Mahavira@gmail.com', '7d5eae036ff3ef88430582b13d1e5f9c', '80ec8d80911b7c4848f8b1521853c6d931179a9bec9bfa0bafa4fbaa8bab6dee', '57783c248d2fdf6c07527b024fe1f4ab20454e5f2c6fbcd3e1941e44aab9b70c', ''),
(263, 'Krishnin', 'Civil', '820520084382', 'Nataraj Soman', 'Tamil Nadu', '542089', 'Thiruvarur', '1/132 kuvindakudi', 'male', '+91 9990789371', 'Krishnin@gmail.com', '8d702de9e28ee6182cd486cf1fed1c96', '54a717e15c56e8fad1389429348323f0b9482046f5e3e74ae8c0d3be35355970', '88c0dc7000d3000d3b5c60e011ecc86acb9f7dbfab22e9b3b8ff343022c57353', ''),
(264, 'Anil', 'ECE', '820520555162', 'Ganesh Kari', 'Tamil Nadu', '005977', 'Thiruvarur', '1/132 kuvindakudi', 'male', '+144 8715239416', 'Anil@gmail.com', '6b4bb0b68543b1e81402f9dc3f2f4c24', 'fd452ee4be6fa94f8e5cbb0ce9d89f0fb7065bab83b66484bf0e7b3d499a5a58', 'd48908003b7860a7d4f2602d3609355ac07b665e6a601769c1973c51bf50899a', ''),
(265, 'ï»¿firstname', 'IT', '820520671026', 'Aishwarya Vig', 'Tamil Nadu', '729012', 'Thiruvarur', '1/132 kuvindakudi', 'gender', '+91 6606030010', 'ï»¿firstname@gmail.c', 'bdded84b1602dd3cf6a37fc40db73bf9', 'ca022b14c96444ed238ca0a4a9233bf9591ba6029426aa3c23a0702045aad2a8', '393fcc296402154c74c5f2086bdcab5ab26adb9988f02451c45b1094d62dbdf5', ''),
(266, 'Madhavi', 'IT', '820520859586', 'Lavanya Jha', 'Tamil Nadu', '131286', 'Thiruvarur', '1/132 kuvindakudi', 'female', '+141 6013654903', 'Madhavi@gmail.com', '1a18663427175a90b07b5373bd7b449c', 'dd66adb0aeac89469e353fe44de25e62fdb316e608699b5957243ecde740e2fd', 'ac894a542f3a45e80915de153b22091c899494051052f4924ce778ad062de002', ''),
(267, 'Harsha', 'CSE', '820520171369', 'Dharmaradj Tiwari', 'Tamil Nadu', '773779', 'Thiruvarur', '1/132 kuvindakudi', 'male', '+7 7414836057', 'Harsha@gmail.com', '02f6cb0c16c13fc7b47a8e86c0829877', '10c5a56e3640ff3a169d116bf9efde44b7c2022890d1b9f8bbe10e11daf4682e', 'e24f00313aedf16a122972c11f124241dd763f8f5f0104712c635e842481e13d', ''),
(268, 'Ajay', 'Mech', '820520677163', 'Nithya Kothari', 'Tamil Nadu', '854082', 'Thiruvarur', '1/132 kuvindakudi', 'male', '+7 8626379413', 'Ajay@gmail.com', 'f602eafc72a8e381179bca908b4816c8', 'd6ad0be35073d7d504d61331d9c76930c8c234cba1ceeead8dddcba16d4eacf5', '7d5714a5f33771ce4d1bab919df27588b55832d28d160cc96022a9c4c02b8e18', ''),
(269, 'Indrani', 'IT', '820520063372', 'Ninad Sura', 'Tamil Nadu', '893561', 'Thiruvarur', '1/132 kuvindakudi', 'female', '+32 7359416219', 'Indrani@gmail.com', 'e7199b538f9325a324c51cd7a72d4ebf', '2137cfa5b67863737332fcc64dffa50d8cea485ac96d5667965e9eeee5ec7e86', 'c841b4c05bb733860cfbc45eb4f4edd7ea59d8573fad8572558af8d6d335dfdf', ''),
(270, 'Anuja', 'IT', '820520229873', 'Aditya Baral', 'Tamil Nadu', '111733', 'Thiruvarur', '1/132 kuvindakudi', 'female', '+31 9078921644', 'Anuja@gmail.com', '792e9d5f8ae0b95b9d72c9d06c16cd48', 'b92ca6f7690d5156706413e2481b6eb24f7871b796edaf53afeb1b37d49840e3', 'e9f8f87281713d8d4e3a3ec1482571633933a11c71a107a82986333e66a3faf0', '');




-- --------------------------------------------------------

--
-- Table structure for table `vacate`
--

CREATE TABLE `vacate` (
  `id` int(10) NOT NULL,
  `room_no` varchar(10) NOT NULL,
  `reason` varchar(300) NOT NULL,
  `status` varchar(30) NOT NULL,
  `token` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vacate`
--

INSERT INTO `vacate` (`id`, `room_no`, `reason`, `status`, `token`) VALUES
(7, '301', 'summa thn summa thn summa thn summa thn summa thn summa thn summa thn summa thn summa thn summa thn summa thn summa thn summa thn summa thn summa thn summa thn summa thn summa thn summa thn summa thn summa thn ', 'pending', '7cbd7906b65e74dfa35aa6ad9b69fcaf09e05835c9fd1a808761728acb47db3e'),
(8, '201', 'room is not comfortable for me', 'accept', 'fc958176583f9e703e647ca9dcf9ab091ea790aa1d94440efdece6478d7fa9b1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guest`
--
ALTER TABLE `guest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`rollno`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reg` (`rollno`);

--
-- Indexes for table `vacate`
--
ALTER TABLE `vacate`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `guest`
--
ALTER TABLE `guest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=278;

--
-- AUTO_INCREMENT for table `vacate`
--
ALTER TABLE `vacate`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
