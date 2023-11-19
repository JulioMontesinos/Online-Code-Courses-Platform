-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2023 at 08:06 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `courses`
--

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `Id_Content` int(11) NOT NULL,
  `Text` varchar(5000) NOT NULL,
  `URL` varchar(500) NOT NULL,
  `Id_Edition` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`Id_Content`, `Text`, `URL`, `Id_Edition`) VALUES
(20, 'Linear regression in python', 'https://realpython.com/linear-regression-in-python/', 36);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `Id_Course` int(11) NOT NULL,
  `Name_Course` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`Id_Course`, `Name_Course`) VALUES
(36, 'Basic Mathematics'),
(37, 'Machine Learning Algorithms');

-- --------------------------------------------------------

--
-- Table structure for table `edition`
--

CREATE TABLE `edition` (
  `Id_Edition` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Id_Course` int(11) NOT NULL,
  `Name_Edition` varchar(50) NOT NULL,
  `Status_Edition` varchar(50) NOT NULL,
  `Description` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `edition`
--

INSERT INTO `edition` (`Id_Edition`, `Date`, `Id_Course`, `Name_Edition`, `Status_Edition`, `Description`) VALUES
(34, '2023-11-18', 36, 'Foundations of Applied Mathematics', 'Activated', 'Explore the magic of foundational mathematics, focusing on practical applications for high school and college students.'),
(35, '2023-11-01', 37, 'Maths Adventures', 'Activated', 'Program drones and robots while delving into applied mathematics in an exciting course.'),
(36, '2023-11-19', 37, 'Simple Linear Regression', 'Activated', 'Dive into practical exercises exploring regression analysis, gaining hands-on experience to analyze relationships and make predictions from your data.');

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE `enrollment` (
  `Id_Student` int(11) NOT NULL,
  `Id_Edition` int(11) NOT NULL,
  `Enrollment_Status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `enrollment`
--

INSERT INTO `enrollment` (`Id_Student`, `Id_Edition`, `Enrollment_Status`) VALUES
(1, 34, 'Accepted'),
(28, 34, 'Pending'),
(28, 35, 'Accepted'),
(28, 36, 'Pending'),
(30, 36, 'Accepted'),
(32, 34, 'Accepted'),
(32, 36, 'Accepted'),
(33, 34, 'Accepted'),
(33, 36, 'Accepted');

-- --------------------------------------------------------

--
-- Table structure for table `impart`
--

CREATE TABLE `impart` (
  `Id_Teacher` int(11) NOT NULL,
  `Id_Edition` int(11) NOT NULL,
  `Responsible` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `impart`
--

INSERT INTO `impart` (`Id_Teacher`, `Id_Edition`, `Responsible`) VALUES
(1, 35, 1),
(1, 36, 1),
(29, 34, 1),
(29, 35, 0),
(29, 36, 0),
(33, 34, 0);

-- --------------------------------------------------------

--
-- Table structure for table `submission`
--

CREATE TABLE `submission` (
  `Id_Submission` int(11) NOT NULL,
  `Score` varchar(20) DEFAULT NULL,
  `Submission_Date` date NOT NULL,
  `Type` varchar(50) NOT NULL DEFAULT 'Codigo Python',
  `Submission` text NOT NULL,
  `Observations` text NOT NULL,
  `Id_Task` int(11) NOT NULL,
  `Id_Student` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `submission`
--

INSERT INTO `submission` (`Id_Submission`, `Score`, `Submission_Date`, `Type`, `Submission`, `Observations`, `Id_Task`, `Id_Student`) VALUES
(40, '', '2023-11-19', 'Codigo Python', '# Initial data\ninitial_velocity = 20  # initial velocity in m/s\ngravity = 9.8  # acceleration due to gravity in m/s^2\n\n# Calculate the time to reach maximum height (v = u + at, where v = 0 at maximum height)\ntime_to_max_height = initial_velocity / gravity\n\n# Calculate the maximum height reached (h = ut + 0.5 * at^2)\nmax_height = (initial_velocity * time_to_max_height) - (0.5 * gravity * time_to_max_height**2)\n\n# Calculate the total time in the air (2 * time to max height)\ntotal_time_in_air = 2 * time_to_max_height\n\n# Display results\nprint(\"Maximum height reached:\", max_height, \"meters\")\nprint(\"Total time in the air:\", total_time_in_air, \"seconds\")', '', 20, 28),
(41, '10', '2023-11-19', 'Codigo Python', 'import numpy as np\n\n# Input data\nX = np.array([1, 2, 3, 4, 5])\nY = np.array([2, 4, 5, 4, 5])\n\n# Implementation of simple linear regression\ncoefficients = np.polyfit(X, Y, 1)\nlinear_model = np.poly1d(coefficients)\n\n# Prediction for X = 6\nprediction = linear_model(6)\n\n# Display the prediction\nprint(\"Predicted value for X = 6:\", prediction)', 'The exercise is Perfect!', 23, 30),
(42, '9', '2023-11-19', 'Codigo Python', '# Initial data\nprincipal = 1000  # initial investment in dollars\nannual_interest_rate = 0.05  # 5% annual interest rate\nyears = 3  # number of years\n\n# Calculate the total amount with compound interest\ntotal_amount = principal * (1 + annual_interest_rate) ** years\n\n# Display the step-by-step calculation\nfor year in range(1, years + 1):\n    interest_earned = principal * annual_interest_rate\n    principal = principal + interest_earned\n    print(f\"Year {year}: Total amount = ${round(principal, 2)}\")\n\n# Display the total amount after 3 years\nprint(\"\\nTotal amount after 3 years:\", round(total_amount, 2))', 'It\'s almost perfect', 21, 33);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `Id_Task` int(11) NOT NULL,
  `Task_Name` varchar(50) NOT NULL,
  `Statement` varchar(5000) NOT NULL,
  `Creation_Date` date NOT NULL,
  `Expiration_Date` date NOT NULL,
  `Id_Edition` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`Id_Task`, `Task_Name`, `Statement`, `Creation_Date`, `Expiration_Date`, `Id_Edition`) VALUES
(20, 'Trajectory Problem', 'Calculate the trajectory of an object launched from the ground with an initial velocity of 20 m/s under the influence of gravity. Determine the maximum height reached and the total time in the air.', '2023-11-13', '2026-02-03', 35),
(21, 'Financial Problem', 'Given an annual interest rate of 5%, calculate the total amount after 3 years of investing $1000. Consider compound interest and show the step-by-step calculation.', '2023-10-02', '2023-12-07', 34),
(22, 'Robot Navigation Challenge', 'Program a robot to navigate a grid, starting from point (0,0) and following movement instructions. Calculate the final position of the robot after a series of movements: move 2 steps forward, turn right, move 3 steps, and turn left.', '2023-04-12', '2024-05-30', 35),
(23, 'Simple Linear Regression', 'Given the following input (X) and output (Y) data: \n\nX = [1, 2, 3, 4, 5]\nY = [2, 4, 5, 4, 5]\n\nImplement a simple linear regression using the NumPy library to predict the value of Y for X = 6.', '2023-11-13', '2023-11-30', 36);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Surname` varchar(50) NOT NULL,
  `Rol` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `Name`, `Surname`, `Rol`, `Password`, `Email`) VALUES
(1, 'Julio', 'Montesinos', 'Administrator', '*00A51F3F48415C7D4E8908980D443C29C69B60C9', 'admin@courses.com'),
(28, 'Maria', 'Rodriguez', 'Student', '*00A51F3F48415C7D4E8908980D443C29C69B60C9', 'maria@gmail.com'),
(29, 'Alexander', 'Smith', 'Teacher', '*00A51F3F48415C7D4E8908980D443C29C69B60C9', 'alexander@gmail.com'),
(30, 'Lucas', 'Fernandez', 'Student', '*00A51F3F48415C7D4E8908980D443C29C69B60C9', 'lucas@gmail.com'),
(31, 'Javier', 'Morales', 'Student', '*00A51F3F48415C7D4E8908980D443C29C69B60C9', 'javier@gmail.com'),
(32, 'Emma', 'Johnson', 'Student', '*00A51F3F48415C7D4E8908980D443C29C69B60C9', 'emma@gmail.com'),
(33, 'Lucia', 'Jimenez', 'Teacher', '*00A51F3F48415C7D4E8908980D443C29C69B60C9', 'lucia@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`Id_Content`),
  ADD KEY `Id_Edicion` (`Id_Edition`) USING BTREE;

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`Id_Course`),
  ADD UNIQUE KEY `Nombre_Curso` (`Name_Course`);

--
-- Indexes for table `edition`
--
ALTER TABLE `edition`
  ADD PRIMARY KEY (`Id_Edition`),
  ADD KEY `Id_Curso` (`Id_Course`) USING BTREE;

--
-- Indexes for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD PRIMARY KEY (`Id_Student`,`Id_Edition`),
  ADD KEY `matricula_ibfk_2` (`Id_Edition`);

--
-- Indexes for table `impart`
--
ALTER TABLE `impart`
  ADD PRIMARY KEY (`Id_Teacher`,`Id_Edition`),
  ADD KEY `imparte_ibfk_2` (`Id_Edition`);

--
-- Indexes for table `submission`
--
ALTER TABLE `submission`
  ADD PRIMARY KEY (`Id_Submission`),
  ADD KEY `Id_Tarea` (`Id_Task`) USING BTREE,
  ADD KEY `Id_Alumno` (`Id_Student`) USING BTREE;

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`Id_Task`,`Id_Edition`),
  ADD KEY `Id_Edicion` (`Id_Edition`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `Id_Content` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `Id_Course` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `edition`
--
ALTER TABLE `edition`
  MODIFY `Id_Edition` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `submission`
--
ALTER TABLE `submission`
  MODIFY `Id_Submission` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `Id_Task` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `content`
--
ALTER TABLE `content`
  ADD CONSTRAINT `content_ibfk_1` FOREIGN KEY (`Id_Edition`) REFERENCES `edition` (`Id_Edition`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `edition`
--
ALTER TABLE `edition`
  ADD CONSTRAINT `edition_ibfk_1` FOREIGN KEY (`Id_Course`) REFERENCES `course` (`Id_Course`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD CONSTRAINT `enrollment_ibfk_1` FOREIGN KEY (`Id_Student`) REFERENCES `user` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `enrollment_ibfk_2` FOREIGN KEY (`Id_Edition`) REFERENCES `edition` (`Id_Edition`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `impart`
--
ALTER TABLE `impart`
  ADD CONSTRAINT `impart_ibfk_1` FOREIGN KEY (`Id_Teacher`) REFERENCES `user` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `impart_ibfk_2` FOREIGN KEY (`Id_Edition`) REFERENCES `edition` (`Id_Edition`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `submission`
--
ALTER TABLE `submission`
  ADD CONSTRAINT `submission_ibfk_1` FOREIGN KEY (`Id_Task`) REFERENCES `task` (`Id_Task`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `submission_ibfk_2` FOREIGN KEY (`Id_Student`) REFERENCES `user` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`Id_Edition`) REFERENCES `edition` (`Id_Edition`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
