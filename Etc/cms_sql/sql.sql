-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 02-Jul-2015 �s 23:20
-- Vers�o do servidor: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `habbo`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cms_articles`
--

DROP TABLE IF EXISTS `cms_articles`;
CREATE TABLE `cms_articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 NOT NULL COMMENT 'Article Public Title',
  `text` text CHARACTER SET utf8mb4 NOT NULL COMMENT 'Article Body Text',
  `image` varchar(255) CHARACTER SET utf8mb4 NOT NULL COMMENT 'Article Preview Image Url',
  `type` enum('box','article') CHARACTER SET utf8mb4 NOT NULL DEFAULT 'article' COMMENT 'Article Type: box = Info Text of Article. article = If is A Article',
  `external_link` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT 'default' COMMENT 'Article External Url (if ''default'' will redirect to Article Url)',
  `internal_link` varchar(255) COLLATE latin1_general_ci NOT NULL COMMENT 'Article Internal Url (For the Article Url, exmaple: yoursite.com/news/article-url) Only need put the article-url) example: my-article-name',
  `link_text` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT 'read more.' COMMENT 'Article External Url Label',
  `imagemini` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `createdate` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


-- --------------------------------------------------------

--
-- Estrutura da tabela `cms_azure_id`
--

DROP TABLE IF EXISTS `cms_azure_id`;
CREATE TABLE IF NOT EXISTS `cms_azure_id` (
  `id` int(11) NOT NULL,
  `mail` varchar(255) NOT NULL COMMENT 'Email of the User with ID'
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COMMENT='cms_azure_id is the table that represent equal of HabboID.';

-- --------------------------------------------------------

--
-- Estrutura da tabela `cms_campaigns`
--

DROP TABLE IF EXISTS `cms_campaigns`;
CREATE TABLE IF NOT EXISTS `cms_campaigns` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL COMMENT 'Campaign Public Title',
  `text` text NOT NULL COMMENT 'Campaign Body Text',
  `external_link` varchar(255) NOT NULL COMMENT 'Campaign External URL'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `cms_campaigns`
--

INSERT INTO `cms_campaigns` (`id`, `title`, `text`, `external_link`) VALUES
  (2, 'Welcome to Azure', '<p style=\\"text-align:justify\\"><img alt=\\"\\" src=\\"https://pbs.twimg.com/media/B7ZZgpkCAAAMdgX.png\\" style=\\"float:left; height:150px; margin:5px 10px; width:150px\\" />Welcome to Azure BETA</p>\\r\\n\\r\\n<p style=\\"text-align:justify\\"><strong><em>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Um abra&ccedil;o, da ger&ecirc;ncia do Hotel</em></strong></p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cms_hk_notes`
--

DROP TABLE IF EXISTS `cms_hk_notes`;
CREATE TABLE IF NOT EXISTS `cms_hk_notes` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL COMMENT 'Text of the Note'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cms_hk_ranks`
--

DROP TABLE IF EXISTS `cms_hk_ranks`;
CREATE TABLE IF NOT EXISTS `cms_hk_ranks` (
  `id` int(11) NOT NULL DEFAULT '4' COMMENT 'Rank Id',
  `name` varchar(255) NOT NULL DEFAULT 'Ambassador' COMMENT 'Rank Public Name'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `cms_hk_ranks`
--

INSERT INTO `cms_hk_ranks` (`id`, `name`) VALUES
  (4, 'Ambassador'),
  (5, 'Moderator'),
  (6, 'Senior Moderator'),
  (7, 'Administrator'),
  (8, 'Senior Administrator'),
  (9, 'Manager'),
  (10, 'Senior Manager'),
  (11, 'Director'),
  (12, 'Senior Director');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cms_hk_users`
--

DROP TABLE IF EXISTS `cms_hk_users`;
CREATE TABLE IF NOT EXISTS `cms_hk_users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL COMMENT 'User Name (In Database Encrypted as md5)',
  `password` varchar(255) NOT NULL COMMENT 'User Password (In Database Encrypted as md5)',
  `rank` enum('1','2','3','4','5') NOT NULL COMMENT 'Rank of User (1,2,3,4,5,6) (6 = Hotel Owner, the onliest rank that can create other HK users)',
  `hash` varchar(255) NOT NULL COMMENT 'Every open Session must have a Hash'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cms_shop_countries`
--

DROP TABLE IF EXISTS `cms_shop_countries`;
CREATE TABLE IF NOT EXISTS `cms_shop_countries` (
  `country_code` varchar(4) NOT NULL COMMENT 'Country Code: example: br',
  `country_id` int(5) NOT NULL COMMENT 'Country Unique Identification',
  `country_name` varchar(100) NOT NULL COMMENT 'Country Name: example: Brazil',
  `country_locale` varchar(10) NOT NULL COMMENT 'Country Locale: Must be: ''null'''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `cms_shop_countries`
--

INSERT INTO `cms_shop_countries` (`country_code`, `country_id`, `country_name`, `country_locale`) VALUES
  ('all', 5113, 'Global', 'null'),
  ('au', 5103, 'Australia', 'null'),
  ('br', 5115, 'Brazil', 'null'),
  ('ca', 5014, 'Canada', 'null'),
  ('ie', 5114, 'Ireland', 'null'),
  ('in', 5015, 'India', 'null'),
  ('my', 5016, 'Malaysia', 'null'),
  ('nz', 5017, 'New Zeland', 'null'),
  ('ph', 5108, 'Philippines', 'null'),
  ('sg', 5109, 'Singapore', 'null'),
  ('uk', 5110, 'United Kingdom', 'null'),
  ('us', 5102, 'USA', 'null');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cms_shop_inventory`
--

DROP TABLE IF EXISTS `cms_shop_inventory`;
CREATE TABLE IF NOT EXISTS `cms_shop_inventory` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Public Name',
  `description` varchar(255) NOT NULL COMMENT 'Public Description',
  `credits_amount` int(11) NOT NULL DEFAULT '0' COMMENT 'Amount of Credits',
  `price` int(11) NOT NULL DEFAULT '0' COMMENT 'Price in Real Life :p',
  `icon` enum('1','2','3','4','5','6') NOT NULL DEFAULT '1' COMMENT 'Icon Type',
  `categories` enum('HABBO_CLUB','CREDITS') NOT NULL DEFAULT 'CREDITS' COMMENT 'Item Category',
  `region` varchar(11) NOT NULL DEFAULT 'us' COMMENT 'Region of Locale (Like: br)',
  `payment_type` int(11) NOT NULL DEFAULT '0' COMMENT 'Id of the Payment Type from cms_shop_payments_types'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `cms_shop_inventory`:
--   `payment_type`
--       `cms_shop_payments_types` -> `id`
--   `region`
--       `cms_shop_countries` -> `country_code`
--

--
-- Extraindo dados da tabela `cms_shop_inventory`
--

INSERT INTO `cms_shop_inventory` (`id`, `name`, `description`, `credits_amount`, `price`, `icon`, `categories`, `region`, `payment_type`) VALUES
  (1, '6-months Habbo Club', 'Benefit from all the Habbo Club membership exclusives for 6 MONTHS! Still have some days left on your membership? The new days will just be added on t.', 0, 30, '5', 'HABBO_CLUB', 'all', 1),
  (2, '55 credits and diamonds', 'Get 55 credits and 55 diamonds! You can use them in Habbo Hotel to purchase all sorts of amazing things, like furni, pets and even Habbo Club memberships!', 55, 16, '6', 'CREDITS', 'all', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cms_shop_payments_types`
--

DROP TABLE IF EXISTS `cms_shop_payments_types`;
CREATE TABLE IF NOT EXISTS `cms_shop_payments_types` (
  `id` int(11) NOT NULL COMMENT 'Payment ID, is Important, because the Payment Dialogue will open a url like: YOURSITE/payment/order/PAYMENT_TYPE_ID/SHOP_INVENTORY_ID/',
  `name` varchar(255) NOT NULL COMMENT 'Payment Public Name',
  `button` varchar(255) NOT NULL DEFAULT 'Subscribe' COMMENT 'Payment Button Purchase Text',
  `image` varchar(255) NOT NULL DEFAULT '//habboo-a.akamaihd.net/c_images/cbs2_partner_logos/partner_logo_credit_card_005.png?h=6187207968649e80689770c84ae75f92' COMMENT 'Image of Icon'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `cms_shop_payments_types`
--

INSERT INTO `cms_shop_payments_types` (`id`, `name`, `button`, `image`) VALUES
  (1, 'Credit Card', 'Subscribe', '//habboo-a.akamaihd.net/c_images/cbs2_partner_logos/partner_logo_credit_card_005.png?h=6187207968649e80689770c84ae75f92');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cms_shop_subscriptions`
--

DROP TABLE IF EXISTS `cms_shop_subscriptions`;
CREATE TABLE IF NOT EXISTS `cms_shop_subscriptions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Public Subscription Name',
  `description` varchar(255) NOT NULL COMMENT 'Public Subscription Description',
  `credits_amount` int(11) NOT NULL DEFAULT '0' COMMENT 'Amount of Credits that will give',
  `price` int(11) NOT NULL DEFAULT '0' COMMENT 'Price in Real Life :p',
  `icon` enum('1','2','3','4','5','6','7') NOT NULL DEFAULT '1' COMMENT 'Id of the Payment Icon',
  `type` enum('0','1','2','3') NOT NULL DEFAULT '0' COMMENT 'Type of Subscription',
  `payment_type` int(11) NOT NULL DEFAULT '0' COMMENT 'Payment type id from cms_shop_payments_types',
  `region` varchar(11) NOT NULL DEFAULT 'us' COMMENT 'Region (Locale: example: us)'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `cms_shop_subscriptions`:
--   `payment_type`
--       `cms_shop_payments_types` -> `id`
--   `region`
--       `cms_shop_countries` -> `country_code`
--

--
-- Extraindo dados da tabela `cms_shop_subscriptions`
--

INSERT INTO `cms_shop_subscriptions` (`id`, `name`, `description`, `credits_amount`, `price`, `icon`, `type`, `payment_type`, `region`) VALUES
  (1, 'Credits Subscription', '35 credits + gift point entitling to an exclusive gift', 0, 5, '7', '0', 1, 'all');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cms_stories_channels`
--

DROP TABLE IF EXISTS `cms_stories_channels`;
CREATE TABLE IF NOT EXISTS `cms_stories_channels` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL COMMENT 'Public Title when Into the channel',
  `title_key` varchar(255) NOT NULL COMMENT 'Title Key (Used in CMS Language Files)',
  `description` varchar(255) NOT NULL COMMENT 'Public Description',
  `image` varchar(255) NOT NULL COMMENT 'Public Channel Image Icon',
  `url` varchar(255) NOT NULL COMMENT 'Url of the Channel (Is Automatically interpreted by CMS)',
  `tag` varchar(255) NOT NULL COMMENT 'Public Tag'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `cms_stories_channels`
--

INSERT INTO `cms_stories_channels` (`id`, `title`, `title_key`, `description`, `image`, `url`, `tag`) VALUES
  (1, 'Habbo Comics', 'CHANNEL_HABBO_COMICS_TITLE', 'CHANNEL_HABBO_COMICS_TEXT', '//habbo-stories-content.s3.amazonaws.com/habbo-comics/preview.png', 'habbo-comics', 'Habbo+Comics'),
  (2, 'Bootcamp', 'CHANNEL__BOOTCAMP__TITLE', 'CHANNEL__BOOTCAMP__TEXT', '//habbo-stories-content.s3.amazonaws.com/diy/bootcamp/preview.png', 'bootcamp', 'bootcamp');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cms_stories_channels_inventory`
--

DROP TABLE IF EXISTS `cms_stories_channels_inventory`;
CREATE TABLE IF NOT EXISTS `cms_stories_channels_inventory` (
  `id` int(11) NOT NULL,
  `channel_id` int(11) NOT NULL COMMENT 'Channel Id (Id from cms_shop_channels)',
  `user_id` int(11) NOT NULL COMMENT 'User Id from the Photo''s Owner',
  `user_name` varchar(255) NOT NULL COMMENT 'User Name from the Photo''s Owner',
  `title` varchar(255) NOT NULL COMMENT 'Title of the Photo',
  `image_url` varchar(255) NOT NULL COMMENT 'Image (Photo) Url (External)',
  `type` enum('SELFIE','USER_CREATION') NOT NULL COMMENT 'Type of Photo',
  `date` varchar(14) NOT NULL COMMENT 'Date of Creation',
  `tags` varchar(255) NOT NULL COMMENT 'Tags of the Photo'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `cms_stories_channels_inventory`:
--   `channel_id`
--       `cms_stories_channels` -> `id`
--   `user_id`
--       `users` -> `id`
--

--
-- Extraindo dados da tabela `cms_stories_channels_inventory`
--

INSERT INTO `cms_stories_channels_inventory` (`id`, `channel_id`, `user_id`, `user_name`, `title`, `image_url`, `type`, `date`, `tags`) VALUES
  (1, 2, 26, '_=oi!*', 'Meu Azure Cagado', '//habbo-stories-content.s3.amazonaws.com/diy%2Fnew-year2015%2Fhhus-1422260815685-Pixierockstar-My2015%20SNSResolutions.png', 'USER_CREATION', '1435677342544', 'new-year2015');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cms_stories_photos`
--

DROP TABLE IF EXISTS `cms_stories_photos`;
CREATE TABLE IF NOT EXISTS `cms_stories_photos` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'User Id of the Owner of the Photo',
  `user_name` varchar(255) NOT NULL COMMENT 'User Name of the Owner of the Photo',
  `room_id` int(11) NOT NULL COMMENT 'Room ID from where the photo was taken',
  `image_preview_url` varchar(255) NOT NULL COMMENT 'Image Preview Url of the Photo',
  `image_url` varchar(255) NOT NULL COMMENT 'Image Url of the Photo',
  `type` enum('PHOTO','SELFIE') NOT NULL COMMENT 'Type of the Photo',
  `date` varchar(14) NOT NULL COMMENT 'Photo Creation Date',
  `tags` varchar(255) NOT NULL COMMENT 'Photo Tags'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `cms_stories_photos`:
--   `room_id`
--       `rooms_data` -> `id`
--   `user_id`
--       `users` -> `id`
--

--
-- Extraindo dados da tabela `cms_stories_photos`
--

INSERT INTO `cms_stories_photos` (`id`, `user_id`, `user_name`, `room_id`, `image_preview_url`, `image_url`, `type`, `date`, `tags`) VALUES
  (1, 1, 'Dominic', 1, '//habbo-stories-content.s3.amazonaws.com/servercamera/purchased/hhus/0-42363577-1435588251509.png', '//habbo-stories-content.s3.amazonaws.com/servercamera/purchased/hhus/0-42363577-1435588251509.png', 'PHOTO', '1435677430455', ''),
  (2, 1, 'Dominic', 0, 'https://habbo-stories-content.s3.amazonaws.com/postcards/selfie/1435671806717-hhus-2c2908eb6eaab15eab0b954f3c2d3b3e.png', 'https://habbo-stories-content.s3.amazonaws.com/postcards/selfie/1435671806717-hhus-2c2908eb6eaab15eab0b954f3c2d3b3e.png', 'SELFIE', '1435677430455', ''),
  (3, 1, 'Dominic', 1, '//habbo-stories-content.s3.amazonaws.com/servercamera/purchased/hhus/0-42363577-1435588251509.png', '//habbo-stories-content.s3.amazonaws.com/servercamera/purchased/hhus/0-42363577-1435588251509.png', 'PHOTO', '1435677430455', '');

ALTER TABLE users ADD trade_lock ENUM('0', '1') NOT NULL DEFAULT '0';
  
--
-- Indexes for dumped tables
--

--
-- Indexes for table `cms_articles`
--
ALTER TABLE `cms_articles`
ADD PRIMARY KEY (`id`), ADD KEY `id` (`id`);

--
-- Indexes for table `cms_azure_id`
--
ALTER TABLE `cms_azure_id`
ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `mail_2` (`mail`), ADD KEY `mail` (`mail`);

--
-- Indexes for table `cms_campaigns`
--
ALTER TABLE `cms_campaigns`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_hk_notes`
--
ALTER TABLE `cms_hk_notes`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_hk_ranks`
--
ALTER TABLE `cms_hk_ranks`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_hk_users`
--
ALTER TABLE `cms_hk_users`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_shop_countries`
--
ALTER TABLE `cms_shop_countries`
ADD PRIMARY KEY (`country_code`), ADD KEY `country_code` (`country_code`);

--
-- Indexes for table `cms_shop_inventory`
--
ALTER TABLE `cms_shop_inventory`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_shop_payments_types`
--
ALTER TABLE `cms_shop_payments_types`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_shop_subscriptions`
--
ALTER TABLE `cms_shop_subscriptions`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_stories_channels`
--
ALTER TABLE `cms_stories_channels`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_stories_channels_inventory`
--
ALTER TABLE `cms_stories_channels_inventory`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_stories_photos`
--
ALTER TABLE `cms_stories_photos`
ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cms_articles`
--
ALTER TABLE `cms_articles`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `cms_azure_id`
--
ALTER TABLE `cms_azure_id`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `cms_campaigns`
--
ALTER TABLE `cms_campaigns`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `cms_hk_notes`
--
ALTER TABLE `cms_hk_notes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `cms_hk_users`
--
ALTER TABLE `cms_hk_users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cms_shop_inventory`
--
ALTER TABLE `cms_shop_inventory`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `cms_shop_payments_types`
--
ALTER TABLE `cms_shop_payments_types`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Payment ID, is Important, because the Payment Dialogue will open a url like: YOURSITE/payment/order/PAYMENT_TYPE_ID/SHOP_INVENTORY_ID/',AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `cms_shop_subscriptions`
--
ALTER TABLE `cms_shop_subscriptions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `cms_stories_channels`
--
ALTER TABLE `cms_stories_channels`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `cms_stories_channels_inventory`
--
ALTER TABLE `cms_stories_channels_inventory`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `cms_stories_photos`
--
ALTER TABLE `cms_stories_photos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

DROP TABLE IF EXISTS `cms_users_verification`;
CREATE TABLE IF NOT EXISTS `cms_users_verification` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_hash` varchar(255) NOT NULL,
  `verified` enum('false','true') NOT NULL DEFAULT 'false'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `cms_restore_password`;
CREATE TABLE IF NOT EXISTS `cms_restore_password` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_hash` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `cms_security_questions`;
CREATE TABLE IF NOT EXISTS `cms_security_questions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question_one` varchar(255) NOT NULL,
  `question_two` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

ALTER TABLE `cms_restore_password`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_users_verification`
--
ALTER TABLE `cms_users_verification`
ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for table `cms_restore_password`
--
ALTER TABLE `cms_restore_password`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `cms_users_verification`
--
ALTER TABLE `cms_users_verification`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

ALTER TABLE `users` ADD `novato` INT(2) NOT NULL DEFAULT '1';
ALTER TABLE `users` CHANGE `novato` `novato` ENUM('0','1','2') NOT NULL DEFAULT '1';

