-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2017 at 08:18 PM
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
  `type` varchar(2) DEFAULT 'AM' COMMENT 'SA=>super admin, AM=>merchant account manager',
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
(1, 'Admin', ' ', 'admin@learneron.com', 'admin@learneron.com', 'no-reply@learneron.com', '$2y$10$raU/4ebGf1ayQblLyJ.gne6xZ6ul.NHKbrk3UiobGKq312ag2PF8W', 'SA', '2017-07-16 00:00:00', '', '', '2017-07-16 00:00:00', '2017-07-16 00:00:00', 'A');

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

-- --------------------------------------------------------

--
-- Table structure for table `learn_cms_pages`
--

CREATE TABLE `learn_cms_pages` (
  `id` int(11) NOT NULL,
  `page_section` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(1) NOT NULL COMMENT 'A=>active,I=>inactive,D=>deleted',
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `use_referral` enum('Y','N') NOT NULL,
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_common_settings`
--

INSERT INTO `learn_common_settings` (`id`, `facebook_link`, `twitter_link`, `google_plus_link`, `linkedin`, `email`, `phone_number`, `address`, `footer_text`, `use_referral`, `modified`, `created`) VALUES
(1, 'https://www.facebook.com/', 'http://www.twitter.com', 'https://plus.google.com', 'http://www.linkedin.com', 'info@learneron.com', '', '', '', 'Y', '2017-05-09 08:17:18', '2016-11-25 14:54:50');

-- --------------------------------------------------------

--
-- Table structure for table `learn_contacts`
--

CREATE TABLE `learn_contacts` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone_number` varchar(30) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'A' COMMENT 'A=>Active, I=>Inactive',
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `learn_faqs`
--

CREATE TABLE `learn_faqs` (
  `id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `status` enum('A','I') NOT NULL DEFAULT 'A' COMMENT '''A'' => Active, ''I'' => Inactive',
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_faqs`
--

INSERT INTO `learn_faqs` (`id`, `question`, `slug`, `answer`, `status`, `modified`, `created`) VALUES
(4, 'When has discrete understanding preceded continuous?', 'when-has-discrete-understanding-preceded-continuous', 'When has discrete understanding preceded continuous', 'A', '2017-07-25 18:52:10', '2017-07-25 18:52:10'),
(5, 'What does the word \"ab\" mean?', 'what-does-the-word-ab-mean', 'What does the word \"ab\" mean', 'A', '2017-07-25 19:05:02', '2017-07-25 19:05:02'),
(6, 'Is facebook sdk(iOS) supporting ipv6?', 'is-facebook-sdk-ios-supporting-ipv6', 'Is facebook sdk(iOS) supporting ipv6', 'A', '2017-07-25 19:05:16', '2017-07-25 19:05:16'),
(7, 'What does the word \"ab\" mean?', 'what-does-the-word-ab-mean-1', 'What does the word \"ab\" mean', 'A', '2017-07-25 19:05:30', '2017-07-25 19:05:30');

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
  `status` enum('A','I') NOT NULL DEFAULT 'A',
  `view` int(11) DEFAULT NULL COMMENT 'total views',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_news`
--

INSERT INTO `learn_news` (`id`, `category_id`, `user_id`, `name`, `slug`, `description`, `image`, `meta_keywords`, `meta_description`, `status`, `view`, `created`, `modified`) VALUES
(1, 22, NULL, 'Test News', 'test-news-1', '<p>Test description<br></p>', 'news_image_150080972760.jpg', 'Test ', 'Test meta description', 'A', NULL, '2017-07-23 11:12:28', '2017-07-23 11:35:28');

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
  `status` enum('A','I') NOT NULL DEFAULT 'A' COMMENT 'A=>Active, I=>Inactive',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_news_categories`
--

INSERT INTO `learn_news_categories` (`id`, `parent_id`, `name`, `slug`, `status`, `created`, `modified`) VALUES
(22, 0, 'Category 1', 'category-1', 'A', '2017-07-20 20:57:05', '2017-07-21 20:11:17'),
(23, 0, 'Category 2', 'category-2', 'A', '2017-07-20 20:57:15', '2017-07-21 20:11:43'),
(24, 22, 'Category 11', 'category-11', 'A', '2017-07-21 19:49:15', '2017-07-21 20:12:19'),
(25, 23, 'Category 21', 'category-21', 'A', '2017-07-21 20:12:40', '2017-07-21 20:12:40'),
(26, 22, 'Category 12', 'category-12', 'A', '2017-07-21 20:12:50', '2017-07-21 20:12:50'),
(27, 22, 'Category 13', 'category-13', 'A', '2017-07-21 20:13:00', '2017-07-21 20:13:00'),
(28, 23, 'Category 22', 'category-22', 'A', '2017-07-21 20:13:10', '2017-07-21 20:13:10');

-- --------------------------------------------------------

--
-- Table structure for table `learn_questions`
--

CREATE TABLE `learn_questions` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL COMMENT 'Question Category Id from "question_categories" table',
  `user_id` int(11) NOT NULL COMMENT 'User id from "users" table',
  `name` text,
  `slug` text,
  `short_description` text,
  `learning_goal` text,
  `budget_constraints` text,
  `preferred_learning_mode` text NOT NULL,
  `response_email` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '''Y'' => Need update through email, ''U'' => Not needed',
  `is_featured` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'Featured question ot not',
  `user_type` enum('A','U') NOT NULL DEFAULT 'U' COMMENT '''A'' => Admin, ''U'' => Users',
  `status` enum('A','I') NOT NULL DEFAULT 'A',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `learn_question_answers`
--

CREATE TABLE `learn_question_answers` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL COMMENT 'Question Id from "question" table',
  `user_id` int(11) NOT NULL COMMENT 'User Id from "users" table',
  `learning_path_recommendation` text NOT NULL,
  `learning_experience` text NOT NULL,
  `learning_utility` text NOT NULL,
  `answer` text NOT NULL,
  `status` enum('A','I') NOT NULL DEFAULT 'I',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `learn_question_categories`
--

CREATE TABLE `learn_question_categories` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `status` enum('A','I') NOT NULL DEFAULT 'A' COMMENT '''A'' => Active, ''I'' => Inactive',
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `learn_question_categories`
--

INSERT INTO `learn_question_categories` (`id`, `parent_id`, `name`, `slug`, `status`, `modified`, `created`) VALUES
(1, 0, 'Business', 'business', 'A', '2017-07-23 11:07:20', '2017-07-23 11:07:20');

-- --------------------------------------------------------

--
-- Table structure for table `learn_question_tags`
--

CREATE TABLE `learn_question_tags` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL COMMENT 'Question Id from "questions" table',
  `tag_id` int(11) NOT NULL COMMENT 'Tag Id from "tags" table'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `learn_tags`
--

CREATE TABLE `learn_tags` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `status` enum('A','I') NOT NULL DEFAULT 'A' COMMENT 'A=>Active, I=>Inactive',
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `password` varchar(200) DEFAULT NULL COMMENT 'Hashed password',
  `full_name` varchar(100) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `about_me` text,
  `signup_string` varchar(200) DEFAULT NULL COMMENT 'string used to verify the signup users email',
  `forget_password_string` varchar(200) DEFAULT NULL COMMENT 'string used to verify the account owner',
  `signup_ip` varchar(50) DEFAULT NULL COMMENT 'ip from where account was created',
  `is_verified` varchar(1) DEFAULT 'N' COMMENT 'is the user verified by admin. Y=>yes, N=>No',
  `type` varchar(1) DEFAULT NULL COMMENT '''F'' => Facebook, ''N'' => Normal',
  `facebook_id` varchar(255) NOT NULL,
  `facebook_link` varchar(255) DEFAULT NULL,
  `twitter_link` varchar(255) DEFAULT NULL,
  `gplus_link` varchar(255) DEFAULT NULL,
  `linkedin_link` varchar(255) DEFAULT NULL,
  `history_type` enum('C','E') NOT NULL DEFAULT 'E' COMMENT '''C'' => Career, ''E'' => Education Type',
  `modified` datetime NOT NULL COMMENT 'update time',
  `created` datetime NOT NULL COMMENT 'insert time',
  `agree` enum('Y','N') NOT NULL DEFAULT 'Y',
  `status` enum('A','I') NOT NULL DEFAULT 'I' COMMENT 'A=>active, I=>inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `learn_admins`
--
ALTER TABLE `learn_admins`
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
-- Indexes for table `learn_users`
--
ALTER TABLE `learn_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `learn_admins`
--
ALTER TABLE `learn_admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `learn_careereducations`
--
ALTER TABLE `learn_careereducations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `learn_cms_pages`
--
ALTER TABLE `learn_cms_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `learn_common_settings`
--
ALTER TABLE `learn_common_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `learn_contacts`
--
ALTER TABLE `learn_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `learn_faqs`
--
ALTER TABLE `learn_faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `learn_news`
--
ALTER TABLE `learn_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `learn_newsletter_subscriptions`
--
ALTER TABLE `learn_newsletter_subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `learn_news_categories`
--
ALTER TABLE `learn_news_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `learn_questions`
--
ALTER TABLE `learn_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `learn_question_answers`
--
ALTER TABLE `learn_question_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `learn_question_categories`
--
ALTER TABLE `learn_question_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `learn_question_tags`
--
ALTER TABLE `learn_question_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `learn_tags`
--
ALTER TABLE `learn_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `learn_users`
--
ALTER TABLE `learn_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
