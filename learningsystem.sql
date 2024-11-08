-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 08, 2024 lúc 11:56 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `learningsystem`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `assignments`
--

CREATE TABLE `assignments` (
  `assignment_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `due_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `file_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `assignments`
--

INSERT INTO `assignments` (`assignment_id`, `course_id`, `title`, `description`, `due_date`, `created_at`, `file_path`) VALUES
(1, 1, 'Bài tập', 'Đây là bài tập 1. Hãy hoàn thành', '2024-02-12', '2024-10-28 08:39:37', 'uploads/CT223-Baitapthuchanh-Buoi4.pdf'),
(3, 1, 'Bài tập 2', 'Hãy hoàn thành', '2024-11-20', '2024-11-02 07:56:53', 'uploads/3-4 Frontend (2).pdf');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `lecturer_id` int(11) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `description`, `lecturer_id`, `start_date`, `end_date`, `image_path`, `created_at`) VALUES
(1, 'Cấu trúc dữ liệu', 'C', 3, '2024-10-13', '2024-11-10', 'cau_truc_du_lieu.png', '2024-11-07 10:04:38'),
(2, 'Python cho người mới bắt đầu', 'Python', 3, '2024-10-24', '2024-11-10', 'python_for_beginner.png', '2024-11-07 10:04:38'),
(3, 'Lập trình căn bản C++', 'C++', 3, '2024-09-30', '2024-11-29', 'lap_trinh_can_ban_c++.png', '2024-11-07 10:04:38'),
(4, 'Lập trình hướng đối tượng', 'Java', 3, '2024-10-05', '2024-10-31', 'java_script_co_ban.png', '2024-11-07 10:04:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `enrollments`
--

CREATE TABLE `enrollments` (
  `enrollment_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `enrollment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `progress` decimal(5,2) DEFAULT 0.00,
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `enrollments`
--

INSERT INTO `enrollments` (`enrollment_id`, `course_id`, `student_id`, `enrollment_date`, `progress`, `status`) VALUES
(4, 1, 14, '2024-11-01 07:38:47', 0.00, 'approved'),
(5, 2, 14, '2024-11-02 09:36:14', 0.00, 'approved'),
(6, 1, 15, '2024-11-02 12:09:44', 0.00, 'approved'),
(7, 3, 14, '2024-11-08 08:25:05', 0.00, 'approved'),
(8, 4, 14, '2024-11-08 08:38:21', 0.00, 'rejected');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lectures`
--

CREATE TABLE `lectures` (
  `lecture_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `lectures`
--

INSERT INTO `lectures` (`lecture_id`, `course_id`, `title`, `content`, `file_path`, `created_at`) VALUES
(1, 1, 'Danh sách', 'Nội dung về danh sách', 'lecture1.pdf', '2024-10-11 05:51:36'),
(2, 4, 'Bài giảng 1', '123', 'lecture1.pdf', '2024-10-11 08:31:27');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `registrations`
--

CREATE TABLE `registrations` (
  `registration_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `role` enum('lecturer','student') NOT NULL,
  `status` enum('approved','pending') DEFAULT 'pending',
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `registrations`
--

INSERT INTO `registrations` (`registration_id`, `full_name`, `email`, `phone_number`, `address`, `date_of_birth`, `role`, `status`, `submitted_at`) VALUES
(1, 'Nguyễn Lê Huy', 'me@example.com', '0911111112', 'Vĩnh Long', '2024-10-02', 'student', 'approved', '2024-11-07 09:57:44'),
(2, 'Nguyễn Quỳnh Anh', 'clone@gmail.com', '0912121212', 'Hậu Giang', '2014-01-16', 'student', 'approved', '2024-11-07 09:57:44'),
(3, 'Nguyễn Minh Hân ', 'minhhan@gmail.com', '0945897645', 'Xã Vĩnh Tường, huyện Vị Thủy, Hậu Giang', '2003-01-01', 'student', 'approved', '2024-11-08 04:15:18'),
(5, 'Quách Vĩnh Phát', 'phat@example.com', '0945897642', 'Xã Vĩnh Tường 2, huyện Vị Thủy, Hậu Giang', '2003-02-02', 'student', 'pending', '2024-11-08 04:32:59');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `submissions`
--

CREATE TABLE `submissions` (
  `submission_id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `grade` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `submissions`
--

INSERT INTO `submissions` (`submission_id`, `assignment_id`, `student_id`, `file_path`, `submitted_at`, `grade`) VALUES
(2, 1, 2, '/uploads/3-4 Frontend.pdf', '2024-10-28 10:54:28', NULL),
(3, 1, 15, '/uploads/MIPS Reference Data.pdf', '2024-11-02 12:11:08', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('admin','lecturer','student') NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `registration_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `full_name`, `email`, `role`, `phone_number`, `address`, `date_of_birth`, `registration_id`, `created_at`) VALUES
(2, 'admin', '$2y$10$QeAAKAWfJ5hGLDCpViTgO.biw0Y6FdrjLB3asuUX/LL3MMQN5aTne', 'Nguyễn Lê Huy', 'me@example.com', 'admin', '091111123', 'Hậu Giang', '2003-01-16', NULL, '2024-11-07 10:04:38'),
(3, 'lecturer1', '$2y$10$FQ/6dT0yVPVkSWBT10/a5uDvvuw00c/b07Cp20RKuH/puriGA.6aW', 'Nguyễn Huy', 'nlhfz001@gmail.com', 'lecturer', '0912456456', 'Hậu Giang', '2002-02-16', NULL, '2024-11-07 10:04:38'),
(14, 'student1', '$2y$10$8sP05A83DhTUCq2bnpreYe0G2fgrR1vmM3Bw9B46lNolyse7Q3dRO', 'Nguyễn Lê Huy', 'me@example.com', 'student', '0911111112', 'Vĩnh Long', '2024-10-02', NULL, '2024-11-07 10:04:38'),
(15, 'student2', '$2y$10$25UE/4HWQXYg7U7A55Git.mrIFCyvfxkhD0b9ErZG8gUffvqnzdie', 'Nguyễn Quỳnh Anh', 'clone@gmail.com', 'student', '0912121212', 'Hậu Giang', '2014-01-16', 2, '2024-11-07 10:04:38'),
(19, 'student3', '$2y$10$qubxNxUFUhOy63GjJJgWpe82DNZ/vsbRdfRbE1zAtO8oP37yJYTmq', 'Nguyễn Minh Hân ', 'minhhan@gmail.com', 'student', '0945897645', 'Xã Vĩnh Tường, huyện Vị Thủy, Hậu Giang', '2003-01-01', 3, '2024-11-08 04:26:52');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Chỉ mục cho bảng `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `lecturer_id` (`lecturer_id`);

--
-- Chỉ mục cho bảng `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`enrollment_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Chỉ mục cho bảng `lectures`
--
ALTER TABLE `lectures`
  ADD PRIMARY KEY (`lecture_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Chỉ mục cho bảng `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`registration_id`);

--
-- Chỉ mục cho bảng `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`submission_id`),
  ADD KEY `assignment_id` (`assignment_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk_registration_id` (`registration_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `assignments`
--
ALTER TABLE `assignments`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `lectures`
--
ALTER TABLE `lectures`
  MODIFY `lecture_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `registrations`
--
ALTER TABLE `registrations`
  MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `submissions`
--
ALTER TABLE `submissions`
  MODIFY `submission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`lecturer_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `lectures`
--
ALTER TABLE `lectures`
  ADD CONSTRAINT `lectures_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `submissions`
--
ALTER TABLE `submissions`
  ADD CONSTRAINT `submissions_ibfk_1` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`assignment_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `submissions_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_registration_id` FOREIGN KEY (`registration_id`) REFERENCES `registrations` (`registration_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
