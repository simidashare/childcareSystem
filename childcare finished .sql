-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2021 at 03:49 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00"; 


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `childcare`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetChildEnrolmentRows` (IN `cid` INT)  BEGIN
	select count(*) from enrolment where child_id = cid;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetChildNumberRows` (IN `cid` INT)  BEGIN
	IF (cid = 0) THEN
     	select * from child;
    ELSE
     	select * from child where child_id=cid;
    End IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetFamilyNumberRows` (IN `fid` INT)  BEGIN
	IF (fid = 0) THEN
     	select * from family;
    ELSE
     	select * from family where family_id=fid;
    End IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetStaffAssignNum` (IN `sid` INT)  BEGIN
	select count(*) from staff_child GROUP BY staff_id having staff_id = sid;	
	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `searchChildAllergy` (IN `cid` SMALLINT)  BEGIN
	select c.child_id ,c.child_fname ,c.child_lname,c.child_dob,c.child_gender, ifnull(a.alle_code, -1) as alle_code ,ifnull(a.alle_description, "Please Select") as alle_description from child as c left join child_allergy as ca on c.child_id= ca.child_id left join allergy as a on ca.alle_code = a.alle_code where c.child_id = cid limit 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `searchStaffChild` (IN `sid` SMALLINT)  BEGIN
select c.child_id as "child_id",concat(" ", c.child_fname ," ",c.child_lname, " ") as "child_name", s.staff_id as "staff_id", concat(" ", s.staff_fname ," ",s.staff_lname, " ") as "staff_name" from child as c join staff_child as sc on c.child_id= sc.child_id join staff as s on sc.staff_id = s.staff_id where s.staff_id = sid;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewAllChild` ()  BEGIN
	select c.child_id as ID,c.child_fname as "First Name",c.child_lname "Last Name",c.child_dob as "Date of Birth",c.child_gender as "Gender" , ifnull(a.alle_description, "-")as "Allergy" from child as c left join child_allergy as ca on c.child_id= ca.child_id left join allergy as a 
on ca.alle_code = a.alle_code;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `viewAllStaffChild` ()  BEGIN
select c.child_id as "Child ID",c.child_fname as "First Name",c.child_lname "Last Name", concat(s.staff_id, " - " ,s.staff_fname," ",s.staff_lname) as "Staff" from child as c  join staff_child as sc on c.child_id= sc.child_id  join staff as s 
on sc.staff_id = s.staff_id;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `allergy`
--

CREATE TABLE `allergy` (
  `alle_code` smallint(6) NOT NULL,
  `alle_description` varchar(255) NOT NULL,
  `alle_symptoms` varchar(255) NOT NULL,
  `alle_dth` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `allergy`
--

INSERT INTO `allergy` (`alle_code`, `alle_description`, `alle_symptoms`, `alle_dth`) VALUES
(1, 'Pet Allergy', 'Hay fever', 'Y'),
(2, 'Drug Allergy', 'Fever or sore throat', 'Y'),
(3, 'Virus Allergy', 'Fever, sore throat or shortness of breath', 'Y'),
(4, 'Peanut Allergy', 'Hives, Itching, Tingling ', 'Y'),
(5, 'Milk Allergy', 'Wheezing, vomiting, hives, digestive problems', 'Y'),
(6, 'Latex allergy', 'Hives, itching, stuffy , runny nose.', 'N'),
(17, 'Egg Allergy', 'Skin inflammation, vomiting', 'N'),
(18, 'Soy Allergy', 'Wheezing, hives, itching', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `child`
--

CREATE TABLE `child` (
  `child_id` smallint(6) NOT NULL,
  `child_fname` varchar(30) NOT NULL,
  `child_lname` varchar(30) NOT NULL,
  `child_dob` date NOT NULL,
  `child_gender` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `child`
--

INSERT INTO `child` (`child_id`, `child_fname`, `child_lname`, `child_dob`, `child_gender`) VALUES
(23, 'Sally', 'Biden', '2020-01-01', 'F'),
(24, 'John', 'Gate', '2020-11-11', 'M'),
(25, 'Mickey', 'Parkers', '2021-02-03', 'O'),
(26, 'William', 'Prince', '2021-01-01', 'M'),
(27, 'Oliver', 'Brown', '2020-01-03', 'M'),
(28, 'Jessica', 'Biden', '2021-01-07', 'F'),
(32, 'Elon', 'March', '2019-11-12', 'M'),
(33, 'Tony', 'Spark', '2019-05-05', 'M'),
(37, 'Ali', 'Baba', '2020-02-02', 'M');

-- --------------------------------------------------------

--
-- Table structure for table `child_allergy`
--

CREATE TABLE `child_allergy` (
  `child_id` smallint(6) NOT NULL,
  `alle_code` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `child_allergy`
--

INSERT INTO `child_allergy` (`child_id`, `alle_code`) VALUES
(23, 1),
(23, 2),
(23, 3);

-- --------------------------------------------------------

--
-- Table structure for table `child_guardian`
--

CREATE TABLE `child_guardian` (
  `child_id` smallint(6) NOT NULL,
  `guardian_id` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `child_medicine`
--

CREATE TABLE `child_medicine` (
  `child_id` smallint(6) NOT NULL,
  `med_id` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contact_received`
