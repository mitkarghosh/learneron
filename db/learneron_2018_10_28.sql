-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2018 at 05:27 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `learneron`
--

-- --------------------------------------------------------

--
-- Table structure for table `learn_admins`
--

CREATE TABLE `learn_admins` (
  `id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL COMMENT 'first name',
  `last_name` varchar(30) NOT NULL COMMENT 'last name',
  `email` varchar(100) NOT NULL COMMENT 'email id',
  `contact_email` varchar(100) NOT NULL,
  `mail_email` varchar(255) NOT NULL COMMENT 'Email from which all the mails will be sent to the users',
  `password` varchar(255) NOT NULL COMMENT 'cakephp hashed password',
  `type` varchar(2) DEFAULT 'A' COMMENT 'SA=>Super Admin, A=>Sub Admin',
  `last_login_date` datetime NOT NULL COMMENT 'last login time',
  `forget_password_string` varchar(255) NOT NULL COMMENT 'forget password string require to verify account owner',
  `signup_string` varchar(255) NOT NULL COMMENT 'signup string to verify account owner',
  `modified` datetime NOT NULL COMMENT 'update time',
  `created` datetime NOT NULL COMMENT 'insert time',
  `status` varchar(2) NOT NULL COMMENT 'A=>Active,I=>Inactive,V=>Verified,NV=>not-verified,D=>deleted'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_admins`
--

INSERT INTO `learn_admins` (`id`, `first_name`, `last_name`, `email`, `contact_email`, `mail_email`, `password`, `type`, `last_login_date`, `forget_password_string`, `signup_string`, `modified`, `created`, `status`) VALUES
(1, 'Sukanta', ' Sarkar ', 'administrator@learneron.net', 'administrator@learneron.net', 'no-reply@learneron.com', '$2y$10$raU/4ebGf1ayQblLyJ.gne6xZ6ul.NHKbrk3UiobGKq312ag2PF8W', 'SA', '2017-07-16 00:00:00', '', '', '2017-12-10 13:14:40', '2017-07-16 00:00:00', 'A'),
(2, 'Mitkar', 'Ghosh ', '100websolution11@gmail.com', '100websolution11@gmail.com', 'no-reply@learneron.com', '$2y$10$raU/4ebGf1ayQblLyJ.gne6xZ6ul.NHKbrk3UiobGKq312ag2PF8W', 'SA', '2017-08-01 00:00:00', '', '', '2017-07-31 20:47:19', '2017-08-01 00:00:00', 'A'),
(3, 'Dweyne', 'Smith', 'smith@gmail.com', 'smith@gmail.com', 'smith@gmail.com', '$2y$10$K/2dGiKxYAwrzqXnb9g4vetG4u40vGkHuJz0a/cTa0PR5sb6HP7Xy', 'A', '2017-10-24 19:36:54', '', '', '2017-10-25 20:19:49', '2017-10-24 19:36:54', 'A'),
(4, 'Dean', 'Jones', 'dean@gmail.com', 'dean@gmail.com', 'dean@gmail.com', '$2y$10$x0KlcFFHcXg1JOKDOmH3ouoQwkLe35trpA/7936CPPuYKlScYsGKS', 'A', '2017-10-25 19:46:23', '', '', '2017-10-25 19:46:23', '2017-10-25 19:46:23', 'A'),
(5, 'Sanja', 'kar', '100websolution@gmail.com', '100websolution@gmail.com', '100websolution@gmail.com', '$2y$10$PfftTL98CtGdLMf640SUB.Hjkm3mfwjA/EvMBMbAMTVrq1J8u70ym', 'A', '2017-10-27 19:36:53', '', '', '2017-10-27 19:36:53', '2017-10-27 19:36:53', 'A'),
(6, 'Sukanta', 'Sarkar', 'sukanta.info2@gmail.com', 'sukanta.info2@gmail.com', 'sukanta.info2@gmail.com', '$2y$10$ehY8Yx0AaDV1tqfAuUs6eevMzKwh/Chu3xnjs.Z9fiJcwzGbpOKj2', 'A', '2017-10-30 19:23:03', '', '', '2017-10-30 19:23:03', '2017-10-30 19:23:03', 'A'),
(7, 'aaa', 'Learner1', 'spinskillsup@gmail.com', 'spinskillsup@gmail.com', 'spinskillsup@gmail.com', '$2y$10$raU/4ebGf1ayQblLyJ.gne6xZ6ul.NHKbrk3UiobGKq312ag2PF8W', 'A', '2017-11-12 14:38:05', '', '', '2018-02-10 05:16:19', '2017-11-12 14:38:05', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `learn_admin_menus`
--

CREATE TABLE `learn_admin_menus` (
  `id` int(11) NOT NULL,
  `main_menu_name` varchar(255) NOT NULL,
  `menu_name` varchar(255) NOT NULL,
  `menu_name_modified` varchar(255) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `controller_name` varchar(255) NOT NULL,
  `method_name` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `is_display` enum('Y','N') NOT NULL,
  `status` enum('A','I') NOT NULL,
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_admin_menus`
--

INSERT INTO `learn_admin_menus` (`id`, `main_menu_name`, `menu_name`, `menu_name_modified`, `parent_id`, `controller_name`, `method_name`, `sort_order`, `is_display`, `status`, `modified`, `created`) VALUES
(1, 'Manage Sub Admin', 'Manage Sub Admin', 'Manage Sub Admin', 0, 'AdminDetails', '', 1, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Manage Admin', 'View', 'View', 1, 'AdminDetails', 'list-sub-admin', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Manage Admin', 'Add', 'Add', 1, 'AdminDetails', 'add-sub-admin', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Manage Admin', 'Edit', 'Edit', 1, 'AdminDetails', 'edit-sub-admin', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Manage Admin', 'Status', 'Status', 1, 'AdminDetails', 'change-status-subadmin', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'Manage Admin', 'Delete', 'Delete', 1, 'AdminDetails', 'delete-sub-admin', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'Manage Admin', 'ChangePassword', 'Change Password', 1, 'AdminDetails', 'sub-admin-change-password', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'User Management', 'User Management', 'User Management', 0, 'Users', '', 2, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'User Management', 'View', 'View', 8, 'Users', 'list-data', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'User Management', 'Add', 'Add', 8, 'Users', 'add-user', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 'User Management', 'Edit', 'Edit', 8, 'Users', 'edit-user', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'User Management', 'Status', 'Status', 8, 'Users', 'change-status', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 'User Management', 'Delete', 'Delete', 8, 'Users', 'delete-user', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 'User Management', 'AccountSetting', 'Account Setting', 8, 'Users', 'user-account-setting', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 'User Management', 'ChangePassword', 'Change Password', 8, 'Users', 'user-change-password', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 'User Management', 'SubmittedDetails', 'Submitted Details', 8, 'Users', 'user-submitted-details', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 'Tags Management', 'Tags Management', 'Tags Management', 0, 'Tags', '', 3, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 'Tags Management', 'View', 'View', 17, 'Tags', 'list-data', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 'Tags Management', 'Add', 'Add', 17, 'Tags', 'add-tag', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 'Tags Management', 'Edit', 'Edit', 17, 'Tags', 'edit-tag', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 'Tags Management', 'Status', 'Status', 17, 'Tags', 'change-status', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 'Tags Management', 'Delete', 'Delete', 17, 'Tags', 'delete-tag', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 'Question Categories', 'Question Categories', 'Question Categories', 0, 'QuestionCategories', '', 4, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 'Question Categories', 'View', 'View', 23, 'QuestionCategories', 'list-data', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 'Question Categories', 'Add', 'Add', 23, 'QuestionCategories', 'add-question-category', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 'Question Categories', 'Edit', 'Edit', 23, 'QuestionCategories', 'edit-question-category', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, 'Question Categories', 'Status', 'Status', 23, 'QuestionCategories', 'change-status', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(28, 'Question Categories', 'Delete', 'Delete', 23, 'QuestionCategories', 'delete-question-category', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, 'Questions', 'Questions', 'Questions', 0, 'Questions', '', 5, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, 'Questions', 'View', 'View', 29, 'Questions', 'list-data', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, 'Questions', 'Add', 'Add', 29, 'Questions', 'add-question', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(32, 'Questions', 'Edit', 'Edit', 29, 'Questions', 'edit-question', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(33, 'Questions', 'Status', 'Status', 29, 'Questions', 'change-status', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(34, 'Questions', 'Delete', 'Delete', 29, 'Questions', 'delete-question', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(35, 'Question Answers', 'Question Answers', 'Question Answers', 0, 'QuestionAnswers', '', 6, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(36, 'Question Answers', 'View', 'View', 35, 'QuestionAnswers', 'list-data', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(37, 'Question Answers', 'Add', 'Add', 35, 'QuestionAnswers', '', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(38, 'Question Answers', 'Edit', 'Edit', 35, 'QuestionAnswers', 'edit-question-answer', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(39, 'Question Answers', 'Status', 'Status', 35, 'QuestionAnswers', 'change-status', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(40, 'Question Answers', 'Delete', 'Delete', 35, 'QuestionAnswers', 'delete-question-answer', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(41, 'Question Answer Comments', 'Question Answer Comments', 'Question Answer Comments', 0, 'AnswerComments', '', 7, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(42, 'Question Answer Comments', 'View', 'View', 41, 'AnswerComments', 'list-data', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(43, 'Question Answer Comments', 'Add', 'Add', 41, 'AnswerComments', '', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(44, 'Question Answer Comments', 'Edit', 'Edit', 41, 'AnswerComments', 'edit-answer-comment', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(45, 'Question Answer Comments', 'Status', 'Status', 41, 'AnswerComments', 'change-status', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(46, 'Question Answer Comments', 'Delete', 'Delete', 41, 'AnswerComments', 'delete-comment', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(47, 'Question Comments', 'Question Comments', 'Question Comments', 0, 'QuestionComments', '', 8, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(48, 'Question Comments', 'View', 'View', 47, 'QuestionComments', 'list-data', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(49, 'Question Comments', 'Add', 'Add', 47, 'QuestionComments', '', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(50, 'Question Comments', 'Edit', 'Edit', 47, 'QuestionComments', 'edit-comment', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(51, 'Question Comments', 'Status', 'Status', 47, 'QuestionComments', 'change-status', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(52, 'Question Comments', 'Delete', 'Delete', 47, 'QuestionComments', 'delete-comment', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(53, 'News Category', 'News Category', 'News Category', 0, 'NewsCategories', '', 9, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(54, 'News Category', 'View', 'View', 53, 'NewsCategories', 'list-data', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(55, 'News Category', 'Add', 'Add', 53, 'NewsCategories', 'add-news-category', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(56, 'News Category', 'Edit', 'Edit', 53, 'NewsCategories', 'edit-news-category', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(57, 'News Category', 'Status', 'Status', 53, 'NewsCategories', 'change-status', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(58, 'News Category', 'Delete', 'Delete', 53, 'NewsCategories', 'delete-news-category', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(59, 'News Management', 'News Management', 'News Management', 0, 'News', '', 10, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(60, 'News Management', 'View', 'View', 59, 'News', 'list-data', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(61, 'News Management', 'Add', 'Add', 59, 'News', 'add-news', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(62, 'News Management', 'Edit', 'Edit', 59, 'News', 'edit-news', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(63, 'News Management', 'Status', 'Status', 59, 'News', 'change-status', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(64, 'News Management', 'Delete', 'Delete', 59, 'News', 'delete-news', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(65, 'News Comments', 'News Comments', 'News Comments', 0, 'NewsComments', '', 11, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(66, 'News Comments', 'View', 'View', 65, 'NewsComments', 'list-data', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(67, 'News Comments', 'Add', 'Add', 65, 'NewsComments', '', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(68, 'News Comments', 'Edit', 'Edit', 65, 'NewsComments', 'edit-comment', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(69, 'News Comments', 'Status', 'Status', 65, 'NewsComments', 'change-status', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(70, 'News Comments', 'Delete', 'Delete', 65, 'NewsComments', 'delete-comment', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(71, 'FAQs', 'FAQs', 'FAQs', 0, 'Faqs', '', 12, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(72, 'FAQs', 'View', 'View', 71, 'Faqs', 'list-data', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(73, 'FAQs', 'Add', 'Add', 71, 'Faqs', 'add-faq', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(74, 'FAQs', 'Edit', 'Edit', 71, 'Faqs', 'edit-faq', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(75, 'FAQs', 'Status', 'Status', 71, 'Faqs', 'change-status', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(76, 'FAQs', 'Delete', 'Delete', 71, 'Faqs', 'delete-faq', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(77, 'Contacts Management', 'Contacts Management', 'Contacts Management', 0, 'Contacts', '', 13, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(78, 'Contacts Management', 'View', 'View', 77, 'Contacts', 'list-data', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(79, 'Contacts Management', 'Reply', 'Reply', 77, 'Contacts', 'reply', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(80, 'Contacts Management', 'Delete', 'Delete', 77, 'Contacts', 'delete-contacts', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(81, 'CMS Management', 'CMS Management', 'CMS Management', 0, 'cms', '', 14, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(82, 'CMS Management', 'View', 'View', 81, 'cms', 'list-data', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(83, 'CMS Management', 'Edit', 'Edit', 81, 'cms', 'edit-cms', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(84, 'Banner Management', 'Banner Management', 'Banner Management', 0, 'BannerSections', '', 15, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(85, 'Banner Management', 'View', 'View', 84, 'BannerSections', 'list-data', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(86, 'Banner Management', 'Add', 'Add', 84, 'BannerSections', 'add-banner-section', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(87, 'Banner Management', 'Edit', 'Edit', 84, 'BannerSections', 'edit-banner-section', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(88, 'Banner Management', 'Status', 'Status', 84, 'BannerSections', 'change-status', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(89, 'Banner Management', 'Delete', 'Delete', 84, 'BannerSections', 'delete-banner', 0, 'Y', 'A', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(90, 'Advertise Management', 'Advertise Management', 'Advertise Management', 0, 'Advertisements', '', 16, 'Y', 'A', '2017-11-16 02:00:00', '2017-11-16 02:00:00'),
(91, 'Advertise Management', 'View', 'View', 90, 'Advertisements', 'list-data', 0, 'Y', 'A', '2017-11-16 03:00:00', '2017-11-16 03:00:00'),
(92, 'Advertise Management', 'Add', 'Add', 90, 'Advertisements', 'add-advertise', 0, 'Y', 'A', '2017-11-16 03:00:00', '2017-11-16 03:00:00'),
(93, 'Advertise Management', 'Edit', 'Edit', 90, 'Advertisements', 'edit-advertise', 0, 'Y', 'A', '2017-08-09 00:00:00', '2017-08-09 00:00:00'),
(94, 'Advertise Management', 'Status', 'Status', 90, 'Advertisements', 'change-status', 0, 'Y', 'A', '2017-08-13 12:27:33', '2017-08-13 03:07:09'),
(95, 'Advertise Management', 'Delete', 'Delete', 90, 'Advertisements', 'delete-advertise', 0, 'Y', 'A', '2017-08-13 12:27:33', '2017-08-13 12:27:33'),
(96, 'Cookie Management', 'Cookie Management', 'Cookie Management', 0, 'CookieConsents', '', 17, 'Y', 'A', '2017-11-16 02:00:00', '2017-11-16 02:00:00'),
(97, 'Cookie Management', 'View', 'View', 96, 'CookieConsents', 'list-data', 0, 'Y', 'A', '2017-11-16 03:00:00', '2017-11-16 03:00:00'),
(98, 'Cookie Management', 'Add', 'Add', 96, 'CookieConsents', 'add-cookie-consent', 0, 'Y', 'A', '2017-11-16 03:00:00', '2017-11-16 03:00:00'),
(99, 'Cookie Management', 'Edit', 'Edit', 96, 'CookieConsents', 'edit-cookie-consent', 0, 'Y', 'A', '2017-08-09 00:00:00', '2017-08-09 00:00:00'),
(100, 'Cookie Management', 'Status', 'Status', 96, 'CookieConsents', 'change-status', 0, 'Y', 'A', '2017-08-13 12:27:33', '2017-08-13 03:07:09'),
(101, 'Cookie Management', 'Delete', 'Delete', 96, 'CookieConsents', 'delete-cookie-consent', 0, 'Y', 'A', '2017-08-13 12:27:33', '2017-08-13 12:27:33');

-- --------------------------------------------------------

--
-- Table structure for table `learn_admin_permisions`
--

CREATE TABLE `learn_admin_permisions` (
  `id` int(11) NOT NULL,
  `admin_user_id` int(11) NOT NULL,
  `admin_menu_id` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_admin_permisions`
--

INSERT INTO `learn_admin_permisions` (`id`, `admin_user_id`, `admin_menu_id`, `modified`, `created`) VALUES
(9, 4, 2, '2017-10-25 19:46:23', '2017-10-25 19:46:23'),
(10, 4, 3, '2017-10-25 19:46:23', '2017-10-25 19:46:23'),
(11, 4, 9, '2017-10-25 19:46:23', '2017-10-25 19:46:23'),
(46, 3, 2, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(47, 3, 3, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(48, 3, 4, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(49, 3, 5, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(50, 3, 9, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(51, 3, 11, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(52, 3, 18, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(53, 3, 20, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(54, 3, 24, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(55, 3, 26, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(56, 3, 30, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(57, 3, 32, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(58, 3, 36, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(59, 3, 38, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(60, 3, 42, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(61, 3, 45, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(62, 3, 48, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(63, 3, 50, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(64, 3, 54, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(65, 3, 55, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(66, 3, 56, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(67, 3, 60, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(68, 3, 62, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(69, 3, 66, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(70, 3, 68, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(71, 3, 72, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(72, 3, 73, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(73, 3, 74, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(74, 3, 78, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(75, 3, 82, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(76, 3, 83, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(77, 3, 85, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(78, 3, 86, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(79, 3, 87, '2017-10-25 20:19:49', '2017-10-25 20:19:49'),
(80, 5, 9, '2017-10-27 19:36:53', '2017-10-27 19:36:53'),
(81, 5, 18, '2017-10-27 19:36:53', '2017-10-27 19:36:53'),
(82, 6, 9, '2017-10-30 19:23:03', '2017-10-30 19:23:03'),
(83, 6, 10, '2017-10-30 19:23:03', '2017-10-30 19:23:03'),
(84, 6, 24, '2017-10-30 19:23:03', '2017-10-30 19:23:03'),
(85, 6, 25, '2017-10-30 19:23:03', '2017-10-30 19:23:03'),
(145, 7, 2, '2018-02-10 05:16:19', '2018-02-10 05:16:19'),
(146, 7, 9, '2018-02-10 05:16:19', '2018-02-10 05:16:19'),
(147, 7, 18, '2018-02-10 05:16:19', '2018-02-10 05:16:19'),
(148, 7, 19, '2018-02-10 05:16:19', '2018-02-10 05:16:19'),
(149, 7, 24, '2018-02-10 05:16:19', '2018-02-10 05:16:19'),
(150, 7, 25, '2018-02-10 05:16:19', '2018-02-10 05:16:19'),
(151, 7, 26, '2018-02-10 05:16:19', '2018-02-10 05:16:19'),
(152, 7, 30, '2018-02-10 05:16:19', '2018-02-10 05:16:19'),
(153, 7, 31, '2018-02-10 05:16:20', '2018-02-10 05:16:20'),
(154, 7, 32, '2018-02-10 05:16:20', '2018-02-10 05:16:20'),
(155, 7, 33, '2018-02-10 05:16:20', '2018-02-10 05:16:20'),
(156, 7, 36, '2018-02-10 05:16:20', '2018-02-10 05:16:20'),
(157, 7, 38, '2018-02-10 05:16:20', '2018-02-10 05:16:20'),
(158, 7, 39, '2018-02-10 05:16:20', '2018-02-10 05:16:20'),
(159, 7, 42, '2018-02-10 05:16:20', '2018-02-10 05:16:20'),
(160, 7, 45, '2018-02-10 05:16:20', '2018-02-10 05:16:20'),
(161, 7, 48, '2018-02-10 05:16:20', '2018-02-10 05:16:20'),
(162, 7, 50, '2018-02-10 05:16:20', '2018-02-10 05:16:20'),
(163, 7, 51, '2018-02-10 05:16:20', '2018-02-10 05:16:20'),
(164, 7, 54, '2018-02-10 05:16:20', '2018-02-10 05:16:20'),
(165, 7, 55, '2018-02-10 05:16:20', '2018-02-10 05:16:20'),
(166, 7, 60, '2018-02-10 05:16:20', '2018-02-10 05:16:20'),
(167, 7, 61, '2018-02-10 05:16:20', '2018-02-10 05:16:20'),
(168, 7, 66, '2018-02-10 05:16:20', '2018-02-10 05:16:20'),
(169, 7, 68, '2018-02-10 05:16:20', '2018-02-10 05:16:20'),
(170, 7, 69, '2018-02-10 05:16:20', '2018-02-10 05:16:20'),
(171, 7, 72, '2018-02-10 05:16:20', '2018-02-10 05:16:20'),
(172, 7, 78, '2018-02-10 05:16:20', '2018-02-10 05:16:20'),
(173, 7, 82, '2018-02-10 05:16:20', '2018-02-10 05:16:20'),
(174, 7, 85, '2018-02-10 05:16:20', '2018-02-10 05:16:20');

-- --------------------------------------------------------

--
-- Table structure for table `learn_advertisements`
--

CREATE TABLE `learn_advertisements` (
  `id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `status` enum('A','I') NOT NULL DEFAULT 'I',
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_advertisements`
--

INSERT INTO `learn_advertisements` (`id`, `link`, `page_name`, `image`, `status`, `modified`, `created`) VALUES
(1, 'http://www.google.com', 'homePage', 'advertise_15110221068.jpg', 'A', '2017-11-18 16:24:06', '2017-11-18 16:21:46'),
(2, 'http://www.google.com', 'postQuestion', 'advertise_15110222836.jpg', 'A', '2017-11-18 16:24:43', '2017-11-18 16:24:43'),
(3, 'http://www.google.com', 'allQuestions', 'advertise_15110268847.jpg', 'A', '2017-11-18 17:41:24', '2017-11-18 17:41:24'),
(4, 'http://www.google.com', 'allUsers', 'advertise_15110269016.jpg', 'A', '2017-11-18 17:41:41', '2017-11-18 17:41:41'),
(5, 'http://www.google.com', 'newsListing', 'advertise_15110269151.jpg', 'A', '2017-11-18 17:41:56', '2017-11-18 17:41:56');

-- --------------------------------------------------------

--
-- Table structure for table `learn_anonymous_users`
--

CREATE TABLE `learn_anonymous_users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'User id from "users" table',
  `usertype` enum('individual','group') DEFAULT NULL COMMENT 'anonymous type',
  `slug` varchar(255) NOT NULL COMMENT 'unique slug',
  `unique_id` int(11) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'update time',
  `created` datetime NOT NULL COMMENT 'insert time'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_anonymous_users`
--

INSERT INTO `learn_anonymous_users` (`id`, `user_id`, `usertype`, `slug`, `unique_id`, `modified`, `created`) VALUES
(2, 0, 'individual', 'anonymous', 0, '2018-04-07 02:00:00', '2018-04-07 02:00:00'),
(11, 68, 'individual', 'anonymous-1', 1, '2018-04-11 20:58:55', '2018-04-06 21:06:14'),
(15, 67, 'individual', 'anonymous-2', 2, '2018-04-07 03:18:42', '2018-04-07 03:18:42'),
(16, 66, 'individual', 'anonymous-3', 3, '2018-04-07 03:19:46', '2018-04-07 03:19:46'),
(18, 65, 'individual', 'anonymous-4', 4, '2018-04-11 21:20:23', '2018-04-11 21:18:45'),
(19, 64, 'group', 'Anonymous Group', 5, '2018-04-11 21:43:13', '2018-04-11 21:42:40'),
(20, 63, 'group', 'Anonymous Group', NULL, '2018-04-11 21:43:26', '2018-04-11 21:43:26'),
(30, 59, 'group', 'Anonymous Group', 5, '2018-04-12 19:01:53', '2018-04-12 19:01:21'),
(31, 77, 'group', 'Anonymous Group', 5, '2018-10-05 18:38:24', '2018-10-05 18:37:30');

-- --------------------------------------------------------

--
-- Table structure for table `learn_answer_comments`
--

CREATE TABLE `learn_answer_comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Logged in user id (who posted this comment)',
  `question_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL,
  `answer_user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '0',
  `user_ip` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_answer_comments`
--

INSERT INTO `learn_answer_comments` (`id`, `user_id`, `question_id`, `answer_id`, `answer_user_id`, `comment`, `status`, `user_ip`, `created`, `modified`) VALUES
(1, 27, 8, 5, 1, 'Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter a ', '0', '47.15.11.173', '2017-08-31 20:23:44', '2017-08-31 20:23:44');

-- --------------------------------------------------------

--
-- Table structure for table `learn_answer_upvotes`
--

CREATE TABLE `learn_answer_upvotes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Logged in user id',
  `question_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL,
  `answer_user_id` int(11) NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '0',
  `user_ip` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_answer_upvotes`
--

INSERT INTO `learn_answer_upvotes` (`id`, `user_id`, `question_id`, `answer_id`, `answer_user_id`, `status`, `user_ip`, `created`, `modified`) VALUES
(1, 27, 8, 5, 1, '1', '47.15.11.173', '2017-08-31 20:23:32', '2017-08-31 20:23:32'),
(5, 27, 7, 6, 1, '1', '47.15.1.254', '2017-09-07 19:12:58', '2017-09-07 19:12:58'),
(10, 27, 6, 2, 21, '1', '202.142.77.93', '2017-09-17 07:21:32', '2017-09-17 07:21:32'),
(11, 27, 8, 7, 35, '1', '47.15.12.47', '2017-10-06 20:08:07', '2017-10-06 20:08:07');

-- --------------------------------------------------------

--
-- Table structure for table `learn_banner_sections`
--

CREATE TABLE `learn_banner_sections` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `sub_title` text NOT NULL,
  `sub_title2` text NOT NULL,
  `sub_title_mobile` text NOT NULL,
  `link` varchar(255) NOT NULL,
  `link_text` varchar(255) NOT NULL,
  `link2` varchar(255) NOT NULL,
  `link2_text` text NOT NULL,
  `image` text NOT NULL,
  `status` enum('A','I') NOT NULL DEFAULT 'I',
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_banner_sections`
--

INSERT INTO `learn_banner_sections` (`id`, `title`, `sub_title`, `sub_title2`, `sub_title_mobile`, `link`, `link_text`, `link2`, `link2_text`, `image`, `status`, `modified`, `created`) VALUES
(1, 'Welcome to learn with us!', 'It may not be easy for a grown person to navigate what learning path can take one further in the right direction towards a better job, better pay, or firmer confidence. What goal shall I set, given what I already - or, rather, still - know? What budget shall I need to accomplish my learning mission? What time will I need to allocate? What learning options are there, with what take-aways?', 'to join the Lifelong Learners\' community to ask your questions, or share your answers!', 'test', 'http://techtimes-in.com/projects/learneron/signup', 'Sign Up', 'http://techtimes-in.com/projects/learneron/login', 'Log In', 'banner_15020913215.jpg', 'A', '2018-10-22 18:09:20', '2017-08-07 07:35:23'),
(2, 'Are you', 'An experienced person, whose industry or job seems soon to get automated?<br />\r\nJust freshly graduated, but you feel somewhat practically unprepared for the job market?<br />\r\nNeeding just a part time job, or become a freelancer, but you are not confident having the right skills and preparation for it?', 'to join the Lifelong Learners\' community to ask your questions, or share your answers!', '', 'http://techtimes-in.com/projects/learneron/signup', 'Sign Up', 'http://techtimes-in.com/projects/learneron/login', 'Log In', 'banner_15020917577.jpg', 'A', '2017-10-15 15:14:31', '2017-08-07 07:42:39'),
(3, 'Do you', 'Feel, that while you\'re successful at what you do, the world is changing so rapidly, and so interestingly, that you... perhaps for the sole sake of curiosity... ought to learn more?', 'to join the Lifelong Learners\' community to ask your questions, or share your answers!', '', 'http://techtimes-in.com/projects/learneron/signup', 'Sign Up', 'http://techtimes-in.com/projects/learneron/login', 'Log In', 'banner_15020917822.jpg', 'A', '2017-10-15 15:15:01', '2017-08-07 07:43:03');

-- --------------------------------------------------------

--
-- Table structure for table `learn_careereducations`
--

CREATE TABLE `learn_careereducations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `history_type` enum('C','E') NOT NULL DEFAULT 'E',
  `edu_degree` varchar(255) DEFAULT NULL,
  `edu_organization` varchar(255) DEFAULT NULL,
  `edu_from` date DEFAULT NULL,
  `edu_to` date DEFAULT NULL,
  `career_position` varchar(255) DEFAULT NULL,
  `career_company` varchar(255) DEFAULT NULL,
  `career_from` date DEFAULT NULL,
  `career_to` date DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_careereducations`
--

INSERT INTO `learn_careereducations` (`id`, `user_id`, `history_type`, `edu_degree`, `edu_organization`, `edu_from`, `edu_to`, `career_position`, `career_company`, `career_from`, `career_to`, `created`, `modified`) VALUES
(6, 3, 'C', NULL, NULL, NULL, NULL, 'jersey', 'New jersey', '1999-01-10', '2004-05-29', '2017-08-15 06:45:47', '2017-08-15 06:45:47'),
(9, 27, 'E', 'MCA', 'WBUT', '2007-08-15', '2010-08-15', NULL, NULL, NULL, NULL, '2017-08-20 12:24:35', '2018-05-06 18:09:00'),
(10, 27, 'E', 'BSC', 'CU', '2004-08-02', '2007-08-04', NULL, NULL, NULL, NULL, '2017-08-20 12:24:35', '2018-05-06 18:09:00'),
(11, 27, 'E', 'HS', 'VMPS', '2002-08-01', '2004-08-15', NULL, NULL, NULL, NULL, '2017-08-20 12:24:35', '2018-05-06 18:09:00'),
(12, 27, 'C', NULL, NULL, NULL, NULL, 'Senior Developer', 'Company 2', '2017-01-01', '2017-02-28', '2017-08-20 12:24:35', '2018-05-06 18:09:00'),
(13, 27, 'C', NULL, NULL, NULL, NULL, 'Developer', 'Company 1', '2016-12-01', '2016-12-31', '2017-08-20 12:24:35', '2018-05-06 18:09:00'),
(17, 41, 'E', 'BTech', 'GCETTS', '2016-10-05', '2017-09-28', NULL, NULL, NULL, NULL, '2017-09-29 03:24:58', '2017-09-29 03:24:58'),
(18, 41, 'C', NULL, NULL, NULL, NULL, 'Web Designer', 'Eclock', '2017-09-01', '2017-09-20', '2017-09-29 03:24:58', '2017-09-29 03:24:58');

-- --------------------------------------------------------

--
-- Table structure for table `learn_cms_pages`
--

CREATE TABLE `learn_cms_pages` (
  `id` int(11) NOT NULL,
  `page_section` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `short_description` text NOT NULL,
  `description` text NOT NULL,
  `status` varchar(1) NOT NULL COMMENT 'A=>active,I=>inactive,D=>deleted',
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_cms_pages`
--

INSERT INTO `learn_cms_pages` (`id`, `page_section`, `title`, `short_description`, `description`, `status`, `modified`, `created`, `meta_keywords`, `meta_description`) VALUES
(1, 'home', 'Home', '', 'test description', 'A', '2017-08-18 16:40:21', '2017-08-06 01:09:18', 'Home', 'Home'),
(2, 'news', 'News & Views', '', 'You will find here our site blog, sharing with you our reviews of and comments on interesting Lifelong Learning topics (Views), as well as news on the LearnerOn.Net site development and functionality (News)', 'A', '2017-08-09 00:00:00', '2017-08-09 00:00:00', 'News & Views', 'News & Views'),
(3, 'about us', 'About Us', '', '<p>We build LearnerOn.Net in order to support the community of adult, lifelong learners in finding the learning path for their needs and means, whatever these are.</p>\r\n<p>We do it because we believe that learning, knowing and understanding more, rather than less, is universally good thing. Not only it leads to an immediate better individual well being through improved skills and job prospects; it also makes the world better as a whole. It fuels progress.</p>\r\n<p>Our starting team is small. Our background is education, math, physics, data science, finance, consulting. We are convinced lifelong learners ourselves: in learning we trust.</p>\r\n<p>As LearnerOn.Net itself is on a learning path, over time we intend to bring more to support the participating users and learners.</p>\r\n<p>Our highest hope is following: we intend to set grown people onto a learning path. All of them. The entire humankind.</p>\r\n<p>&nbsp;</p>\r\n<hr>\r\n<p>LearnerOn.Net is delivered by <a href=\"javascript:void(0);\" onclick=\"show_details();\">Learneron, SE</a><br>© Learneron, SE, 2017</p>\r\n<div id=\"show\" class=\"hidedetails\"><p>Learneron, SE; business ID: 061 59 010; registered seat: Zahrebska 23, 120 00, Prague, Czech Republic; e-mail: <a href=\"mailto:administrator@learneron.net\">administrator@learneron.net</a></p></div>\r\n', 'A', '2017-10-07 21:20:28', '2017-08-09 00:00:00', 'About Us', 'About Us'),
(4, 'terms of use', 'Terms of Use', '', '<p><span style=\"text-decoration:underline\">Introductory Provisions</span><br>\r\nThese Terms and Conditions for using the portal LearnerOn.Net (the “Conditions”) provide for the conditions for using the services of the portal LearnerOn.Net (the “Services”) and set rights and obligations arising during the provision of these Services between you as a user (the “User”) and the company company: Learneron, SE; business ID: 061 59 010; registered seat: Zahrebska 23, 120 00, Prague, Czech Republic as a provider of the Services (the “Provider”). For creating the user account and using the Services, the User has to agree with the Conditions. If the User does not agree to the Conditions, then the User cannot use the Services.<br><br>\r\n<span style=\"text-decoration:underline\">Formation of a Contract and its Subject-matter</span><br>\r\nThe Contract, the subject of which is provision of the Services via a user account, is established by the moment of giving consent to these Conditions and successful creation of a user account.<br><br>\r\nThe agreement is concluded free of charge and the User is not obliged to pay any remuneration, taxes, fees or delivery costs are connected to the Services. Costs connected with using of remote means of communication on the side of the User are, however, borne by the User. The User expressly asks the Provider for commencement of provision of the Services from the moment of establishment of the Agreement and is aware of the fact that in such a case, the User is not entitled to withdraw from the Agreement.<br><br>\r\nThe agreement is concluded for an indefinite period of time. The Services provided by the Provider to the User are provided “as is” and the Provider does not provide the User with any guarantees regarding the functionality, speed and availability of the Services. The Provider in no way acquaints itself with the content added by the users.<br><br>\r\nInformation about the User’s personal data processing are stated in <a href=\"privacy\">Privacy Policy</a>.<br><br>\r\n<span style=\"text-decoration:underline\">Termination of the Contract</span><br>\r\nThe agreement on provision of Services may be terminated by the User or the Provider without cause with the effect from the day of delivery of a written (including means of electronic communication – specifically, email) notice to the other contracting party. <br><br>\r\n<span style=\"text-decoration:underline\">Conditions for Using the Services</span><br>\r\nThe rules stipulated below apply during any use of the Services by the User. <br><br>\r\nPersons professionally providing educational services or persons affiliated with them are not allowed to use the Question asking, Answer providing and Comments posting part of the Services and to create a user account for Questions, Answers or Comments purposes.<br><br>\r\nDuring the use of the Services, the User is always obliged to act in accordance with applicable statutory provisions and to comply with the below stated conditions and rules:\r\n</p><ul>\r\n<li>It is forbidden to use vulgar expressions, offensive language, personally attacking or dehonesting texts or insults, as well as intentionally false and misleading statements or information.</li>\r\n<li>It is forbidden to repeatedly insert duplicate posts or to insert intentionally false or misleading posts.</li>\r\n<li>It is forbidden to post any paid or unpaid advertisement, or as the case may be, third party advertisement to the portal, unless such posting of paid or unpaid advertisement, or as the case may be, third party advertisement to the portal, is allowed on the basis of prior specific agreement with the Provider.</li>\r\n<li>It is forbidden to promote educational or other services offered by the User or by a person affiliated with the User, unless such promoting of educational or other services offered by the User or by a person affiliated with the User is allowed on the basis of prior specific agreement with the Provider.</li>\r\n<li>All User\'s posts on the portal have to be in compliance with all applicable laws and rules and these Terms and Conditions, which, as the case may be, can develop and change over time.</li>\r\nIn case that the User breaches these Conditions, the Provider is entitled to delete the posts sent by the User. In case of repeated or serious breach of these Conditions, upon the sole decision of the Provider, the Provider is further entitled to cancel the account of the User including the blocking of User’s access to the portal of the Provider.<br>\r\n</ul><p></p>\r\n<p><span style=\"text-decoration:underline\">Final Provisions</span><br>\r\nThese Conditions are made in English language and the agreement can be concluded only in English language. The User is entitled to save this counterpart of the Conditions and print it. These Conditions are kept at the Provider’s and the Provider shall enable the User to access them. \r\nAs the Provider is incorporated and has its registered office in the Czech Republic, the agreement will be governed by and interpreted in accordance with the laws of the Czech Republic.<br><br>\r\nThe Provider is entitled at any time to unilaterally change the content of these Conditions, where any changes of these Conditions become effective after they are made public and on the day determined by the Provider. In relation to every User, however, changes to these Conditions become effective only if the User agrees to such a change, where using the Services by the User after the effective date of change of the Conditions set by the Provider is considered a consent to such change. If the User does not agree with the change of the Conditions, the User is obliged to refrain from using the Services after the date set by the Provider as the effective date of change of the Conditions.<br><br>\r\nThese Conditions are valid and effective from 1 October, 2017.</p>', 'A', '2017-10-07 06:37:07', '2017-08-09 00:00:00', 'Terms of Use', 'Terms of Use'),
(5, 'privacy', 'Privacy', '', '<div id=\"show_0\" class=\"shwdetails displayclass\">\r\n<p>Your personal data will be processed by the company: Learneron, SE; business ID: 061 59 010; registered seat: Zahrebska 23, 120 00, Prague, Czech Republic; e-mail: <a href=\"mailto:administrator@learneron.net\">administrator@learneron.net</a> as a personal data controller (“Controller”) on the basis of performance of a contract for the purpose of creating a user account and using services of the portal LearnerOn.Net. Further information about personal data processing and your rights are available in Privacy Overview. For more details click <a id=\"show_more_1\" href=\"javascript:void(0);\" onclick=\"show_details(\'1\');\">here</a>.</p></div>\r\n<div id=\"show_1\" class=\"hidedetails displayclass\">\r\n	<p>Your personal data will be processed by the company: Learneron, SE; business ID: 061 59 010; registered seat: Zahrebska 23, 120 00, Prague, Czech Republic; e-mail: <a href=\"mailto:administrator@learneron.net\">administrator@learneron.net</a> as a personal data controller (“Controller”) on the basis of performance of a contract for the purpose of creating a user account and using services of the portal LearnerOn.Net.<br><br>\r\n	The personal data will be processed in the extent of name and surname (if provided by you), username, e-mail address, data about the communication within the portal and data entered over or into the portal. The personal data processing is necessary for creating the user account and using services of the portal LearnerOn.Net.<br><br>\r\n	In case of suspicion that the Controller processes your personal data in breach of privacy protection or in breach of law, you are entitled to demand an explanation from the Controller and to seek a rectification of the unsound situation from the Controller. You are also entitled to ask for blocking, rectification, completion or removal of personal data, information about your personal data processing and you have a right to access your personal data and other rights stipulated in the Czech Act No. 121/2000 Coll., on personal data protection and on amendment of some acts, as amended, which implements Directive 95/46/EC of the European Parliament and of the Council of 24 October 1995 on the protection of individuals with regard to the processing of personal data and on the free movement of such data.<br>\r\n	Further information on privacy protection, personal data processing and your rights are available in <a id=\"show_more_2\" href=\"javascript:void(0);\" onclick=\"show_details(\'2\');\">Privacy Policy</a>.</p>\r\n</div>\r\n\r\n<div id=\"show_2\" class=\"hidedetails displayclass\">\r\n	<p>Your personal data will be processed by the company: Learneron, SE; business ID: 061 59 010; registered seat: Zahrebska 23, 120 00, Prague, Czech Republic; e-mail: <a href=\"mailto:administrator@learneron.net\">administrator@learneron.net</a> as a personal data controller (“Controller”) on the basis of performance of a contract for the purpose of creating a user account and using services of the portal LearnerOn.Net.<br><br>\r\n	The personal data will be processed in the extent of name and surname (if provided by you), username, e-mail address, data about the communication within the portal and data entered over or into the portal. The personal data processing is necessary for creating the user account and using services of the portal LearnerOn.Net.<br><br>\r\n	The personal data will be processed until the end of force of the agreement between you and the Controller.<br><br>\r\n	In case of suspicion that the Controller processes your personal data in breach of privacy protection or in breach of law, especially if your personal data are inaccurate with regard to the purpose of their processing, you are entitled to demand an explanation from the Controller and to seek a rectification of the situation from the Controller. You are also entitled to ask for blocking, rectification, completion or removal of personal data. Provided that the demand pursuant to the previous sentences is found reasonable, the Controller shall rectify the defect.<br><br>\r\n	If you require information about your personal data processing, the Controller is obliged to provide you with these information. For provision of these information, the Controller is entitled to seek compensation not exceeding the expenses for provision of these information.<br><br>\r\n	You are further always entitled to ask the Controller for the access to your personal data or to carry out other rights stipulated in the Czech Act No. 121/2000 Coll., on personal data protection and on amendment of some acts, as amended, which implements Directive 95/46/EC of the European Parliament and of the Council of 24 October 1995 on the protection of individuals with regard to the processing of personal data and on the free movement of such data.<br><br>\r\n	This Privacy Policy will be amended on 25 May 2018 in connection with applicability of the Regulation (EU) 2016/679 of the European Parliament and of the Council of 27 April 2016 on the protection of natural persons with regard to the processing of personal data and on the free movement of such data, and repealing Directive 95/46/EC (General Data Protection Regulation). The new version of this Privacy Policy applicable from 25 May 2018 is available <a id=\"show_more_3\" href=\"javascript:void(0);\" onclick=\"show_details(\'3\');\">here</a>.</p>\r\n</div>\r\n\r\n<div id=\"show_3\" class=\"hidedetails displayclass\">\r\n	<h5>Privacy policy valid from 25 May 2018</h5>\r\n	<p>Our personal data will be processed by the company: Learneron, SE; business ID: 061 59 010; registered seat: Zahrebska 23, 120 00, Prague, Czech Republic; e-mail: <a href=\"mailto:administrator@learneron.net\">administrator@learneron.net</a> as a personal data controller (“Controller”) on the basis of performance of a contract for the purpose of creating a user account and using services of the portal LearnerOn.Net.<br><br>\r\n	The personal data will be processed in the extent of name and surname (if provided by you), username, e-mail address, data about the communication within the portal and data entered over or into the portal. The personal data processing is necessary for creating the user account and using services of the portal LearnerOn.Net. You may decline to provide the Controller with the personal data, in such case, however, the creation of the user account and subsequent provision of services of the portal LearnerOn.Net will not be possible.<br><br>\r\n	The personal data will be processed until the end of force of the agreement between you and the Controller. You are entitled to ask for access to personal data, their rectification, completion, erasure, limitation of the processing, explanation of the processing, to raise an objection against processing of data, and you have a right to data portability and right to lodge a complaint against the personal data processing with the Czech Office for Personal Data Protection.</p>\r\n</div>', 'A', '2017-10-29 19:46:42', '2017-08-09 00:00:00', 'Privacy', 'Privacy'),
(6, 'contact us', 'Contact Us', '', '', 'A', '2017-08-09 00:00:00', '2017-08-09 00:00:00', 'Contact Us', 'Contact Us'),
(7, 'processing my data', 'Your personal data', '', '<p>Your personal data, i.e. identification and contact details and data about communications within the portal, will be processed by Learneron, SE, for the purpose of creating a user account and using services of the portal  - including personalised search results, suggestions, answers, learning paths, courses, learning providers and vendors offerings or ads and, also, further improving and developing the current or future portal services and performance; also, for occasional contacts by the portal on potentially relevant portal’s, or associated or third parties offerings related to the portal’s main purpose. Further information about personal data processing and your rights are available in <a href=\"privacy\">Privacy Policy</a>.</p>', 'A', '2017-10-07 06:37:07', '2017-10-07 06:37:07', 'Your personal data', 'Your personal data'),
(8, 'cookie consent', 'Cookie Consent', '<p>This site uses cookies, viewer\'s statistics or similar activity tracking technology. By viewing the site or clicking on it, you agree with using the tracking technology and with storing and processing the tracked data for the purposes of the site.</p>', '<p>The tools and data tracked are used for purposes of monitoring the site statistics, the visitors / users conversions, for personalisation of the site content and, actually or prospectively, also for personalisation of the advertising or third party content possibly shown over the site</p>', 'A', '2018-05-06 18:47:19', '2018-05-01 03:00:00', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `learn_common_settings`
--

CREATE TABLE `learn_common_settings` (
  `id` int(11) NOT NULL,
  `facebook_link` varchar(255) NOT NULL,
  `twitter_link` varchar(255) NOT NULL,
  `google_plus_link` varchar(255) NOT NULL,
  `linkedin` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(30) NOT NULL,
  `address` varchar(255) NOT NULL,
  `footer_text` varchar(255) NOT NULL,
  `question_approval` enum('1','0') NOT NULL DEFAULT '0' COMMENT '1 => Need approval, 0 => Not needed',
  `question_answer_approval` enum('1','0') NOT NULL DEFAULT '0' COMMENT '1 => Need approval, 0 => Not needed',
  `question_comment_approval` enum('1','0') NOT NULL DEFAULT '0' COMMENT '1 => Need approval, 0 => Not needed',
  `answer_comment_approval` enum('1','0') NOT NULL DEFAULT '0' COMMENT '1 => Need approval, 0 => Not needed',
  `news_comment_approval` enum('1','0') NOT NULL DEFAULT '0' COMMENT '1 => Need approval, 0 => Not needed',
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_common_settings`
--

INSERT INTO `learn_common_settings` (`id`, `facebook_link`, `twitter_link`, `google_plus_link`, `linkedin`, `email`, `phone_number`, `address`, `footer_text`, `question_approval`, `question_answer_approval`, `question_comment_approval`, `answer_comment_approval`, `news_comment_approval`, `modified`, `created`) VALUES
(1, 'https://www.facebook.com/', 'http://www.twitter.com', 'https://plus.google.com', 'http://www.linkedin.com', 'spinskillsup@gmail.com', '9876543210', '', '', '1', '1', '1', '1', '1', '2017-12-10 13:02:44', '2016-11-25 14:54:50');

-- --------------------------------------------------------

--
-- Table structure for table `learn_contacts`
--

CREATE TABLE `learn_contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone_number` varchar(30) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'A' COMMENT 'A=>Active, I=>Inactive',
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_contacts`
--

INSERT INTO `learn_contacts` (`id`, `name`, `user_name`, `email`, `phone_number`, `subject`, `message`, `status`, `modified`, `created`) VALUES
(4, 'Sanjay', 'sanja', '100websolution@gmail.com', '9876543210', 'test subject', 'This is a message', 'A', '2017-09-10 08:18:48', '2017-09-10 08:18:48'),
(5, 'Sujoy', 'suj', 'suj@gmail.com', '9876543210', 'test subject', 'this is testing', 'A', '2017-09-10 15:27:57', '2017-09-10 15:27:57'),
(6, 'baby', 'baby', 'baby@baby.com', '', '', 'hi', 'A', '2017-09-23 19:26:11', '2017-09-23 19:26:11'),
(7, 'Learner1', 'Learner1', 'administrator@learneron.net', '', 'question', 'question', 'A', '2017-10-08 18:43:33', '2017-10-08 18:43:33'),
(8, 'Rams', 'Rams Dean', 'sanjoy86.jk@gmail.com', '9876543210', 'This is testing subject', 'my comments are listed below...', 'A', '2017-10-10 20:47:46', '2017-10-10 20:47:46'),
(9, 'sdf', 'sdf', 'dsfds@fsdf.cv', '9477482876', 'sdf', 'sdfs df sdf', 'A', '2017-10-15 20:47:40', '2017-10-15 20:47:40'),
(10, 'Sukanta Sarkar', 'sukanta', 'sukanta.info2@gmail.com', '9477482876', 'test', 'test message 123 test message 123 test message 123 test message 123 test message 123 test message 123 test message 123 test message 123 test message 123 ', 'A', '2017-10-15 20:49:58', '2017-10-15 20:49:58'),
(11, 'Mr Big', 'Learner1', 'administrator@learneron.net', '', '', 'Hi, are you there?', 'A', '2017-10-22 11:14:06', '2017-10-22 11:14:06'),
(12, 'Learner1', 'Learner1', 'spinskillsup@gmail.com', '', 'Hi', 'Hi', 'A', '2017-11-12 14:22:10', '2017-11-12 14:22:10'),
(13, 'test', 'testing', 'sanjoy86.jk@gmail.com', '9876543210', 'hi my subject', 'this is testing email', 'A', '2017-11-13 18:26:21', '2017-11-13 18:26:21'),
(14, 'Mitkar', 'testing', 'sanjoy86.jk@gmail.com', '9876543210', 'hi my subject', 'hkllklj', 'A', '2017-11-13 18:42:31', '2017-11-13 18:42:31'),
(15, 'Learner1', 'Learner1', 'severav@seznam.cz', '', 'question', 'Is this working on November 26?', 'A', '2017-11-26 13:32:59', '2017-11-26 13:32:59'),
(16, 'aa', 'a', 'administrator@learneron.net', '', '2nd Nov 26', 'second attempt on Nov26', 'A', '2017-11-26 13:36:54', '2017-11-26 13:36:54'),
(17, 'a', 'a', 'severav@seznam.cz', '', 'trying', '3rd attempt on NOv 26', 'A', '2017-11-26 13:41:17', '2017-11-26 13:41:17'),
(18, 'a', 'aa', 'severav@seznam.cz', '', 'hi', 'Nov 26, 4th attempt', 'A', '2017-11-26 13:48:54', '2017-11-26 13:48:54'),
(19, 'Ja', 'Learner1', 'severav@seznam.cz', '', '', 'Nov 27 - is it working?', 'A', '2017-11-27 05:19:03', '2017-11-27 05:19:03'),
(20, 'severav', 'severav', 'severav@seznam.cz', '', 'indirect mail', 'indirect mail', 'A', '2017-12-10 13:04:19', '2017-12-10 13:04:19');

-- --------------------------------------------------------

--
-- Table structure for table `learn_contact_replies`
--

CREATE TABLE `learn_contact_replies` (
  `id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `reply_message` text NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_contact_replies`
--

INSERT INTO `learn_contact_replies` (`id`, `contact_id`, `reply_message`, `created`) VALUES
(1, 4, '<p>thanks..<br></p>', '2017-10-12 19:37:01'),
(2, 4, '<p>Testing on</p>', '2017-10-13 20:40:03'),
(3, 4, '<p>Testing on<span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><br></p>', '2017-10-13 20:40:24'),
(6, 4, '<p>happy testing<br></p>', '2017-10-29 18:39:08'),
(7, 10, '<p>Hi<br></p>', '2017-11-13 19:23:13'),
(8, 10, '<p>This is another reply from admin</p>', '2017-11-20 19:23:29'),
(9, 12, '<p>hi, is it working now?</p><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p>', '2017-11-26 12:46:33'),
(10, 17, '<p>3rd answer<br></p>', '2017-11-26 13:42:04'),
(11, 15, '<p>1st answer<br></p>', '2017-11-26 13:42:51'),
(12, 16, '<p>2nd&nbsp; answer<br></p>', '2017-11-26 13:43:22');

-- --------------------------------------------------------

--
-- Table structure for table `learn_cookie_consents`
--

CREATE TABLE `learn_cookie_consents` (
  `id` int(11) NOT NULL,
  `user_ipaddress` varchar(255) NOT NULL,
  `cookie_type` enum('Implicit','Explicit') DEFAULT NULL,
  `cookie_time` datetime DEFAULT NULL,
  `withdrawl_status` enum('1','0') NOT NULL DEFAULT '1' COMMENT '1=>Withdrawl accept, 0=>Withdrawl decline',
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_cookie_consents`
--

INSERT INTO `learn_cookie_consents` (`id`, `user_ipaddress`, `cookie_type`, `cookie_time`, `withdrawl_status`, `created`) VALUES
(1, '::1', 'Implicit', '2018-05-28 18:46:11', '0', '2018-05-28 18:46:11');

-- --------------------------------------------------------

--
-- Table structure for table `learn_faqs`
--

CREATE TABLE `learn_faqs` (
  `id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `status` enum('A','I') NOT NULL DEFAULT 'I' COMMENT '''A'' => Active, ''I'' => Inactive',
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_faqs`
--

INSERT INTO `learn_faqs` (`id`, `question`, `slug`, `answer`, `status`, `modified`, `created`) VALUES
(4, 'What are the benefits of signing up and becoming LearnerOn.Net registered user, as opposed to staying as an unregistered site viewer?', 'what-are-the-benefits-of-signing-up-and-becoming-learneron-net-registered-user-as-opposed-to-staying-as-an-unregistered-site-viewer', 'While the site content is generally available to unregistered viewers who can browse the Questions and Answers material, read the News &amp; Views and make use of these, the registered and signed users are in addition getting an access to a multiple of features and functionalities:\r\n<ul>\r\n	<li>the key user\'s activity - asking a Question, placing and Answer or posting a Comment on the site - can be done only by registered users,</li>\r\n	<li>registration also allows to participate in the voting on Answers placed on the site, which is very valuable feature for the learning community</li>\r\n	<li>registered users can get automatic notification of new Answers posted on their questions, on new Questions in a category of interest, and also can subscribe to automatic notification on new News &amp; Views content and postings, as well as to the Twitter version of them,</li>\r\n	<li>LearnerOn.Net development does not stop here: new functionalities for the site users are intended and postings on them, if and when they become available, will be part of the site <a href=\"news\">News &amp; Views</a> stream.</li>\r\n</ul>', 'A', '2017-10-29 05:36:05', '2017-07-25 18:52:10'),
(5, 'How a question can be posted on the LearnerOn.Net site?', 'how-a-question-can-be-posted-on-the-learneron-net-site-1', 'Similarly to posting a question (please see above the Q related to a question posting), you first need to sign up and / or log in to the site before you will be able to post a comment or an answer.  Then, anywhere on the site where you can view a question posted, you can add your comment or place an answer to that question (in the <a href=\"news\">News &amp; Views</a> section of the site, you can also place comment to the <a href=\"news\">News &amp; Views</a> item of your interest). Please note that a full answer to a question on the LearnerOn.Net site consists of three parts, and ideally each of them should be filled to provide maximum utility for the user who is asking: i) Learning Path Recommendation – in this part, the succession of recommended courses or practical steps to learn the subject of interest should be included; ii) What Was Your Learning Experience – eg, quality, availability and attention of the lecturerers, of the lectures themselves, of the shared / available course materials, rating of the content / delivery would be good to place here; iii) What Was Your Learning Utility – matters as, eg, what in restropsect was the major take-away of your learning experience, how useful and practical it really was in helping you to achieve your goal (eg, finding new job, getting a salary progression, mastering the skill you needed, any other applicable goal) fits here.', 'A', '2017-10-29 05:32:09', '2017-07-25 19:05:02'),
(6, 'How an answer or a comment can be posted on the LearnerOn.Net site?', 'how-an-answer-or-a-comment-can-be-posted-on-the-learneron-net-site', 'Similarly to posting a question (please see above the Q related to a question posting), you first need to sign up and / or log in to the site before you will be able to post a comment or an answer.  Then, anywhere on the site where you can view a question posted, you can add your comment or place an answer to that question (in the <a href=\"news\">News &amp; Views</a> section of the site, you can also place comment to the <a href=\"news\">News &amp; Views</a> item of your interest). Please note that a full answer to a question on the LearnerOn.Net site consists of three parts, and ideally each of them should be filled to provide maximum utility for the user who is asking: i) Learning Path Recommendation – in this part, the succession of recommended courses or practical steps to learn the subject of interest should be included; ii) What Was Your Learning Experience – eg, quality, availability and attention of the lecturerers, of the lectures themselves, of the shared / available course materials, rating of the content / delivery would be good to place here; iii) What Was Your Learning Utility – matters as, eg, what in restropsect was the major take-away of your learning experience, how useful and practical it really was in helping you to achieve your goal (eg, finding new job, getting a salary progression, mastering the skill you needed, any other applicable goal) fits here.', 'A', '2017-10-29 05:33:04', '2017-07-25 19:05:16'),
(7, 'I submitted a Question (Answer, Comment) on the site, but do not see it appearing there yet', 'i-submitted-a-question-answer-comment-on-the-site-but-do-not-see-it-appearing-there-yet', 'All user\'s posts on the site are going through an appoval procedure, which may need certain time – therefore, please be a little patient. You however will be notified on your registered email address when your post goes live (or if it needs a review or an adjustment), thus your post will not go on screen unnoticed by you!', 'A', '2017-10-29 05:33:46', '2017-07-25 19:05:30'),
(8, 'Do the site posts need to be solely in English? Are there any language standards for the site?', 'do-the-site-posts-need-to-be-solely-in-english-are-there-any-language-standards-for-the-site', '<p>At the moment, the site\'s language is English and right now we do not have any other language versions. The language standards are simple - posts need to be in line with the site Terms of Use (thus, eg, no offensive language or hate terms are allowed to be part of a post), and, also, the meaning of the post needs to be clear (thus, use of proper English is desirable) and reflecting the purpose of the site and the particular section (learning path Question, Answer, Comment or similar). If the post does not fulfill the above standards, it may be returned back to the posting user for editing or not allowed to be posted.<br></p>', 'A', '2017-11-12 10:47:45', '2017-11-12 10:47:45');

-- --------------------------------------------------------

--
-- Table structure for table `learn_news`
--

CREATE TABLE `learn_news` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL COMMENT 'News Category Id from "news_categories" table',
  `user_id` int(11) DEFAULT NULL COMMENT 'User Id from "users" table',
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `meta_keywords` text NOT NULL,
  `meta_description` text NOT NULL,
  `status` enum('A','I') NOT NULL DEFAULT 'I',
  `view` int(11) DEFAULT NULL COMMENT 'total views',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_news`
--

INSERT INTO `learn_news` (`id`, `category_id`, `user_id`, `name`, `slug`, `description`, `image`, `meta_keywords`, `meta_description`, `status`, `view`, `created`, `modified`) VALUES
(1, 22, NULL, 'Test News', 'test-news-1', '<p>Test description<br></p>', 'news_image_150080972760.jpg', 'Test ', 'Test meta description', 'A', 9, '2017-07-23 11:12:28', '2017-08-17 19:03:19'),
(2, 23, 1, 'test', 'test', 'dfsdf', NULL, '', '', 'A', 12, '2017-07-25 03:10:00', '2017-08-24 00:27:19'),
(3, 22, NULL, 'Rio - Movie', 'rio-movie', '<p><br></p><p>Lorem Ipsum is simply dummy text of the printing &amp; typesetting industry. </p><p><br></p>', 'news_image_15024749913.jpg', '', '', 'A', 27, '2017-08-12 18:09:51', '2017-08-24 20:21:50'),
(4, 24, NULL, 'Kids movie -Kunfu', 'kids-movie-kunfu', '<p>Lorem Ipsum is simply dummy text of the printing &amp; typesetting industry. </p><p><br></p>', 'news_image_15024750403.jpg', '', '', 'A', 9, '2017-08-08 18:10:40', '2017-08-24 00:27:48'),
(5, 23, 1, 'Kids movie -Kunfu 1', 'kids-movie-kunfu-1', '<p>Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt&nbsp; ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi&nbsp; iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt&nbsp; ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi&nbsp; iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt&nbsp; ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi&nbsp; iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt&nbsp; ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi&nbsp; iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt&nbsp; ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi&nbsp; iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt&nbsp; ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi&nbsp; iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt&nbsp; ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi&nbsp; iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt&nbsp; ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi&nbsp; iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt&nbsp; ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi&nbsp; iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt&nbsp; ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi&nbsp; iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt&nbsp; ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi&nbsp; iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt&nbsp; ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi&nbsp; iam, quis nostrud exerci.</p>', 'news_image_15024751169.jpg', 'Kids movie -Kunfu 1 meta key', 'Kids movie -Kunfu 1 meta description', 'A', 28, '2017-08-10 18:11:56', '2017-08-24 00:26:59'),
(6, 24, NULL, 'Todays news', 'todays-news', '<p>hi this is todays news<br></p>', 'news_image_15025336230.jpg', '', '', 'A', 27, '2017-08-12 10:27:03', '2017-08-24 00:23:18');

-- --------------------------------------------------------

--
-- Table structure for table `learn_newsletter_subscriptions`
--

CREATE TABLE `learn_newsletter_subscriptions` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'A' COMMENT 'A=>Active, I=>Inactive',
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `learn_news_categories`
--

CREATE TABLE `learn_news_categories` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `status` enum('A','I') NOT NULL DEFAULT 'I' COMMENT 'A=>Active, I=>Inactive',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_news_categories`
--

INSERT INTO `learn_news_categories` (`id`, `parent_id`, `name`, `slug`, `status`, `created`, `modified`) VALUES
(22, 0, 'Business', 'business', 'A', '2017-07-20 20:57:05', '2017-07-30 10:21:56'),
(23, 0, 'Technology', 'technology', 'A', '2017-07-30 10:22:13', '2017-07-30 10:22:13'),
(24, 0, 'Marketing', 'marketing', 'A', '2017-07-30 10:22:27', '2017-07-30 10:22:27'),
(25, 22, 'New cat', 'new-cat', 'A', '2017-07-31 20:08:36', '2017-07-31 20:08:36');

-- --------------------------------------------------------

--
-- Table structure for table `learn_news_comments`
--

CREATE TABLE `learn_news_comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `news_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `comment` text NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '0' COMMENT '1=>Active, 0=>Inactive',
  `user_ip` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_news_comments`
--

INSERT INTO `learn_news_comments` (`id`, `user_id`, `news_id`, `name`, `email`, `comment`, `status`, `user_ip`, `created`, `modified`) VALUES
(1, 0, 2, 'Test', 'test@gmail.com', 'this is testing comment', '1', '47.15.12.34', '2017-08-26 10:37:17', '2017-08-26 10:37:17'),
(4, 27, 6, NULL, NULL, 'Hi thi is test...', '1', '47.15.8.21', '2017-12-17 16:53:35', '2017-12-17 16:53:52'),
(5, 27, 3, NULL, NULL, 'hello text', '1', '::1', '2018-03-23 20:41:20', '2018-03-24 04:40:21');

-- --------------------------------------------------------

--
-- Table structure for table `learn_questions`
--

CREATE TABLE `learn_questions` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL COMMENT 'Question Category Id from "question_categories" table',
  `user_id` int(11) DEFAULT NULL COMMENT 'User id from "users" table',
  `name` text,
  `slug` text,
  `short_description` text,
  `learning_goal` text,
  `education_history` text NOT NULL,
  `budget_constraints` text,
  `preferred_learning_mode` text NOT NULL,
  `response_email` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '''Y'' => Need update through email, ''U'' => Not needed',
  `is_featured` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'Featured question ot not',
  `user_type` enum('A','U','F','G','T','L') NOT NULL DEFAULT 'U' COMMENT '''A'' => Admin, ''U'' => Users, ''F'' => Facebook, ''G'' => GooglePlus, ''T'' => Twitter, ''L'' => ''LinkedIn''',
  `view` int(11) NOT NULL,
  `status` enum('A','I') NOT NULL DEFAULT 'I',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_questions`
--

INSERT INTO `learn_questions` (`id`, `category_id`, `user_id`, `name`, `slug`, `short_description`, `learning_goal`, `education_history`, `budget_constraints`, `preferred_learning_mode`, `response_email`, `is_featured`, `user_type`, `view`, `status`, `created`, `modified`) VALUES
(3, 18, NULL, 'When has discrete understanding preceded continuous?', NULL, 'When has discrete understanding preceded continuous When has discrete understanding preceded continuous', '', '', '', '', 'N', 'Y', 'A', 6, 'A', '2017-08-12 12:32:52', '2018-02-09 20:00:54'),
(6, 18, NULL, 'this is also a new question', NULL, 'by details ', '', '', '', '', 'N', '', 'A', 20, 'A', '2017-08-15 18:19:55', '2018-02-09 19:59:14'),
(7, 20, 27, 'My tets question', NULL, 'test description', '<p>test learning goal<br></p>', '', '<p>test budget<br></p>', '<p>test input<br></p>', 'Y', 'Y', 'U', 39, 'A', '2017-08-24 20:27:10', '2018-02-09 19:59:12'),
(9, 18, 27, 'A new question', NULL, 'my latest description1', '<p>Learning Goal<br></p>', 'New edu 1 at new school 1 from 7th May 2017 to 15th May 2017<br />', '<p>Budget &amp; other constraints<br></p>', '<p>Optional input on preferred learning mode <br></p>', 'Y', 'Y', 'U', 24, 'A', '2017-09-08 19:11:33', '2018-03-20 18:50:39'),
(11, 21, 27, 'test', NULL, 'test1', '<p>test2&nbsp;&nbsp;&nbsp;&nbsp;<p><br></p></p>', 'MCA at WBUT from 15th August 2007 to 15th August 2010<br />BSC at CU from 2nd August 2004 to 4th August 2007<br />HS at VMPS from 1st August 2002 to 15th August 2004<br />', '', '', 'Y', 'N', 'U', 0, 'A', '2018-03-24 14:42:26', '2018-03-24 14:42:26'),
(12, 22, 27, 'test', NULL, 'test1', 'test2', 'MCA at WBUT from 15th August 2007 to 15th August 2010<br />BSC at CU from 2nd August 2004 to 4th August 2007<br />HS at VMPS from 1st August 2002 to 15th August 2004<br />', '', '', 'Y', 'N', 'U', 1, 'A', '2018-03-24 14:58:07', '2018-04-04 17:43:47'),
(13, 22, 27, 'gdfgdf', NULL, 'dfgdfg', '<p>dfgdfg<br></p>', '', 'dfgdfg<p><br></p>', 'fbvb<p><br></p>', 'N', 'N', 'U', 0, 'A', '2018-10-06 16:26:38', '2018-10-06 16:26:38'),
(14, 22, 27, 'gdfgdf', NULL, 'dfgdfg', '<p>dfgdfg<br></p>', '', 'dfgdfg<p><br></p>', 'fbvb<p><br></p>', 'N', 'N', 'U', 0, 'A', '2018-10-06 16:26:57', '2018-10-06 16:26:57'),
(15, 22, 27, 'gdfgdf', NULL, 'dfgdfg', '<p>dfgdfg<br></p>', '', 'dfgdfg<p><br></p>', 'fbvb<p><br></p>', 'N', 'N', 'U', 0, 'A', '2018-10-06 16:27:30', '2018-10-06 16:27:30'),
(16, 22, 27, 'gdfgdf', NULL, 'dfgdfg', '<p>dfgdfg<br></p>', '', 'dfgdfg<p><br></p>', 'fbvb<p><br></p>', 'N', 'N', 'U', 0, 'A', '2018-10-06 16:29:04', '2018-10-06 16:29:04'),
(17, 22, 27, 'sdfsd', NULL, 'fsdfdsf', '<p>rty<br></p>', 'MCA at WBUT from 15th August 2007 to 15th August 2010<br />BSC at CU from 2nd August 2004 to 4th August 2007<br />HS at VMPS from 1st August 2002 to 15th August 2004<br />', '<p>ty<br></p>', 'g<p><br></p>', 'N', 'N', 'U', 0, 'A', '2018-10-06 16:31:55', '2018-10-06 16:31:55'),
(18, 22, 27, 'sdfsd', NULL, 'fsdfdsf', '<p>rty<br></p>', 'MCA at WBUT from 15th August 2007 to 15th August 2010<br />BSC at CU from 2nd August 2004 to 4th August 2007<br />HS at VMPS from 1st August 2002 to 15th August 2004<br />', '<p>ty<br></p>', 'g<p><br></p>', 'N', 'N', 'U', 0, 'A', '2018-10-06 16:36:07', '2018-10-06 16:36:07'),
(19, 19, 27, 'rty', NULL, 'rtyrty', '<p>rtyrty<br></p>', 'MCA at WBUT from 15th August 2007 to 15th August 2010<br />BSC at CU from 2nd August 2004 to 4th August 2007<br />HS at VMPS from 1st August 2002 to 15th August 2004<br />', '<p>rty<br></p>', 'rty<p><br></p>', 'N', 'N', 'U', 0, 'A', '2018-10-06 16:37:27', '2018-10-06 16:37:27'),
(20, 26, 27, 'helllllllllllll', NULL, 'sddasd', 'sd<p><br></p>', 'MCA at WBUT from 15th August 2007 to 15th August 2010<br />BSC at CU from 2nd August 2004 to 4th August 2007<br />HS at VMPS from 1st August 2002 to 15th August 2004<br />', '<p>ad<br></p>', 'asd<p><br></p>', 'N', 'N', 'U', 0, 'A', '2018-10-06 16:39:49', '2018-10-06 16:39:49');

-- --------------------------------------------------------

--
-- Table structure for table `learn_question_answers`
--

CREATE TABLE `learn_question_answers` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL COMMENT 'Question Id from questions table',
  `user_id` int(11) NOT NULL COMMENT 'User Id from "users" table',
  `learning_path_recommendation` text NOT NULL,
  `learning_experience` text NOT NULL,
  `learning_utility` text NOT NULL,
  `answer` text,
  `status` enum('A','I') NOT NULL DEFAULT 'I',
  `user_ip` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_question_answers`
--

INSERT INTO `learn_question_answers` (`id`, `question_id`, `user_id`, `learning_path_recommendation`, `learning_experience`, `learning_utility`, `answer`, `status`, `user_ip`, `created`, `modified`) VALUES
(1, 6, 27, '<p>test1<br></p>', '<p>test2<br></p>', 'test3<p><br></p>', NULL, 'A', '', '2017-08-26 20:39:56', '2017-08-26 20:39:56'),
(3, 6, 27, '<p>test1<br></p>', '<p>test2<br></p>', '<p>test3<br></p>', NULL, 'A', '', '2017-08-27 18:27:08', '2017-08-27 18:27:08');

-- --------------------------------------------------------

--
-- Table structure for table `learn_question_categories`
--

CREATE TABLE `learn_question_categories` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `status` enum('A','I') NOT NULL DEFAULT 'I' COMMENT '''A'' => Active, ''I'' => Inactive',
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_question_categories`
--

INSERT INTO `learn_question_categories` (`id`, `parent_id`, `name`, `slug`, `status`, `modified`, `created`) VALUES
(18, 0, 'Category1', 'category1', 'A', '2017-08-01 18:22:19', '2017-08-01 18:22:19'),
(19, 0, 'Category 2', 'category-2', 'A', '2017-08-01 18:22:37', '2017-08-01 18:22:37'),
(20, 18, 'Cat 11', 'cat-11', 'A', '2017-08-01 18:23:26', '2017-08-01 18:23:26'),
(21, 18, 'New sub cat', 'new-sub-cat', 'A', '2017-10-14 16:33:59', '2017-10-14 16:33:59'),
(22, 21, 'Sub sub cat', 'sub-sub-cat', 'A', '2017-10-14 16:34:13', '2017-10-14 16:34:13'),
(23, 21, 'Another sub cat', 'another-sub-cat', 'A', '2017-10-14 16:34:32', '2017-10-14 16:34:32'),
(24, 19, 'Test sub cat', 'test-sub-cat', 'A', '2017-10-14 16:35:15', '2017-10-14 16:35:15'),
(25, 24, 'working', 'working', 'A', '2017-10-14 16:35:27', '2017-10-14 16:35:27'),
(26, 24, 'good enough ', 'good-enough', 'A', '2017-10-14 16:35:51', '2017-10-14 16:35:51');

-- --------------------------------------------------------

--
-- Table structure for table `learn_question_comments`
--

CREATE TABLE `learn_question_comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '0' COMMENT '1=>Approved, 0=>Not approved',
  `user_ip` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_question_comments`
--

INSERT INTO `learn_question_comments` (`id`, `user_id`, `question_id`, `comment`, `status`, `user_ip`, `created`, `modified`) VALUES
(1, 27, 8, 'Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter a ', '1', '47.15.11.173', '2017-08-31 20:15:08', '2017-08-31 20:15:08');

-- --------------------------------------------------------

--
-- Table structure for table `learn_question_tags`
--

CREATE TABLE `learn_question_tags` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL COMMENT 'Question Id from "questions" table',
  `user_id` int(11) DEFAULT NULL COMMENT 'Submitter Id',
  `tag_id` int(11) NOT NULL COMMENT 'Tag Id from "tags" table'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_question_tags`
--

INSERT INTO `learn_question_tags` (`id`, `question_id`, `user_id`, `tag_id`) VALUES
(7, 3, NULL, 1),
(8, 3, NULL, 2),
(9, 3, NULL, 13),
(19, 6, NULL, 17),
(20, 6, NULL, 22),
(21, 7, 27, 3),
(22, 7, 27, 8),
(23, 7, 27, 10),
(24, 7, 27, 12),
(67, 9, NULL, 2),
(68, 9, NULL, 3),
(69, 9, NULL, 8),
(71, 11, 27, 2),
(72, 12, 27, 3),
(73, 13, 27, 2),
(74, 13, 27, 8),
(75, 13, 27, 48),
(76, 14, 27, 2),
(77, 14, 27, 8),
(78, 14, 27, 49),
(79, 15, 27, 2),
(80, 15, 27, 8),
(81, 15, 27, 50),
(82, 16, 27, 2),
(83, 16, 27, 8),
(84, 17, 27, 4),
(85, 17, 27, 9),
(86, 18, 27, 4),
(87, 18, 27, 9),
(88, 18, 27, 21),
(89, 18, 27, 51),
(90, 19, 27, 3),
(91, 19, 27, 8),
(92, 19, 27, 24),
(93, 19, 27, 26),
(94, 20, 27, 7),
(95, 20, 27, 9),
(96, 20, 27, 18),
(97, 20, 27, 52);

-- --------------------------------------------------------

--
-- Table structure for table `learn_tags`
--

CREATE TABLE `learn_tags` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `status` enum('A','I') NOT NULL DEFAULT 'I' COMMENT 'A=>Active, I=>Inactive',
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_tags`
--

INSERT INTO `learn_tags` (`id`, `title`, `slug`, `status`, `created`) VALUES
(1, 'Android', 'android', 'A', '2017-07-29 16:03:02'),
(2, 'Apps', 'apps', 'A', '2017-07-29 16:03:11'),
(3, 'Analog', 'analog', 'A', '2017-07-29 16:03:22'),
(4, 'Angular', 'angular', 'A', '2017-07-29 16:03:34'),
(7, 'Bid', 'bid', 'A', '2017-07-29 16:04:39'),
(8, 'Batfied', 'batfied', 'A', '2017-07-29 16:04:53'),
(9, 'Car', 'car', 'A', '2017-07-29 16:05:02'),
(10, 'Commercial', 'commercial', 'A', '2017-07-29 16:05:17'),
(11, 'Demo', 'demo', 'A', '2017-07-29 16:05:32'),
(12, 'Designer', 'designer', 'A', '2017-07-29 16:05:42'),
(13, 'Facebook', 'facebook', 'A', '2017-08-03 20:44:48'),
(14, 'Budget', 'budget', 'A', '2017-08-13 17:51:03'),
(15, 'Business', 'business', 'A', '2017-08-13 17:51:17'),
(16, 'Follow', 'follow', 'A', '2017-08-13 17:51:50'),
(17, 'Game', 'game', 'A', '2017-08-13 17:52:00'),
(18, 'Hotspot', 'hotspot', 'A', '2017-08-13 17:52:11'),
(19, 'Hifi', 'hifi', 'A', '2017-08-13 17:52:18'),
(20, 'Inkjet', 'inkjet', 'A', '2017-08-13 17:52:27'),
(21, 'Jumbo Speaker', 'jumbo-speaker', 'A', '2017-08-13 17:52:38'),
(22, 'Keyboard', 'keyboard', 'A', '2017-08-13 17:52:48'),
(23, 'Lamp', 'lamp', 'A', '2017-08-13 17:52:55'),
(24, 'Auction', 'auction', 'A', '2017-08-14 16:29:09'),
(26, 'hhgg', 'hhgg', 'I', '2018-10-06 11:36:54'),
(27, 'hhgg', 'hhgg-1', 'I', '2018-10-06 11:37:22'),
(28, 'Auction', 'auction-1', 'I', '2018-10-06 11:38:30'),
(29, 'hhgg', 'hhgg-2', 'I', '2018-10-06 11:40:57'),
(30, 'hhgg', 'hhgg-3', 'I', '2018-10-06 11:41:30'),
(31, 'hhgg', 'hhgg-4', 'I', '2018-10-06 11:42:44'),
(32, 'Auction', 'auction-2', 'I', '2018-10-06 11:45:36'),
(33, 'hhgg', 'hhgg-5', 'I', '2018-10-06 11:46:04'),
(34, 'hhgg', 'hhgg-6', 'I', '2018-10-06 11:46:56'),
(35, 'Auction', 'auction-3', 'I', '2018-10-06 11:48:06'),
(37, 'hhgg', 'hhgg-7', 'A', '2018-10-06 11:49:20'),
(38, 'Auction', 'auction-4', 'A', '2018-10-06 11:49:56'),
(39, 'hhgg', 'hhgg-8', 'A', '2018-10-06 11:49:56'),
(40, 'Auction', 'auction-5', 'A', '2018-10-06 11:52:13'),
(41, 'hhgg', 'hhgg-9', 'A', '2018-10-06 11:52:13'),
(42, 'my mumm', 'my-mumm', 'A', '2018-10-06 14:29:48'),
(43, 'kitty', 'kitty', 'A', '2018-10-06 14:29:48'),
(44, 'yes', 'yes', 'A', '2018-10-06 14:29:48'),
(45, 'my mumm', 'my-mumm-1', 'A', '2018-10-06 14:32:44'),
(46, 'kitty', 'kitty-1', 'A', '2018-10-06 14:32:44'),
(47, 'yes', 'yes-1', 'A', '2018-10-06 14:32:44'),
(48, 'Jumbo Speaker', '', 'A', '2018-10-06 16:26:38'),
(49, 'Jumbo Speaker', '-1', 'A', '2018-10-06 16:26:57'),
(50, 'Jumbo Speaker', '-2', 'A', '2018-10-06 16:27:30'),
(51, 'Krk   Sssss', 'krk-sssss', 'A', '2018-10-06 16:36:07'),
(52, 'Testinglearneron', 'testinglearneron', 'A', '2018-10-06 16:39:49');

-- --------------------------------------------------------

--
-- Table structure for table `learn_terms`
--

CREATE TABLE `learn_terms` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_commercialparty` enum('1','0') NOT NULL DEFAULT '1',
  `commercialparty_checked_time` datetime DEFAULT NULL,
  `commercialparty_unchecked_time` datetime DEFAULT NULL,
  `personal_data` enum('Y','N') NOT NULL DEFAULT 'Y',
  `personaldata_checked_time` datetime DEFAULT NULL,
  `personaldata_unchecked_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_terms`
--

INSERT INTO `learn_terms` (`id`, `user_id`, `is_commercialparty`, `commercialparty_checked_time`, `commercialparty_unchecked_time`, `personal_data`, `personaldata_checked_time`, `personaldata_unchecked_time`) VALUES
(1, 77, '0', NULL, '2018-05-14 17:42:47', 'Y', '2018-05-14 17:42:47', NULL),
(2, 77, '1', '2018-05-14 18:12:52', NULL, 'Y', '2018-05-14 18:12:52', NULL),
(3, 77, '1', '2018-05-15 19:31:02', NULL, 'Y', '2018-05-15 19:31:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `learn_users`
--

CREATE TABLE `learn_users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT 'Publicly Visible (Nick name)',
  `profile_pic` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL COMMENT 'email address',
  `notification_email` varchar(50) DEFAULT NULL COMMENT 'notification email address',
  `password` varchar(200) DEFAULT NULL COMMENT 'Hashed password',
  `full_name` varchar(100) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `about_me` text,
  `signup_string` varchar(200) DEFAULT NULL COMMENT 'string used to verify the signup users email',
  `forget_password_string` varchar(200) DEFAULT NULL COMMENT 'string used to verify the account owner',
  `signup_ip` varchar(50) DEFAULT NULL COMMENT 'ip from where account was created',
  `is_verified` enum('1','0') DEFAULT '0' COMMENT 'is the user verified by admin. 1=>yes, 0=>No',
  `type` enum('F','N','G','T','L') DEFAULT 'N' COMMENT '''F'' => Facebook, ''N'' => Normal',
  `facebook_id` varchar(255) NOT NULL,
  `googleplus_id` varchar(255) NOT NULL,
  `twitter_id` varchar(255) NOT NULL,
  `linkedin_id` varchar(255) NOT NULL,
  `facebook_link` varchar(255) DEFAULT NULL,
  `twitter_link` varchar(255) DEFAULT NULL,
  `gplus_link` varchar(255) DEFAULT NULL,
  `linkedin_link` varchar(255) DEFAULT NULL,
  `modified` datetime NOT NULL COMMENT 'update time',
  `created` datetime NOT NULL COMMENT 'insert time',
  `agree` enum('Y','N') NOT NULL DEFAULT 'Y',
  `is_commercialparty` enum('1','0') NOT NULL DEFAULT '1',
  `commercialparty_checked_time` datetime DEFAULT NULL,
  `commercialparty_unchecked_time` datetime DEFAULT NULL,
  `personal_data` enum('Y','N') NOT NULL DEFAULT 'Y',
  `personaldata_checked_time` datetime DEFAULT NULL,
  `personaldata_unchecked_time` datetime DEFAULT NULL,
  `is_setting` enum('1','0') NOT NULL DEFAULT '0' COMMENT '1=>Checked settings, 0=>Uncheck',
  `see_setting_page` enum('1','0') NOT NULL DEFAULT '1' COMMENT '1=>Popup will open, 0=>Popup close permanently',
  `status` enum('A','I') NOT NULL DEFAULT 'I' COMMENT 'A=>active, I=>inactive',
  `loggedin_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `loggedin_status` int(2) NOT NULL DEFAULT '0' COMMENT '1=>Online, 0=>Offline'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_users`
--

INSERT INTO `learn_users` (`id`, `name`, `profile_pic`, `location`, `title`, `email`, `notification_email`, `password`, `full_name`, `birthday`, `about_me`, `signup_string`, `forget_password_string`, `signup_ip`, `is_verified`, `type`, `facebook_id`, `googleplus_id`, `twitter_id`, `linkedin_id`, `facebook_link`, `twitter_link`, `gplus_link`, `linkedin_link`, `modified`, `created`, `agree`, `is_commercialparty`, `commercialparty_checked_time`, `commercialparty_unchecked_time`, `personal_data`, `personaldata_checked_time`, `personaldata_unchecked_time`, `is_setting`, `see_setting_page`, `status`, `loggedin_time`, `loggedin_status`) VALUES
(3, 'Gordon', 'profile_150277954667.jpg', 'New York, United Sates', 'My gordon', 'gordon@gmail.com', NULL, '$2y$10$LIfmgn9B21UFIEtsWTM87e35RIXgvjasNDBILnqzl2Rqbxj1jUAu6', 'Gordon Linoff', '1985-02-08', 'nothing to say', NULL, NULL, NULL, '0', 'N', '', '', '', '', '', 'http://www.twitter.com', '', '', '2017-08-15 06:45:47', '2017-08-15 06:45:47', 'Y', '1', NULL, NULL, 'Y', NULL, NULL, '0', '1', 'A', NULL, 0),
(22, 'max', NULL, NULL, NULL, 'techtimes14@gmail.com', NULL, '$2y$10$GxcwCd3TQaAWx5WU.V7xLOi3KviIxOdgl/Pnd6V5qfU8nQ401gPuy', NULL, NULL, NULL, 'IGQ1503168384CSN', NULL, '122.163.86.28', '0', 'N', '', '', '', '', NULL, NULL, NULL, NULL, '2017-08-19 18:46:24', '2017-08-19 18:46:24', 'Y', '1', NULL, NULL, 'Y', NULL, NULL, '0', '1', 'I', NULL, 0),
(23, 'jhjk', NULL, NULL, NULL, 'techtimes14@gmail.co', NULL, '$2y$10$7lU2XiN./qNgEQ62vW9U1e39.yep1pZvWjsOIk7NhQBnBFvfUq55K', NULL, NULL, NULL, 'VEF1503169199ZSH', NULL, '122.163.86.28', '0', 'N', '', '', '', '', NULL, NULL, NULL, NULL, '2017-08-19 18:59:59', '2017-08-19 18:59:59', 'Y', '1', NULL, NULL, 'Y', NULL, NULL, '0', '1', 'I', NULL, 0),
(27, 'Mitkar', 'profile_15034281190.jpg', 'Kolkata', 'this is Kolkata style', '100websolution@gmail.com', '100websolution@gmail.com', '$2y$10$l7bdbg8.eC6FnhwwRK3XZOU2zacuCZFzcm80lWMGxF67EfGxa3jyu', 'Mitkar Ghosh', NULL, 'nothing to say', 'LAK1538769711JMM', '', '47.15.5.107', '1', 'N', '', '', '', '', 'http://www.facebook.com', '', '', 'http://www.linkedin.com', '2018-05-06 18:09:00', '2017-08-19 19:22:51', 'Y', '1', '2018-05-06 18:09:00', NULL, 'N', NULL, '2018-05-06 18:09:00', '0', '0', 'A', '2018-10-08 17:51:17', 0),
(33, 'Learner1', NULL, NULL, NULL, 'spinskillsup@gmail.com', NULL, '$2y$10$C4tFP9HeARhPtIFATNa2suOSi/K9hhq4yy9Y5rZATRxyAK1QQGdTO', NULL, NULL, NULL, 'TKC1503838438TRL', NULL, '90.179.101.195', '0', 'N', '', '', '', '', NULL, NULL, NULL, NULL, '2017-08-27 12:53:59', '2017-08-27 12:53:59', 'Y', '1', NULL, NULL, 'Y', NULL, NULL, '0', '1', 'I', NULL, 0),
(40, 'Puja', 'profile_15075750340.jpg', NULL, NULL, 'duttapoly.info@gmail.com', NULL, NULL, 'Puja Paul', NULL, NULL, NULL, NULL, '110.225.22.131', '', 'F', '1450066711749441', '', '', '', NULL, NULL, NULL, NULL, '2017-10-09 18:50:34', '2017-09-24 17:55:37', 'Y', '1', NULL, NULL, 'Y', NULL, NULL, '0', '1', 'A', '2017-10-09 19:03:00', 0),
(41, 'Esha', 'http://graph.facebook.com/2047345325495104/picture?width=9999', 'Kolkata', 'Web Designer', 'esha.socialsites@gmail.com', NULL, NULL, 'Esha Saha', '2017-09-04', 'I am a nice girl', NULL, NULL, '116.203.180.112', '', 'F', '2047345325495104', '', '', '', 'http://facebook.com', 'http://facebook.com', 'http://facebook.com', 'http://facebook.com', '2017-09-29 03:24:58', '2017-09-29 03:21:57', 'Y', '1', NULL, NULL, 'Y', NULL, NULL, '0', '1', 'A', NULL, 0),
(46, 'Sukanta', 'profile_15075778415.jpg', NULL, NULL, 'sukanta.info10@gmail.com', NULL, NULL, 'Sukanta Sarkar', NULL, NULL, NULL, 'EIL1507988643BMZ', '47.15.9.107', '1', 'T', '', '', '3113475737', '', NULL, NULL, NULL, NULL, '2017-10-09 19:37:21', '2017-10-08 12:07:56', 'Y', '1', NULL, NULL, 'Y', NULL, NULL, '0', '1', 'A', '2017-10-14 11:44:08', 0),
(48, 'njoroge', 'profile_15080678353.jpg', NULL, NULL, 'njorogeikonye@gmail.com', NULL, NULL, 'njoroge ikonye', NULL, NULL, NULL, NULL, '110.227.111.110', '1', 'G', '', '109813575415969680831', '', '', NULL, NULL, 'https://plus.google.com/+njorogeikonye', NULL, '2017-10-15 11:43:55', '2017-10-08 14:50:12', 'Y', '1', NULL, NULL, 'Y', NULL, NULL, '0', '1', 'A', '2017-10-15 11:44:07', 0),
(49, 'Sukanta', 'profile_15086891222.jpg', 'Kolkata Area, India', NULL, 'sukanta.info2@gmail.com', NULL, NULL, 'Sukanta Sarkar', NULL, NULL, NULL, 'VNA1510088229JKH', '110.227.96.198', '1', 'L', '', '', '', 'OfwJ3ZH80d', NULL, NULL, NULL, 'https://www.linkedin.com/in/sukanta-sarkar-1064a786', '2017-10-22 16:18:42', '2017-10-14 19:00:55', 'Y', '1', NULL, NULL, 'Y', NULL, NULL, '0', '1', 'A', '2017-11-07 20:57:09', 0),
(50, 'Esha', 'profile_15086890947.jpg', 'Kolkata Area, India', NULL, 'esha.info90@gmail.com', NULL, NULL, 'Esha Saha', NULL, NULL, NULL, NULL, '110.227.96.198', '1', 'L', '', '', '', 'opeejufEHx', NULL, NULL, NULL, 'https://www.linkedin.com/in/esha-saha-82a50b86', '2017-10-22 16:18:15', '2017-10-14 22:10:34', 'Y', '1', NULL, NULL, 'Y', NULL, NULL, '0', '1', 'A', '2017-10-22 16:29:46', 0),
(51, 'Sanjay', 'profile_15148219291.jpg', NULL, NULL, 'sanjoy86.jk@gmail.com', NULL, NULL, 'Sanjay Karmakar', NULL, NULL, NULL, NULL, '47.15.26.233', '1', 'F', '1799566236743627', '', '', '', NULL, NULL, NULL, NULL, '2018-01-01 15:52:09', '2018-01-01 15:52:09', 'Y', '1', NULL, NULL, 'Y', NULL, NULL, '0', '1', 'A', '2018-01-01 15:52:20', 0),
(59, 'Anonymous Group', 'user_no_image.png', '', '', 'anonymousgroup@learneron.net', NULL, '$2y$10$J7gPCLjjAEqnU7Qf./ODEeORlrFVJ9KWmcQnLQyoMdNH8lyEAg4o6', 'Anonymous Group', NULL, '', '', NULL, '::1', '0', 'N', '', '', '', '', '', '', '', '', '2018-04-12 19:18:15', '2018-03-17 14:54:33', 'Y', '1', NULL, NULL, 'Y', NULL, NULL, '1', '1', 'I', '2018-04-12 19:18:15', 0),
(60, '123', NULL, NULL, NULL, '123@gmail.com', NULL, '$2y$10$oeyuYkOz315RDg8Cn3ylTu/A5ipEbj18hvtbGeBw5fqD1jFPLPbpy', NULL, NULL, NULL, 'KTJ1521299972OFS', NULL, '::1', '0', 'N', '', '', '', '', NULL, NULL, NULL, NULL, '2018-03-17 15:19:32', '2018-03-17 15:19:32', 'Y', '1', NULL, NULL, 'Y', NULL, NULL, '0', '1', 'I', NULL, 0),
(61, '987', NULL, NULL, NULL, '987@gmail.com', NULL, '$2y$10$nkbdqjr6kq14Gv3HUkXn6u2s3c2VpWG7m8DqHVhk1aWjYUCA18vNm', NULL, NULL, NULL, 'KBA1521300570JLZ', NULL, '::1', '0', 'N', '', '', '', '', NULL, NULL, NULL, NULL, '2018-03-17 15:29:30', '2018-03-17 15:29:30', 'Y', '1', NULL, NULL, 'Y', NULL, NULL, '0', '1', 'I', NULL, 0),
(62, 'hello', NULL, NULL, NULL, 'helolo@gmail.com', NULL, '$2y$10$.6KVRO9kPR21MzossVvmne0HkuwFP/rWGt04bEHQu32OkMSRgMMpG', NULL, NULL, NULL, 'LII1521300788AOJ', NULL, '::1', '0', 'N', '', '', '', '', NULL, NULL, NULL, NULL, '2018-03-17 15:33:08', '2018-03-17 15:33:08', 'Y', '1', NULL, NULL, 'Y', NULL, NULL, '0', '1', 'I', NULL, 0),
(63, 'ff', NULL, NULL, NULL, 'ff@gmail.com', NULL, '$2y$10$ZkhwDr4jW0QyrOEOkbryz.jWRtiyXwkeR8l15qijbOtcw.eQouyBm', NULL, NULL, NULL, 'OIO1521300846GDM', NULL, '::1', '0', 'N', '', '', '', '', NULL, NULL, NULL, NULL, '2018-03-17 15:34:21', '2018-03-17 15:34:06', 'Y', '1', NULL, NULL, 'Y', NULL, NULL, '1', '1', 'I', '2018-03-17 15:34:21', 0),
(64, 'Anonymous Group', NULL, NULL, NULL, 'anonymousgroup@learneron.net', NULL, '$2y$10$wAJDsZ0mls.G7BNkI8J1h.CsCE5MDLsM/llfGWMpp6LdVgdW0DL.O', 'Anonymous Group', NULL, NULL, NULL, NULL, '::1', '0', 'N', '', '', '', '', NULL, NULL, NULL, NULL, '2018-04-11 21:43:13', '2018-03-17 15:36:32', 'Y', '1', NULL, NULL, 'Y', NULL, NULL, '0', '1', 'I', '2018-04-11 21:43:13', 0),
(65, 'Anonymous-4', 'user_no_image.png', NULL, NULL, 'anonymous-4@learneron.net', NULL, '$2y$10$9ATCBjjAhW2a48W.gcZLP.WYT7AIApUr8uA/I8p0oLrsq4u/nQBb6', 'Anonymous User', NULL, NULL, NULL, NULL, NULL, '0', 'N', '', '', '', '', NULL, NULL, NULL, NULL, '2018-04-11 21:20:23', '2018-03-17 15:39:13', 'Y', '1', NULL, NULL, 'Y', NULL, NULL, '0', '1', 'I', '2018-04-11 21:20:23', 0),
(66, 'Anonymous-3', 'user_no_image.png', NULL, NULL, 'anonymous-3@learneron.net', NULL, '$2y$10$fw77pXM5NFfn9jT5fpTGx.LTPR7ZJMZH3SoOihPb3xNNG6QIhlbkS', 'Anonymous User', NULL, NULL, 'GUH1521301339ZMD', NULL, NULL, '0', 'N', '', '', '', '', NULL, NULL, NULL, NULL, '2018-04-07 03:19:46', '2018-03-17 15:42:19', 'Y', '1', NULL, NULL, 'Y', NULL, NULL, '0', '1', 'I', '2018-04-07 03:19:46', 0),
(67, 'Anonymous-2', 'user_no_image.png', NULL, NULL, 'anonymous-2@learneron.net', NULL, '$2y$10$lGVt658ycXjWuoVXWdGmfu1NvPfw8CnkIoGYowLNmqGHZGbb8FDZy', 'Anonymous User', NULL, NULL, 'WMF1521301400BBW', NULL, NULL, '0', 'N', '', '', '', '', NULL, NULL, NULL, NULL, '2018-04-07 03:18:42', '2018-03-17 15:43:20', 'Y', '1', NULL, NULL, 'Y', NULL, NULL, '0', '1', 'I', '2018-04-07 03:18:42', 0),
(68, 'Anonymous-1', 'user_no_image.png', NULL, NULL, 'anonymous-1@learneron.net', NULL, '$2y$10$UqCj9se7Fw83NQpkbWxmq.JyMHol/.Rgm5lMp9zg1lvv5gQyaLgDO', 'Anonymous User', NULL, NULL, NULL, NULL, NULL, '0', 'N', '', '', '', '', NULL, NULL, NULL, NULL, '2018-04-11 20:58:55', '2018-03-17 15:46:21', 'Y', '1', NULL, NULL, 'Y', NULL, NULL, '0', '1', 'I', '2018-04-11 20:58:55', 0),
(76, 'ytutyu', NULL, '', '', 'yy@gmail.com', NULL, '$2y$10$6j714wpEA87xZ56gFiYL5uye1vBwi.yrQGBcrio.UNAwIh5GpiEY2', '', NULL, '', NULL, NULL, '::1', '1', 'N', '', '', '', '', '', '', '', '', '2018-05-05 21:02:15', '2018-05-05 20:42:33', 'Y', '1', '2018-05-05 20:48:55', NULL, 'N', '2018-05-05 20:42:33', '2018-05-05 20:48:55', '0', '0', 'A', '2018-05-06 18:06:15', 0),
(77, 'Anonymous Group', 'user_no_image.png', '', '', 'anonymousgroup@learneron.net', NULL, '$2y$10$rDg./eCb965qTl47Dlazzu.pGZu0M2zbfkDXZFRxfuWPX.O3aMut.', 'Anonymous Group', '0000-00-00', '', '', NULL, '::1', '0', 'N', '', '', '', '', '', '', '', '', '2018-05-15 19:31:02', '2018-05-14 17:42:47', 'Y', '1', '2018-05-15 19:31:02', '2018-05-14 17:42:47', 'Y', '2018-05-15 19:31:02', NULL, '0', '0', 'A', '2018-10-05 18:38:24', 0);

-- --------------------------------------------------------

--
-- Table structure for table `learn_user_account_settings`
--

CREATE TABLE `learn_user_account_settings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Id from User table',
  `response_to_my_question_notification` enum('1','0') NOT NULL DEFAULT '0' COMMENT '1=>Get notification, 0=>No notification',
  `news_notification` enum('1','0') NOT NULL DEFAULT '0' COMMENT '1=>Get notification, 0=>No notification',
  `follow_twitter` enum('1','0') NOT NULL DEFAULT '0' COMMENT '1=>Follow, 0=>No follow',
  `posting_new_question_notification` enum('1','0') NOT NULL DEFAULT '0' COMMENT '1=>Get notification, 0=>No notification',
  `category_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_user_account_settings`
--

INSERT INTO `learn_user_account_settings` (`id`, `user_id`, `response_to_my_question_notification`, `news_notification`, `follow_twitter`, `posting_new_question_notification`, `category_id`, `created`, `modified`) VALUES
(4, 27, '1', '1', '1', '1', 20, '2017-09-07 18:50:24', '2018-02-13 17:32:35'),
(5, 76, '1', '1', '1', '0', 0, '2018-05-05 21:02:26', '2018-05-05 21:02:26');

-- --------------------------------------------------------

--
-- Table structure for table `learn_visitors`
--

CREATE TABLE `learn_visitors` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'User id from "users" table',
  `user_ipaddress` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_visitors`
--

INSERT INTO `learn_visitors` (`id`, `user_id`, `user_ipaddress`) VALUES
(1, 0, '::1'),
(2, 1, '::1'),
(3, 27, '::1'),
(4, 69, '::1'),
(5, 76, '::1'),
(6, 77, '::1');

-- --------------------------------------------------------

--
-- Table structure for table `learn_visitor_logs`
--

CREATE TABLE `learn_visitor_logs` (
  `id` int(11) NOT NULL,
  `visitor_id` int(11) NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `page_url` varchar(255) DEFAULT NULL,
  `controller` varchar(255) NOT NULL,
  `method` varchar(255) NOT NULL,
  `news_id` int(11) DEFAULT NULL COMMENT 'News table id',
  `news_category_id` int(11) DEFAULT NULL COMMENT 'News Category table id',
  `user_id` int(11) DEFAULT NULL COMMENT 'User table id',
  `question_id` int(11) DEFAULT NULL COMMENT 'Question table id',
  `question_category_id` int(11) DEFAULT NULL COMMENT 'Question Category table id',
  `answer_id` int(11) DEFAULT NULL COMMENT 'Question Answer table id',
  `tag_id` int(11) DEFAULT NULL COMMENT 'Tag table id',
  `visited_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_visitor_logs`
--

INSERT INTO `learn_visitor_logs` (`id`, `visitor_id`, `page_name`, `page_url`, `controller`, `method`, `news_id`, `news_category_id`, `user_id`, `question_id`, `question_category_id`, `answer_id`, `tag_id`, `visited_time`) VALUES
(2, 1, '', 'http://localhost/learneron/faqs', 'Sites', 'faqs', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-03-22 18:36:29'),
(3, 1, '', 'http://localhost/learneron/privacy', 'Sites', 'privacy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-03-22 18:36:36'),
(4, 1, '', 'http://localhost/learneron/post-question', 'Questions', 'postQuestion', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-03-22 19:58:59'),
(5, 2, '', 'http://localhost/learneron/post-question', 'Questions', 'postQuestion', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-03-22 19:59:09'),
(6, 2, '', 'http://localhost/learneron/view-submissions', 'Users', 'viewSubmissions', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-03-22 19:59:25'),
(7, 1, '', 'http://localhost/learneron/', 'Sites', 'homePage', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-03-23 18:49:43'),
(8, 1, '', 'http://localhost/learneron/login', 'Users', 'login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-03-23 18:49:46'),
(9, 1, '', 'http://localhost/learneron/users/login/', 'Users', 'login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-03-23 18:49:52'),
(11, 2, '', 'http://localhost/learneron/view-submissions', 'Users', 'viewSubmissions', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-03-23 18:49:58'),
(12, 2, '', 'http://localhost/learneron/questions', 'Questions', 'allQuestions', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-03-23 20:12:46'),
(13, 2, '', 'http://localhost/learneron/questions/details/MTA%3D', 'Questions', 'details', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-03-23 20:13:03'),
(14, 2, '', 'http://localhost/learneron/', 'Sites', 'homePage', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-03-23 20:21:06'),
(26, 1, 'News Details', 'http://localhost/learneron/news/details/kids-movie-kunfu-1', 'News', 'details', 5, NULL, NULL, NULL, NULL, NULL, NULL, '2018-03-24 03:24:43'),
(27, 1, 'News Category', 'http://localhost/learneron/news/category/business', 'News', 'category', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-03-24 03:53:16'),
(28, 1, 'More News From Category', 'http://localhost/learneron/news/search_category_news/business', 'News', 'searchCategoryNews', 22, NULL, NULL, NULL, NULL, NULL, NULL, '2018-03-24 03:55:38'),
(29, 1, 'News Details', 'http://localhost/learneron/news/details/todays-news', 'News', 'details', 6, NULL, NULL, NULL, NULL, NULL, NULL, '2018-03-24 03:56:04'),
(30, 1, 'News Category', 'http://localhost/learneron/news/category/new-cat', 'News', 'category', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-03-24 03:56:18'),
(31, 1, 'News Category', 'http://localhost/learneron/news/category/marketing', 'News', 'category', NULL, 24, NULL, NULL, NULL, NULL, NULL, '2018-03-24 04:08:35'),
(33, 1, 'More News From Category', 'http://localhost/learneron/news/search_category_news/marketing', 'News', 'searchCategoryNews', NULL, 24, NULL, NULL, NULL, NULL, NULL, '2018-03-24 04:14:29'),
(34, 1, 'News Details', 'http://localhost/learneron/news/details/test', 'News', 'details', 2, NULL, NULL, NULL, NULL, NULL, NULL, '2018-03-24 04:15:09'),
(38, 2, '', 'http://localhost/learneron/view-submissions', 'Users', 'viewSubmissions', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-03-24 04:37:33'),
(39, 2, '', 'http://localhost/learneron/edit-submitted-news-comment/NQ%3D%3D', 'News', 'editSubmittedNewsComment', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-03-24 04:37:39'),
(40, 1, 'Users Listing', 'http://localhost/learneron/users', 'Users', 'allUsers', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-03-24 05:21:33'),
(41, 1, 'More Users', 'http://localhost/learneron/users/search', 'Users', 'search', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-03-24 05:25:53'),
(43, 1, '', 'http://localhost/learneron/', 'Sites', 'homePage', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-03-24 05:38:02'),
(46, 1, '', 'http://localhost/learneron/signup', 'Users', 'signup', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-03-24 05:41:31'),
(47, 1, 'Login', 'http://localhost/learneron/users/login/', 'Users', 'login', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-03-24 05:49:49'),
(48, 1, '', 'http://localhost/learneron/login', 'Users', 'login', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-03-24 06:25:40'),
(49, 2, 'Logout', 'http://localhost/learneron/logout', 'Users', 'logout', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-03-24 06:30:46'),
(52, 2, 'My Account', 'http://localhost/learneron/my-account', 'Users', 'myAccount', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-03-24 06:48:57'),
(55, 2, 'Edit Profile', 'http://localhost/learneron/edit-profile', 'Users', 'editProfile', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-03-24 06:58:37'),
(60, 2, 'Question Submission', 'http://localhost/learneron/questions/post-question-submission/', 'Questions', 'postQuestionSubmission', NULL, NULL, 27, 12, NULL, NULL, NULL, '2018-03-24 14:58:07'),
(62, 2, 'Latest Question Listing', 'http://localhost/learneron/questions', 'Questions', 'allQuestions', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-03-24 15:14:17'),
(64, 2, 'More Latest Question Listing', 'http://localhost/learneron/questions/latestquestions_search/', 'Questions', 'latestquestionsSearch', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-03-24 15:18:00'),
(65, 2, 'Most Viewed Question Listing', 'http://localhost/learneron/most-viewed-questions', 'Questions', 'mostViewedQuestions', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-03-24 15:20:26'),
(66, 2, 'More Most Viewed Question Listing', 'http://localhost/learneron/questions/mostviewed_questions_search', 'Questions', 'mostviewedQuestionsSearch', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-03-24 15:20:34'),
(67, 2, 'Unanswered Question Listing', 'http://localhost/learneron/un-answered-questions', 'Questions', 'unAnsweredQuestions', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-03-24 15:25:08'),
(68, 2, 'More Unanswered Question Listing', 'http://localhost/learneron/questions/unanswered_questions_search', 'Questions', 'unansweredQuestionsSearch', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-03-24 15:29:17'),
(74, 2, 'Question Category', 'http://localhost/learneron/category/category-2', 'Questions', 'questionCategory', NULL, NULL, 27, NULL, 19, NULL, NULL, '2018-03-24 15:51:40'),
(76, 2, 'More Question From Category', 'http://localhost/learneron/questions/questioncategory_search/category-2', 'Questions', 'questioncategorySearch', NULL, NULL, 27, NULL, 19, NULL, NULL, '2018-03-24 15:54:35'),
(77, 2, 'Question Details', 'http://localhost/learneron/questions/details/MTA%3D', 'Questions', 'details', NULL, NULL, 27, 10, NULL, NULL, NULL, '2018-03-24 16:09:10'),
(79, 2, 'Question Answer Submission', 'http://localhost/learneron/questions/post-question-answer/', 'Questions', 'postQuestionAnswer', NULL, NULL, 27, 10, NULL, NULL, NULL, '2018-03-24 16:10:21'),
(80, 2, 'Question Comment Submission', 'http://localhost/learneron/questions/post-question-comment/', 'Questions', 'postQuestionComment', NULL, NULL, 27, 10, NULL, NULL, NULL, '2018-03-24 16:13:21'),
(81, 2, 'Answer Comment Submission', 'http://localhost/learneron/questions/post-answer-comment/', 'Questions', 'postAnswerComment', NULL, NULL, 27, 10, NULL, 12, NULL, '2018-03-24 16:23:37'),
(84, 2, 'Edited Question', 'http://localhost/learneron/edit-submitted-question-comment/MTA%3D', 'Questions', 'editSubmittedQuestion', NULL, NULL, 27, 10, NULL, NULL, NULL, '2018-03-24 16:58:36'),
(87, 2, 'Tag Related Question', 'http://localhost/learneron/tag/android', 'Questions', 'questionTag', NULL, NULL, 27, NULL, NULL, NULL, 1, '2018-03-24 17:08:04'),
(88, 2, 'Edited Question Answer', 'http://localhost/learneron/edit-submitted-question-answer/MTg%3D', 'Questions', 'editSubmittedQuestionAnswer', NULL, NULL, 27, 10, NULL, NULL, NULL, '2018-03-24 17:53:21'),
(89, 2, 'index', 'http://localhost/learneron/', 'Sites', 'homePage', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-03-24 17:57:42'),
(90, 2, 'Tag Listing', 'http://localhost/learneron/tags', 'Tags', 'index', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-03-24 18:19:20'),
(91, 1, 'Front Page', 'http://localhost/learneron/', 'Sites', 'homePage', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-03-25 04:00:01'),
(92, 1, 'Latest Question Listing', 'http://localhost/learneron/questions', 'Questions', 'allQuestions', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-03-25 10:00:52'),
(93, 1, 'Question Details', 'http://localhost/learneron/questions/details/OA%3D%3D', 'Questions', 'details', NULL, NULL, NULL, 8, NULL, NULL, NULL, '2018-03-25 10:01:00'),
(94, 1, 'Front Page', 'http://localhost/learneron/', 'Sites', 'homePage', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-03 19:43:18'),
(95, 2, '', 'http://localhost/learneron/view-submissions', 'Users', 'viewSubmissions', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-04-03 20:33:42'),
(96, 2, 'Edited Question', 'http://localhost/learneron/edit-submitted-question/MTI%3D', 'Questions', 'editSubmittedQuestion', NULL, NULL, 27, 12, NULL, NULL, NULL, '2018-04-03 20:36:12'),
(97, 1, 'Front Page', 'http://localhost/learneron/', 'Sites', 'homePage', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-04 17:40:31'),
(98, 1, 'Question Details', 'http://localhost/learneron/questions/details/MTI%3D', 'Questions', 'details', NULL, NULL, NULL, 12, NULL, NULL, NULL, '2018-04-04 17:43:47'),
(99, 1, 'Front Page', 'http://localhost/learneron/', 'Sites', 'homePage', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-05 18:18:33'),
(100, 1, 'Latest Question Listing', 'http://localhost/learneron/questions', 'Questions', 'allQuestions', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-05 18:18:58'),
(101, 1, 'Front Page', 'http://localhost/learneron/', 'Sites', 'homePage', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-06 18:57:26'),
(102, 1, 'About Us', 'http://localhost/learneron/about-us', 'Sites', 'aboutUs', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-06 20:30:51'),
(103, 1, 'Front Page', 'http://localhost/learneron/', 'Sites', 'homePage', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-07 17:04:46'),
(104, 1, 'Login', 'http://localhost/learneron/users/login/', 'Users', 'login', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-04-07 17:04:54'),
(105, 2, 'My Account', 'http://localhost/learneron/my-account', 'Users', 'myAccount', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-04-07 17:04:55'),
(106, 2, '', 'http://localhost/learneron/view-submissions', 'Users', 'viewSubmissions', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-04-07 17:05:01'),
(107, 1, 'Front Page', 'http://localhost/learneron/', 'Sites', 'homePage', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-08 03:40:37'),
(108, 1, 'Login', 'http://localhost/learneron/users/login/', 'Users', 'login', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-04-08 03:40:50'),
(109, 3, 'My Account', 'http://localhost/learneron/my-account', 'Users', 'myAccount', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-04-08 03:40:51'),
(110, 3, '', 'http://localhost/learneron/view-submissions', 'Users', 'viewSubmissions', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-04-08 03:40:55'),
(111, 3, 'Front Page', 'http://localhost/learneron/', 'Sites', 'homePage', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-04-08 03:49:33'),
(112, 3, 'Most Viewed Question Listing For Home Page', 'http://localhost/learneron/most-viewed', 'Sites', 'mostViewed', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-04-08 03:52:38'),
(113, 3, 'Edit Profile', 'http://localhost/learneron/edit-profile', 'Users', 'editProfile', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-04-08 07:41:18'),
(114, 1, 'Front Page', 'http://localhost/learneron/', 'Sites', 'homePage', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-11 17:15:28'),
(115, 1, 'Login', 'http://localhost/learneron/users/login/', 'Users', 'login', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-04-11 18:09:32'),
(116, 3, 'My Account', 'http://localhost/learneron/my-account', 'Users', 'myAccount', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-04-11 18:09:32'),
(117, 3, 'Logout', 'http://localhost/learneron/logout', 'Users', 'logout', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-04-11 18:09:36'),
(118, 1, 'Front Page', 'http://localhost/learneron/', 'Sites', 'homePage', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-12 19:24:08'),
(119, 1, 'Login', 'http://localhost/learneron/users/login/', 'Users', 'login', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-04-12 19:24:19'),
(120, 3, 'My Account', 'http://localhost/learneron/my-account', 'Users', 'myAccount', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-04-12 19:24:20'),
(121, 3, 'Edit Profile', 'http://localhost/learneron/edit-profile', 'Users', 'editProfile', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-04-12 19:24:23'),
(122, 3, 'Front Page', 'http://localhost/learneron/', 'Sites', 'homePage', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-04-12 19:39:34'),
(123, 3, 'Update Profile', 'http://localhost/learneron/users/update-profile/', 'Users', 'updateProfile', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-04-12 19:40:33'),
(124, 1, 'Front Page', 'http://localhost/learneron/', 'Sites', 'homePage', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-16 18:19:57'),
(125, 1, 'Signup', 'http://localhost/learneron/users/signup/', 'Users', 'signup', NULL, NULL, 69, NULL, NULL, NULL, NULL, '2018-04-16 20:52:30'),
(126, 1, 'Login', 'http://localhost/learneron/users/login/', 'Users', 'login', NULL, NULL, 69, NULL, NULL, NULL, NULL, '2018-04-16 20:56:16'),
(127, 4, 'My Account', 'http://localhost/learneron/my-account', 'Users', 'myAccount', NULL, NULL, 69, NULL, NULL, NULL, NULL, '2018-04-16 20:56:17'),
(128, 4, 'Logout', 'http://localhost/learneron/logout', 'Users', 'logout', NULL, NULL, 69, NULL, NULL, NULL, NULL, '2018-04-16 20:56:28'),
(129, 1, 'Front Page', 'http://localhost/learneron/', 'Sites', 'homePage', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-17 19:59:44'),
(130, 1, 'Login', 'http://localhost/learneron/users/login/', 'Users', 'login', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-04-17 20:15:36'),
(131, 3, 'My Account', 'http://localhost/learneron/my-account', 'Users', 'myAccount', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-04-17 20:15:36'),
(132, 3, 'Update Account Setting', 'http://localhost/learneron/users/account-setting/', 'Users', 'accountSetting', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-04-17 20:31:11'),
(133, 1, 'Front Page', 'http://localhost/learneron/', 'Sites', 'homePage', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-18 17:56:12'),
(134, 1, 'News Listing', 'http://localhost/learneron/news', 'News', 'newsListing', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-18 17:56:18'),
(135, 1, 'About Us', 'http://localhost/learneron/about-us', 'Sites', 'aboutUs', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-04-18 17:56:23'),
(136, 1, 'Front Page', 'http://localhost/learneron/', 'Sites', 'homePage', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-05-01 14:56:30'),
(137, 1, 'Contact Us', 'http://localhost/learneron/contact-us', 'Sites', 'contactUs', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-05-01 15:58:00'),
(138, 1, 'About Us', 'http://localhost/learneron/about-us', 'Sites', 'aboutUs', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-05-01 15:58:45'),
(139, 1, 'Front Page', 'http://localhost/learneron/', 'Sites', 'homePage', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-05-05 16:49:04'),
(140, 1, 'About Us', 'http://localhost/learneron/about-us', 'Sites', 'aboutUs', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-05-05 19:31:38'),
(141, 1, 'Login', 'http://localhost/learneron/users/login/', 'Users', 'login', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-05-05 20:12:33'),
(142, 3, 'My Account', 'http://localhost/learneron/my-account', 'Users', 'myAccount', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-05-05 20:12:33'),
(143, 3, 'Edit Profile', 'http://localhost/learneron/edit-profile', 'Users', 'editProfile', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-05-05 20:12:41'),
(144, 3, 'Logout', 'http://localhost/learneron/logout', 'Users', 'logout', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-05-05 20:16:42'),
(145, 1, 'Signup', 'http://localhost/learneron/users/signup/', 'Users', 'signup', NULL, NULL, 71, NULL, NULL, NULL, NULL, '2018-05-05 20:29:56'),
(146, 5, 'My Account', 'http://localhost/learneron/my-account', 'Users', 'myAccount', NULL, NULL, 76, NULL, NULL, NULL, NULL, '2018-05-05 21:02:13'),
(147, 5, 'Update Account Setting', 'http://localhost/learneron/users/account-setting/', 'Users', 'accountSetting', NULL, NULL, 76, NULL, NULL, NULL, NULL, '2018-05-05 21:02:26'),
(148, 1, 'Front Page', 'http://localhost/learneron/', 'Sites', 'homePage', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-05-06 18:06:16'),
(149, 1, 'Login', 'http://localhost/learneron/users/login/', 'Users', 'login', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-05-06 18:06:25'),
(150, 3, 'My Account', 'http://localhost/learneron/my-account', 'Users', 'myAccount', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-05-06 18:06:25'),
(151, 1, 'Front Page', 'http://localhost/learneron/', 'Sites', 'homePage', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-05-14 17:17:47'),
(152, 1, 'Login', 'http://localhost/learneron/users/login/', 'Users', 'login', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-05-14 17:18:07'),
(153, 3, 'My Account', 'http://localhost/learneron/my-account', 'Users', 'myAccount', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-05-14 17:18:07'),
(154, 3, 'Logout', 'http://localhost/learneron/logout', 'Users', 'logout', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-05-14 17:41:26'),
(155, 1, 'Signup', 'http://localhost/learneron/users/signup/', 'Users', 'signup', NULL, NULL, 77, NULL, NULL, NULL, NULL, '2018-05-14 17:42:47'),
(156, 6, 'My Account', 'http://localhost/learneron/my-account', 'Users', 'myAccount', NULL, NULL, 77, NULL, NULL, NULL, NULL, '2018-05-14 17:44:38'),
(157, 1, 'Front Page', 'http://localhost/learneron/', 'Sites', 'homePage', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-05-21 04:44:10'),
(158, 1, 'Contact Us', 'http://localhost/learneron/contact-us', 'Sites', 'contactUs', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-05-28 18:45:55'),
(159, 1, 'Front Page', 'http://localhost/learneron/', 'Sites', 'homePage', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-06-17 17:08:23'),
(160, 1, 'News Listing', 'http://localhost/learneron/news', 'News', 'newsListing', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-06-17 17:08:27'),
(161, 1, 'Front Page', 'http://localhost/learneron/', 'Sites', 'homePage', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-10-04 19:17:43'),
(162, 1, 'Front Page', 'http://localhost/learneron/', 'Sites', 'homePage', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-10-05 16:12:39'),
(163, 1, 'Front Page', 'http://localhost/learneron/', 'Sites', 'homePage', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-10-06 07:56:33'),
(164, 1, 'Login', 'http://localhost/learneron/users/login/', 'Users', 'login', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-10-06 07:57:19'),
(165, 3, 'My Account', 'http://localhost/learneron/my-account', 'Users', 'myAccount', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-10-06 07:57:19'),
(166, 3, 'Question Submission', 'http://localhost/learneron/questions/post-question-submission/', 'Questions', 'postQuestionSubmission', NULL, NULL, 27, 13, NULL, NULL, NULL, '2018-10-06 16:26:38'),
(167, 3, '', 'http://localhost/learneron/view-submissions', 'Users', 'viewSubmissions', NULL, NULL, 27, NULL, NULL, NULL, NULL, '2018-10-06 16:37:46'),
(168, 3, 'Edited Question', 'http://localhost/learneron/edit-submitted-question/MTk%3D', 'Questions', 'editSubmittedQuestion', NULL, NULL, 27, 19, NULL, NULL, NULL, '2018-10-06 16:37:54'),
(169, 3, 'Edited Question', 'http://localhost/learneron/edit-submitted-question/MjA%3D', 'Questions', 'editSubmittedQuestion', NULL, NULL, 27, 20, NULL, NULL, NULL, '2018-10-06 16:40:16'),
(170, 1, 'More Latest Question Listing For Home Page', 'http://localhost/learneron/sites/latestquestions_search', 'Sites', 'latestquestionsSearch', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-10-06 16:46:01'),
(171, 1, 'Front Page', 'http://localhost/learneron/', 'Sites', 'homePage', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-10-08 17:51:17'),
(172, 1, 'Front Page', 'http://localhost/learneron/', 'Sites', 'homePage', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-10-09 17:05:47'),
(173, 1, 'Front Page', 'http://localhost/learneron/', 'Sites', 'homePage', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-10-22 17:52:06'),
(174, 1, 'About Us', 'http://localhost/learneron/about-us', 'Sites', 'aboutUs', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-10-22 18:02:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `learn_admins`
--
ALTER TABLE `learn_admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learn_admin_menus`
--
ALTER TABLE `learn_admin_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learn_admin_permisions`
--
ALTER TABLE `learn_admin_permisions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learn_advertisements`
--
ALTER TABLE `learn_advertisements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learn_anonymous_users`
--
ALTER TABLE `learn_anonymous_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learn_answer_comments`
--
ALTER TABLE `learn_answer_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learn_answer_upvotes`
--
ALTER TABLE `learn_answer_upvotes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learn_banner_sections`
--
ALTER TABLE `learn_banner_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learn_careereducations`
--
ALTER TABLE `learn_careereducations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learn_cms_pages`
--
ALTER TABLE `learn_cms_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learn_common_settings`
--
ALTER TABLE `learn_common_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learn_contacts`
--
ALTER TABLE `learn_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learn_contact_replies`
--
ALTER TABLE `learn_contact_replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learn_cookie_consents`
--
ALTER TABLE `learn_cookie_consents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learn_faqs`
--
ALTER TABLE `learn_faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learn_news`
--
ALTER TABLE `learn_news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learn_newsletter_subscriptions`
--
ALTER TABLE `learn_newsletter_subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learn_news_categories`
--
ALTER TABLE `learn_news_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learn_news_comments`
--
ALTER TABLE `learn_news_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learn_questions`
--
ALTER TABLE `learn_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learn_question_answers`
--
ALTER TABLE `learn_question_answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learn_question_categories`
--
ALTER TABLE `learn_question_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `learn_question_comments`
--
ALTER TABLE `learn_question_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learn_question_tags`
--
ALTER TABLE `learn_question_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learn_tags`
--
ALTER TABLE `learn_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learn_terms`
--
ALTER TABLE `learn_terms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learn_users`
--
ALTER TABLE `learn_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learn_user_account_settings`
--
ALTER TABLE `learn_user_account_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learn_visitors`
--
ALTER TABLE `learn_visitors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learn_visitor_logs`
--
ALTER TABLE `learn_visitor_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `learn_admins`
--
ALTER TABLE `learn_admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `learn_admin_menus`
--
ALTER TABLE `learn_admin_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;
--
-- AUTO_INCREMENT for table `learn_admin_permisions`
--
ALTER TABLE `learn_admin_permisions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;
--
-- AUTO_INCREMENT for table `learn_advertisements`
--
ALTER TABLE `learn_advertisements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `learn_anonymous_users`
--
ALTER TABLE `learn_anonymous_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `learn_answer_comments`
--
ALTER TABLE `learn_answer_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `learn_answer_upvotes`
--
ALTER TABLE `learn_answer_upvotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `learn_banner_sections`
--
ALTER TABLE `learn_banner_sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `learn_careereducations`
--
ALTER TABLE `learn_careereducations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `learn_cms_pages`
--
ALTER TABLE `learn_cms_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `learn_common_settings`
--
ALTER TABLE `learn_common_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `learn_contacts`
--
ALTER TABLE `learn_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `learn_contact_replies`
--
ALTER TABLE `learn_contact_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `learn_cookie_consents`
--
ALTER TABLE `learn_cookie_consents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `learn_faqs`
--
ALTER TABLE `learn_faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `learn_news`
--
ALTER TABLE `learn_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `learn_newsletter_subscriptions`
--
ALTER TABLE `learn_newsletter_subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `learn_news_categories`
--
ALTER TABLE `learn_news_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `learn_news_comments`
--
ALTER TABLE `learn_news_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `learn_questions`
--
ALTER TABLE `learn_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `learn_question_answers`
--
ALTER TABLE `learn_question_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `learn_question_categories`
--
ALTER TABLE `learn_question_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `learn_question_comments`
--
ALTER TABLE `learn_question_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `learn_question_tags`
--
ALTER TABLE `learn_question_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;
--
-- AUTO_INCREMENT for table `learn_tags`
--
ALTER TABLE `learn_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT for table `learn_terms`
--
ALTER TABLE `learn_terms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `learn_users`
--
ALTER TABLE `learn_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
--
-- AUTO_INCREMENT for table `learn_user_account_settings`
--
ALTER TABLE `learn_user_account_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `learn_visitors`
--
ALTER TABLE `learn_visitors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `learn_visitor_logs`
--
ALTER TABLE `learn_visitor_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
