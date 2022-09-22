-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2022 at 08:52 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clubunimy`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminlogin`
--

CREATE TABLE `adminlogin` (
  `user_first` varchar(200) NOT NULL,
  `user_last` varchar(200) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `user_uid` varchar(200) NOT NULL,
  `user_pwd` varchar(200) NOT NULL,
  `student_id` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `adminlogin`
--

INSERT INTO `adminlogin` (`user_first`, `user_last`, `user_email`, `user_uid`, `user_pwd`, `student_id`) VALUES
('John', 'doe', 'zayque@yahoo.com', 'zayque', '$2y$10$/rviYQw3HFXsGizqh7MxXudXiSJahTxO6GDnls7EHIN1oj6wI1FR6', 'b09190001');

-- --------------------------------------------------------

--
-- Table structure for table `club_activity`
--

CREATE TABLE `club_activity` (
  `club_id` int(11) NOT NULL,
  `club_image` varchar(200) NOT NULL,
  `club_content` varchar(200) NOT NULL,
  `club_content_2` varchar(200) NOT NULL,
  `club_date` varchar(200) NOT NULL,
  `club_time` varchar(200) NOT NULL,
  `club_contact` varchar(200) NOT NULL,
  `club_name` varchar(200) NOT NULL,
  `club_type` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `club_activity`
--

INSERT INTO `club_activity` (`club_id`, `club_image`, `club_content`, `club_content_2`, `club_date`, `club_time`, `club_contact`, `club_name`, `club_type`) VALUES
(1, 'img/UNIMY Clubs May21 Sem_page-0002.jpg', 'Club Esport', 'Test', '2022-04-11', '10:41 pm', '0178782932', 'Zakaria', 'esport'),
(2, 'img/UNIMY Clubs May21 Sem_page-0003.jpg', 'Hackerthon', 'Meet and greet with staff', '2022-09-12', '5.00pm', '032039032', 'Ahmad', 'cyber'),
(3, 'img/UNIMY Clubs May21 Sem_page-0004.jpg', 'Capture nice photo!', 'Travel and trip around park', '2022-02-08', '3.00 pm', '0167267823', 'Siti', 'photo'),
(4, 'img/UNIMY Clubs May21 Sem_page-0006.jpg', 'Learn Japanese Language', 'Attend Japanese class!', '2022-09-01', '3.00 pm', '0178789233', 'Jann', 'japan'),
(5, 'img/UNIMY Clubs May21 Sem_page-0007.jpg', 'Air freshener for All', 'Go hiking with team', '2022-01-10', '4.00 pm', '0189892032', 'Ali', 'advent'),
(6, 'img/UNIMY Clubs May21 Sem_page-0005.jpg', 'Learn instrument with musician', 'Attend musician class', '2022-07-14', '5.00 pm', '0123454321', 'Abu', 'music'),
(7, 'img/UNIMY Clubs May21 Sem_page-0008.jpg', 'Biztech for All', 'Learn from experiences worker!', '2022-09-02', '4.00 pm', '0178789203', 'Akmal', 'biztech'),
(8, 'img/UNIMY Clubs May21 Sem_page-0009.jpg', 'The Future IRS', 'Attend lab class', '2022-09-05', '5.00 pm', '0189283920', 'Hafiz', 'inge');

-- --------------------------------------------------------

--
-- Table structure for table `email`
--

CREATE TABLE `email` (
  `id_email` int(100) NOT NULL,
  `subject_email` varchar(200) NOT NULL,
  `body_email` varchar(200) NOT NULL,
  `altbody_email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `email`
--

INSERT INTO `email` (`id_email`, `subject_email`, `body_email`, `altbody_email`) VALUES
(1, 'Registration UNIMY Club 2022', 'Registration UNIMY Club for Students 2022', 'Registration UNIMY Club for Students 2022');

-- --------------------------------------------------------

--
-- Table structure for table `limitseminar`
--

CREATE TABLE `limitseminar` (
  `id_limit2` varchar(200) NOT NULL,
  `jumlah_limit2` varchar(200) NOT NULL,
  `mesej_limit2` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `limitseminar`
--

INSERT INTO `limitseminar` (`id_limit2`, `jumlah_limit2`, `mesej_limit2`) VALUES
('', '200', 'Full Registered');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(100) NOT NULL,
  `name_user` varchar(200) NOT NULL,
  `studentid_user` varchar(200) NOT NULL,
  `email_user` varchar(200) NOT NULL,
  `phone_user` varchar(200) NOT NULL,
  `club_user` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `name_user`, `studentid_user`, `email_user`, `phone_user`, `club_user`) VALUES
(0, 'Ahmad Munir', 'B08180002', 'munir@yahoo.com', '0178782930', 'Photography,Japananime,Adventurous Recreational,');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminlogin`
--
ALTER TABLE `adminlogin`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `club_activity`
--
ALTER TABLE `club_activity`
  ADD PRIMARY KEY (`club_id`);

--
-- Indexes for table `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`id_email`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `club_activity`
--
ALTER TABLE `club_activity`
  MODIFY `club_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `email`
--
ALTER TABLE `email`
  MODIFY `id_email` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
