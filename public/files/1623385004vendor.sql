-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 104.199.219.205
-- Generation Time: May 15, 2021 at 03:10 AM
-- Server version: 8.0.18-google
-- PHP Version: 8.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_samtool`
--

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `vendor_firstname` varchar(255) NOT NULL,
  `vendor_lastlname` varchar(255) NOT NULL,
  `vendor_admin_email` varchar(255) NOT NULL,
  `vendor_sec_reg_name` varchar(255) NOT NULL,
  `vendor_acronym` varchar(255) DEFAULT NULL,
  `vendor_office_address` text,
  `vendor_status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`vendor_id`, `vendor_firstname`, `vendor_lastlname`, `vendor_admin_email`, `vendor_sec_reg_name`, `vendor_acronym`, `vendor_office_address`, `vendor_status`, `created_at`, `updated_at`) VALUES
(1, '', 'Huawei', 'huawei@gmail.com', 'Sec huawei', 'HT', 'HT Headquarter, Makati City', 'Complete Offboarding', '2021-05-04 13:01:00', '2021-05-04 13:01:00'),
(2, '', 'Nokia', 'nokia@gmail.com', 'Sec nokia', 'NK', 'NK plaza, BGC, taguig City', 'Ongoing Offboarding', '2021-05-04 13:05:00', '2021-05-04 13:05:00'),
(3, 'Marvin', 'Esternon', 'maesternon@absi.ph', 'Huawei Philippines', 'Huawei PH', '713 Barangay Poblacion 7 Tanauan City, Batangas', 'Ongoing Offboarding', NULL, NULL),
(4, 'Aris', 'Salvador', 'arhizsx@gmail.com', 'TEST VENDOR', 'TV', 'QC', 'Ongoing Offboarding', NULL, NULL),
(5, '', 'Monahan, Howell and Koelpin', 'mohan@example.com', 'sec mohan', 'mhk', 'BGC', 'Active', NULL, NULL),
(6, '', 'Toy, Batz and Feest', 'toy@sample.ph', 'sec ty', 'tbf', 'MAKATI', 'Ongoing Offboarding', NULL, NULL),
(7, '', 'Lang PLC', 'langplc@gmail.com', 'sec langPlc', 'lang', 'PASIG', 'Ongoing Offboarding', NULL, NULL),
(8, '', 'Wisozk and Sons', 'ws@yahoo.com', 'wisozk sec', 'w&s', 'BGC', 'Ongoing Offboarding', NULL, NULL),
(9, '', 'Wunsch, DuBuque and O\'Keefe', 'wunsch@gmail.com', 'wunch', 'wun', 'QC', 'Ongoing Offboarding', NULL, NULL),
(10, '', 'Bailey, Doyle and Orn', 'bailey@bailry.com', 'bailey sec', 'bai', 'QC', 'Ongoing Offboarding', NULL, NULL),
(11, '', 'Koch-Lubowitz', 'kock@gmail.com', 'kock sec', 'kock', 'MANILA', 'Ongoing Offboarding', NULL, NULL),
(12, '', 'Gusikowski-Okuneva', 'gusikowski@gmail.com', 'gusikowski', 'gus', 'MANILA', 'Ongoing Offboarding', NULL, NULL),
(13, '', 'Ward-Schmidt', 'ward@gmail.com', 'war sec', NULL, NULL, 'Ongoing Offboarding', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`vendor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `vendor_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
