
ALTER TABLE `profile`
ADD COLUMN `phone` VARCHAR(64) CHARACTER SET 'utf8' NULL DEFAULT NULL AFTER `picture_id`,
ADD COLUMN `address` TEXT CHARACTER SET 'utf8' NULL DEFAULT NULL AFTER `phone`,
ADD COLUMN `recordStatus` ENUM('active','deleted') CHARACTER SET 'utf8' NULL DEFAULT 'active' AFTER `address`,
ADD COLUMN `created_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `recordStatus`,
ADD COLUMN `created_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_at`,
ADD COLUMN `updated_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_by`,
ADD COLUMN `updated_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_at`,
ADD COLUMN `deleted_at` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `updated_by`,
ADD COLUMN `deleted_by` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `deleted_at`,
ADD UNIQUE INDEX `user_id_UNIQUE` (`user_id` ASC),
DROP INDEX `user_id` ;
