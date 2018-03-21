-- Adminer 4.2.3 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `learn_admins`;
CREATE TABLE `learn_admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `status` varchar(2) NOT NULL COMMENT 'A=>Active,I=>Inactive,V=>Verified,NV=>not-verified,D=>deleted',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `learn_admins` (`id`, `first_name`, `last_name`, `email`, `contact_email`, `mail_email`, `password`, `type`, `last_login_date`, `forget_password_string`, `signup_string`, `modified`, `created`, `status`) VALUES
(1,	'Sukanta',	' Sarkar ',	'administrator@learneron.net',	'administrator@learneron.net',	'no-reply@learneron.com',	'$2y$10$raU/4ebGf1ayQblLyJ.gne6xZ6ul.NHKbrk3UiobGKq312ag2PF8W',	'SA',	'2017-07-16 00:00:00',	'',	'',	'2017-12-10 13:14:40',	'2017-07-16 00:00:00',	'A'),
(2,	'Mitkar',	'Ghosh ',	'100websolution11@gmail.com',	'100websolution11@gmail.com',	'no-reply@learneron.com',	'$2y$10$raU/4ebGf1ayQblLyJ.gne6xZ6ul.NHKbrk3UiobGKq312ag2PF8W',	'SA',	'2017-08-01 00:00:00',	'',	'',	'2017-07-31 20:47:19',	'2017-08-01 00:00:00',	'A'),
(3,	'Dweyne',	'Smith',	'smith@gmail.com',	'smith@gmail.com',	'smith@gmail.com',	'$2y$10$K/2dGiKxYAwrzqXnb9g4vetG4u40vGkHuJz0a/cTa0PR5sb6HP7Xy',	'A',	'2017-10-24 19:36:54',	'',	'',	'2017-10-25 20:19:49',	'2017-10-24 19:36:54',	'A'),
(4,	'Dean',	'Jones',	'dean@gmail.com',	'dean@gmail.com',	'dean@gmail.com',	'$2y$10$x0KlcFFHcXg1JOKDOmH3ouoQwkLe35trpA/7936CPPuYKlScYsGKS',	'A',	'2017-10-25 19:46:23',	'',	'',	'2017-10-25 19:46:23',	'2017-10-25 19:46:23',	'A'),
(5,	'Sanja',	'kar',	'100websolution@gmail.com',	'100websolution@gmail.com',	'100websolution@gmail.com',	'$2y$10$PfftTL98CtGdLMf640SUB.Hjkm3mfwjA/EvMBMbAMTVrq1J8u70ym',	'A',	'2017-10-27 19:36:53',	'',	'',	'2017-10-27 19:36:53',	'2017-10-27 19:36:53',	'A'),
(6,	'Sukanta',	'Sarkar',	'sukanta.info2@gmail.com',	'sukanta.info2@gmail.com',	'sukanta.info2@gmail.com',	'$2y$10$ehY8Yx0AaDV1tqfAuUs6eevMzKwh/Chu3xnjs.Z9fiJcwzGbpOKj2',	'A',	'2017-10-30 19:23:03',	'',	'',	'2017-10-30 19:23:03',	'2017-10-30 19:23:03',	'A'),
(7,	'aaa',	'Learner1',	'spinskillsup@gmail.com',	'spinskillsup@gmail.com',	'spinskillsup@gmail.com',	'$2y$10$agSEyzHiggFOwBOJUQMBfeUEz/ZVkfQO7V60gIQ/1NuIcbOXcm5RG',	'A',	'2017-11-12 14:38:05',	'',	'',	'2017-11-12 14:38:05',	'2017-11-12 14:38:05',	'A');

DROP TABLE IF EXISTS `learn_admin_menus`;
CREATE TABLE `learn_admin_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `learn_admin_menus` (`id`, `main_menu_name`, `menu_name`, `menu_name_modified`, `parent_id`, `controller_name`, `method_name`, `sort_order`, `is_display`, `status`, `modified`, `created`) VALUES
(1,	'Manage Sub Admin',	'Manage Sub Admin',	'Manage Sub Admin',	0,	'AdminDetails',	'',	1,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(2,	'Manage Admin',	'View',	'View',	1,	'AdminDetails',	'list-sub-admin',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(3,	'Manage Admin',	'Add',	'Add',	1,	'AdminDetails',	'add-sub-admin',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(4,	'Manage Admin',	'Edit',	'Edit',	1,	'AdminDetails',	'edit-sub-admin',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(5,	'Manage Admin',	'Status',	'Status',	1,	'AdminDetails',	'change-status-subadmin',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(6,	'Manage Admin',	'Delete',	'Delete',	1,	'AdminDetails',	'delete-sub-admin',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(7,	'Manage Admin',	'ChangePassword',	'Change Password',	1,	'AdminDetails',	'sub-admin-change-password',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(8,	'User Management',	'User Management',	'User Management',	0,	'Users',	'',	2,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(9,	'User Management',	'View',	'View',	8,	'Users',	'list-data',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(10,	'User Management',	'Add',	'Add',	8,	'Users',	'add-user',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(11,	'User Management',	'Edit',	'Edit',	8,	'Users',	'edit-user',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(12,	'User Management',	'Status',	'Status',	8,	'Users',	'change-status',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(13,	'User Management',	'Delete',	'Delete',	8,	'Users',	'delete-user',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(14,	'User Management',	'AccountSetting',	'Account Setting',	8,	'Users',	'user-account-setting',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(15,	'User Management',	'ChangePassword',	'Change Password',	8,	'Users',	'user-change-password',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(16,	'User Management',	'SubmittedDetails',	'Submitted Details',	8,	'Users',	'user-submitted-details',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(17,	'Tags Management',	'Tags Management',	'Tags Management',	0,	'Tags',	'',	3,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(18,	'Tags Management',	'View',	'View',	17,	'Tags',	'list-data',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(19,	'Tags Management',	'Add',	'Add',	17,	'Tags',	'add-tag',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(20,	'Tags Management',	'Edit',	'Edit',	17,	'Tags',	'edit-tag',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(21,	'Tags Management',	'Status',	'Status',	17,	'Tags',	'change-status',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(22,	'Tags Management',	'Delete',	'Delete',	17,	'Tags',	'delete-tag',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(23,	'Question Categories',	'Question Categories',	'Question Categories',	0,	'QuestionCategories',	'',	4,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(24,	'Question Categories',	'View',	'View',	23,	'QuestionCategories',	'list-data',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(25,	'Question Categories',	'Add',	'Add',	23,	'QuestionCategories',	'add-question-category',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(26,	'Question Categories',	'Edit',	'Edit',	23,	'QuestionCategories',	'edit-question-category',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(27,	'Question Categories',	'Status',	'Status',	23,	'QuestionCategories',	'change-status',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(28,	'Question Categories',	'Delete',	'Delete',	23,	'QuestionCategories',	'delete-question-category',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(29,	'Questions',	'Questions',	'Questions',	0,	'Questions',	'',	5,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(30,	'Questions',	'View',	'View',	29,	'Questions',	'list-data',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(31,	'Questions',	'Add',	'Add',	29,	'Questions',	'add-question',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(32,	'Questions',	'Edit',	'Edit',	29,	'Questions',	'edit-question',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(33,	'Questions',	'Status',	'Status',	29,	'Questions',	'change-status',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(34,	'Questions',	'Delete',	'Delete',	29,	'Questions',	'delete-question',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(35,	'Question Answers',	'Question Answers',	'Question Answers',	0,	'QuestionAnswers',	'',	6,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(36,	'Question Answers',	'View',	'View',	35,	'QuestionAnswers',	'list-data',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(37,	'Question Answers',	'Add',	'Add',	35,	'QuestionAnswers',	'',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(38,	'Question Answers',	'Edit',	'Edit',	35,	'QuestionAnswers',	'edit-question-answer',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(39,	'Question Answers',	'Status',	'Status',	35,	'QuestionAnswers',	'change-status',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(40,	'Question Answers',	'Delete',	'Delete',	35,	'QuestionAnswers',	'delete-question-answer',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(41,	'Question Answer Comments',	'Question Answer Comments',	'Question Answer Comments',	0,	'AnswerComments',	'',	7,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(42,	'Question Answer Comments',	'View',	'View',	41,	'AnswerComments',	'list-data',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(43,	'Question Answer Comments',	'Add',	'Add',	41,	'AnswerComments',	'',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(44,	'Question Answer Comments',	'Edit',	'Edit',	41,	'AnswerComments',	'edit-answer-comment',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(45,	'Question Answer Comments',	'Status',	'Status',	41,	'AnswerComments',	'change-status',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(46,	'Question Answer Comments',	'Delete',	'Delete',	41,	'AnswerComments',	'delete-comment',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(47,	'Question Comments',	'Question Comments',	'Question Comments',	0,	'QuestionComments',	'',	8,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(48,	'Question Comments',	'View',	'View',	47,	'QuestionComments',	'list-data',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(49,	'Question Comments',	'Add',	'Add',	47,	'QuestionComments',	'',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(50,	'Question Comments',	'Edit',	'Edit',	47,	'QuestionComments',	'edit-comment',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(51,	'Question Comments',	'Status',	'Status',	47,	'QuestionComments',	'change-status',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(52,	'Question Comments',	'Delete',	'Delete',	47,	'QuestionComments',	'delete-comment',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(53,	'News Category',	'News Category',	'News Category',	0,	'NewsCategories',	'',	9,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(54,	'News Category',	'View',	'View',	53,	'NewsCategories',	'list-data',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(55,	'News Category',	'Add',	'Add',	53,	'NewsCategories',	'add-news-category',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(56,	'News Category',	'Edit',	'Edit',	53,	'NewsCategories',	'edit-news-category',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(57,	'News Category',	'Status',	'Status',	53,	'NewsCategories',	'change-status',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(58,	'News Category',	'Delete',	'Delete',	53,	'NewsCategories',	'delete-news-category',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(59,	'News Management',	'News Management',	'News Management',	0,	'News',	'',	10,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(60,	'News Management',	'View',	'View',	59,	'News',	'list-data',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(61,	'News Management',	'Add',	'Add',	59,	'News',	'add-news',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(62,	'News Management',	'Edit',	'Edit',	59,	'News',	'edit-news',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(63,	'News Management',	'Status',	'Status',	59,	'News',	'change-status',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(64,	'News Management',	'Delete',	'Delete',	59,	'News',	'delete-news',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(65,	'News Comments',	'News Comments',	'News Comments',	0,	'NewsComments',	'',	11,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(66,	'News Comments',	'View',	'View',	65,	'NewsComments',	'list-data',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(67,	'News Comments',	'Add',	'Add',	65,	'NewsComments',	'',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(68,	'News Comments',	'Edit',	'Edit',	65,	'NewsComments',	'edit-comment',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(69,	'News Comments',	'Status',	'Status',	65,	'NewsComments',	'change-status',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(70,	'News Comments',	'Delete',	'Delete',	65,	'NewsComments',	'delete-comment',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(71,	'FAQs',	'FAQs',	'FAQs',	0,	'Faqs',	'',	12,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(72,	'FAQs',	'View',	'View',	71,	'Faqs',	'list-data',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(73,	'FAQs',	'Add',	'Add',	71,	'Faqs',	'add-faq',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(74,	'FAQs',	'Edit',	'Edit',	71,	'Faqs',	'edit-faq',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(75,	'FAQs',	'Status',	'Status',	71,	'Faqs',	'change-status',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(76,	'FAQs',	'Delete',	'Delete',	71,	'Faqs',	'delete-faq',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(77,	'Contacts Management',	'Contacts Management',	'Contacts Management',	0,	'Contacts',	'',	13,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(78,	'Contacts Management',	'View',	'View',	77,	'Contacts',	'list-data',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(79,	'Contacts Management',	'Reply',	'Reply',	77,	'Contacts',	'reply',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(80,	'Contacts Management',	'Delete',	'Delete',	77,	'Contacts',	'delete-contacts',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(81,	'CMS Management',	'CMS Management',	'CMS Management',	0,	'cms',	'',	14,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(82,	'CMS Management',	'View',	'View',	81,	'cms',	'list-data',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(83,	'CMS Management',	'Edit',	'Edit',	81,	'cms',	'edit-cms',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(84,	'Banner Management',	'Banner Management',	'Banner Management',	0,	'BannerSections',	'',	15,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(85,	'Banner Management',	'View',	'View',	84,	'BannerSections',	'list-data',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(86,	'Banner Management',	'Add',	'Add',	84,	'BannerSections',	'add-banner-section',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(87,	'Banner Management',	'Edit',	'Edit',	84,	'BannerSections',	'edit-banner-section',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(88,	'Banner Management',	'Status',	'Status',	84,	'BannerSections',	'change-status',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(89,	'Banner Management',	'Delete',	'Delete',	84,	'BannerSections',	'delete-banner',	0,	'Y',	'A',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(90,	'Advertise Management',	'Advertise Management',	'Advertise Management',	0,	'Advertisements',	'',	16,	'Y',	'A',	'2017-11-16 02:00:00',	'2017-11-16 02:00:00'),
(91,	'Advertise Management',	'View',	'View',	90,	'Advertisements',	'list-data',	0,	'Y',	'A',	'2017-11-16 03:00:00',	'2017-11-16 03:00:00'),
(92,	'Advertise Management',	'Add',	'Add',	90,	'Advertisements',	'add-advertise',	0,	'Y',	'A',	'2017-11-16 03:00:00',	'2017-11-16 03:00:00'),
(93,	'Advertise Management',	'Edit',	'Edit',	90,	'Advertisements',	'edit-advertise',	0,	'Y',	'A',	'2017-08-09 00:00:00',	'2017-08-09 00:00:00'),
(94,	'Advertise Management',	'Status',	'Status',	90,	'Advertisements',	'change-status',	0,	'Y',	'A',	'2017-08-13 12:27:33',	'2017-08-13 03:07:09'),
(95,	'Advertise Management',	'Delete',	'Delete',	90,	'Advertisements',	'delete-advertise',	0,	'Y',	'A',	'2017-08-13 12:27:33',	'2017-08-13 12:27:33');

DROP TABLE IF EXISTS `learn_admin_permisions`;
CREATE TABLE `learn_admin_permisions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_user_id` int(11) NOT NULL,
  `admin_menu_id` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `learn_admin_permisions` (`id`, `admin_user_id`, `admin_menu_id`, `modified`, `created`) VALUES
(9,	4,	2,	'2017-10-25 19:46:23',	'2017-10-25 19:46:23'),
(10,	4,	3,	'2017-10-25 19:46:23',	'2017-10-25 19:46:23'),
(11,	4,	9,	'2017-10-25 19:46:23',	'2017-10-25 19:46:23'),
(46,	3,	2,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(47,	3,	3,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(48,	3,	4,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(49,	3,	5,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(50,	3,	9,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(51,	3,	11,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(52,	3,	18,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(53,	3,	20,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(54,	3,	24,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(55,	3,	26,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(56,	3,	30,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(57,	3,	32,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(58,	3,	36,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(59,	3,	38,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(60,	3,	42,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(61,	3,	45,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(62,	3,	48,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(63,	3,	50,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(64,	3,	54,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(65,	3,	55,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(66,	3,	56,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(67,	3,	60,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(68,	3,	62,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(69,	3,	66,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(70,	3,	68,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(71,	3,	72,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(72,	3,	73,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(73,	3,	74,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(74,	3,	78,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(75,	3,	82,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(76,	3,	83,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(77,	3,	85,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(78,	3,	86,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(79,	3,	87,	'2017-10-25 20:19:49',	'2017-10-25 20:19:49'),
(80,	5,	9,	'2017-10-27 19:36:53',	'2017-10-27 19:36:53'),
(81,	5,	18,	'2017-10-27 19:36:53',	'2017-10-27 19:36:53'),
(82,	6,	9,	'2017-10-30 19:23:03',	'2017-10-30 19:23:03'),
(83,	6,	10,	'2017-10-30 19:23:03',	'2017-10-30 19:23:03'),
(84,	6,	24,	'2017-10-30 19:23:03',	'2017-10-30 19:23:03'),
(85,	6,	25,	'2017-10-30 19:23:03',	'2017-10-30 19:23:03'),
(86,	7,	2,	'2017-11-12 14:38:05',	'2017-11-12 14:38:05'),
(87,	7,	9,	'2017-11-12 14:38:05',	'2017-11-12 14:38:05'),
(88,	7,	18,	'2017-11-12 14:38:05',	'2017-11-12 14:38:05'),
(89,	7,	19,	'2017-11-12 14:38:05',	'2017-11-12 14:38:05'),
(90,	7,	24,	'2017-11-12 14:38:05',	'2017-11-12 14:38:05'),
(91,	7,	25,	'2017-11-12 14:38:05',	'2017-11-12 14:38:05'),
(92,	7,	26,	'2017-11-12 14:38:05',	'2017-11-12 14:38:05'),
(93,	7,	30,	'2017-11-12 14:38:05',	'2017-11-12 14:38:05'),
(94,	7,	31,	'2017-11-12 14:38:05',	'2017-11-12 14:38:05'),
(95,	7,	32,	'2017-11-12 14:38:05',	'2017-11-12 14:38:05'),
(96,	7,	33,	'2017-11-12 14:38:05',	'2017-11-12 14:38:05'),
(97,	7,	36,	'2017-11-12 14:38:05',	'2017-11-12 14:38:05'),
(98,	7,	38,	'2017-11-12 14:38:05',	'2017-11-12 14:38:05'),
(99,	7,	39,	'2017-11-12 14:38:05',	'2017-11-12 14:38:05'),
(100,	7,	42,	'2017-11-12 14:38:05',	'2017-11-12 14:38:05'),
(101,	7,	45,	'2017-11-12 14:38:05',	'2017-11-12 14:38:05'),
(102,	7,	48,	'2017-11-12 14:38:05',	'2017-11-12 14:38:05'),
(103,	7,	50,	'2017-11-12 14:38:05',	'2017-11-12 14:38:05'),
(104,	7,	51,	'2017-11-12 14:38:05',	'2017-11-12 14:38:05'),
(105,	7,	54,	'2017-11-12 14:38:05',	'2017-11-12 14:38:05'),
(106,	7,	55,	'2017-11-12 14:38:05',	'2017-11-12 14:38:05'),
(107,	7,	60,	'2017-11-12 14:38:05',	'2017-11-12 14:38:05'),
(108,	7,	66,	'2017-11-12 14:38:05',	'2017-11-12 14:38:05'),
(109,	7,	68,	'2017-11-12 14:38:05',	'2017-11-12 14:38:05'),
(110,	7,	69,	'2017-11-12 14:38:05',	'2017-11-12 14:38:05'),
(111,	7,	72,	'2017-11-12 14:38:05',	'2017-11-12 14:38:05'),
(112,	7,	78,	'2017-11-12 14:38:05',	'2017-11-12 14:38:05'),
(113,	7,	82,	'2017-11-12 14:38:05',	'2017-11-12 14:38:05'),
(114,	7,	85,	'2017-11-12 14:38:05',	'2017-11-12 14:38:05');

DROP TABLE IF EXISTS `learn_advertisements`;
CREATE TABLE `learn_advertisements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(255) NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `status` enum('A','I') NOT NULL DEFAULT 'I',
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `learn_advertisements` (`id`, `link`, `page_name`, `image`, `status`, `modified`, `created`) VALUES
(1,	'http://www.google.com',	'homePage',	'advertise_15110221068.jpg',	'A',	'2017-11-18 16:24:06',	'2017-11-18 16:21:46'),
(2,	'http://www.google.com',	'postQuestion',	'advertise_15110222836.jpg',	'A',	'2017-11-18 16:24:43',	'2017-11-18 16:24:43'),
(3,	'http://www.google.com',	'allQuestions',	'advertise_15110268847.jpg',	'A',	'2017-11-18 17:41:24',	'2017-11-18 17:41:24'),
(4,	'http://www.google.com',	'allUsers',	'advertise_15110269016.jpg',	'A',	'2017-11-18 17:41:41',	'2017-11-18 17:41:41'),
(5,	'http://www.google.com',	'newsListing',	'advertise_15110269151.jpg',	'A',	'2017-11-18 17:41:56',	'2017-11-18 17:41:56');

DROP TABLE IF EXISTS `learn_answer_comments`;
CREATE TABLE `learn_answer_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'Logged in user id (who posted this comment)',
  `question_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL,
  `answer_user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '0',
  `user_ip` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `learn_answer_comments` (`id`, `user_id`, `question_id`, `answer_id`, `answer_user_id`, `comment`, `status`, `user_ip`, `created`, `modified`) VALUES
(1,	27,	8,	5,	1,	'Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter a ',	'0',	'47.15.11.173',	'2017-08-31 20:23:44',	'2017-08-31 20:23:44'),
(2,	1,	8,	4,	27,	'Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter a ',	'1',	'47.15.11.173',	'2017-08-31 20:24:09',	'2017-08-31 20:24:09'),
(3,	2,	8,	4,	27,	'Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter a ',	'1',	'47.15.11.173',	'2017-08-31 20:34:25',	'2017-08-31 20:34:25'),
(7,	2,	7,	6,	1,	'test related',	'0',	'47.15.1.254',	'2017-09-07 20:55:17',	'2017-09-07 20:55:17'),
(8,	21,	8,	4,	27,	'nice',	'1',	'110.227.98.195',	'2017-09-08 18:39:41',	'2017-09-08 18:39:41'),
(9,	21,	8,	7,	35,	'ghjgh',	'0',	'110.225.8.16',	'2017-09-13 19:55:41',	'2017-09-13 19:55:41'),
(10,	34,	7,	6,	1,	'good!',	'1',	'46.135.78.164',	'2017-09-23 19:50:21',	'2017-09-23 19:50:21'),
(11,	34,	8,	5,	1,	'I think that for comfortable completion 8 months might be safer time, subject to the level of initial readiness of the learner',	'1',	'46.135.10.110',	'2017-10-01 12:58:31',	'2017-10-01 12:58:31'),
(12,	27,	10,	10,	40,	'this is testing...',	'0',	'47.15.13.175',	'2017-10-08 05:45:22',	'2017-11-27 18:54:15');

DROP TABLE IF EXISTS `learn_answer_upvotes`;
CREATE TABLE `learn_answer_upvotes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'Logged in user id',
  `question_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL,
  `answer_user_id` int(11) NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '0',
  `user_ip` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `learn_answer_upvotes` (`id`, `user_id`, `question_id`, `answer_id`, `answer_user_id`, `status`, `user_ip`, `created`, `modified`) VALUES
(1,	27,	8,	5,	1,	'1',	'47.15.11.173',	'2017-08-31 20:23:32',	'2017-08-31 20:23:32'),
(2,	1,	8,	4,	27,	'1',	'47.15.11.173',	'2017-08-31 20:24:01',	'2017-08-31 20:24:01'),
(3,	2,	8,	4,	27,	'1',	'47.15.11.173',	'2017-08-31 20:34:03',	'2017-08-31 20:34:03'),
(4,	21,	8,	5,	1,	'1',	'122.163.61.92',	'2017-08-31 20:41:15',	'2017-08-31 20:41:15'),
(5,	27,	7,	6,	1,	'1',	'47.15.1.254',	'2017-09-07 19:12:58',	'2017-09-07 19:12:58'),
(6,	2,	7,	6,	1,	'1',	'47.15.1.254',	'2017-09-07 20:15:28',	'2017-09-07 20:15:28'),
(7,	34,	7,	6,	1,	'1',	'90.179.53.6',	'2017-09-10 21:00:07',	'2017-09-10 21:00:07'),
(8,	21,	8,	4,	27,	'1',	'110.225.8.16',	'2017-09-13 19:55:07',	'2017-09-13 19:55:07'),
(9,	21,	8,	7,	35,	'1',	'110.225.8.16',	'2017-09-13 19:55:28',	'2017-09-13 19:55:28'),
(10,	27,	6,	2,	21,	'1',	'202.142.77.93',	'2017-09-17 07:21:32',	'2017-09-17 07:21:32'),
(11,	27,	8,	7,	35,	'1',	'47.15.12.47',	'2017-10-06 20:08:07',	'2017-10-06 20:08:07'),
(12,	2,	8,	5,	1,	'1',	'47.15.12.47',	'2017-10-06 20:25:25',	'2017-10-06 20:25:25');

DROP TABLE IF EXISTS `learn_banner_sections`;
CREATE TABLE `learn_banner_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `sub_title` text NOT NULL,
  `sub_title2` text NOT NULL,
  `link` varchar(255) NOT NULL,
  `link_text` varchar(255) NOT NULL,
  `link2` varchar(255) NOT NULL,
  `link2_text` text NOT NULL,
  `image` text NOT NULL,
  `status` enum('A','I') NOT NULL DEFAULT 'I',
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `learn_banner_sections` (`id`, `title`, `sub_title`, `sub_title2`, `link`, `link_text`, `link2`, `link2_text`, `image`, `status`, `modified`, `created`) VALUES
(1,	'Welcome to learn with us!',	'It may not be easy for a grown person to navigate what learning path can take one further in the right direction towards a better job, better pay, or firmer confidence. What goal shall I set, given what I already - or, rather, still - know? What budget shall I need to accomplish my learning mission? What time will I need to allocate? What learning options are there, with what take-aways?',	'to join the Lifelong Learners\' community to ask your questions, or share your answers!',	'http://techtimes-in.com/projects/learneron/signup',	'Sign Up',	'http://techtimes-in.com/projects/learneron/login',	'Log In',	'banner_15020913215.jpg',	'A',	'2017-10-15 15:15:39',	'2017-08-07 07:35:23'),
(2,	'Are you',	'An experienced person, whose industry or job seems soon to get automated?<br />\r\nJust freshly graduated, but you feel somewhat practically unprepared for the job market?<br />\r\nNeeding just a part time job, or become a freelancer, but you are not confident having the right skills and preparation for it?',	'to join the Lifelong Learners\' community to ask your questions, or share your answers!',	'http://techtimes-in.com/projects/learneron/signup',	'Sign Up',	'http://techtimes-in.com/projects/learneron/login',	'Log In',	'banner_15020917577.jpg',	'A',	'2017-10-15 15:14:31',	'2017-08-07 07:42:39'),
(3,	'Do you',	'Feel, that while you\'re successful at what you do, the world is changing so rapidly, and so interestingly, that you... perhaps for the sole sake of curiosity... ought to learn more?',	'to join the Lifelong Learners\' community to ask your questions, or share your answers!',	'http://techtimes-in.com/projects/learneron/signup',	'Sign Up',	'http://techtimes-in.com/projects/learneron/login',	'Log In',	'banner_15020917822.jpg',	'A',	'2017-10-15 15:15:01',	'2017-08-07 07:43:03');

DROP TABLE IF EXISTS `learn_careereducations`;
CREATE TABLE `learn_careereducations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `learn_careereducations` (`id`, `user_id`, `history_type`, `edu_degree`, `edu_organization`, `edu_from`, `edu_to`, `career_position`, `career_company`, `career_from`, `career_to`, `created`, `modified`) VALUES
(1,	1,	'E',	'edu 1',	'school 1',	'2017-08-01',	'2017-08-03',	NULL,	NULL,	NULL,	NULL,	'2017-08-06 13:54:00',	'2017-08-06 13:56:45'),
(2,	1,	'C',	NULL,	NULL,	NULL,	NULL,	'car 1',	'com 1',	'2017-08-03',	'2017-08-04',	'2017-08-06 13:54:00',	'2017-08-06 13:56:45'),
(3,	1,	'C',	NULL,	NULL,	NULL,	NULL,	'car 2',	'com 2',	'2017-07-04',	'2017-07-19',	'2017-08-06 13:54:00',	'2017-08-06 13:56:45'),
(4,	2,	'E',	'New edu 1',	'new school 1',	'2017-05-07',	'2017-05-15',	NULL,	NULL,	NULL,	NULL,	'2017-08-15 05:43:51',	'2017-08-15 05:43:51'),
(5,	2,	'C',	NULL,	NULL,	NULL,	NULL,	'new com 1',	'com 1',	'2017-05-16',	'2017-07-21',	'2017-08-15 05:43:51',	'2017-08-15 05:43:51'),
(6,	3,	'C',	NULL,	NULL,	NULL,	NULL,	'jersey',	'New jersey',	'1999-01-10',	'2004-05-29',	'2017-08-15 06:45:47',	'2017-08-15 06:45:47'),
(7,	4,	'E',	'Graduate',	'St. Gomes',	'2017-04-01',	'2017-06-02',	NULL,	NULL,	NULL,	NULL,	'2017-08-15 11:54:59',	'2017-08-15 11:54:59'),
(8,	4,	'C',	NULL,	NULL,	NULL,	NULL,	'Student',	'Vidyalaya',	'2017-07-01',	'2017-07-18',	'2017-08-15 11:54:59',	'2017-08-15 11:54:59'),
(9,	27,	'E',	'MCA',	'WBUT',	'2007-08-15',	'2010-08-15',	NULL,	NULL,	NULL,	NULL,	'2017-08-20 12:24:35',	'2017-08-20 12:24:35'),
(10,	27,	'E',	'BSC',	'CU',	'2004-08-02',	'2007-08-04',	NULL,	NULL,	NULL,	NULL,	'2017-08-20 12:24:35',	'2017-08-20 12:24:35'),
(11,	27,	'E',	'HS',	'VMPS',	'2002-08-01',	'2004-08-15',	NULL,	NULL,	NULL,	NULL,	'2017-08-20 12:24:35',	'2017-08-20 12:24:35'),
(12,	27,	'C',	NULL,	NULL,	NULL,	NULL,	'Senior Developer',	'Company 2',	'2017-01-01',	'2017-02-28',	'2017-08-20 12:24:35',	'2017-08-20 12:24:35'),
(13,	27,	'C',	NULL,	NULL,	NULL,	NULL,	'Developer',	'Company 1',	'2016-12-01',	'2016-12-31',	'2017-08-20 12:24:35',	'2017-08-20 12:24:35'),
(14,	21,	'E',	'BTech',	'GCETTS',	'2016-12-01',	'2017-07-03',	NULL,	NULL,	NULL,	NULL,	'2017-08-23 20:08:04',	'2017-08-23 20:09:21'),
(15,	21,	'E',	'HS',	'BKAPI',	'2017-08-01',	'2017-08-24',	NULL,	NULL,	NULL,	NULL,	'2017-08-23 20:08:04',	'2017-08-23 20:09:21'),
(16,	21,	'C',	NULL,	NULL,	NULL,	NULL,	'Developer',	'Accenza',	'2017-08-23',	'2017-08-31',	'2017-08-23 20:08:04',	'2017-08-23 20:09:21'),
(17,	41,	'E',	'BTech',	'GCETTS',	'2016-10-05',	'2017-09-28',	NULL,	NULL,	NULL,	NULL,	'2017-09-29 03:24:58',	'2017-09-29 03:24:58'),
(18,	41,	'C',	NULL,	NULL,	NULL,	NULL,	'Web Designer',	'Eclock',	'2017-09-01',	'2017-09-20',	'2017-09-29 03:24:58',	'2017-09-29 03:24:58');

DROP TABLE IF EXISTS `learn_cms_pages`;
CREATE TABLE `learn_cms_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_section` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(1) NOT NULL COMMENT 'A=>active,I=>inactive,D=>deleted',
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `learn_cms_pages` (`id`, `page_section`, `title`, `description`, `status`, `modified`, `created`, `meta_keywords`, `meta_description`) VALUES
(1,	'home',	'Home',	'test description',	'A',	'2017-08-18 16:40:21',	'2017-08-06 01:09:18',	'Home',	'Home'),
(2,	'news',	'News & Views',	'You will find here our site blog, sharing with you our reviews of and comments on interesting Lifelong Learning topics (Views), as well as news on the LearnerOn.Net site development and functionality (News)',	'A',	'2017-08-09 00:00:00',	'2017-08-09 00:00:00',	'News & Views',	'News & Views'),
(3,	'about us',	'About Us',	'<p>We build LearnerOn.Net in order to support the community of adult, lifelong learners in finding the learning path for their needs and means, whatever these are.</p>\r\n<p>We do it because we believe that learning, knowing and understanding more, rather than less, is universally good thing. Not only it leads to an immediate better individual well being through improved skills and job prospects; it also makes the world better as a whole. It fuels progress.</p>\r\n<p>Our starting team is small. Our background is education, math, physics, data science, finance, consulting. We are convinced lifelong learners ourselves: in learning we trust.</p>\r\n<p>As LearnerOn.Net itself is on a learning path, over time we intend to bring more to support the participating users and learners.</p>\r\n<p>Our highest hope is following: we intend to set grown people onto a learning path. All of them. The entire humankind.</p>\r\n<p>&nbsp;</p>\r\n<hr>\r\n<p>LearnerOn.Net is delivered by <a href=\"javascript:void(0);\" onclick=\"show_details();\">Learneron, SE</a><br>© Learneron, SE, 2017</p>\r\n<div id=\"show\" class=\"hidedetails\"><p>Learneron, SE; business ID: 061 59 010; registered seat: Zahrebska 23, 120 00, Prague, Czech Republic; e-mail: <a href=\"mailto:administrator@learneron.net\">administrator@learneron.net</a></p></div>\r\n',	'A',	'2017-10-07 21:20:28',	'2017-08-09 00:00:00',	'About Us',	'About Us'),
(4,	'terms of use',	'Terms of Use',	'<p><span style=\"text-decoration:underline\">Introductory Provisions</span><br>\r\nThese Terms and Conditions for using the portal LearnerOn.Net (the “Conditions”) provide for the conditions for using the services of the portal LearnerOn.Net (the “Services”) and set rights and obligations arising during the provision of these Services between you as a user (the “User”) and the company company: Learneron, SE; business ID: 061 59 010; registered seat: Zahrebska 23, 120 00, Prague, Czech Republic as a provider of the Services (the “Provider”). For creating the user account and using the Services, the User has to agree with the Conditions. If the User does not agree to the Conditions, then the User cannot use the Services.<br><br>\r\n<span style=\"text-decoration:underline\">Formation of a Contract and its Subject-matter</span><br>\r\nThe Contract, the subject of which is provision of the Services via a user account, is established by the moment of giving consent to these Conditions and successful creation of a user account.<br><br>\r\nThe agreement is concluded free of charge and the User is not obliged to pay any remuneration, taxes, fees or delivery costs are connected to the Services. Costs connected with using of remote means of communication on the side of the User are, however, borne by the User. The User expressly asks the Provider for commencement of provision of the Services from the moment of establishment of the Agreement and is aware of the fact that in such a case, the User is not entitled to withdraw from the Agreement.<br><br>\r\nThe agreement is concluded for an indefinite period of time. The Services provided by the Provider to the User are provided “as is” and the Provider does not provide the User with any guarantees regarding the functionality, speed and availability of the Services. The Provider in no way acquaints itself with the content added by the users.<br><br>\r\nInformation about the User’s personal data processing are stated in <a href=\"privacy\">Privacy Policy</a>.<br><br>\r\n<span style=\"text-decoration:underline\">Termination of the Contract</span><br>\r\nThe agreement on provision of Services may be terminated by the User or the Provider without cause with the effect from the day of delivery of a written (including means of electronic communication – specifically, email) notice to the other contracting party. <br><br>\r\n<span style=\"text-decoration:underline\">Conditions for Using the Services</span><br>\r\nThe rules stipulated below apply during any use of the Services by the User. <br><br>\r\nPersons professionally providing educational services or persons affiliated with them are not allowed to use the Question asking, Answer providing and Comments posting part of the Services and to create a user account for Questions, Answers or Comments purposes.<br><br>\r\nDuring the use of the Services, the User is always obliged to act in accordance with applicable statutory provisions and to comply with the below stated conditions and rules:\r\n</p><ul>\r\n<li>It is forbidden to use vulgar expressions, offensive language, personally attacking or dehonesting texts or insults, as well as intentionally false and misleading statements or information.</li>\r\n<li>It is forbidden to repeatedly insert duplicate posts or to insert intentionally false or misleading posts.</li>\r\n<li>It is forbidden to post any paid or unpaid advertisement, or as the case may be, third party advertisement to the portal, unless such posting of paid or unpaid advertisement, or as the case may be, third party advertisement to the portal, is allowed on the basis of prior specific agreement with the Provider.</li>\r\n<li>It is forbidden to promote educational or other services offered by the User or by a person affiliated with the User, unless such promoting of educational or other services offered by the User or by a person affiliated with the User is allowed on the basis of prior specific agreement with the Provider.</li>\r\n<li>All User\'s posts on the portal have to be in compliance with all applicable laws and rules and these Terms and Conditions, which, as the case may be, can develop and change over time.</li>\r\nIn case that the User breaches these Conditions, the Provider is entitled to delete the posts sent by the User. In case of repeated or serious breach of these Conditions, upon the sole decision of the Provider, the Provider is further entitled to cancel the account of the User including the blocking of User’s access to the portal of the Provider.<br>\r\n</ul><p></p>\r\n<p><span style=\"text-decoration:underline\">Final Provisions</span><br>\r\nThese Conditions are made in English language and the agreement can be concluded only in English language. The User is entitled to save this counterpart of the Conditions and print it. These Conditions are kept at the Provider’s and the Provider shall enable the User to access them. \r\nAs the Provider is incorporated and has its registered office in the Czech Republic, the agreement will be governed by and interpreted in accordance with the laws of the Czech Republic.<br><br>\r\nThe Provider is entitled at any time to unilaterally change the content of these Conditions, where any changes of these Conditions become effective after they are made public and on the day determined by the Provider. In relation to every User, however, changes to these Conditions become effective only if the User agrees to such a change, where using the Services by the User after the effective date of change of the Conditions set by the Provider is considered a consent to such change. If the User does not agree with the change of the Conditions, the User is obliged to refrain from using the Services after the date set by the Provider as the effective date of change of the Conditions.<br><br>\r\nThese Conditions are valid and effective from 1 October, 2017.</p>',	'A',	'2017-10-07 06:37:07',	'2017-08-09 00:00:00',	'Terms of Use',	'Terms of Use'),
(5,	'privacy',	'Privacy',	'<div id=\"show_0\" class=\"shwdetails displayclass\">\r\n<p>Your personal data will be processed by the company: Learneron, SE; business ID: 061 59 010; registered seat: Zahrebska 23, 120 00, Prague, Czech Republic; e-mail: <a href=\"mailto:administrator@learneron.net\">administrator@learneron.net</a> as a personal data controller (“Controller”) on the basis of performance of a contract for the purpose of creating a user account and using services of the portal LearnerOn.Net. Further information about personal data processing and your rights are available in Privacy Overview. For more details click <a id=\"show_more_1\" href=\"javascript:void(0);\" onclick=\"show_details(\'1\');\">here</a>.</p></div>\r\n<div id=\"show_1\" class=\"hidedetails displayclass\">\r\n	<p>Your personal data will be processed by the company: Learneron, SE; business ID: 061 59 010; registered seat: Zahrebska 23, 120 00, Prague, Czech Republic; e-mail: <a href=\"mailto:administrator@learneron.net\">administrator@learneron.net</a> as a personal data controller (“Controller”) on the basis of performance of a contract for the purpose of creating a user account and using services of the portal LearnerOn.Net.<br><br>\r\n	The personal data will be processed in the extent of name and surname (if provided by you), username, e-mail address, data about the communication within the portal and data entered over or into the portal. The personal data processing is necessary for creating the user account and using services of the portal LearnerOn.Net.<br><br>\r\n	In case of suspicion that the Controller processes your personal data in breach of privacy protection or in breach of law, you are entitled to demand an explanation from the Controller and to seek a rectification of the unsound situation from the Controller. You are also entitled to ask for blocking, rectification, completion or removal of personal data, information about your personal data processing and you have a right to access your personal data and other rights stipulated in the Czech Act No. 121/2000 Coll., on personal data protection and on amendment of some acts, as amended, which implements Directive 95/46/EC of the European Parliament and of the Council of 24 October 1995 on the protection of individuals with regard to the processing of personal data and on the free movement of such data.<br>\r\n	Further information on privacy protection, personal data processing and your rights are available in <a id=\"show_more_2\" href=\"javascript:void(0);\" onclick=\"show_details(\'2\');\">Privacy Policy</a>.</p>\r\n</div>\r\n\r\n<div id=\"show_2\" class=\"hidedetails displayclass\">\r\n	<p>Your personal data will be processed by the company: Learneron, SE; business ID: 061 59 010; registered seat: Zahrebska 23, 120 00, Prague, Czech Republic; e-mail: <a href=\"mailto:administrator@learneron.net\">administrator@learneron.net</a> as a personal data controller (“Controller”) on the basis of performance of a contract for the purpose of creating a user account and using services of the portal LearnerOn.Net.<br><br>\r\n	The personal data will be processed in the extent of name and surname (if provided by you), username, e-mail address, data about the communication within the portal and data entered over or into the portal. The personal data processing is necessary for creating the user account and using services of the portal LearnerOn.Net.<br><br>\r\n	The personal data will be processed until the end of force of the agreement between you and the Controller.<br><br>\r\n	In case of suspicion that the Controller processes your personal data in breach of privacy protection or in breach of law, especially if your personal data are inaccurate with regard to the purpose of their processing, you are entitled to demand an explanation from the Controller and to seek a rectification of the situation from the Controller. You are also entitled to ask for blocking, rectification, completion or removal of personal data. Provided that the demand pursuant to the previous sentences is found reasonable, the Controller shall rectify the defect.<br><br>\r\n	If you require information about your personal data processing, the Controller is obliged to provide you with these information. For provision of these information, the Controller is entitled to seek compensation not exceeding the expenses for provision of these information.<br><br>\r\n	You are further always entitled to ask the Controller for the access to your personal data or to carry out other rights stipulated in the Czech Act No. 121/2000 Coll., on personal data protection and on amendment of some acts, as amended, which implements Directive 95/46/EC of the European Parliament and of the Council of 24 October 1995 on the protection of individuals with regard to the processing of personal data and on the free movement of such data.<br><br>\r\n	This Privacy Policy will be amended on 25 May 2018 in connection with applicability of the Regulation (EU) 2016/679 of the European Parliament and of the Council of 27 April 2016 on the protection of natural persons with regard to the processing of personal data and on the free movement of such data, and repealing Directive 95/46/EC (General Data Protection Regulation). The new version of this Privacy Policy applicable from 25 May 2018 is available <a id=\"show_more_3\" href=\"javascript:void(0);\" onclick=\"show_details(\'3\');\">here</a>.</p>\r\n</div>\r\n\r\n<div id=\"show_3\" class=\"hidedetails displayclass\">\r\n	<h5>Privacy policy valid from 25 May 2018</h5>\r\n	<p>Our personal data will be processed by the company: Learneron, SE; business ID: 061 59 010; registered seat: Zahrebska 23, 120 00, Prague, Czech Republic; e-mail: <a href=\"mailto:administrator@learneron.net\">administrator@learneron.net</a> as a personal data controller (“Controller”) on the basis of performance of a contract for the purpose of creating a user account and using services of the portal LearnerOn.Net.<br><br>\r\n	The personal data will be processed in the extent of name and surname (if provided by you), username, e-mail address, data about the communication within the portal and data entered over or into the portal. The personal data processing is necessary for creating the user account and using services of the portal LearnerOn.Net. You may decline to provide the Controller with the personal data, in such case, however, the creation of the user account and subsequent provision of services of the portal LearnerOn.Net will not be possible.<br><br>\r\n	The personal data will be processed until the end of force of the agreement between you and the Controller. You are entitled to ask for access to personal data, their rectification, completion, erasure, limitation of the processing, explanation of the processing, to raise an objection against processing of data, and you have a right to data portability and right to lodge a complaint against the personal data processing with the Czech Office for Personal Data Protection.</p>\r\n</div>',	'A',	'2017-10-29 19:46:42',	'2017-08-09 00:00:00',	'Privacy',	'Privacy'),
(6,	'contact us',	'Contact Us',	'',	'A',	'2017-08-09 00:00:00',	'2017-08-09 00:00:00',	'Contact Us',	'Contact Us');

DROP TABLE IF EXISTS `learn_common_settings`;
CREATE TABLE `learn_common_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `learn_common_settings` (`id`, `facebook_link`, `twitter_link`, `google_plus_link`, `linkedin`, `email`, `phone_number`, `address`, `footer_text`, `question_approval`, `question_answer_approval`, `question_comment_approval`, `answer_comment_approval`, `news_comment_approval`, `modified`, `created`) VALUES
(1,	'https://www.facebook.com/',	'http://www.twitter.com',	'https://plus.google.com',	'http://www.linkedin.com',	'spinskillsup@gmail.com',	'9876543210',	'',	'',	'1',	'1',	'1',	'1',	'1',	'2017-12-10 13:02:44',	'2016-11-25 14:54:50');

DROP TABLE IF EXISTS `learn_contacts`;
CREATE TABLE `learn_contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone_number` varchar(30) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'A' COMMENT 'A=>Active, I=>Inactive',
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `learn_contacts` (`id`, `name`, `user_name`, `email`, `phone_number`, `subject`, `message`, `status`, `modified`, `created`) VALUES
(4,	'Sanjay',	'sanja',	'100websolution@gmail.com',	'9876543210',	'test subject',	'This is a message',	'A',	'2017-09-10 08:18:48',	'2017-09-10 08:18:48'),
(5,	'Sujoy',	'suj',	'suj@gmail.com',	'9876543210',	'test subject',	'this is testing',	'A',	'2017-09-10 15:27:57',	'2017-09-10 15:27:57'),
(6,	'baby',	'baby',	'baby@baby.com',	'',	'',	'hi',	'A',	'2017-09-23 19:26:11',	'2017-09-23 19:26:11'),
(7,	'Learner1',	'Learner1',	'administrator@learneron.net',	'',	'question',	'question',	'A',	'2017-10-08 18:43:33',	'2017-10-08 18:43:33'),
(8,	'Rams',	'Rams Dean',	'sanjoy86.jk@gmail.com',	'9876543210',	'This is testing subject',	'my comments are listed below...',	'A',	'2017-10-10 20:47:46',	'2017-10-10 20:47:46'),
(9,	'sdf',	'sdf',	'dsfds@fsdf.cv',	'9477482876',	'sdf',	'sdfs df sdf',	'A',	'2017-10-15 20:47:40',	'2017-10-15 20:47:40'),
(10,	'Sukanta Sarkar',	'sukanta',	'sukanta.info2@gmail.com',	'9477482876',	'test',	'test message 123 test message 123 test message 123 test message 123 test message 123 test message 123 test message 123 test message 123 test message 123 ',	'A',	'2017-10-15 20:49:58',	'2017-10-15 20:49:58'),
(11,	'Mr Big',	'Learner1',	'administrator@learneron.net',	'',	'',	'Hi, are you there?',	'A',	'2017-10-22 11:14:06',	'2017-10-22 11:14:06'),
(12,	'Learner1',	'Learner1',	'spinskillsup@gmail.com',	'',	'Hi',	'Hi',	'A',	'2017-11-12 14:22:10',	'2017-11-12 14:22:10'),
(13,	'test',	'testing',	'sanjoy86.jk@gmail.com',	'9876543210',	'hi my subject',	'this is testing email',	'A',	'2017-11-13 18:26:21',	'2017-11-13 18:26:21'),
(14,	'Mitkar',	'testing',	'sanjoy86.jk@gmail.com',	'9876543210',	'hi my subject',	'hkllklj',	'A',	'2017-11-13 18:42:31',	'2017-11-13 18:42:31'),
(15,	'Learner1',	'Learner1',	'severav@seznam.cz',	'',	'question',	'Is this working on November 26?',	'A',	'2017-11-26 13:32:59',	'2017-11-26 13:32:59'),
(16,	'aa',	'a',	'administrator@learneron.net',	'',	'2nd Nov 26',	'second attempt on Nov26',	'A',	'2017-11-26 13:36:54',	'2017-11-26 13:36:54'),
(17,	'a',	'a',	'severav@seznam.cz',	'',	'trying',	'3rd attempt on NOv 26',	'A',	'2017-11-26 13:41:17',	'2017-11-26 13:41:17'),
(18,	'a',	'aa',	'severav@seznam.cz',	'',	'hi',	'Nov 26, 4th attempt',	'A',	'2017-11-26 13:48:54',	'2017-11-26 13:48:54'),
(19,	'Ja',	'Learner1',	'severav@seznam.cz',	'',	'',	'Nov 27 - is it working?',	'A',	'2017-11-27 05:19:03',	'2017-11-27 05:19:03'),
(20,	'severav',	'severav',	'severav@seznam.cz',	'',	'indirect mail',	'indirect mail',	'A',	'2017-12-10 13:04:19',	'2017-12-10 13:04:19');

DROP TABLE IF EXISTS `learn_contact_replies`;
CREATE TABLE `learn_contact_replies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) NOT NULL,
  `reply_message` text NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `learn_contact_replies` (`id`, `contact_id`, `reply_message`, `created`) VALUES
(1,	4,	'<p>thanks..<br></p>',	'2017-10-12 19:37:01'),
(2,	4,	'<p>Testing on</p>',	'2017-10-13 20:40:03'),
(3,	4,	'<p>Testing on<span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><span style=\"font-size: 1rem;\">Testing on</span><br></p>',	'2017-10-13 20:40:24'),
(6,	4,	'<p>happy testing<br></p>',	'2017-10-29 18:39:08'),
(7,	10,	'<p>Hi<br></p>',	'2017-11-13 19:23:13'),
(8,	10,	'<p>This is another reply from admin</p>',	'2017-11-20 19:23:29'),
(9,	12,	'<p>hi, is it working now?</p><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p>',	'2017-11-26 12:46:33'),
(10,	17,	'<p>3rd answer<br></p>',	'2017-11-26 13:42:04'),
(11,	15,	'<p>1st answer<br></p>',	'2017-11-26 13:42:51'),
(12,	16,	'<p>2nd&nbsp; answer<br></p>',	'2017-11-26 13:43:22');

DROP TABLE IF EXISTS `learn_faqs`;
CREATE TABLE `learn_faqs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `status` enum('A','I') NOT NULL DEFAULT 'I' COMMENT '''A'' => Active, ''I'' => Inactive',
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `learn_faqs` (`id`, `question`, `slug`, `answer`, `status`, `modified`, `created`) VALUES
(4,	'What are the benefits of signing up and becoming LearnerOn.Net registered user, as opposed to staying as an unregistered site viewer?',	'what-are-the-benefits-of-signing-up-and-becoming-learneron-net-registered-user-as-opposed-to-staying-as-an-unregistered-site-viewer',	'While the site content is generally available to unregistered viewers who can browse the Questions and Answers material, read the News &amp; Views and make use of these, the registered and signed users are in addition getting an access to a multiple of features and functionalities:\r\n<ul>\r\n	<li>the key user\'s activity - asking a Question, placing and Answer or posting a Comment on the site - can be done only by registered users,</li>\r\n	<li>registration also allows to participate in the voting on Answers placed on the site, which is very valuable feature for the learning community</li>\r\n	<li>registered users can get automatic notification of new Answers posted on their questions, on new Questions in a category of interest, and also can subscribe to automatic notification on new News &amp; Views content and postings, as well as to the Twitter version of them,</li>\r\n	<li>LearnerOn.Net development does not stop here: new functionalities for the site users are intended and postings on them, if and when they become available, will be part of the site <a href=\"news\">News &amp; Views</a> stream.</li>\r\n</ul>',	'A',	'2017-10-29 05:36:05',	'2017-07-25 18:52:10'),
(5,	'How a question can be posted on the LearnerOn.Net site?',	'how-a-question-can-be-posted-on-the-learneron-net-site-1',	'Similarly to posting a question (please see above the Q related to a question posting), you first need to sign up and / or log in to the site before you will be able to post a comment or an answer.  Then, anywhere on the site where you can view a question posted, you can add your comment or place an answer to that question (in the <a href=\"news\">News &amp; Views</a> section of the site, you can also place comment to the <a href=\"news\">News &amp; Views</a> item of your interest). Please note that a full answer to a question on the LearnerOn.Net site consists of three parts, and ideally each of them should be filled to provide maximum utility for the user who is asking: i) Learning Path Recommendation – in this part, the succession of recommended courses or practical steps to learn the subject of interest should be included; ii) What Was Your Learning Experience – eg, quality, availability and attention of the lecturerers, of the lectures themselves, of the shared / available course materials, rating of the content / delivery would be good to place here; iii) What Was Your Learning Utility – matters as, eg, what in restropsect was the major take-away of your learning experience, how useful and practical it really was in helping you to achieve your goal (eg, finding new job, getting a salary progression, mastering the skill you needed, any other applicable goal) fits here.',	'A',	'2017-10-29 05:32:09',	'2017-07-25 19:05:02'),
(6,	'How an answer or a comment can be posted on the LearnerOn.Net site?',	'how-an-answer-or-a-comment-can-be-posted-on-the-learneron-net-site',	'Similarly to posting a question (please see above the Q related to a question posting), you first need to sign up and / or log in to the site before you will be able to post a comment or an answer.  Then, anywhere on the site where you can view a question posted, you can add your comment or place an answer to that question (in the <a href=\"news\">News &amp; Views</a> section of the site, you can also place comment to the <a href=\"news\">News &amp; Views</a> item of your interest). Please note that a full answer to a question on the LearnerOn.Net site consists of three parts, and ideally each of them should be filled to provide maximum utility for the user who is asking: i) Learning Path Recommendation – in this part, the succession of recommended courses or practical steps to learn the subject of interest should be included; ii) What Was Your Learning Experience – eg, quality, availability and attention of the lecturerers, of the lectures themselves, of the shared / available course materials, rating of the content / delivery would be good to place here; iii) What Was Your Learning Utility – matters as, eg, what in restropsect was the major take-away of your learning experience, how useful and practical it really was in helping you to achieve your goal (eg, finding new job, getting a salary progression, mastering the skill you needed, any other applicable goal) fits here.',	'A',	'2017-10-29 05:33:04',	'2017-07-25 19:05:16'),
(7,	'I submitted a Question (Answer, Comment) on the site, but do not see it appearing there yet',	'i-submitted-a-question-answer-comment-on-the-site-but-do-not-see-it-appearing-there-yet',	'All user\'s posts on the site are going through an appoval procedure, which may need certain time – therefore, please be a little patient. You however will be notified on your registered email address when your post goes live (or if it needs a review or an adjustment), thus your post will not go on screen unnoticed by you!',	'A',	'2017-10-29 05:33:46',	'2017-07-25 19:05:30'),
(8,	'Do the site posts need to be solely in English? Are there any language standards for the site?',	'do-the-site-posts-need-to-be-solely-in-english-are-there-any-language-standards-for-the-site',	'<p>At the moment, the site\'s language is English and right now we do not have any other language versions. The language standards are simple - posts need to be in line with the site Terms of Use (thus, eg, no offensive language or hate terms are allowed to be part of a post), and, also, the meaning of the post needs to be clear (thus, use of proper English is desirable) and reflecting the purpose of the site and the particular section (learning path Question, Answer, Comment or similar). If the post does not fulfill the above standards, it may be returned back to the posting user for editing or not allowed to be posted.<br></p>',	'A',	'2017-11-12 10:47:45',	'2017-11-12 10:47:45');

DROP TABLE IF EXISTS `learn_news`;
CREATE TABLE `learn_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `learn_news` (`id`, `category_id`, `user_id`, `name`, `slug`, `description`, `image`, `meta_keywords`, `meta_description`, `status`, `view`, `created`, `modified`) VALUES
(1,	22,	NULL,	'Test News',	'test-news-1',	'<p>Test description<br></p>',	'news_image_150080972760.jpg',	'Test ',	'Test meta description',	'A',	9,	'2017-07-23 11:12:28',	'2017-08-17 19:03:19'),
(2,	23,	1,	'test',	'test',	'dfsdf',	NULL,	'',	'',	'A',	11,	'2017-07-25 03:10:00',	'2017-08-24 00:27:19'),
(3,	22,	NULL,	'Rio - Movie',	'rio-movie',	'<p><br></p><p>Lorem Ipsum is simply dummy text of the printing &amp; typesetting industry. </p><p><br></p>',	'news_image_15024749913.jpg',	'',	'',	'A',	15,	'2017-08-12 18:09:51',	'2017-08-24 20:21:50'),
(4,	24,	NULL,	'Kids movie -Kunfu',	'kids-movie-kunfu',	'<p>Lorem Ipsum is simply dummy text of the printing &amp; typesetting industry. </p><p><br></p>',	'news_image_15024750403.jpg',	'',	'',	'A',	9,	'2017-08-08 18:10:40',	'2017-08-24 00:27:48'),
(5,	23,	1,	'Kids movie -Kunfu 1',	'kids-movie-kunfu-1',	'<p>Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt&nbsp; ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi&nbsp; iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt&nbsp; ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi&nbsp; iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt&nbsp; ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi&nbsp; iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt&nbsp; ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi&nbsp; iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt&nbsp; ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi&nbsp; iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt&nbsp; ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi&nbsp; iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt&nbsp; ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi&nbsp; iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt&nbsp; ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi&nbsp; iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt&nbsp; ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi&nbsp; iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt&nbsp; ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi&nbsp; iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt&nbsp; ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi&nbsp; iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt&nbsp; ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi&nbsp; iam, quis nostrud exerci.</p>',	'news_image_15024751169.jpg',	'Kids movie -Kunfu 1 meta key',	'Kids movie -Kunfu 1 meta description',	'A',	15,	'2017-08-10 18:11:56',	'2017-08-24 00:26:59'),
(6,	24,	NULL,	'Todays news',	'todays-news',	'<p>hi this is todays news<br></p>',	'news_image_15025336230.jpg',	'',	'',	'A',	19,	'2017-08-12 10:27:03',	'2017-08-24 00:23:18');

DROP TABLE IF EXISTS `learn_newsletter_subscriptions`;
CREATE TABLE `learn_newsletter_subscriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'A' COMMENT 'A=>Active, I=>Inactive',
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `learn_news_categories`;
CREATE TABLE `learn_news_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `status` enum('A','I') NOT NULL DEFAULT 'I' COMMENT 'A=>Active, I=>Inactive',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `learn_news_categories` (`id`, `parent_id`, `name`, `slug`, `status`, `created`, `modified`) VALUES
(22,	0,	'Business',	'business',	'A',	'2017-07-20 20:57:05',	'2017-07-30 10:21:56'),
(23,	0,	'Technology',	'technology',	'A',	'2017-07-30 10:22:13',	'2017-07-30 10:22:13'),
(24,	0,	'Marketing',	'marketing',	'A',	'2017-07-30 10:22:27',	'2017-07-30 10:22:27'),
(25,	22,	'New cat',	'new-cat',	'A',	'2017-07-31 20:08:36',	'2017-07-31 20:08:36');

DROP TABLE IF EXISTS `learn_news_comments`;
CREATE TABLE `learn_news_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `news_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `comment` text NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '0' COMMENT '1=>Active, 0=>Inactive',
  `user_ip` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `learn_news_comments` (`id`, `user_id`, `news_id`, `name`, `email`, `comment`, `status`, `user_ip`, `created`, `modified`) VALUES
(1,	0,	2,	'Test',	'test@gmail.com',	'this is testing comment',	'1',	'47.15.12.34',	'2017-08-26 10:37:17',	'2017-08-26 10:37:17'),
(2,	21,	6,	NULL,	NULL,	'test hjhk kkk',	'0',	'110.225.0.177',	'2017-08-27 18:04:19',	'2017-08-27 18:04:19'),
(3,	2,	6,	NULL,	NULL,	'hi boss',	'1',	'47.15.2.161',	'2017-09-08 19:23:45',	'2017-09-08 19:23:45'),
(4,	27,	6,	NULL,	NULL,	'Hi thi is test...',	'1',	'47.15.8.21',	'2017-12-17 16:53:35',	'2017-12-17 16:53:52');

DROP TABLE IF EXISTS `learn_questions`;
CREATE TABLE `learn_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `learn_questions` (`id`, `category_id`, `user_id`, `name`, `slug`, `short_description`, `learning_goal`, `education_history`, `budget_constraints`, `preferred_learning_mode`, `response_email`, `is_featured`, `user_type`, `view`, `status`, `created`, `modified`) VALUES
(3,	18,	NULL,	'When has discrete understanding preceded continuous?',	NULL,	'When has discrete understanding preceded continuous When has discrete understanding preceded continuous',	'',	'',	'',	'',	'N',	'Y',	'A',	5,	'A',	'2017-08-12 12:32:52',	'2018-01-16 21:46:08'),
(4,	20,	1,	'What is business??',	NULL,	'new short description new short descriptionnew short descriptionnew short descriptionnew short descriptionnew short descriptionnew short descriptionnew short descriptionnew short descriptionnew short descriptionnew short descriptionnew short descriptionnew short descriptionnew short descriptionnew short descriptionnew short descriptionnew short descriptionnew short descriptionnew short descriptionnew short descriptionnew short descriptionnew short descriptionnew short descriptionnew short descriptionnew short descriptionnew short description',	'',	'',	'',	'',	'N',	'Y',	'U',	8,	'A',	'2017-08-13 03:07:09',	'2018-01-16 21:46:09'),
(5,	19,	NULL,	'latest question',	NULL,	'posted by me',	'',	'',	'',	'',	'N',	'',	'A',	7,	'A',	'2017-08-15 18:19:21',	'2018-01-16 21:46:11'),
(6,	18,	NULL,	'this is also a new question',	NULL,	'by details ',	'',	'',	'',	'',	'N',	'',	'A',	19,	'A',	'2017-08-15 18:19:55',	'2018-01-16 13:55:20'),
(7,	20,	27,	'My tets question',	NULL,	'test description',	'<p>test learning goal<br></p>',	'',	'<p>test budget<br></p>',	'<p>test input<br></p>',	'Y',	'Y',	'U',	37,	'A',	'2017-08-24 20:27:10',	'2018-01-16 13:55:23'),
(8,	20,	21,	'Test questions 31 aug ?',	NULL,	'test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description ',	'<p>test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description&nbsp;<br></p>',	'BTech at GCETTS from 1st December 2016 to 3rd July 2017\r\nHS at BKAPI from 1st August 2017 to 24th August 2017',	'<p>test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description&nbsp;<br></p>',	'<p>test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description test description&nbsp;<br></p>',	'Y',	'Y',	'U',	110,	'A',	'2017-08-31 12:58:19',	'2018-01-16 13:55:26'),
(9,	18,	27,	'A new question',	NULL,	'my latest description1',	'<p>Learning Goal<br></p>',	'New edu 1 at new school 1 from 7th May 2017 to 15th May 2017<br />',	'<p>Budget &amp; other constraints<br></p>',	'<p>Optional input on preferred learning mode <br></p>',	'Y',	'Y',	'U',	23,	'A',	'2017-09-08 19:11:33',	'2018-01-21 00:06:28'),
(10,	19,	34,	'How to learn Spanish well?',	NULL,	'Would you recommend me a learning path, and an institution, to learn the Spanish language from scratch?',	'<p>First, to grasp the Spanish on a conversational level. Second, to be able to read books in Spanish. Third, to understand TV and movies in Spanish. In this order.<br></p>',	'I just understand a few words, otherwise I speak English as foreign language decently well. My native is Czech.',	'<p>I would be happy to spend a budget of app USD 1-3 th. on it, depending on the intensity. I probably can spare 1 hour per day, and some 2 hours at selected days.<br></p>',	'<p>Well, one on one or a small class would be great; I however can think of a combination of offline learning of the grammar and vocabulary, and face to face for corrections and conversation.<br></p>',	'Y',	'N',	'U',	81,	'A',	'2017-09-10 20:40:18',	'2018-01-20 16:37:53');

DROP TABLE IF EXISTS `learn_question_answers`;
CREATE TABLE `learn_question_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL COMMENT 'Question Id from questions table',
  `user_id` int(11) NOT NULL COMMENT 'User Id from "users" table',
  `learning_path_recommendation` text NOT NULL,
  `learning_experience` text NOT NULL,
  `learning_utility` text NOT NULL,
  `answer` text,
  `status` enum('A','I') NOT NULL DEFAULT 'I',
  `user_ip` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `learn_question_answers` (`id`, `question_id`, `user_id`, `learning_path_recommendation`, `learning_experience`, `learning_utility`, `answer`, `status`, `user_ip`, `created`, `modified`) VALUES
(1,	6,	27,	'<p>test1<br></p>',	'<p>test2<br></p>',	'test3<p><br></p>',	NULL,	'A',	'',	'2017-08-26 20:39:56',	'2017-08-26 20:39:56'),
(2,	6,	21,	'<p>test test test test test test test test test test test test&nbsp;<br></p>',	'<p>test test test test test test test test test test test test 000<br></p>',	'<p>test test test test test test test test test test test test 111<br></p>',	NULL,	'A',	'',	'2017-08-27 17:59:46',	'2017-08-27 17:59:46'),
(3,	6,	27,	'<p>test1<br></p>',	'<p>test2<br></p>',	'<p>test3<br></p>',	NULL,	'A',	'',	'2017-08-27 18:27:08',	'2017-08-27 18:27:08'),
(4,	8,	27,	'<p>Modules 1-4 each require a post-module assignment to reinforce what is \r\nlearned in class. In Module 5, the assignment is accomplished during \r\nclass (with some evening work during the module). Each assignment and \r\nassociated readings may require up to 20 hours to complete. Module 6 \r\n(the practicum) involves the design, development, and facilitation of an\r\n actual training program and time requirements vary. Learners usually \r\ncomplete the practicum in 6 months or more of part-time work/study.<br></p>',	'<p>Modules 1-4 each require a post-module assignment to reinforce what is \r\nlearned in class. In Module 5, the assignment is accomplished during \r\nclass (with some evening work during the module). Each assignment and \r\nassociated readings may require up to 20 hours to complete. Module 6 \r\n(the practicum) involves the design, development, and facilitation of an\r\n actual training program and time requirements vary. Learners usually \r\ncomplete the practicum in 6 months or more of part-time work/study.<br></p>',	'<p>Modules 1-4 each require a post-module assignment to reinforce what is \r\nlearned in class. In Module 5, the assignment is accomplished during \r\nclass (with some evening work during the module). Each assignment and \r\nassociated readings may require up to 20 hours to complete. Module 6 \r\n(the practicum) involves the design, development, and facilitation of an\r\n actual training program and time requirements vary. Learners usually \r\ncomplete the practicum in 6 months or more of part-time work/study.<br></p>',	NULL,	'A',	'47.15.11.173',	'2017-08-31 20:17:45',	'2017-08-31 20:17:45'),
(5,	8,	1,	'<p>Modules 1-4 each require a post-module assignment to reinforce what is \r\nlearned in class. In Module 5, the assignment is accomplished during \r\nclass (with some evening work during the module). Each assignment and \r\nassociated readings may require up to 20 hours to complete. Module 6 \r\n(the practicum) involves the design, development, and facilitation of an\r\n actual training program and time requirements vary. Learners usually \r\ncomplete the practicum in 6 months or more of part-time work/study.<br></p>',	'<p>Modules 1-4 each require a post-module assignment to reinforce what is \r\nlearned in class. In Module 5, the assignment is accomplished during \r\nclass (with some evening work during the module). Each assignment and \r\nassociated readings may require up to 20 hours to complete. Module 6 \r\n(the practicum) involves the design, development, and facilitation of an\r\n actual training program and time requirements vary. Learners usually \r\ncomplete the practicum in 6 months or more of part-time work/study.<br></p>',	'<p>Modules 1-4 each require a post-module assignment to reinforce what is \r\nlearned in class. In Module 5, the assignment is accomplished during \r\nclass (with some evening work during the module). Each assignment and \r\nassociated readings may require up to 20 hours to complete. Module 6 \r\n(the practicum) involves the design, development, and facilitation of an\r\n actual training program and time requirements vary. Learners usually \r\ncomplete the practicum in 6 months or more of part-time work/study.<br></p>',	NULL,	'A',	'47.15.11.173',	'2017-08-31 20:21:22',	'2017-08-31 20:21:22'),
(6,	7,	1,	'<p>this is learingpath&nbsp;&nbsp;&nbsp;&nbsp;<br></p>',	'<p>this is learning experience<br></p>',	'<p>this is learning utility<br></p>',	NULL,	'A',	'47.15.1.254',	'2017-09-07 18:51:27',	'2017-09-07 18:51:27'),
(7,	8,	35,	'<p><span style=\"color: rgb(41, 43, 44); font-size: 13px; font-style: italic;\">Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter a</span><br></p>',	'<p><span style=\"color: rgb(41, 43, 44); font-size: 13px; font-style: italic;\">Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter a</span></p><p><span style=\"color: rgb(41, 43, 44); font-size: 13px; font-style: italic;\">Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter a</span><span style=\"color: rgb(41, 43, 44); font-size: 13px; font-style: italic;\"><br></span><br></p>',	'<p><span style=\"color: rgb(41, 43, 44); font-size: 13px; font-style: italic;\">Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter a</span></p><p><span style=\"color: rgb(41, 43, 44); font-size: 13px; font-style: italic;\">Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter a</span><span style=\"color: rgb(41, 43, 44); font-size: 13px; font-style: italic;\"><br></span><br></p>',	NULL,	'A',	'110.227.98.195',	'2017-09-08 21:28:51',	'2017-09-08 21:28:51'),
(8,	10,	21,	'<p>sdsd fsd fsdf sdf</p>',	'<p>f sdf dsf dsf</p>',	'<p>dsf sdf sdf dsf</p>',	NULL,	'I',	'122.163.76.82',	'2017-09-11 20:34:14',	'2017-09-11 20:34:14'),
(9,	7,	34,	'<p>My recommendation<br></p>',	'<p>My experience<br></p>',	'<p>My utility<br></p>',	NULL,	'A',	'46.135.78.164',	'2017-09-23 19:43:47',	'2017-09-23 19:43:47'),
(10,	10,	40,	'<p>test from sukanta</p>',	'<p>test from sukanta111<br></p>',	'<p>test from sukanta222<br></p>',	NULL,	'A',	'110.227.73.213',	'2017-10-07 20:57:28',	'2017-10-07 20:57:28'),
(11,	10,	40,	'<p>sdfd sd dsf ds</p>',	'<p>sdf sd sdf1sdf</p>',	'<p>dsf dsf dsfggggg</p>',	NULL,	'A',	'110.227.73.213',	'2017-10-07 20:59:39',	'2017-10-07 20:59:39'),
(12,	10,	40,	'<p>dsad asd asd asd asd</p>',	'<p>asda sd asda sd asdasd</p>',	'<p>asd asd asd asdasdasdasd asd&nbsp; das d</p>',	NULL,	'A',	'110.227.73.213',	'2017-10-07 21:02:46',	'2017-10-07 21:02:46'),
(13,	9,	34,	'<p>AAA<br></p>',	'<p>BBB<br></p>',	'<p>CCC<br></p>',	NULL,	'A',	'46.135.79.231',	'2017-10-22 12:01:36',	'2017-10-22 12:01:36'),
(14,	10,	27,	'<p>test Learning Path recommendation<br></p>',	'<p>test What was your learning experience<br></p>',	'<p>test What was your learning utility<br><p><br></p></p>',	NULL,	'A',	'47.15.9.41',	'2017-10-29 19:12:54',	'2017-10-29 19:12:54'),
(15,	9,	34,	'<p>Learning by doing<br></p>',	'<p>Good<br></p>',	'<p>In 3 months I managed to be skilled<br></p>',	NULL,	'A',	'90.179.53.6',	'2017-11-12 11:49:12',	'2017-11-12 11:49:12'),
(16,	6,	34,	'<p>aaa<br></p>',	'<p>bbb<br></p>',	'<p>ccc<br></p>',	NULL,	'A',	'90.179.53.6',	'2017-11-12 14:05:40',	'2017-11-12 14:05:40');

DROP TABLE IF EXISTS `learn_question_categories`;
CREATE TABLE `learn_question_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `status` enum('A','I') NOT NULL DEFAULT 'I' COMMENT '''A'' => Active, ''I'' => Inactive',
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `learn_question_categories` (`id`, `parent_id`, `name`, `slug`, `status`, `modified`, `created`) VALUES
(18,	0,	'Category1',	'category1',	'A',	'2017-08-01 18:22:19',	'2017-08-01 18:22:19'),
(19,	0,	'Category 2',	'category-2',	'A',	'2017-08-01 18:22:37',	'2017-08-01 18:22:37'),
(20,	18,	'Cat 11',	'cat-11',	'A',	'2017-08-01 18:23:26',	'2017-08-01 18:23:26'),
(21,	18,	'New sub cat',	'new-sub-cat',	'A',	'2017-10-14 16:33:59',	'2017-10-14 16:33:59'),
(22,	21,	'Sub sub cat',	'sub-sub-cat',	'A',	'2017-10-14 16:34:13',	'2017-10-14 16:34:13'),
(23,	21,	'Another sub cat',	'another-sub-cat',	'A',	'2017-10-14 16:34:32',	'2017-10-14 16:34:32'),
(24,	19,	'Test sub cat',	'test-sub-cat',	'A',	'2017-10-14 16:35:15',	'2017-10-14 16:35:15'),
(25,	24,	'working',	'working',	'A',	'2017-10-14 16:35:27',	'2017-10-14 16:35:27'),
(26,	24,	'good enough ',	'good-enough',	'A',	'2017-10-14 16:35:51',	'2017-10-14 16:35:51');

DROP TABLE IF EXISTS `learn_question_comments`;
CREATE TABLE `learn_question_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '0' COMMENT '1=>Approved, 0=>Not approved',
  `user_ip` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `learn_question_comments` (`id`, `user_id`, `question_id`, `comment`, `status`, `user_ip`, `created`, `modified`) VALUES
(1,	27,	8,	'Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter a ',	'1',	'47.15.11.173',	'2017-08-31 20:15:08',	'2017-08-31 20:15:08'),
(2,	1,	8,	'Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter a  Lorem ipsum dolor sit amet, consecteter adipiscing elit , sed diam nonummy nibh euin mod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minimi iam, quis nostrud exerci. Lorem ipsum dolor sit amet, consecteter a ',	'1',	'47.15.11.173',	'2017-08-31 20:16:25',	'2017-08-31 20:16:25'),
(4,	1,	7,	'please test',	'0',	'47.15.1.254',	'2017-09-07 19:42:26',	'2017-09-07 19:42:26'),
(5,	35,	8,	'This is a test 1',	'1',	'110.227.98.195',	'2017-09-08 21:26:55',	'2017-10-22 16:30:48'),
(6,	34,	8,	'Testing comment',	'1',	'90.179.53.6',	'2017-09-10 20:54:22',	'2017-09-10 20:54:22'),
(7,	34,	7,	'Another test comment',	'0',	'90.179.53.6',	'2017-09-10 20:57:25',	'2017-11-26 14:23:49'),
(8,	21,	10,	'dfg  df dfg dfgfg dfgtttttttttttttttttttt',	'1',	'122.163.91.97',	'2017-09-20 18:19:14',	'2017-09-20 18:19:14'),
(9,	34,	9,	'This is a good question, although would benefit from a bit further specification',	'1',	'46.135.10.110',	'2017-10-01 13:08:33',	'2017-10-01 13:08:33');

DROP TABLE IF EXISTS `learn_question_tags`;
CREATE TABLE `learn_question_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL COMMENT 'Question Id from "questions" table',
  `user_id` int(11) DEFAULT NULL COMMENT 'Submitter Id',
  `tag_id` int(11) NOT NULL COMMENT 'Tag Id from "tags" table',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `learn_question_tags` (`id`, `question_id`, `user_id`, `tag_id`) VALUES
(7,	3,	NULL,	1),
(8,	3,	NULL,	2),
(9,	3,	NULL,	13),
(12,	4,	NULL,	1),
(13,	4,	NULL,	10),
(14,	4,	NULL,	14),
(15,	4,	NULL,	18),
(16,	5,	NULL,	7),
(17,	5,	NULL,	20),
(18,	5,	NULL,	23),
(19,	6,	NULL,	17),
(20,	6,	NULL,	22),
(21,	7,	27,	3),
(22,	7,	27,	8),
(23,	7,	27,	10),
(24,	7,	27,	12),
(25,	8,	21,	1),
(26,	8,	21,	2),
(67,	9,	NULL,	2),
(68,	9,	NULL,	3),
(69,	9,	NULL,	8),
(70,	10,	NULL,	21);

DROP TABLE IF EXISTS `learn_tags`;
CREATE TABLE `learn_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `status` enum('A','I') NOT NULL DEFAULT 'I' COMMENT 'A=>Active, I=>Inactive',
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `learn_tags` (`id`, `title`, `slug`, `status`, `created`) VALUES
(1,	'Android',	'android',	'A',	'2017-07-29 16:03:02'),
(2,	'Apps',	'apps',	'A',	'2017-07-29 16:03:11'),
(3,	'Analog',	'analog',	'A',	'2017-07-29 16:03:22'),
(4,	'Angular',	'angular',	'A',	'2017-07-29 16:03:34'),
(7,	'Bid',	'bid',	'A',	'2017-07-29 16:04:39'),
(8,	'Batfied',	'batfied',	'A',	'2017-07-29 16:04:53'),
(9,	'Car',	'car',	'A',	'2017-07-29 16:05:02'),
(10,	'Commercial',	'commercial',	'A',	'2017-07-29 16:05:17'),
(11,	'Demo',	'demo',	'A',	'2017-07-29 16:05:32'),
(12,	'Designer',	'designer',	'A',	'2017-07-29 16:05:42'),
(13,	'Facebook',	'facebook',	'A',	'2017-08-03 20:44:48'),
(14,	'Budget',	'budget',	'A',	'2017-08-13 17:51:03'),
(15,	'Business',	'business',	'A',	'2017-08-13 17:51:17'),
(16,	'Follow',	'follow',	'A',	'2017-08-13 17:51:50'),
(17,	'Game',	'game',	'A',	'2017-08-13 17:52:00'),
(18,	'Hotspot',	'hotspot',	'A',	'2017-08-13 17:52:11'),
(19,	'Hifi',	'hifi',	'A',	'2017-08-13 17:52:18'),
(20,	'Inkjet',	'inkjet',	'A',	'2017-08-13 17:52:27'),
(21,	'Jumbo Speaker',	'jumbo-speaker',	'A',	'2017-08-13 17:52:38'),
(22,	'Keyboard',	'keyboard',	'A',	'2017-08-13 17:52:48'),
(23,	'Lamp',	'lamp',	'A',	'2017-08-13 17:52:55'),
(24,	'Auction',	'auction',	'A',	'2017-08-14 16:29:09');

DROP TABLE IF EXISTS `learn_users`;
CREATE TABLE `learn_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `is_setting` enum('1','0') NOT NULL DEFAULT '0' COMMENT '1=>Checked settings, 0=>Uncheck',
  `status` enum('A','I') NOT NULL DEFAULT 'I' COMMENT 'A=>active, I=>inactive',
  `loggedin_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `loggedin_status` int(2) NOT NULL DEFAULT '0' COMMENT '1=>Online, 0=>Offline',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `learn_users` (`id`, `name`, `profile_pic`, `location`, `title`, `email`, `notification_email`, `password`, `full_name`, `birthday`, `about_me`, `signup_string`, `forget_password_string`, `signup_ip`, `is_verified`, `type`, `facebook_id`, `googleplus_id`, `twitter_id`, `linkedin_id`, `facebook_link`, `twitter_link`, `gplus_link`, `linkedin_link`, `modified`, `created`, `agree`, `is_setting`, `status`, `loggedin_time`, `loggedin_status`) VALUES
(1,	'David',	'profile_150202763973.jpg',	'Kolkata',	'David',	'david@gmail.com',	'100websolution@gmail.com',	'$2y$10$bT9D97KJDcn63.2VXscHi.i0NfyexDra7L2qm6GuXRW/KxDkB3EVK',	'David Gomes',	'2002-03-16',	'testing',	NULL,	NULL,	NULL,	'0',	'N',	'',	'',	'',	'',	'http://www.facebook.com',	'http://www.twitter.com',	'http://www.gplus.com',	'http://linkedin.com',	'2017-09-07 20:13:40',	'2017-08-06 13:54:00',	'Y',	'0',	'A',	'2017-10-06 20:24:42',	0),
(2,	'Sujoy',	'profile_150277583117.jpg',	'Dhanbad',	'test title',	'sujoy@gmail.com',	NULL,	'$2y$10$BgZWXXcS/r5RYs4UFIRgBO10WoNj3w/77KLxv1fmxtRDPpLzUtTh6',	'Sujoy Kar',	'2004-08-03',	'I\'m a student',	NULL,	NULL,	NULL,	'0',	'N',	'',	'',	'',	'',	'http://www.facebook.com',	'http://www.twitter.com',	'http://www.gplus.com',	'http://www.linkedin.com',	'2017-08-15 05:43:51',	'2017-08-15 05:43:51',	'Y',	'0',	'A',	'2017-10-06 20:25:31',	0),
(3,	'Gordon',	'profile_150277954667.jpg',	'New York, United Sates',	'My gordon',	'gordon@gmail.com',	NULL,	'$2y$10$LIfmgn9B21UFIEtsWTM87e35RIXgvjasNDBILnqzl2Rqbxj1jUAu6',	'Gordon Linoff',	'1985-02-08',	'nothing to say',	NULL,	NULL,	NULL,	'0',	'N',	'',	'',	'',	'',	'',	'http://www.twitter.com',	'',	'',	'2017-08-15 06:45:47',	'2017-08-15 06:45:47',	'Y',	'0',	'A',	NULL,	0),
(4,	'Sumon',	'profile_150279809947.png',	'Chennai',	'this is chennai style',	'sumon@gmail.com',	NULL,	'$2y$10$XClpvV3BK1aCau23jrSvKuY0/GsBZ2AC8ZuAoFEnGZ0zSxm2oguG.',	'Sumon Das',	'1992-08-09',	'this is',	NULL,	NULL,	NULL,	'0',	'N',	'',	'',	'',	'',	'',	'',	'http://www.gplus.com',	'',	'2017-08-15 11:54:59',	'2017-08-15 11:54:59',	'Y',	'0',	'A',	NULL,	0),
(21,	'Suk',	'profile_15035186870.jpg',	'Kolkata',	'Test',	'sukanta.info3@gmail.com',	'sukanta.info3@gmail.com',	'$2y$10$nVx.D/X51g7PwRfwDd3Tt.eclo3BEvjfkUOWdwbo.USGFpI2Agtta',	'Sukanta Sarkar',	'1972-10-18',	'tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets tets ',	'',	'',	'122.163.86.28',	'1',	'N',	'',	'',	'',	'',	'',	'',	'',	'',	'2017-08-23 20:11:23',	'2017-08-19 18:44:51',	'Y',	'0',	'A',	'2017-10-08 21:01:58',	0),
(22,	'max',	NULL,	NULL,	NULL,	'techtimes14@gmail.com',	NULL,	'$2y$10$GxcwCd3TQaAWx5WU.V7xLOi3KviIxOdgl/Pnd6V5qfU8nQ401gPuy',	NULL,	NULL,	NULL,	'IGQ1503168384CSN',	NULL,	'122.163.86.28',	'0',	'N',	'',	'',	'',	'',	NULL,	NULL,	NULL,	NULL,	'2017-08-19 18:46:24',	'2017-08-19 18:46:24',	'Y',	'0',	'I',	NULL,	0),
(23,	'jhjk',	NULL,	NULL,	NULL,	'techtimes14@gmail.co',	NULL,	'$2y$10$7lU2XiN./qNgEQ62vW9U1e39.yep1pZvWjsOIk7NhQBnBFvfUq55K',	NULL,	NULL,	NULL,	'VEF1503169199ZSH',	NULL,	'122.163.86.28',	'0',	'N',	'',	'',	'',	'',	NULL,	NULL,	NULL,	NULL,	'2017-08-19 18:59:59',	'2017-08-19 18:59:59',	'Y',	'0',	'I',	NULL,	0),
(27,	'Mitkar',	'profile_15034281190.jpg',	'Kolkata',	'this is Kolkata style',	'100websolution@gmail.com',	'100websolution@gmail.com',	'$2y$10$l7bdbg8.eC6FnhwwRK3XZOU2zacuCZFzcm80lWMGxF67EfGxa3jyu',	'Mitkar Ghosh',	'1987-02-16',	'nothing to say',	'',	'',	'47.15.5.107',	'1',	'N',	'',	'',	'',	'',	'http://www.facebook.com',	'',	'',	'http://www.linkedin.com',	'2017-09-08 19:08:41',	'2017-08-19 19:22:51',	'Y',	'0',	'A',	'2018-01-01 15:49:56',	0),
(30,	'Subhas',	NULL,	NULL,	NULL,	'subhas@fakeinbox.info',	'newsu@fakeinbox.info',	'$2y$10$8cv0uKyxH3fz.20qk0HEW.CuWfSOidojXOBFLZ8426bN7twyP90TK',	NULL,	NULL,	NULL,	'',	NULL,	'47.15.5.48',	'1',	'N',	'',	'',	'',	'',	NULL,	NULL,	NULL,	NULL,	'2017-08-23 19:21:43',	'2017-08-23 19:16:33',	'Y',	'0',	'A',	NULL,	0),
(31,	'sdgd',	NULL,	NULL,	NULL,	'esha.info900@gmail.com',	NULL,	'$2y$10$qGBpmlsC2fQsQa9X4Atw4OKNIcI81.Dkyi.ZhA7RdaynzIHBOib8u',	NULL,	NULL,	NULL,	'',	NULL,	'110.227.88.40',	'1',	'N',	'',	'',	'',	'',	NULL,	NULL,	NULL,	NULL,	'2017-08-23 20:32:20',	'2017-08-23 20:32:20',	'Y',	'0',	'A',	'2017-10-14 15:10:01',	0),
(32,	'Sbs',	NULL,	NULL,	NULL,	'sbs@fakeinbox.info',	NULL,	'$2y$10$pJIY7Mol7uUYYmW9TO/eruM1d5E15CAH3q1s6D.Xx4HmhkpNAGyXy',	NULL,	NULL,	NULL,	'',	NULL,	'47.15.12.246',	'1',	'N',	'',	'',	'',	'',	NULL,	NULL,	NULL,	NULL,	'2017-08-26 12:10:37',	'2017-08-26 12:10:37',	'Y',	'0',	'A',	NULL,	0),
(33,	'Learner1',	NULL,	NULL,	NULL,	'spinskillsup@gmail.com',	NULL,	'$2y$10$C4tFP9HeARhPtIFATNa2suOSi/K9hhq4yy9Y5rZATRxyAK1QQGdTO',	NULL,	NULL,	NULL,	'TKC1503838438TRL',	NULL,	'90.179.101.195',	'0',	'N',	'',	'',	'',	'',	NULL,	NULL,	NULL,	NULL,	'2017-08-27 12:53:59',	'2017-08-27 12:53:59',	'Y',	'0',	'I',	NULL,	0),
(34,	'Learner1',	NULL,	NULL,	NULL,	'administrator@learneron.net',	NULL,	'$2y$10$lalptd61MVFfXWo4FfKs4eTZHoD9r.qRyDKL118H9F62oQKpleQSG',	NULL,	NULL,	NULL,	'',	'',	'90.179.53.6',	'1',	'N',	'',	'',	'',	'',	NULL,	NULL,	NULL,	NULL,	'2017-09-10 20:26:03',	'2017-08-29 06:38:43',	'Y',	'0',	'A',	'2017-12-24 11:41:48',	0),
(35,	'TechTimes',	'profile_15092974744.jpg',	NULL,	NULL,	'sukdevloper@gmail.com',	NULL,	'$2y$10$DNRCnkxqGRN4tlfXo1ZDAum20jlcP4swrhq2xPb4SMhy.J7loCXGC',	NULL,	NULL,	NULL,	'',	NULL,	'110.227.98.195',	'1',	'N',	'',	'',	'',	'',	NULL,	NULL,	NULL,	NULL,	'2017-10-29 17:17:56',	'2017-09-08 21:20:06',	'Y',	'0',	'A',	'2017-12-17 18:05:21',	0),
(40,	'Puja',	'profile_15075750340.jpg',	NULL,	NULL,	'duttapoly.info@gmail.com',	NULL,	NULL,	'Puja Paul',	NULL,	NULL,	NULL,	NULL,	'110.225.22.131',	'',	'F',	'1450066711749441',	'',	'',	'',	NULL,	NULL,	NULL,	NULL,	'2017-10-09 18:50:34',	'2017-09-24 17:55:37',	'Y',	'0',	'A',	'2017-10-09 19:03:00',	0),
(41,	'Esha',	'http://graph.facebook.com/2047345325495104/picture?width=9999',	'Kolkata',	'Web Designer',	'esha.socialsites@gmail.com',	NULL,	NULL,	'Esha Saha',	'2017-09-04',	'I am a nice girl',	NULL,	NULL,	'116.203.180.112',	'',	'F',	'2047345325495104',	'',	'',	'',	'http://facebook.com',	'http://facebook.com',	'http://facebook.com',	'http://facebook.com',	'2017-09-29 03:24:58',	'2017-09-29 03:21:57',	'Y',	'0',	'A',	NULL,	0),
(46,	'Sukanta',	'profile_15075778415.jpg',	NULL,	NULL,	'sukanta.info10@gmail.com',	NULL,	NULL,	'Sukanta Sarkar',	NULL,	NULL,	NULL,	'EIL1507988643BMZ',	'47.15.9.107',	'1',	'T',	'',	'',	'3113475737',	'',	NULL,	NULL,	NULL,	NULL,	'2017-10-09 19:37:21',	'2017-10-08 12:07:56',	'Y',	'0',	'A',	'2017-10-14 11:44:08',	0),
(48,	'njoroge',	'profile_15080678353.jpg',	NULL,	NULL,	'njorogeikonye@gmail.com',	NULL,	NULL,	'njoroge ikonye',	NULL,	NULL,	NULL,	NULL,	'110.227.111.110',	'1',	'G',	'',	'109813575415969680831',	'',	'',	NULL,	NULL,	'https://plus.google.com/+njorogeikonye',	NULL,	'2017-10-15 11:43:55',	'2017-10-08 14:50:12',	'Y',	'0',	'A',	'2017-10-15 11:44:07',	0),
(49,	'Sukanta',	'profile_15086891222.jpg',	'Kolkata Area, India',	NULL,	'sukanta.info2@gmail.com',	NULL,	NULL,	'Sukanta Sarkar',	NULL,	NULL,	NULL,	'VNA1510088229JKH',	'110.227.96.198',	'1',	'L',	'',	'',	'',	'OfwJ3ZH80d',	NULL,	NULL,	NULL,	'https://www.linkedin.com/in/sukanta-sarkar-1064a786',	'2017-10-22 16:18:42',	'2017-10-14 19:00:55',	'Y',	'0',	'A',	'2017-11-07 20:57:09',	0),
(50,	'Esha',	'profile_15086890947.jpg',	'Kolkata Area, India',	NULL,	'esha.info90@gmail.com',	NULL,	NULL,	'Esha Saha',	NULL,	NULL,	NULL,	NULL,	'110.227.96.198',	'1',	'L',	'',	'',	'',	'opeejufEHx',	NULL,	NULL,	NULL,	'https://www.linkedin.com/in/esha-saha-82a50b86',	'2017-10-22 16:18:15',	'2017-10-14 22:10:34',	'Y',	'0',	'A',	'2017-10-22 16:29:46',	0),
(51,	'Sanjay',	'profile_15148219291.jpg',	NULL,	NULL,	'sanjoy86.jk@gmail.com',	NULL,	NULL,	'Sanjay Karmakar',	NULL,	NULL,	NULL,	NULL,	'47.15.26.233',	'1',	'F',	'1799566236743627',	'',	'',	'',	NULL,	NULL,	NULL,	NULL,	'2018-01-01 15:52:09',	'2018-01-01 15:52:09',	'Y',	'0',	'A',	'2018-01-01 15:52:20',	0);

DROP TABLE IF EXISTS `learn_user_account_settings`;
CREATE TABLE `learn_user_account_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'Id from User table',
  `response_to_my_question_notification` enum('1','0') NOT NULL DEFAULT '0' COMMENT '1=>Get notification, 0=>No notification',
  `news_notification` enum('1','0') NOT NULL DEFAULT '0' COMMENT '1=>Get notification, 0=>No notification',
  `follow_twitter` enum('1','0') NOT NULL DEFAULT '0' COMMENT '1=>Follow, 0=>No follow',
  `posting_new_question_notification` enum('1','0') NOT NULL DEFAULT '0' COMMENT '1=>Get notification, 0=>No notification',
  `category_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `learn_user_account_settings` (`id`, `user_id`, `response_to_my_question_notification`, `news_notification`, `follow_twitter`, `posting_new_question_notification`, `category_id`, `created`, `modified`) VALUES
(1,	30,	'1',	'0',	'1',	'0',	0,	'2017-08-23 19:21:49',	'2017-08-23 19:23:18'),
(2,	21,	'0',	'0',	'0',	'0',	0,	'2017-08-23 19:59:36',	'2017-08-23 20:01:07'),
(3,	34,	'1',	'1',	'1',	'1',	19,	'2017-08-29 07:08:18',	'2017-10-08 19:16:48'),
(4,	27,	'1',	'1',	'1',	'1',	20,	'2017-09-07 18:50:24',	'2017-09-21 20:31:29'),
(5,	1,	'1',	'1',	'1',	'0',	0,	'2017-09-07 20:14:03',	'2017-09-07 20:14:03');

-- 2018-01-21 04:43:26
