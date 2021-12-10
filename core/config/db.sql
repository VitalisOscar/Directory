CREATE DATABASE IF NOT EXISTS `places`;

USE `places`;

CREATE TABLE IF NOT EXISTS `users`(
    `id` INTEGER(11) PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `email` VARCHAR(50) UNIQUE NOT NULL,
    `phone` VARCHAR(15) UNIQUE NOT NULL,
    `password` VARCHAR(100) NOT NULL,
    `registered_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS `categories`(
    `id` INTEGER(11) PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS `businesses`(
    `id` INTEGER(11) PRIMARY KEY AUTO_INCREMENT,
    `user_id` INTEGER(11) NOT NULL REFERENCES `users`(`id`),
    `category_id` INTEGER(11) NOT NULL REFERENCES `categories`(`id`),
    `name` VARCHAR(50) NOT NULL,
    `address` VARCHAR(100) NOT NULL,
    `description` TEXT NOT NULL,
    `email` VARCHAR(50) NOT NULL,
    `phone` VARCHAR(15) NOT NULL,
    `website` VARCHAR(50) NULL,
    `logo` VARCHAR(50) NULL,
    `images` TEXT NULL,
    `added_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS `reviews`(
    `id` INTEGER(11) PRIMARY KEY AUTO_INCREMENT,
    `user_id` INTEGER(11) NOT NULL REFERENCES `users`(`id`),
    `business_id` INTEGER(11) NOT NULL REFERENCES `businesses`(`id`),
    `title` VARCHAR(50) NULL,
    `review` VARCHAR(100) NULL,
    `rating` INTEGER(1) NOT NULL,
    `added_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS `acknowledgements`(
    `id` INTEGER(11) PRIMARY KEY AUTO_INCREMENT,
    `user_id` INTEGER(11) NOT NULL REFERENCES `users`(`id`),
    `business_id` INTEGER(11) NOT NULL REFERENCES `businesses`(`id`),
    `added_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE `businesses` ADD `hours` TEXT NULL DEFAULT '{}' AFTER `website`; 

ALTER TABLE `users` ADD `role` VARCHAR(20) DEFAULT 'user' AFTER `password`;