--

CREATE TABLE `contact_received` (
  `cr_id` smallint(6) NOT NULL,
  `cr_fname` varchar(30) NOT NULL,
  `cr_lname` varchar(30) NOT NULL,
  `cr_email` varchar(100) NOT NULL,
  `cr_comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `days`
--

CREATE TABLE `days` (
  `days_id` smallint(6) NOT NULL,
  `monday` smallint(6) DEFAULT NULL,
  `tuesday` smallint(6) DEFAULT NULL,
  `wednesday` smallint(6) DEFAULT NULL,
  `thursday` smallint(6) DEFAULT NULL,
  `friday` smallint(6) DEFAULT NULL,
  `saturday` smallint(6) DEFAULT NULL,
  `staff_id` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `days`
--

INSERT INTO `days` (`days_id`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `staff_id`) VALUES
(1, 1, 1, 1, 1, 1, 0, 26),
(5, 1, 1, 1, 1, 1, 0, 26),
(6, 0, 1, 1, 1, 1, 0, 32),
(7, 1, 0, 1, 0, 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `doc_id` smallint(6) NOT NULL,
  `doc_fname` varchar(30) NOT NULL,
  `doc_lname` varchar(30) NOT NULL,
  `doc_street` varchar(255) NOT NULL,
  `doc_suburb` varchar(100) NOT NULL,
  `doc_state` char(3) NOT NULL,
  `doc_postCode` char(4) NOT NULL,
  `doc_phone` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`doc_id`, `doc_fname`, `doc_lname`, `doc_street`, `doc_suburb`, `doc_state`, `doc_postCode`, `doc_phone`) VALUES
(1, 'Shang', 'Chong', '123 Church St', 'Granville', 'NSW', '2200', '0412-123-123'),
(2, 'Ala', 'Din', '234 Food St', 'Auburn', 'NSW', '2201', '0423-234-234'),
(3, 'Esther', 'Simida', '123 Castle St', 'Parramata', 'NSW', '2010', '0412-023-023'),
(5, 'Tyler ', 'Cheap', '66, Market St', 'Auburn', 'NSW', '1234', '0412-023-023');

-- --------------------------------------------------------

--
-- Table structure for table `enrolment`
--

CREATE TABLE `enrolment` (
  `enrolment_id` smallint(6) NOT NULL,
  `enrolment_startDate` date NOT NULL,
  `enrolment_endDate` date NOT NULL,
  `enrolment_numDays` smallint(6) NOT NULL,
  `enrolment_numHours` smallint(6) NOT NULL,
  `child_id` smallint(6) NOT NULL,
  `enrolment_status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `enrolment`
--

INSERT INTO `enrolment` (`enrolment_id`, `enrolment_startDate`, `enrolment_endDate`, `enrolment_numDays`, `enrolment_numHours`, `child_id`, `enrolment_status`) VALUES
(37, '2020-06-06', '2020-06-13', 4, 4, 23, 'Y'),
(38, '2021-06-01', '2021-06-07', 7, 1, 23, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `family`
--

CREATE TABLE `family` (
  `family_id` smallint(6) NOT NULL,
  `family_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `family`
--

INSERT INTO `family` (`family_id`, `family_name`) VALUES
(1, 'Biden'),
(2, 'Gate'),
(3, 'Parkers'),
(4, 'Potter'),
(5, 'Hilton'),
(8, 'Brown'),
(9, 'Badot'),
(10, 'Spark'),
(11, 'March'),
(12, 'Simida'),
(13, 'Walton'),
(15, 'Einstein'),
(16, 'Koch'),
(20, 'Johnson'),
(22, 'Mars');

-- --------------------------------------------------------

--
-- Table structure for table `family_doctor`
--

CREATE TABLE `family_doctor` (
  `family_id` smallint(6) NOT NULL,
  `doc_id` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `guardian`
--

CREATE TABLE `guardian` (
  `guardian_id` smallint(6) NOT NULL,
  `guardian_fname` varchar(30) NOT NULL,
  `guardian_lname` varchar(30) NOT NULL,
  `guardian_address` varchar(255) NOT NULL,
  `guardian_phone` char(10) NOT NULL,
  `family_id` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guardian`
--

INSERT INTO `guardian` (`guardian_id`, `guardian_fname`, `guardian_lname`, `guardian_address`, `guardian_phone`, `family_id`) VALUES
(2, 'Ngee', 'Biden', '1 Garden St, Miller NSW 2201', '0432-555-5', 1),
(3, 'Henry', 'Parkers', '1 Garden St,Auburn NSW 2202', '0432-555-5', 3),
(4, 'Harry ', 'Potter', '11 Garden St,Parramata NSW 2211', '0432-555-5', 4),
(19, 'Camila', 'Brown', '22 Funny St, Granville NSW 2221', '0423321321', 1);

-- --------------------------------------------------------

--
-- Table structure for table `medicine`
--

CREATE TABLE `medicine` (
  `med_id` smallint(6) NOT NULL,
  `med_name` varchar(255) NOT NULL,
  `med_dosage` varchar(30) NOT NULL,
  `med_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `medicine`
--

INSERT INTO `medicine` (`med_id`, `med_name`, `med_dosage`, `med_description`) VALUES
(2, 'Ventolin HFA', '1 tablet', 'To treat wheezing and shortness of breath caused by breathing problems such as asthma'),
(3, 'Hydrocortisone ', '1 tablet', 'To treat adrenocortical deficiency, and swelling and inflammation'),
(6, 'Amoxicillin ', '1 tablet', 'Antibiotic to treat strep throat , infections'),
(7, 'Panadol ', '1 tablet', 'To treat fever, painful and febrile conditions');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` smallint(6) NOT NULL,
  `payment_from` date NOT NULL,
  `payment_to` date NOT NULL,
  `payment_amountPaid` decimal(6,2) NOT NULL,
  `payment_outstandingAmount` decimal(6,2) NOT NULL,
  `enrolment_id` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `payment_from`, `payment_to`, `payment_amountPaid`, `payment_outstandingAmount`, `enrolment_id`) VALUES
(6, '2020-06-06', '2020-06-13', '640.00', '0.00', 37),
(7, '2021-06-01', '2021-06-07', '280.00', '0.00', 38);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` smallint(6) NOT NULL,
  `staff_fname` varchar(30) NOT NULL,
  `staff_lname` varchar(30) NOT NULL,
  `staff_gender` char(1) NOT NULL,
  `staff_homePhone` varchar(30) NOT NULL,
  `staff_workPhone` varchar(30) NOT NULL,
  `staff_mobile` varchar(30) NOT NULL,
  `registration_key` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `staff_fname`, `staff_lname`, `staff_gender`, `staff_homePhone`, `staff_workPhone`, `staff_mobile`, `registration_key`) VALUES
(1, 'One', 'Staff', 'O', '0412-000-000', '0412-000-000', '0412-000-000', 's001'),
(2, 'Two', 'Staff', 'F', '0499234234', '0499234234', '0499234234', 'abcdefg'),
(3, 'Three', 'Staff', 'F', '0499234234', '0499234234', '0499234234', 's003'),
(4, 'Four', 'Staff', 'M', '0499234234', '0499234234', '0499234234', 's004'),
(26, 'New', 'Staff', 'M', '0412-000-000', '0412-000-000', '0412-000-000', '0412-000-000'),
(31, 'Five', 'Staff', 'F', '0412-000-000', '0412-000-000', '0412-000-000', 's010'),
(32, 'Sixth', 'Staff', 'F', '0455543543', '0455543543', '0455543543', 's011');

-- --------------------------------------------------------

--
-- Table structure for table `staff_child`
--

CREATE TABLE `staff_child` (
  `staff_id` smallint(6) NOT NULL,
  `child_id` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `registration_key` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `registration_key`) VALUES
(8, 'shang', '$2y$10$rMR7LgpODmD9Gy4/AOTiTe5zLeqLz2Lf4IysaTsuz2vRTMO3/kSpi', '2021-06-01 01:52:34', '0455543543');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allergy`
--
ALTER TABLE `allergy`
  ADD PRIMARY KEY (`alle_code`);

--
-- Indexes for table `child`
--
ALTER TABLE `child`
  ADD PRIMARY KEY (`child_id`);

--
-- Indexes for table `child_allergy`
--
ALTER TABLE `child_allergy`
  ADD PRIMARY KEY (`child_id`,`alle_code`),
  ADD KEY `alle_code` (`alle_code`);

--
-- Indexes for table `child_guardian`
--
ALTER TABLE `child_guardian`
  ADD PRIMARY KEY (`child_id`,`guardian_id`),
  ADD KEY `guardian_child_guardian_fk` (`guardian_id`);

--
-- Indexes for table `child_medicine`
--
ALTER TABLE `child_medicine`
  ADD PRIMARY KEY (`child_id`,`med_id`),
  ADD KEY `medicine_child_medicine_fk` (`med_id`);

--
-- Indexes for table `contact_received`
--
ALTER TABLE `contact_received`
  ADD PRIMARY KEY (`cr_id`);

--
-- Indexes for table `days`
--
ALTER TABLE `days`
  ADD PRIMARY KEY (`days_id`),
  ADD KEY `days_staff_fk` (`staff_id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`doc_id`);

--
-- Indexes for table `enrolment`
--
ALTER TABLE `enrolment`
  ADD PRIMARY KEY (`enrolment_id`),
  ADD KEY `enroment_child_fk` (`child_id`);

--
-- Indexes for table `family`
--
ALTER TABLE `family`
  ADD PRIMARY KEY (`family_id`);

--
-- Indexes for table `family_doctor`
--
ALTER TABLE `family_doctor`
  ADD PRIMARY KEY (`family_id`,`doc_id`),
  ADD KEY `doctor_family_doctor_fk` (`doc_id`);

--
-- Indexes for table `guardian`
--
ALTER TABLE `guardian`
  ADD PRIMARY KEY (`guardian_id`),
  ADD KEY `family_guardian_family__fk` (`family_id`);

--
-- Indexes for table `medicine`
--
ALTER TABLE `medicine`
  ADD PRIMARY KEY (`med_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `payment_enrolment_fk` (`enrolment_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `staff_child`
--
ALTER TABLE `staff_child`
  ADD PRIMARY KEY (`staff_id`,`child_id`),
  ADD KEY `staff_child_child_fk` (`child_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allergy`
--
ALTER TABLE `allergy`
  MODIFY `alle_code` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `child`
--
ALTER TABLE `child`
  MODIFY `child_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `contact_received`
--
ALTER TABLE `contact_received`
  MODIFY `cr_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `days`
--
ALTER TABLE `days`
  MODIFY `days_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `doc_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `enrolment`
--
ALTER TABLE `enrolment`
  MODIFY `enrolment_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `family`
--
ALTER TABLE `family`
  MODIFY `family_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `guardian`
--
ALTER TABLE `guardian`
  MODIFY `guardian_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `medicine`
--
ALTER TABLE `medicine`
  MODIFY `med_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `child_allergy`
--
ALTER TABLE `child_allergy`
  ADD CONSTRAINT `child_allergy_allergy_fk` FOREIGN KEY (`alle_code`) REFERENCES `allergy` (`alle_code`),
  ADD CONSTRAINT `child_allergy_child_fk` FOREIGN KEY (`child_id`) REFERENCES `child` (`child_id`);

--
-- Constraints for table `child_guardian`
--
ALTER TABLE `child_guardian`
  ADD CONSTRAINT `child_child_guardian_fk` FOREIGN KEY (`child_id`) REFERENCES `child` (`child_id`),
  ADD CONSTRAINT `guardian_child_guardian_fk` FOREIGN KEY (`guardian_id`) REFERENCES `guardian` (`guardian_id`);

--
-- Constraints for table `child_medicine`
--
ALTER TABLE `child_medicine`
  ADD CONSTRAINT `child_child_medicine_fk` FOREIGN KEY (`child_id`) REFERENCES `child` (`child_id`),
  ADD CONSTRAINT `medicine_child_medicine_fk` FOREIGN KEY (`med_id`) REFERENCES `medicine` (`med_id`);

--
-- Constraints for table `days`
--
ALTER TABLE `days`
  ADD CONSTRAINT `days_staff_fk` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`);

--
-- Constraints for table `enrolment`
--
ALTER TABLE `enrolment`
  ADD CONSTRAINT `enroment_child_fk` FOREIGN KEY (`child_id`) REFERENCES `child` (`child_id`);

--
-- Constraints for table `family_doctor`
--
ALTER TABLE `family_doctor`
  ADD CONSTRAINT `doctor_family_doctor_fk` FOREIGN KEY (`doc_id`) REFERENCES `doctor` (`doc_id`),
  ADD CONSTRAINT `family_family_doctor_fk` FOREIGN KEY (`family_id`) REFERENCES `family` (`family_id`);

--
-- Constraints for table `guardian`
--
ALTER TABLE `guardian`
  ADD CONSTRAINT `family_guardian_family__fk` FOREIGN KEY (`family_id`) REFERENCES `family` (`family_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_enrolment_fk` FOREIGN KEY (`enrolment_id`) REFERENCES `enrolment` (`enrolment_id`);

--
-- Constraints for table `staff_child`
--
ALTER TABLE `staff_child`
  ADD CONSTRAINT `staff_child_child_fk` FOREIGN KEY (`child_id`) REFERENCES `child` (`child_id`),
  ADD CONSTRAINT `staff_child_staff_fk` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
